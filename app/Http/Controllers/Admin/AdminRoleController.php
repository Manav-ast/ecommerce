<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roles;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AdminRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage_roles');
    }

    // Display all roles
    public function index()
    {
        try {
            $roles = Roles::latest()->paginate(5);
            return view('admin.roles.index', compact('roles'));
        } catch (\Exception $e) {
            Log::error("Error fetching roles: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while fetching roles.');
        }
    }

    // Show create role form
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    // Store new role
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('roles', 'name')->whereNull('deleted_at')
            ],
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Create the role
            $role = Roles::create([
                'name' => $request->name,
                'is_super_admin' => $request->is_super_admin ? Roles::STATUS_YES : Roles::STATUS_NO,
            ]);

            // Sync permissions if they are provided
            if (!empty($request->permissions)) {
                $role->permissions()->sync($request->permissions);
            }

            // Commit the transaction
            DB::commit();

            return redirect()->route('admin.roles')->with('success', 'Role created successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();
            Log::error("Error creating role: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while creating the role: ' . $e->getMessage());
        }
    }

    // Show edit role form
    public function edit($id)
    {
        try {
            $role = Roles::findOrFail($id);
            $permissions = Permission::all();
            $rolePermissions = $role->permissions->pluck('id')->toArray();
            return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
        } catch (\Exception $e) {
            Log::error("Error fetching role: " . $e->getMessage());
            return back()->with('error', 'Role not found.');
        }
    }

    // Update role details
    public function update(Request $request, $id)
    {
        // Validate the request - no uniqueness check on name for updates
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            $role = Roles::findOrFail($id);
            $role->update([
                'name' => $request->name,
                'is_super_admin' => $request->is_super_admin ? Roles::STATUS_YES : Roles::STATUS_NO,
            ]);

            // Sync permissions if they are provided
            if (!empty($request->permissions)) {
                $role->permissions()->sync($request->permissions);
            } else {
                // If no permissions are selected, detach all permissions
                $role->permissions()->detach();
            }

            // Commit the transaction
            DB::commit();

            return redirect()->route('admin.roles')->with('success', 'Role updated successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();
            Log::error("Error updating role: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while updating the role: ' . $e->getMessage());
        }
    }

    // Delete a role
    public function destroy($id)
    {
        try {
            $role = Roles::findOrFail($id);

            // Check if this role is assigned to any admins
            if ($role->admins()->exists()) {
                return response()->json(['success' => false, 'message' => 'Cannot delete a role assigned to admins.'], 400);
            }

            $role->delete();

            return redirect()->route('admin.roles')->with('success', 'Role deleted successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error("Database error while deleting role: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'This role is linked to other records and cannot be deleted.'], 500);
        } catch (\Exception $e) {
            Log::error("Error deleting role: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }




    public function search(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = $request->q;

                $roles = Roles::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->get();

                // Desktop view HTML
                $output = '';
                if ($roles->isNotEmpty()) {
                    foreach ($roles as $role) {
                        $output .= '
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-3 text-gray-800">' . e($role->id) . '</td>
                            <td class="px-6 py-3 text-gray-800">' . e($role->name) . '</td>
                            <td class="px-6 py-3 text-gray-600">' . e($role->description ?? 'No description') . '</td>
                            <td class="px-6 py-3 flex space-x-4">
                                <a href="' . route('admin.roles.edit', $role->id) . '" class="text-blue-500 hover:text-blue-700 transition">
                                    <i class="uil uil-edit"></i>
                                </a>
                                <button type="button" onclick="openDeleteModal(' . $role->id . ', \'' . e($role->name) . '\')"
                                    class="text-red-500 hover:text-red-700 transition">
                                    <i class="uil uil-trash-alt"></i>
                                </button>
                            </td>
                        </tr>';
                    }
                } else {
                    $output = '<tr><td colspan="4" class="text-center py-3 text-gray-600">No roles found</td></tr>';
                }

                // Mobile view HTML
                $mobileOutput = '';
                if ($roles->isNotEmpty()) {
                    foreach ($roles as $role) {
                        $mobileOutput .= '
                        <div class="bg-white rounded-lg shadow-md p-4">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-semibold text-gray-800">#' . e($role->id) . ' - ' . e($role->name) . '</h3>
                                    <p class="text-sm text-gray-600 mt-1">' . e($role->description ?? 'No description') . '</p>
                                </div>
                                <div class="flex space-x-3">
                                    <a href="' . route('admin.roles.edit', $role->id) . '" class="text-blue-500 hover:text-blue-700 transition">
                                        <i class="uil uil-edit"></i>
                                    </a>
                                    <button type="button" onclick="openDeleteModal(' . $role->id . ', \'' . e($role->name) . '\')"
                                        class="text-red-500 hover:text-red-700 transition">
                                        <i class="uil uil-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    $mobileOutput = '<div class="bg-white rounded-lg shadow-md p-4 text-center text-gray-600">No roles found</div>';
                }

                return response()->json([
                    'html' => $output,
                    'mobileHtml' => $mobileOutput
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Error searching roles: " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong while searching roles.'], 500);
        }
    }
}
