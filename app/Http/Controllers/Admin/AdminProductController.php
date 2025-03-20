<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Admin\ProductRequest;

class AdminProductController extends Controller
{
    // Display all products
    public function index()
    {
        try {
            $products = Product::with('categories')->get(); // Load categories with products
            return view('admin.products.index', compact('products'));
        } catch (\Exception $e) {
            Log::error("Error fetching products: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while fetching products.');
        }
    }

    // Show product creation form
    public function create()
    {
        try {
            $categories = Category::all();
            return view('admin.products.create', compact('categories'));
        } catch (\Exception $e) {
            Log::error("Error fetching categories: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while fetching categories.');
        }
    }

    // Store new product
    public function store(ProductRequest $request)
    {
        try {
            $validated = $request->validated();

            // Handle Image Upload
            $imagePath = $request->file('image')->store('product_images', 'public');

            // Create Product
            $product = Product::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'price' => $validated['price'],
                'stock_quantity' => $validated['stock_quantity'],
                'image' => $imagePath,
            ]);

            // Attach Categories
            $product->categories()->sync($validated['categories']);

            return response()->json(['success' => true, 'message' => 'Product added successfully!']);
        } catch (\Exception $e) {
            Log::error("Error storing product: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong while adding the product.'], 500);
        }
    }

    // Show edit form
    public function edit($id)
    {
        try {
            $product = Product::with('categories')->findOrFail($id);
            $categories = Category::all();
            return view('admin.products.edit', compact('product', 'categories'));
        } catch (\Exception $e) {
            Log::error("Error fetching product for edit: " . $e->getMessage());
            return back()->with('error', 'Product not found.');
        }
    }

    // Update product
    public function update(ProductRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $validated = $request->validated();

            // Handle Image Upload
            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($product->image);
                $validated['image'] = $request->file('image')->store('product_images', 'public');
            }

            $product->update($validated);

            // Update Categories in Pivot Table
            $product->categories()->sync($validated['categories']);

            return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            Log::error("Error updating product: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while updating the product.');
        }
    }

    // Delete product
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Delete image from storage
            Storage::disk('public')->delete($product->image);

            // Detach related categories if applicable
            if (method_exists($product, 'categories')) {
                $product->categories()->detach();
            }

            $product->delete();

            return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            Log::error("Error deleting product: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while deleting the product.');
        }
    }

    // Search products via AJAX
    public function search(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = $request->q;

                $products = Product::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('slug', 'LIKE', "%{$query}%")
                    ->with('categories')
                    ->get();

                $output = '';
                if ($products->isNotEmpty()) {
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
                            <td class="px-6 py-3 text-gray-800">' . e($product->name) . '</td>
                            <td class="px-6 py-3 text-gray-600">' . e($product->slug) . '</td>
                            <td class="px-6 py-3 text-gray-600">$' . number_format($product->price, 2) . '</td>
                            <td class="px-6 py-3 text-gray-600">' . $product->stock_quantity . '</td>
                            <td class="px-6 py-3 text-gray-600">' . ($categoryNames ?: 'No Category') . '</td>
                            <td class="px-6 py-3 flex space-x-4">
                                <a href="' . route('admin.products.edit', $product->id) . '" class="text-blue-500 hover:text-blue-700 transition">
                                    <i class="uil uil-edit"></i>
                                </a>
                                <button type="button" onclick="openDeleteModal(' . $product->id . ', \'' . e($product->name) . '\')"
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
        } catch (\Exception $e) {
            Log::error("Error searching products: " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong while searching products.'], 500);
        }
    }
}
