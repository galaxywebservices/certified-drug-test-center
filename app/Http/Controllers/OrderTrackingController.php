<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Mail\DonorPassMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OrderTrackingController extends Controller
{
    /**
     * Show the Order Tracking & Donor Pass Lookup Form
     */
    public function index(Request $request)
    {
        $order = null;
        $orderNumber = trim($request->query('order', ''));
        $email = trim($request->query('email', ''));

        if (!empty($orderNumber) && !empty($email)) {
            $order = Order::with(['items.product', 'location'])
                ->where('order_number', strtoupper($orderNumber))
                ->where('donor_email', $email)
                ->first();
        }

        $pageTitle = "Track Order & Electronic Donor Pass Lookup | Certified Drug Test Centers";
        $metaDescription = "Lookup your electronic Donor Pass, check laboratory testing status, or resend your authorization barcode for Quest Diagnostics and Labcorp collection centers.";

        return view('orders.track', compact('order', 'orderNumber', 'email', 'pageTitle', 'metaDescription'));
    }

    /**
     * Lookup Order by Order Number & Email
     */
    public function lookup(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|string|max:50',
            'email' => 'required|email|max:150',
        ], [
            'order_number.required' => 'Please enter your CDTC order number (e.g., CDTC-A1B2C3D4).',
            'email.required' => 'Please enter the email address used during registration.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        $orderNumber = strtoupper(trim($validated['order_number']));
        $email = strtolower(trim($validated['email']));

        $order = Order::with(['items.product', 'location'])
            ->where('order_number', $orderNumber)
            ->whereRaw('LOWER(donor_email) = ?', [$email])
            ->first();

        if (!$order) {
            return back()->withInput()->with('error', 'No registration found matching Order #' . $orderNumber . ' and email ' . $email . '. Please check your receipt or contact national dispatch at (800)-985-4339.');
        }

        $pageTitle = "Order #{$order->order_number} Status & Donor Pass | Certified Drug Test Centers";
        $metaDescription = "View testing status and electronic donor pass for Order #{$order->order_number}.";

        return view('orders.track', [
            'order' => $order,
            'orderNumber' => $order->order_number,
            'email' => $order->donor_email,
            'pageTitle' => $pageTitle,
            'metaDescription' => $metaDescription,
        ]);
    }

    /**
     * Resend the Electronic Donor Pass email
     */
    public function resend(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|string',
            'email' => 'required|email',
        ]);

        $order = Order::where('order_number', strtoupper(trim($validated['order_number'])))
            ->whereRaw('LOWER(donor_email) = ?', [strtolower(trim($validated['email']))])
            ->first();

        if (!$order) {
            return back()->with('error', 'Order not found. Please verify your details.');
        }

        try {
            Mail::to($order->donor_email)->send(new DonorPassMail($order));
            return back()->with('success', "Electronic Donor Pass has been re-sent to {$order->donor_email}. Please check your inbox and spam folder.");
        } catch (\Throwable $e) {
            Log::error('OrderTrackingController::resend error: ' . $e->getMessage());
            return back()->with('error', 'Unable to send email right now. Please print your Donor Pass directly below or call dispatch at (800)-985-4339.');
        }
    }
}
