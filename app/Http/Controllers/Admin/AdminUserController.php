<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\UserRequest;

class AdminUserController extends Controller
{
    // Display all users
    public function index()
    {
        try {
            $users = User::latest()->paginate(5);
            return view('admin.users.index', compact('users'));
        } catch (\Exception $e) {
            Log::error("Error fetching users: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while fetching users.');
        }
    }

    // Show user creation form
    public function create()
    {
        return view('admin.users.create');
    }

    // Store new user
    public function store(UserRequest $request)
    {
        try {
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'password' => Hash::make($request->password), // Secure password
                'status' => $request->status,
            ]);

            return redirect()->route('admin.users')->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            Log::error("Error creating user: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while creating the user.');
        }
    }

    // Show edit form
    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('admin.users.edit', compact('user'));
        } catch (\Exception $e) {
            Log::error("Error fetching user for edit: " . $e->getMessage());
            return back()->with('error', 'User not found.');
        }
    }

    // Update user
    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Update user data
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'status' => $request->status,
                'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            ]);

            return redirect()->route('admin.users')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            Log::error("Error updating user: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while updating the user.');
        }
    }

    // Delete user
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            Log::error("Error deleting user: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while deleting the user.');
        }
    }

    // AJAX Search Users
    public function search(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = $request->q;

                // Fetch matching users
                $users = User::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%")
                    ->orWhere('phone_no', 'LIKE', "%{$query}%")
                    ->get();

                // Generate HTML output for desktop view
                $output = '';
                if ($users->isNotEmpty()) {
                    foreach ($users as $user) {
                        $statusClass = $user->status == 'active' ? 'bg-green-500' : 'bg-red-500';

                        $output .= '
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                        <td class="px-6 py-3 text-gray-800">' . $user->id . '</td>
                        <td class="px-6 py-3 text-gray-800">' . e($user->name) . '</td>
                        <td class="px-6 py-3 text-gray-600">' . e($user->email) . '</td>
                        <td class="px-6 py-3 text-gray-600">' . e($user->phone_no) . '</td>
                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded-full text-white text-sm ' . $statusClass . '">
                                ' . ucfirst($user->status) . '
                            </span>
                        </td>
                        <td class="px-6 py-3 flex space-x-4">
                            <a href="' . route('admin.users.edit', $user->id) . '" class="text-blue-500 hover:text-blue-700 transition">
                                <i class="uil uil-edit"></i>
                            </a>
                            <button type="button" onclick="openDeleteModal(' . $user->id . ', \'' . e($user->name) . '\')" 
                                class="text-red-500 hover:text-red-700 transition">
                                <i class="uil uil-trash-alt"></i>
                            </button>
                        </td>
                    </tr>';
                    }
                } else {
                    $output = '<tr><td colspan="6" class="text-center py-3 text-gray-600">No users found</td></tr>';
                }

                // Generate HTML output for mobile view
                $mobileOutput = '';
                if ($users->isNotEmpty()) {
                    foreach ($users as $user) {
                        $statusClass = $user->status == 'active' ? 'bg-green-500' : 'bg-red-500';

                        $mobileOutput .= '
                        <div class="bg-white rounded-lg shadow p-4 border border-gray-200 mb-4">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-semibold text-gray-800">#' . e($user->id) . ' - ' . e($user->name) . '</h3>
                                    <p class="text-gray-600 text-sm mt-1">' . e($user->email) . '</p>
                                    <p class="text-gray-600 text-sm mt-1">' . e($user->phone_no) . '</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-white text-sm ' . $statusClass . '">
                                    ' . ucfirst($user->status) . '
                                </span>
                            </div>
                            <div class="flex space-x-4 justify-end border-t border-gray-200 pt-3">
                                <a href="' . route('admin.users.edit', $user->id) . '" class="text-blue-500 hover:text-blue-700 transition">
                                    <i class="uil uil-edit"></i>
                                </a>
                                <button type="button" onclick="openDeleteModal(' . $user->id . ', \'' . e($user->name) . '\')" 
                                    class="text-red-500 hover:text-red-700 transition">
                                    <i class="uil uil-trash-alt"></i>
                                </button>
                            </div>
                        </div>';
                    }
                } else {
                    $mobileOutput = '<div class="bg-white rounded-lg shadow p-4 text-center text-gray-600">No users found</div>';
                }

                return response()->json([
                    'html' => $output,
                    'mobileHtml' => $mobileOutput
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Error searching users: " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong while searching users.'], 500);
        }
    }
}
