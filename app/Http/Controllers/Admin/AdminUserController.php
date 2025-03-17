<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    // Display all users
    public function index()
    {
        try {
            $users = User::all();
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
    public function store(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|string|email|max:100|unique:users',
                'phone_no' => 'required|string|size:10|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'status' => 'required|in:active,inactive',
            ]);

            // Create user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_no' => $validated['phone_no'],
                'password' => Hash::make($validated['password']), // Secure password
                'status' => $validated['status'],
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
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|string|email|max:100|unique:users,email,' . $user->id,
                'phone_no' => 'required|string|size:10|unique:users,phone_no,' . $user->id,
                'password' => 'nullable|string|min:6|confirmed',
                'status' => 'required|in:active,inactive',
            ]);

            // Update user data
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_no' => $validated['phone_no'],
                'status' => $validated['status'],
                'password' => $request->filled('password') ? Hash::make($validated['password']) : $user->password,
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

                // Generate HTML output
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

                return response()->json(['html' => $output]);
            }
        } catch (\Exception $e) {
            Log::error("Error searching users: " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong while searching users.'], 500);
        }
    }
}
