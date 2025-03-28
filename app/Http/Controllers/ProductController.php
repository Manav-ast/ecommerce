<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use App\Models\StaticBlock;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::withCount('products')->get(); // ✅ This will add 'products_count' to each category
            $products = Product::paginate(8); // ✅ Paginate products

            return view('user.shop.index', compact('categories', 'products', 'footerBlock', 'footerLinks'  ));
        } catch (\Exception $e) {
            Log::error("Error fetching products and categories: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while loading products.');
        }
    }

    public function show($slug)
    {
        try {
            $product = Product::where('slug', $slug)->with('categories')->firstOrFail();
            $relatedProducts = Product::whereHas('categories', function ($query) use ($product) {
                return $query->whereIn('category_id', $product->categories->pluck('id'));
            })->where('id', '!=', $product->id)->limit(4)->get();

            return view('user.shop.show', compact('product', 'relatedProducts'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Product not found with slug: {$slug}");
            return redirect()->route('shop.index')->with('error', 'Product not found.');
        } catch (\Exception $e) {
            Log::error("Error showing product details: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while loading product details.');
        }
    }

    public function filter(Request $request)
    {
        try {
            $categorySlugs = $request->categories ? explode(',', $request->categories) : [];
            $minPrice = $request->min_price ?? 0;
            $maxPrice = $request->max_price ?? 10000;

            $query = Product::query();

            if (!empty($categorySlugs)) {
                $query->whereHas('categories', function ($q) use ($categorySlugs) {
                    $q->whereIn('categories.slug', $categorySlugs);
                });
            }

            $query->whereBetween('price', [$minPrice, $maxPrice]);

            $products = $query->get();

            return view('user.shop.partials.product-list', compact('products'))->render();
        } catch (\Exception $e) {
            Log::error("Error filtering products: " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong while filtering products.'], 500);
        }
    }
}
