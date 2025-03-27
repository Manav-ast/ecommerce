<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Process the checkout
     *
     * @param array $data
     * @return array
     */
    public function processCheckout(array $data)
    {
        // Get cart from session
        $cart = $this->cartService->getCart();

        // If cart is empty, return error
        if (empty($cart)) {
            return [
                'success' => false,
                'message' => 'Your cart is empty'
            ];
        }

        // Calculate total price
        $totalPrice = $this->cartService->getCartTotal();

        // Begin transaction
        DB::beginTransaction();

        try {
            // Create order
            $order = $this->createOrder($totalPrice);

            // Create order items
            $this->createOrderItems($order, $cart);

            // Create payment
            $this->createPayment($order, $data['payment_method'], $totalPrice);

            // Save billing address
            $this->saveAddress($data, $order);

            // Log successful order creation for debugging
            Log::info('Order created successfully', [
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'total_price' => $totalPrice
            ]);

            // Clear cart
            $this->cartService->clearCart();

            // Commit transaction
            DB::commit();

            // Send order confirmation email
            try {
                Mail::to($order->user->email)->send(new \App\Mail\OrderConfirmationEmail($order));
            } catch (\Exception $e) {
                Log::error("Failed to send order confirmation email: " . $e->getMessage());
                // Continue with order process even if email fails
            }

            return [
                'success' => true,
                'order_id' => $order->id,
                'message' => 'Order placed successfully'
            ];
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();

            Log::error('Error processing checkout', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Something went wrong while processing your order: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Create a new order
     *
     * @param float $totalPrice
     * @return Order
     */
    private function createOrder($totalPrice)
    {
        return Order::create([
            'user_id' => Auth::id(),
            'order_status' => 'pending',
            'total_price' => $totalPrice,
            'order_date' => now(),
        ]);
    }

    /**
     * Create order items from cart
     *
     * @param Order $order
     * @param array $cart
     * @return void
     */
    private function createOrderItems(Order $order, array $cart)
    {
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
    }

    /**
     * Create payment record
     *
     * @param Order $order
     * @param string $paymentMethod
     * @param float $amount
     * @return Payment
     */
    private function createPayment(Order $order, $paymentMethod, $amount)
    {
        // Set default payment status based on payment method
        $paymentStatus = 'pending';

        // For credit card and PayPal, set status to completed by default
        if ($paymentMethod === 'credit_card' || $paymentMethod === 'paypal') {
            $paymentStatus = 'completed';
        }

        return Payment::create([
            'order_id' => $order->id,
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentStatus,
            'amount' => $amount,
            'payment_date' => now(),
        ]);
    }

    /**
     * Save address information
     *
     * @param array $data
     * @param Order $order
     * @return void
     */
    private function saveAddress(array $data, Order $order)
    {
        // Check if the address should be saved as default
        $isDefault = isset($data['save_as_default']) && !empty($data['save_as_default']);

        // If setting as default, remove default flag from all existing user addresses
        if ($isDefault && Auth::check()) {
            Address::where('user_id', Auth::id())
                ->where('is_default', true)
                ->update(['is_default' => false]);
        }

        // Create billing address
        $billingAddress = Address::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'address_line1' => $data['address'],
            'address_line2' => $data['address_line2'] ?? null,
            'city' => $data['city'],
            'state' => $data['state'] ?? '',
            'postal_code' => $data['postal'] ?? null,
            'country' => $data['region'],
            'type' => 'billing',
            'is_default' => $isDefault,
        ]);

        // Debug log to see what value is being received for shipping_same_as_billing
        Log::info('Shipping same as billing value:', [
            'isset' => isset($data['shipping_same_as_billing']),
            'value' => $data['shipping_same_as_billing'] ?? 'not set',
            'type' => isset($data['shipping_same_as_billing']) ? gettype($data['shipping_same_as_billing']) : 'N/A'
        ]);

        // Check if shipping address is same as billing address
        // HTML checkboxes can send various values: '1', 'on', 'true', etc.
        if (isset($data['shipping_same_as_billing']) && !empty($data['shipping_same_as_billing'])) {
            // Create shipping address with same data but different type
            Address::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'address_line1' => $data['address'],
                'address_line2' => $data['address_line2'] ?? null,
                'city' => $data['city'],
                'state' => $data['state'] ?? '',
                'postal_code' => $data['postal'] ?? null,
                'country' => $data['region'],
                'type' => 'shipping',
                'is_default' => false, // Shipping address is not set as default
            ]);
        } else {
            // Create shipping address with different data
            Address::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'address_line1' => $data['shipping_address'] ?? $data['address'],
                'address_line2' => $data['shipping_address_line2'] ?? null,
                'city' => $data['shipping_city'] ?? $data['city'],
                'state' => $data['shipping_state'] ?? $data['state'] ?? '',
                'postal_code' => $data['shipping_postal'] ?? $data['postal'] ?? null,
                'country' => $data['shipping_region'] ?? $data['region'],
                'type' => 'shipping',
                'is_default' => false, // Shipping address is not set as default
            ]);
        }
    }

    /**
     * Get countries for dropdown
     *
     * @return array
     */
    public function getCountries()
    {
        return [
            'IN' => 'INDIA',
            'US' => 'UNITED STATES',
            'UK' => 'UNITED KINGDOM',
            'CA' => 'CANADA',
            'AU' => 'AUSTRALIA',
            // Add more countries as needed
        ];
    }

    /**
     * Validate checkout data
     *
     * @param array $data
     * @return array
     */
    public function validateCheckout(array $data)
    {
        // Get cart from session
        $cart = $this->cartService->getCart();

        // If cart is empty, return error
        if (empty($cart)) {
            return [
                'success' => false,
                'message' => 'Your cart is empty'
            ];
        }

        // No need to check authentication here as the route is already protected by auth middleware
        // The following check is redundant and can cause issues
        // if (!Auth::check()) {
        //     return [
        //         'success' => false,
        //         'message' => 'You must be logged in to checkout'
        //     ];
        // }

        // Validate required fields
        $requiredFields = ['address', 'city', 'postal', 'region', 'payment_method'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return [
                    'success' => false,
                    'message' => 'Please fill in all required fields'
                ];
            }
        }

        return [
            'success' => true,
            'message' => 'Checkout data is valid'
        ];
    }
}
