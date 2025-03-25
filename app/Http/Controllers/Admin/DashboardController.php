<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Get total revenue from orders
            $totalRevenue = Order::sum('total_price');

            // Get total number of products
            $totalProducts = Product::count();

            // Get total number of categories
            $totalCategories = Category::count();

            // Get total number of orders
            $totalOrders = Order::count();

            // Get recent orders for dashboard
            $recentOrders = Order::with('user')
                ->latest('created_at')
                ->take(5)
                ->get();

            // Get monthly revenue data for the chart
            $monthlyRevenue = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_price) as total')
            )
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get()
                ->map(function ($item) {
                    $monthName = Carbon::createFromDate($item->year, $item->month, 1)->format('M');
                    return [
                        'month' => $monthName,
                        'total' => $item->total
                    ];
                });

            return view("admin.home", compact(
                'totalRevenue',
                'totalProducts',
                'totalCategories',
                'totalOrders',
                'recentOrders',
                'monthlyRevenue'
            ));
        } catch (\Exception $e) {
            Log::error("Error loading dashboard: " . $e->getMessage());
            return back()->with('error', 'Something went wrong while loading the dashboard.');
        }
    }
}
