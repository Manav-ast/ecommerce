<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function addToCart(Request $request)
    {
        $result = $this->cartService->addToCart(
            $request->product_id,
            $request->quantity ?? 1
        );

        return response()->json($result);
    }

    public function showCart()
    {
        $cart = $this->cartService->getCart();
        $cartTotal = $this->cartService->getCartTotal();

        return view('user.cart.index', compact('cart', 'cartTotal'));
    }

    public function updateCart(Request $request)
    {
        $result = $this->cartService->updateCart(
            $request->product_id,
            $request->action
        );

        return response()->json($result);
    }

    public function removeFromCart(Request $request)
    {
        $result = $this->cartService->removeFromCart($request->product_id);

        return response()->json($result);
    }
}
