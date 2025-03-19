<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get(); // ✅ This will add 'products_count' to each category
        $products = Product::paginate(12); // ✅ Paginate products

        return view('user.shop.index', compact('categories', 'products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with('categories')->firstOrFail();
        $relatedProducts = Product::whereHas('categories', function ($query) use ($product) {
            return $query->whereIn('category_id', $product->categories->pluck('id'));
        })->where('id', '!=', $product->id)->limit(4)->get();

        return view('user.shop.show', compact('product', 'relatedProducts'));
    }

    public function filter(Request $request)
    {
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
    }
}
