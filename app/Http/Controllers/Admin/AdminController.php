<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('role')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $roles = Roles::all();
        return view('admin.admins.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8',
            'role_id' => 'nullable|exists:roles,id',
            'phone_number' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive'
        ]);

        $validated['password'] = bcrypt($validated['password']);
        Admin::create($validated);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Administrator created successfully');
    }

    public function edit(Admin $admin)
    {
        $roles = Roles::all();
        return view('admin.admins.edit', compact('admin', 'roles'));
    }

    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|min:8',
            'role_id' => 'nullable|exists:roles,id',
            'phone_number' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive'
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Administrator updated successfully');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Administrator deleted successfully');
    }
}
