<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([
                'products' => [],
                'message' => 'No search query provided'
            ]);
        }

        // Search for products by name and slug only
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('slug', 'like', "%{$query}%")
            ->with('categories')
            ->take(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'image' => $product->image,
                    'categories' => $product->categories->map(function ($category) {
                        return [
                            'id' => $category->id,
                            'name' => $category->name,
                            'slug' => $category->slug
                        ];
                    })
                ];
            });

        // Search for categories by name and slug
        $categories = Category::where('name', 'like', "%{$query}%")
            ->orWhere('slug', 'like', "%{$query}%")
            ->take(5)
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug
                ];
            });

        return response()->json([
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function searchPage(Request $request)
    {
        $query = $request->input('search');

        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('slug', 'like', "%{$query}%")
            ->with('categories')
            ->paginate(12);

        return view('user.shop.index', [
            'products' => $products,
            'categories' => Category::all(),
            'search_query' => $query
        ]);
    }
}
