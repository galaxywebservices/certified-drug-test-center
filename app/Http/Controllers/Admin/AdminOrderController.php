<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'LIKE', "%{$search}%")
                  ->orWhere('donor_first_name', 'LIKE', "%{$search}%")
                  ->orWhere('donor_last_name', 'LIKE', "%{$search}%")
                  ->orWhere('donor_email', 'LIKE', "%{$search}%")
                  ->orWhere('paytrace_transaction_id', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'location']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'payment_status' => 'required|string',
            'result_outcome' => 'nullable|string',
            'ccf_number' => 'nullable|string|max:50',
            'specimen_collected_at' => 'nullable|date',
            'mro_verified_at' => 'nullable|date',
            'mro_notes' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Auto timestamp specimen collection if status changed to specimen_collected and date not set
        if ($validated['status'] === 'specimen_collected' && empty($validated['specimen_collected_at']) && empty($order->specimen_collected_at)) {
            $validated['specimen_collected_at'] = now();
        }

        // Auto timestamp MRO verification if completed and date not set
        if ($validated['status'] === 'completed' && empty($validated['mro_verified_at']) && empty($order->mro_verified_at)) {
            $validated['mro_verified_at'] = now();
        }

        $order->update($validated);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status, Chain of Custody & laboratory review updated successfully.');
    }

    public function resendPass(Order $order)
    {
        try {
            \Illuminate\Support\Facades\Mail::to($order->donor_email)->send(new \App\Mail\DonorPassMail($order));
            return back()->with('success', "Electronic Donor Pass re-sent to {$order->donor_email}.");
        } catch (\Throwable $e) {
            return back()->with('error', "Could not send email: " . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        $orders = Order::with('items')->latest()->get();
        $filename = "cdtc-orders-" . date('Y-m-d') . ".csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Order Number', 'Date', 'Donor Name', 'Donor Email', 'Donor Phone', 'Testing Reason', 'Tests Ordered', 'Total ($)', 'Payment Status', 'Transaction ID', 'Registration Status'];

        $callback = function() use ($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                $tests = $order->items->pluck('product_name')->implode(', ');
                fputcsv($file, [
                    $order->order_number,
                    $order->created_at ? $order->created_at->format('Y-m-d H:i:s') : '',
                    $order->donor_full_name,
                    $order->donor_email,
                    $order->donor_phone,
                    $order->test_reason,
                    $tests,
                    number_format($order->total, 2),
                    $order->payment_status,
                    $order->paytrace_transaction_id,
                    $order->status,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

