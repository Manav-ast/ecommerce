<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function addToCart(Request $request)
    {
        try {
            $result = $this->cartService->addToCart(
                $request->product_id,
                $request->quantity ?? 1
            );

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error("Error adding to cart: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong while adding to cart.'], 500);
        }
    }

    public function showCart()
    {
        try {
            $cart = $this->cartService->getCart();
            $cartTotal = $this->cartService->getCartTotal();

            return view('user.cart.index', compact('cart', 'cartTotal'));
        } catch (\Exception $e) {
            Log::error("Error showing cart: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while loading your cart.');
        }
    }

    public function updateCart(Request $request)
    {
        try {
            $result = $this->cartService->updateCart(
                $request->product_id,
                $request->action
            );

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error("Error updating cart: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong while updating your cart.'], 500);
        }
    }

    public function removeFromCart(Request $request)
    {
        try {
            $result = $this->cartService->removeFromCart($request->product_id);

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error("Error removing from cart: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong while removing item from cart.'], 500);
        }
    }
}
