<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories')->get(); // Load categories with products

        return view('admin.products.index', compact('products'));
    }


    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('admin.products.create', compact('categories'));
    }


    public function store(Request $request)
    {
        try {
            // Validate Inputs
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:products,slug',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'categories' => 'array|required', // Expecting category IDs as an array
            ]);

            // Handle Image Upload
            $imagePath = $request->file('image')->store('product_images', 'public');

            // Store Product
            $product = Product::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'price' => $validated['price'],
                'stock_quantity' => $validated['stock_quantity'],
                'image' => $imagePath,
            ]);

            // Attach categories
            $product->categories()->sync($validated['categories']);

            return response()->json(['success' => true, 'message' => 'Product added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }



    public function delete($id)
    {
        $product = Product::findOrFail($id);

        // Delete image from storage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete product from database
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }

    public function edit($id)
    {
        $product = Product::with('categories')->findOrFail($id); // Fetch product with categories
        $categories = Category::all(); // Fetch all categories

        return view('admin.products.edit', compact('product', 'categories'));
    }


    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            // Validate Inputs
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'categories' => 'array|required', // Expecting category IDs as an array
            ]);

            // Handle Image Upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                // Upload new image
                $imagePath = $request->file('image')->store('product_images', 'public');
                $product->image = $imagePath;
            }

            // Update Product Data
            $product->update([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'price' => $validated['price'],
                'stock_quantity' => $validated['stock_quantity'],
            ]);

            // Update Categories in Pivot Table
            $product->categories()->sync($validated['categories']);

            return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }


    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->q;

            // Fetch products that match the search query
            $products = Product::where('name', 'LIKE', "%{$query}%")
                ->orWhere('slug', 'LIKE', "%{$query}%")
                ->with('categories') // Load categories
                ->get();

            // Check if products exist
            if ($products->isNotEmpty()) {
                $output = '';
                foreach ($products as $product) {
                    $categoryNames = $product->categories->pluck('name')->join(', ');

                    $output .= '
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                    <td class="px-6 py-3 relative">
                        <div class="w-10 h-10 overflow-hidden">
                            <img src="' . asset('storage/' . $product->image) . '" 
                                class="w-10 h-10 object-cover rounded">
                        </div>
                    </td>
                    <td class="px-6 py-3 text-gray-800">' . $product->name . '</td>
                    <td class="px-6 py-3 text-gray-600">' . $product->slug . '</td>
                    <td class="px-6 py-3 text-gray-600">$' . number_format($product->price, 2) . '</td>
                    <td class="px-6 py-3 text-gray-600">' . $product->stock_quantity . '</td>
                    <td class="px-6 py-3 text-gray-600">' . ($categoryNames ?: 'No Category') . '</td>
                    <td class="px-6 py-3 flex space-x-4">
                        <a href="' . route('admin.products.edit', $product->id) . '" class="text-blue-500 hover:text-blue-700 transition">
                            <i class="uil uil-edit"></i>
                        </a>
                        <button type="button" onclick="openDeleteModal(' . $product->id . ')" 
                            class="text-red-500 hover:text-red-700 transition">
                            <i class="uil uil-trash-alt"></i>
                        </button>
                    </td>
                </tr>';
                }
            } else {
                $output = '<tr><td colspan="7" class="text-center py-3 text-gray-600">No products found</td></tr>';
            }

            return response()->json(['html' => $output]);
        }
    }


    public function destroy(Product $product)
    {
        $product->delete(); // This will automatically delete from `product_category` due to cascade delete.

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully.');
    }
}
