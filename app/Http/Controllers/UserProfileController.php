<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Address;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

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

    /**
     * Download invoice for a specific order
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function downloadInvoice($id)
    {
        try {
            Log::info("Downloading invoice for order ID: " . $id . " by user: " . Auth::id());

            $order = Order::where('id', $id)
                ->where('user_id', Auth::id())
                ->with('invoice')
                ->firstOrFail();

            if (!$order->invoice) {
                Log::error("No invoice available for order ID: " . $id);
                return back()->with('error', 'No invoice available for this order.');
            }

            $pdfPath = $this->invoiceService->getInvoicePDFPath($order->invoice);

            if (!$pdfPath || !Storage::exists('public/' . $pdfPath)) {
                Log::error("Invoice file not found at path: " . $pdfPath);
                return back()->with('error', 'Invoice file not found.');
            }

            Log::info("Invoice file found, initiating download...");

            return Storage::download('public/' . $pdfPath, $order->invoice->invoice_number . '.pdf');
        } catch (\Exception $e) {
            Log::error("Error downloading invoice: " . $e->getMessage());
            return back()->with('error', 'Error downloading invoice.');
        }
    }

    /**
     * Display the user's addresses.
     */
    public function addresses()
    {
        $user = Auth::user();
        return view('user.profile.addresses', compact('user'));
    }
}
