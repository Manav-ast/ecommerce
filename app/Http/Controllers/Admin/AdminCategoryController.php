<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view("admin.category.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle Image Upload
        $imagePath = $request->file('image')->store('category_images', 'public');

        // Store Category
        Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);

        // Delete image from storage
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        // Delete category from database
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle Image Upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            // Upload new image
            $imagePath = $request->file('image')->store('category_images', 'public');
            $category->image = $imagePath;
        }

        // Update category
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully!');
    }


    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->search;
            $categories = Category::where('name', 'LIKE', "%{$query}%")
                ->orWhere('slug', 'LIKE', "%{$query}%")
                ->get();

            $output = '';
            if ($categories->count() > 0) {
                foreach ($categories as $category) {
                    $output .= '
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                        <td class="px-6 py-3 relative">
                            <div class="w-10 h-10 overflow-hidden">
                                <img src="' . asset('storage/' . $category->image) . '" 
                                    class="w-10 h-10 object-cover rounded transition-transform duration-300 transform hover:scale-150 hover:absolute hover:top-0 hover:left-0 hover:w-24 hover:h-24 hover:shadow-lg">
                            </div>
                        </td>
                        <td class="px-6 py-3 text-gray-800">' . $category->name . '</td>
                        <td class="px-6 py-3 text-gray-600">' . $category->slug . '</td>
                        <td class="px-6 py-3 text-gray-600">' . \Illuminate\Support\Str::limit($category->description, 50) . '</td>
                        <td class="px-6 py-3 flex space-x-4">
                            <a href="' . route('admin.categories.edit', $category->id) . '" class="text-blue-500 hover:text-blue-700 transition">
                                <i class="uil uil-edit"></i>
                            </a>
                            <button type="button" onclick="openDeleteModal(' . $category->id . ')" 
                                class="text-red-500 hover:text-red-700 transition">
                                <i class="uil uil-trash-alt"></i>
                            </button>
                        </td>
                    </tr>';
                }
            } else {
                $output = '<tr><td colspan="5" class="text-center py-3 text-gray-600">No categories found</td></tr>';
            }
            return response()->json($output);
        }
    }

    public function destroy(Category $category)
    {
        $category->products()->detach(); // Removes relations from pivot table
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
    }
}
