<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        return view('pages.checkout', compact('cart'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'payment_method' => 'required|in:credit_card,paypal',
        ]);

        DB::beginTransaction();

        try {
            // Store the address
            $address = Address::create([
                'user_id' => Auth::id(),
                'address_line1' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal,
                'country' => $request->country,
                'type' => 'shipping',
            ]);

            // Create Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_status' => 'Pending',
                'total_price' => collect(session('cart'))->sum(fn($item) => $item['price'] * $item['quantity']),
            ]);

            // Add Items to Order
            foreach (session('cart') as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // Store Payment
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'payment_status' => 'Pending',
                'amount' => $order->total_price,
            ]);

            // Clear Cart
            session()->forget('cart');
            session()->put('cart_count', 0);

            DB::commit();

            return redirect()->route('order.success', ['order_id' => $order->id])->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function orderSuccess($orderId)
    {
        $order = Order::with('orderItems.product')->findOrFail($orderId);
        return view('user.order-success', compact('order'));
    }
}
