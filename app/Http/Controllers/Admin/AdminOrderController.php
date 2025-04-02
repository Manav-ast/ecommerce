<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\InvoiceService;
use \Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class AdminOrderController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->middleware('can:manage_orders');
        $this->invoiceService = $invoiceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(8);
        return view('admin.orders.index', compact('orders'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function search(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = $request->q;

                $orders = Order::where('id', 'LIKE', "%{$query}%")
                    ->orWhereHas('user', function ($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%");
                    })
                    ->orWhere('order_status', 'LIKE', "%{$query}%") // Added order status search
                    ->with('user')
                    ->get();

                $output = '';
                if ($orders->isNotEmpty()) {
                    foreach ($orders as $order) {
                        $statusClass = match ($order->order_status) {
                            'pending' => 'bg-yellow-500',
                            'shipped' => 'bg-blue-500',
                            'delivered' => 'bg-green-500',
                            default => 'bg-red-500',
                        };

                        $output .= '
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition" data-order-id="' . $order->id . '">
                        <td class="px-6 py-3 text-gray-800">' . $order->id . '</td>
                        <td class="px-6 py-3 text-gray-800">' . e(optional($order->user)->name ?? 'Guest') . '</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded-lg text-white ' . $statusClass . '">
                                ' . ucfirst($order->order_status) . '
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-600">$' . number_format($order->total_price, 2) . '</td>
                        <td class="px-6 py-3 text-gray-600">' . date('d M, Y', strtotime($order->order_date)) . '</td>
                        <td class="px-12 py-3 flex space-x-4">
                            <!-- View Button -->
                            <button type="button" onclick="openViewModal(' . $order->id . ')"
                                class="text-green-500 hover:text-green-700 transition">
                                <i class="uil uil-eye"></i>
                            </button>
                        </td>
                    </tr>';
                    }
                } else {
                    $output = '<tr><td colspan="6" class="text-center py-3 text-gray-600">No orders found</td></tr>';
                }

                return response()->json(['html' => $output]);
            }
        } catch (\Exception $e) {
            Log::error("Error searching orders: " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong while searching orders.'], 500);
        }
    }


    public function details($id)
    {
        try {
            // Fetch order with related data (using explicit eager loading despite model defaults)
            $order = Order::with(['orderItems.product', 'payment', 'user.addresses'])->find($id);

            if (!$order) {
                return response()->json(['error' => 'Order not found.'], 404);
            }

            // Debugging: Check what data is returned
            Log::info("Order Details: ", $order->toArray());

            // Render the partial view
            $html = view('admin.orders.partials.order_details', compact('order'))->render();

            return response()->json(['html' => $html]);
        } catch (\Exception $e) {
            Log::error("Error fetching order details: " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong while fetching order details.'], 500);
        }
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            // Validate the request
            $request->validate([
                'order_status' => 'required|string|in:pending,shipped,delivered,cancelled',
            ]);

            // Find the order
            $order = Order::findOrFail($id);

            // Update only the order status, not touching payment status
            $oldStatus = $order->order_status;
            $order->order_status = $request->order_status;
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'old_status' => $oldStatus,
                'new_status' => $order->order_status
            ]);
        } catch (\Exception $e) {
            Log::error("Error updating order status: " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong while updating order status.'], 500);
        }
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
            $order = Order::with('invoice')->findOrFail($id);

            if (!$order->invoice) {
                return back()->with('error', 'No invoice available for this order.');
            }

            $pdfPath = $this->invoiceService->getInvoicePDFPath($order->invoice);

            if (!$pdfPath || !Storage::exists('public/' . $pdfPath)) {
                return back()->with('error', 'Invoice file not found.');
            }

            return Storage::download('public/' . $pdfPath, $order->invoice->invoice_number . '.pdf');
        } catch (\Exception $e) {
            Log::error("Error downloading invoice: " . $e->getMessage());
            return back()->with('error', 'Error downloading invoice.');
        }
    }
}
