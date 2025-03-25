<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Display the user profile dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        return view('user.profile.dashboard', compact('user'));
    }

    /**
     * Display the user's orders.
     */
    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with('orderItems', 'payment')
            ->latest()
            ->paginate(8);

        return view('user.profile.orders', compact('orders', 'user'));
    }

    /**
     * Display details for a specific order.
     */
    public function orderDetails($id)
    {
        $user = Auth::user();
        $order = Order::where('id', $id)
            ->where('user_id', $user->id)
            ->with('orderItems.product', 'payment')
            ->firstOrFail();

        return response()->json([
            'html' => view('user.profile.order-details', compact('order'))->render()
        ]);
    }
}
