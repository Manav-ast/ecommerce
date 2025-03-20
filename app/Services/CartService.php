<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CartService
{
    /**
     * Add a product to the cart
     *
     * @param int $productId
     * @param int $quantity
     * @return array
     */
    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::findOrFail($productId);

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
        $this->updateCartCount();

        return [
            "success" => true,
            "cart_count" => $this->getCartCount()
        ];
    }

    /**
     * Get all items in the cart
     *
     * @return array
     */
    public function getCart()
    {
        return session()->get('cart', []);
    }

    /**
     * Get the total price of all items in the cart
     *
     * @return float
     */
    public function getCartTotal()
    {
        $cart = $this->getCart();
        
        return array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
    }

    /**
     * Get the total number of items in the cart
     *
     * @return int
     */
    public function getCartCount()
    {
        $cart = $this->getCart();
        return count($cart);
    }

    /**
     * Update the quantity of a product in the cart
     *
     * @param int $productId
     * @param string $action
     * @return array
     */
    public function updateCart($productId, $action)
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            if ($action === 'increase') {
                $cart[$productId]['quantity'] += 1;
            } elseif ($action === 'decrease' && $cart[$productId]['quantity'] > 1) {
                $cart[$productId]['quantity'] -= 1;
            }
            session()->put('cart', $cart);
        }

        // Update the cart count
        $this->updateCartCount();

        $cartTotal = $this->getCartTotal();
        $cartCount = $this->getCartCount();

        return [
            "success" => true,
            "cartHtml" => view('user.cart.partials.cart-items', compact('cart'))->render(),
            "cartTotal" => number_format($cartTotal, 2),
            "cartCount" => $cartCount,
        ];
    }

    /**
     * Remove a product from the cart
     *
     * @param int $productId
     * @return array
     */
    public function removeFromCart($productId)
    {
        $cart = $this->getCart();
        
        unset($cart[$productId]);
        session()->put('cart', $cart);

        // Update the cart count
        $this->updateCartCount();

        $cartTotal = $this->getCartTotal();
        $cartCount = $this->getCartCount();

        return [
            "success" => true,
            "cartHtml" => view('user.cart.partials.cart-items', compact('cart'))->render(),
            "cartTotal" => number_format($cartTotal, 2),
            "cartCount" => $cartCount,
        ];
    }

    /**
     * Clear the cart
     *
     * @return void
     */
    public function clearCart()
    {
        session()->forget('cart');
        session()->put('cart_count', 0);
    }

    /**
     * Update the cart count in the session
     *
     * @return void
     */
    private function updateCartCount()
    {
        $cartCount = $this->getCartCount();
        
        if ($cartCount === 0) {
            session()->forget('cart');
            session()->put('cart_count', 0);
        } else {
            session()->put('cart_count', $cartCount);
        }
    }
} 