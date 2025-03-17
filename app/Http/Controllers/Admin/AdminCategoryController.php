<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    // Display all categories
    public function index()
    {
        try {
            $categories = Category::all();
            return view('admin.category.index', compact('categories'));
        } catch (\Exception $e) {
            Log::error("Error fetching categories: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while fetching categories.');
        }
    }

    // Show category creation form
    public function create()
    {
        return view('admin.category.create');
    }

    // Store new category
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:categories,slug',
                'description' => 'nullable|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle Image Upload
            $imagePath = $request->file('image')->store('category_images', 'public');

            // Store Category
            Category::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'image' => $imagePath,
            ]);

            return response()->json(['success' => true, 'message' => 'Category created successfully!']);
        } catch (\Exception $e) {
            Log::error("Error creating category: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong while creating the category.'], 500);
        }
    }

    // Show edit form
    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
            return view('admin.category.edit', compact('category'));
        } catch (\Exception $e) {
            Log::error("Error fetching category for edit: " . $e->getMessage());
            return back()->with('error', 'Category not found.');
        }
    }

    // Update category
    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle Image Upload
            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($category->image); // Delete old image
                $validated['image'] = $request->file('image')->store('category_images', 'public');
            }

            $category->update($validated);

            return redirect()->route('admin.categories')->with('success', 'Category updated successfully!');
        } catch (\Exception $e) {
            Log::error("Error updating category: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while updating the category.');
        }
    }

    // Delete category
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            // Delete associated image
            Storage::disk('public')->delete($category->image);

            // Detach related products if applicable
            if (method_exists($category, 'products')) {
                $category->products()->detach();
            }

            $category->delete();

            return redirect()->route('admin.categories')->with('success', 'Category deleted successfully!');
        } catch (\Exception $e) {
            Log::error("Error deleting category: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while deleting the category.');
        }
    }

    // Search categories via AJAX
    public function search(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = $request->q; // Make sure this matches the AJAX request
                Log::info("Search Query: " . $query); // Debugging

                $categories = Category::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('slug', 'LIKE', "%{$query}%")
                    ->get();

                $output = '';
                if ($categories->isNotEmpty()) {
                    foreach ($categories as $category) {
                        $output .= '
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                        <td class="px-6 py-3 relative">
                            <div class="w-10 h-10 overflow-hidden">
                                <img src="' . asset('storage/' . $category->image) . '" 
                                    class="w-10 h-10 object-cover rounded">
                            </div>
                        </td>
                        <td class="px-6 py-3 text-gray-800">' . e($category->name) . '</td>
                        <td class="px-6 py-3 text-gray-600">' . e($category->slug) . '</td>
                        <td class="px-6 py-3 text-gray-600">' . Str::limit($category->description, 50) . '</td>
                        <td class="px-6 py-3 flex space-x-4">
                            <a href="' . route('admin.categories.edit', $category->id) . '" class="text-blue-500 hover:text-blue-700 transition">
                                <i class="uil uil-edit"></i>
                            </a>
                            <button type="button" onclick="openDeleteModal(' . $category->id . ', \'' . e($category->name) . '\')"
                                class="text-red-500 hover:text-red-700 transition">
                                <i class="uil uil-trash-alt"></i>
                            </button>
                        </td>
                    </tr>';
                    }
                } else {
                    $output = '<tr><td colspan="5" class="text-center py-3 text-gray-600">No categories found</td></tr>';
                }

                return response()->json(['html' => $output]); // Returns JSON response
            }
        } catch (\Exception $e) {
            Log::error("Error searching categories: " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong while searching categories.'], 500);
        }
    }
}
