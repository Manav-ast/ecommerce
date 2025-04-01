<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roles;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Admin\RoleRequest;

class AdminRoleController extends Controller
{
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
        return view('admin.roles.create');
    }

    // Store new role
    public function store(RoleRequest $request)
    {
        try {
            Roles::create($request->validated());

            // **Check if request is AJAX**
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Role created successfully!']);
            }

            return redirect()->route('admin.roles.index')->with('success', 'Role created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // **Return JSON validation errors**
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed!',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error("Error creating role: " . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Something went wrong while creating the role.');
        }
    }

    // Show edit role form
    public function edit($id)
    {
        try {
            $role = Roles::findOrFail($id);
            return view('admin.roles.edit', compact('role'));
        } catch (\Exception $e) {
            Log::error("Error fetching role for edit: " . $e->getMessage());
            return back()->with('error', 'Role not found.');
        }
    }

    // Update role details
    public function update(RoleRequest $request, $id)
    {
        try {
            $role = Roles::findOrFail($id);
            $role->update($request->validated());

            return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully!');
        } catch (\Exception $e) {
            Log::error("Error updating role: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while updating the role.');
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

            return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully!');
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

                $roles = Roles::where('role_name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->get();

                // Desktop view HTML
                $output = '';
                if ($roles->isNotEmpty()) {
                    foreach ($roles as $role) {
                        $output .= '
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-3 text-gray-800">' . e($role->id) . '</td>
                            <td class="px-6 py-3 text-gray-800">' . e($role->role_name) . '</td>
                            <td class="px-6 py-3 text-gray-600">' . e($role->description ?? 'No description') . '</td>
                            <td class="px-6 py-3 flex space-x-4">
                                <a href="' . route('admin.roles.edit', $role->id) . '" class="text-blue-500 hover:text-blue-700 transition">
                                    <i class="uil uil-edit"></i>
                                </a>
                                <button type="button" onclick="openDeleteModal(' . $role->id . ', \'' . e($role->role_name) . '\')"
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
                                    <h3 class="font-semibold text-gray-800">#' . e($role->id) . ' - ' . e($role->role_name) . '</h3>
                                    <p class="text-sm text-gray-600 mt-1">' . e($role->description ?? 'No description') . '</p>
                                </div>
                                <div class="flex space-x-3">
                                    <a href="' . route('admin.roles.edit', $role->id) . '" class="text-blue-500 hover:text-blue-700 transition">
                                        <i class="uil uil-edit"></i>
                                    </a>
                                    <button type="button" onclick="openDeleteModal(' . $role->id . ', \'' . e($role->role_name) . '\')"
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
