<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Address;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        // Get cart from session
        $cart = $this->cartService->getCart();

        // Calculate cart total
        $cartTotal = $this->cartService->getCartTotal();

        // If cart is empty, redirect to cart page
        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Your cart is empty');
        }

        // Get countries for dropdown
        $countries = $this->getCountries();

        return view('pages.checkout', compact('cart', 'cartTotal', 'countries'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'region' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'payment_method' => 'required|in:credit_card,paypal',
        ]);

        // dd($validator);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get cart from session
        $cart = $this->cartService->getCart();

        // If cart is empty, redirect to cart page
        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Your cart is empty');
        }

        // Calculate total price
        $totalPrice = $this->cartService->getCartTotal();

        // Begin transaction
        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_status' => 'pending',
                'total_price' => $totalPrice,
                'order_date' => now(),
            ]);

            // Create order items
            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // Create payment
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'amount' => $totalPrice,
                'payment_date' => now(),
            ]);

            // Save billing address
            Address::create([
                'user_id' => Auth::id(),
                'address_line1' => $request->address,
                'city' => $request->city,
                'state' => '', // You might want to add state field to your form
                'postal_code' => $request->postal,
                'country' => $request->region,
                'type' => 'billing',
            ]);

            // Clear cart
            $this->cartService->clearCart();

            // Commit transaction
            DB::commit();

            return redirect()->route('checkout.success', ['order' => $order->id]);
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Something went wrong while processing your order: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function success($orderId)
    {
        $order = Order::with(['orderItems.product', 'payment'])->findOrFail($orderId);

        return view('user.order-success', compact('order'));
    }

    private function getCountries()
    {
        return [
            'IN' => 'INDIA',
            // Add more countries as needed
        ];
    }
}
