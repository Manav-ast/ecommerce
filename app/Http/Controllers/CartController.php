<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        // Retrieve the cart from session or initialize it
        $cart = session()->get('cart', []);

        // Check if the product already exists in the cart
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => $quantity,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        // Update the cart count
        session()->put('cart_count', count($cart));

        return response()->json([
            "success" => true,
            "cart_count" => count($cart)
        ]);
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);
        $cartTotal = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        return view('user.cart.index', compact('cart', 'cartTotal'));
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->product_id;
        $action = $request->action;

        if (isset($cart[$productId])) {
            if ($action === 'increase') {
                $cart[$productId]['quantity'] += 1;
            } elseif ($action === 'decrease' && $cart[$productId]['quantity'] > 1) {
                $cart[$productId]['quantity'] -= 1;
            }
            session()->put('cart', $cart);
        }

        // If cart is empty, reset cart count
        $cartCount = count($cart);
        if ($cartCount === 0) {
            session()->forget('cart');
            session()->put('cart_count', 0);
        } else {
            session()->put('cart_count', $cartCount);
        }

        $cartTotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        return response()->json([
            "success" => true,
            "cartHtml" => view('user.cart.partials.cart-items', compact('cart'))->render(),
            "cartTotal" => number_format($cartTotal, 2),
            "cartCount" => $cartCount,
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        unset($cart[$request->product_id]);
        session()->put('cart', $cart);

        // If cart is empty, reset cart count
        $cartCount = count($cart);
        if ($cartCount === 0) {
            session()->forget('cart');
            session()->put('cart_count', 0);
        } else {
            session()->put('cart_count', $cartCount);
        }

        $cartTotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        return response()->json([
            "success" => true,
            "cartHtml" => view('user.cart.partials.cart-items', compact('cart'))->render(),
            "cartTotal" => number_format($cartTotal, 2),
            "cartCount" => $cartCount,
        ]);
    }
}
