<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $checkoutService;

    public function __construct(CartService $cartService, CheckoutService $checkoutService)
    {
        $this->cartService = $cartService;
        $this->checkoutService = $checkoutService;
    }

    public function index()
    {
        try {
            // Get cart from session
            $cart = $this->cartService->getCart();

            // Calculate cart total
            $cartTotal = $this->cartService->getCartTotal();

            // If cart is empty, redirect to cart page
            if (empty($cart)) {
                return redirect()->route('cart.show')->with('error', 'Your cart is empty');
            }

            // Get countries for dropdown
            $countries = $this->checkoutService->getCountries();

            return view('pages.checkout', compact('cart', 'cartTotal', 'countries'));
        } catch (\Exception $e) {
            Log::error("Error loading checkout page: " . $e->getMessage());
            return redirect()->route('cart.show')->with('error', 'Something went wrong while loading the checkout page.');
        }
    }

    public function store(CheckoutRequest $request)
    {
        try {
            // Request is automatically validated by the CheckoutRequest class

            // Validate checkout data
            $validationResult = $this->checkoutService->validateCheckout($request->all());
            if (!$validationResult['success']) {
                return redirect()->back()->with('error', $validationResult['message'])->withInput();
            }

            // Process checkout
            $result = $this->checkoutService->processCheckout($request->all());
            
            if ($result['success']) {
                return redirect()->route('checkout.success', ['order' => $result['order_id']]);
            } else {
                return redirect()->back()->with('error', $result['message'])->withInput();
            }
        } catch (\Exception $e) {
            Log::error("Error processing checkout: " . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while processing your order.')->withInput();
        }
    }

    public function success($orderId)
    {
        try {
            $order = Order::with(['orderItems.product', 'payment'])->findOrFail($orderId);

            return view('user.order-success', compact('order'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Order not found with ID: {$orderId}");
            return redirect()->route('home')->with('error', 'Order not found.');
        } catch (\Exception $e) {
            Log::error("Error showing order success page: " . $e->getMessage());
            return redirect()->route('home')->with('error', 'Something went wrong while loading the order success page.');
        }
    }


}
