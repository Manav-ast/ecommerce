<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\CategoryRequest;
use Illuminate\Support\Facades\Gate;

class AdminCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage_categories');
    }

    // Display all categories
    public function index()
    {
        try {
            $categories = Category::latest()->paginate(5); // Fetch all categories paginated
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
    public function store(CategoryRequest $request)
    {
        try {
            $validated = $request->validated();

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

    // Show category edit form
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
    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $validated = $request->validated();

            // Handle Image Upload
            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($category->image); // Delete old image
                $validated['image'] = $request->file('image')->store('category_images', 'public');
            }

            $category->update($validated);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Category updated successfully!']);
            } else {
                return redirect()->route('admin.categories')->with('success', 'Category updated successfully!');
            }
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

            // Detach related products if applicable
            if (method_exists($category, 'products')) {
                $category->products()->detach();
            }

            $category->delete();

            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Category deleted successfully!']);
            } else {
                return redirect()->route('admin.categories')->with('success', 'Category deleted successfully!');
            }
        } catch (\Exception $e) {
            Log::error("Error deleting category: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while deleting the category.');
        }
    }

    // Search categories
    public function search(Request $request)
    {
        try {
            $search = $request->input('q');
            $categories = Category::where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->get();

            $html = view('admin.category.partials.table-body', compact('categories'))->render();
            return response()->json(['success' => true, 'html' => $html]);
        } catch (\Exception $e) {
            Log::error("Error searching categories: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong while searching categories.']);
        }
    }

    // Show trashed categories
    // Get trashed categories
    public function trashed()
    {
        try {
            $categories = Category::onlyTrashed()->latest()->paginate(10);
            return view('admin.category.trashed', compact('categories'));
        } catch (\Exception $e) {
            Log::error("Error retrieving trashed categories: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while retrieving trashed categories.');
        }
    }

    // Restore trashed category
    public function restore($id)
    {
        try {
            $category = Category::onlyTrashed()->findOrFail($id);
            $category->restore();
            return redirect()->route('admin.categories.trashed')->with('success', 'Category restored successfully!');
        } catch (\Exception $e) {
            Log::error("Error restoring category: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while restoring the category.');
        }
    }

    // Force delete category
    public function forceDelete($id)
    {
        try {
            $category = Category::onlyTrashed()->findOrFail($id);

            // Delete image from storage
            Storage::disk('public')->delete($category->image);

            // Detach related products if applicable
            if (method_exists($category, 'products')) {
                $category->products()->detach();
            }

            $category->forceDelete();

            return redirect()->route('admin.categories.trashed')->with('success', 'Category permanently deleted!');
        } catch (\Exception $e) {
            Log::error("Error permanently deleting category: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while permanently deleting the category.');
        }
    }
}
