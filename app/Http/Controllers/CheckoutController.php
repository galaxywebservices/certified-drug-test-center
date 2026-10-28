<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Location;
use App\Services\PayTraceService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected PayTraceService $payTrace;

    public function __construct(PayTraceService $payTrace)
    {
        $this->payTrace = $payTrace;
    }

    public function index(Request $request, ?string $slug = null)
    {
        $product = null;
        if ($slug) {
            $product = Product::where('slug', $slug)->where('is_active', true)->first();
        }

        if (!$product && $request->has('product')) {
            $product = Product::where('slug', $request->input('product'))->where('is_active', true)->first();
        }

        if (!$product && $request->has('product_id')) {
            $product = Product::where('id', $request->input('product_id'))->where('is_active', true)->first();
        }

        if (!$product) {
            $product = Product::where('is_popular', true)->first() ?? Product::first();
        }

        $allProducts = Product::where('is_active', true)->orderBy('position')->get();

        $pageTitle = "Secure Checkout & Test Registration | Certified Drug Test Center";
        $metaDescription = "Register online for your drug or alcohol test in 2 minutes. Walk in today at over 20,000 certified collection centers.";

        return view('checkout.index', compact('product', 'allProducts', 'pageTitle', 'metaDescription'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:50',
            'dob' => 'nullable|date',
            'test_reason' => 'required|string|max:100',
            'zip' => 'required|string|max:10',
            'card_number' => 'required|string',
            'exp' => 'required|string',
            'cvv' => 'required|string|max:4',
            'billing_zip' => 'required|string|max:10',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $total = (float) $product->price;

        // Process payment via PayTrace
        $orderData = [
            'donor_name' => "{$validated['first_name']} {$validated['last_name']}",
            'total' => $total,
        ];

        $paymentData = [
            'card_number' => $validated['card_number'],
            'exp' => $validated['exp'],
            'cvv' => $validated['cvv'],
            'billing_zip' => $validated['billing_zip'],
        ];

        $paymentResult = $this->payTrace->processSale($orderData, $paymentData);

        if (!$paymentResult['success']) {
            return back()->withInput()->with('error', $paymentResult['message'] ?? 'Payment was declined.');
        }

        // Find nearest location if zip provided
        $location = Location::where('zip', 'LIKE', substr($validated['zip'], 0, 3) . '%')->first()
            ?? Location::first();

        // Create Order
        $orderNumber = 'CDTC-' . strtoupper(Str::random(8));
        $token = Str::random(40);

        $order = Order::create([
            'order_number' => $orderNumber,
            'donor_first_name' => $validated['first_name'],
            'donor_last_name' => $validated['last_name'],
            'donor_email' => $validated['email'],
            'donor_phone' => $validated['phone'],
            'donor_dob' => $validated['dob'] ?? null,
            'test_reason' => $validated['test_reason'],
            'location_id' => $location?->id,
            'subtotal' => $total,
            'discount' => 0.00,
            'total' => $total,
            'payment_status' => 'paid',
            'payment_gateway' => 'paytrace',
            'paytrace_transaction_id' => $paymentResult['transaction_id'] ?? null,
            'paytrace_approval_code' => $paymentResult['approval_code'] ?? null,
            'donor_pass_token' => $token,
            'status' => 'registered',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
        ]);

        return redirect()->route('checkout.confirmation', ['token' => $token])
            ->with('success', 'Your test has been successfully ordered and scheduled!');
    }

    public function confirmation(string $token)
    {
        $order = Order::with(['items.product', 'location'])
            ->where('donor_pass_token', $token)
            ->firstOrFail();

        $pageTitle = "Electronic Donor Pass - Order #{$order->order_number} | Certified Drug Test Center";

        return view('checkout.confirmation', compact('order', 'pageTitle'));
    }
}
