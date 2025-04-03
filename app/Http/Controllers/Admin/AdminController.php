<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Admin\AdminRequest;

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

    public function store(AdminRequest $request)
    {
        $validated = $request->validated();

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

    public function update(AdminRequest $request, Admin $admin)
    {
        $validated = $request->validated();

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

    public function search(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = $request->q;

                // Fetch matching admins
                $admins = Admin::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%")
                    ->orWhere('phone_number', 'LIKE', "%{$query}%")
                    ->get();

                // Generate HTML output for desktop view
                $output = '';
                if ($admins->isNotEmpty()) {
                    foreach ($admins as $admin) {
                        $statusClass = $admin->status == 'active' ? 'bg-green-500' : 'bg-red-500';

                        $output .= '
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                        <td class="px-6 py-3 text-gray-800">' . $admin->id . '</td>
                        <td class="px-6 py-3 text-gray-800">' . e($admin->name) . '</td>
                        <td class="px-6 py-3 text-gray-600">' . e($admin->email) . '</td>
                        <td class="px-6 py-3 text-gray-600">' . e($admin->phone_number) . '</td>
                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded-full text-white text-sm ' . $statusClass . '">
                                ' . ucfirst($admin->status) . '
                            </span>
                        </td>
                        <td class="px-6 py-3 flex space-x-4">
                            <a href="' . route('admin.admins.edit', $admin->id) . '" class="text-blue-500 hover:text-blue-700 transition">
                                <i class="uil uil-edit"></i>
                            </a>
                            <button type="button" class="delete-admin text-red-500 hover:text-red-700 transition"
                                data-id="' . $admin->id . '" data-name="' . e($admin->name) . '">
                                <i class="uil uil-trash-alt"></i>
                            </button>
                        </td>
                    </tr>';
                    }
                } else {
                    $output = '<tr><td colspan="6" class="text-center py-3 text-gray-600">No admins found</td></tr>';
                }

                // Generate HTML output for mobile view
                $mobileOutput = '';
                if ($admins->isNotEmpty()) {
                    foreach ($admins as $admin) {
                        $statusClass = $admin->status == 'active' ? 'bg-green-500' : 'bg-red-500';

                        $mobileOutput .= '
                    <div class="bg-white rounded-lg shadow p-4 border border-gray-200 mb-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-semibold text-gray-800">#' . $admin->id . ' - ' . e($admin->name) . '</h3>
                                <p class="text-gray-600 text-sm">' . e($admin->email) . '</p>
                                <p class="text-gray-600 text-sm">' . e($admin->phone_number) . '</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-white text-sm ' . $statusClass . '">
                                ' . ucfirst($admin->status) . '
                            </span>
                        </div>
                        <div class="flex space-x-4 justify-end border-t pt-3">
                            <a href="' . route('admin.admins.edit', $admin->id) . '" class="text-blue-500 hover:text-blue-700 transition">
                                <i class="uil uil-edit"></i>
                            </a>
                            <button type="button" class="delete-admin text-red-500 hover:text-red-700 transition"
                                data-id="' . $admin->id . '" data-name="' . e($admin->name) . '">
                                <i class="uil uil-trash-alt"></i>
                            </button>
                        </div>
                    </div>';
                    }
                } else {
                    $mobileOutput = '<div class="bg-white rounded-lg shadow p-4 text-center text-gray-600">No admins found</div>';
                }

                return response()->json([
                    'html' => $output,
                    'mobileHtml' => $mobileOutput
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Error searching admins: " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong while searching admins.'], 500);
        }

        // Handle non-AJAX requests
        $admins = Admin::orderBy('id', 'desc')->paginate(10);
        return view('admin.admins.index', compact('admins'));
    }
}
