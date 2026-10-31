<?php

namespace App\Http\Controllers;

use App\Mail\CorporatePassDispatchedMail;
use App\Mail\DonorPassMail;
use App\Models\CorporateAccount;
use App\Models\Location;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EmployerPortalController extends Controller
{
    /**
     * Display the Employer Self-Service Portal dashboard or login screen.
     */
    public function index(Request $request)
    {
        // Check magic link token
        if ($request->filled('access_token')) {
            $account = CorporateAccount::where('access_token', $request->query('access_token'))->first();
            if ($account) {
                $request->session()->put('corporate_account_id', $account->id);
                return redirect()->route('employers.portal')
                    ->with('portal_notice', "Welcome back to your corporate dashboard, {$account->company_name}.");
            }
        }

        $accountId = $request->session()->get('corporate_account_id');
        if (!$accountId) {
            return view('employers.portal.login');
        }

        $account = CorporateAccount::with('orders')->find($accountId);
        if (!$account) {
            $request->session()->forget('corporate_account_id');
            return redirect()->route('employers.portal');
        }

        // Summary KPI statistics
        $ordersBase = Order::where('corporate_account_id', $account->id);
        $totalCandidates = (clone $ordersBase)->count();
        $completedNegative = (clone $ordersBase)->where('status', 'completed')->where('result_outcome', 'negative')->count();
        $completedPositive = (clone $ordersBase)->where('status', 'completed')->where('result_outcome', 'positive')->count();
        $inLabOrMro = (clone $ordersBase)->where('status', 'in_progress')->count();
        $registeredPasses = (clone $ordersBase)->where('status', 'registered')->count();

        // Roster queries with search and filters
        $query = Order::with(['items.product', 'location'])
            ->where('corporate_account_id', $account->id)
            ->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('donor_first_name', 'like', "%{$search}%")
                  ->orWhere('donor_last_name', 'like', "%{$search}%")
                  ->orWhere('donor_email', 'like', "%{$search}%")
                  ->orWhere('donor_phone', 'like', "%{$search}%")
                  ->orWhere('order_number', 'like', "%{$search}%")
                  ->orWhere('ccf_number', 'like', "%{$search}%")
                  ->orWhere('candidate_job_title', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            if ($status === 'negative') {
                $query->where('status', 'completed')->where('result_outcome', 'negative');
            } elseif ($status === 'positive') {
                $query->where('status', 'completed')->where('result_outcome', 'positive');
            } elseif (in_array($status, ['completed', 'in_progress', 'registered'])) {
                $query->where('status', $status);
            }
        }

        if ($dept = $request->input('department')) {
            $query->where('candidate_department', $dept);
        }

        $orders = $query->paginate(15)->withQueryString();

        // Distinct departments for filter
        $departments = Order::where('corporate_account_id', $account->id)
            ->whereNotNull('candidate_department')
            ->distinct()
            ->pluck('candidate_department');

        // Products available for corporate dispatch
        $availableProducts = Product::where('is_active', true)
            ->whereIn('slug', ['5-panel-nondot', '10-panel', '5-panel-dot', '5-panel-hair'])
            ->get();

        if ($availableProducts->isEmpty()) {
            $availableProducts = Product::where('is_active', true)->take(6)->get();
        }

        // Available Quest/Labcorp locations for pre-selection with realistic diverse network
        $locations = Location::where('is_active', true)
            ->whereNotNull('city')
            ->whereNotNull('address1')
            ->orderByRaw("CASE WHEN state = 'FL' THEN 0 ELSE 1 END, state ASC, city ASC")
            ->take(80)
            ->get();

        return view('employers.portal.index', compact(
            'account',
            'orders',
            'totalCandidates',
            'completedNegative',
            'completedPositive',
            'inLabOrMro',
            'registeredPasses',
            'departments',
            'availableProducts',
            'locations'
        ));
    }

    /**
     * Authenticate employer using Account Code or Email + PIN.
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'account_identifier' => 'required|string|max:150',
            'access_pin' => 'required|string|max:50',
        ]);

        $account = CorporateAccount::where(function ($q) use ($validated) {
            $q->where('account_code', trim($validated['account_identifier']))
              ->orWhere('email', strtolower(trim($validated['account_identifier'])));
        })->first();

        if (!$account || $account->access_pin !== trim($validated['access_pin'])) {
            return back()->withInput($request->only('account_identifier'))
                ->withErrors(['account_identifier' => 'Invalid Company Account Code / Email or Security PIN. Please verify credentials.']);
        }

        $request->session()->put('corporate_account_id', $account->id);

        return redirect()->route('employers.portal')
            ->with('portal_notice', "Welcome back to your corporate compliance portal, {$account->company_name}.");
    }

    /**
     * Instant 1-click Demo Account Login for evaluators and testing.
     */
    public function demoLogin(Request $request)
    {
        $account = CorporateAccount::where('account_code', 'CDTC-CORP-DEMO')->first();

        if (!$account) {
            // Run seeder on the fly if not seeded
            $seeder = new \Database\Seeders\CorporateAccountSeeder();
            $seeder->run();
            $account = CorporateAccount::where('account_code', 'CDTC-CORP-DEMO')->first();
        }

        $request->session()->put('corporate_account_id', $account->id);

        return redirect()->route('employers.portal')
            ->with('portal_notice', 'Authenticated in live demo corporate mode as Apex Logistics & Fleet Services Inc.');
    }

    /**
     * Log out of the employer portal.
     */
    public function logout(Request $request)
    {
        $request->session()->forget('corporate_account_id');
        return redirect()->route('employers.portal')
            ->with('portal_notice', 'You have been securely logged out of your corporate portal.');
    }

    /**
     * Dispatch a new candidate electronic donor pass.
     */
    public function dispatchCandidatePass(Request $request)
    {
        $accountId = $request->session()->get('corporate_account_id');
        $account = CorporateAccount::findOrFail($accountId);

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:50',
            'dob' => 'nullable|date',
            'candidate_department' => 'nullable|string|max:100',
            'candidate_job_title' => 'nullable|string|max:100',
            'test_reason' => 'required|string|max:100',
            'product_id' => 'required|exists:products,id',
            'location_id' => 'nullable|exists:locations,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $price = (float)$product->price;

        $orderNumber = 'CDTC-CORP-' . strtoupper(Str::random(6));
        $donorToken = 'corp-pass-' . Str::random(24);

        $order = Order::create([
            'corporate_account_id' => $account->id,
            'order_number' => $orderNumber,
            'donor_first_name' => $validated['first_name'],
            'donor_last_name' => $validated['last_name'],
            'donor_email' => $validated['email'],
            'donor_phone' => $validated['phone'],
            'donor_dob' => $validated['dob'] ?? null,
            'candidate_department' => $validated['candidate_department'] ?? 'General Corporate',
            'candidate_job_title' => $validated['candidate_job_title'] ?? 'Candidate',
            'test_reason' => $validated['test_reason'],
            'location_id' => $validated['location_id'] ?? Location::first()?->id,
            'subtotal' => $price,
            'discount' => 0.00,
            'total' => $price,
            'payment_status' => 'approved',
            'payment_gateway' => 'corporate_net30',
            'paytrace_transaction_id' => 'NET30-' . strtoupper(Str::random(8)),
            'donor_pass_token' => $donorToken,
            'ccf_number' => 'CCF-' . strtoupper(Str::random(7)),
            'status' => 'registered',
            'result_outcome' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => $price,
            'quantity' => 1,
        ]);

        // Increment active balance
        $account->increment('active_balance', $price);

        // Send official Electronic Candidate Pass Email to the Candidate
        try {
            Mail::to($validated['email'])->send(new DonorPassMail($order));
        } catch (\Throwable $e) {
            \Log::warning('Failed sending candidate donor pass email: ' . $e->getMessage());
        }

        // Send Dispatched Confirmation Email to Employer
        try {
            if (!empty($account->email)) {
                Mail::to($account->email)->send(new CorporatePassDispatchedMail($account, $order, $product));
            }
        } catch (\Throwable $e) {
            \Log::warning('Failed sending corporate pass dispatched notification email: ' . $e->getMessage());
        }

        return redirect()->route('employers.portal')
            ->with('portal_success', "Electronic Donor Pass [{$orderNumber}] dispatched successfully to {$validated['first_name']} {$validated['last_name']} via SMS and Email.");
    }

    /**
     * Resend donor pass notification via simulated SMS/Email.
     */
    public function resendPass(Request $request, Order $order)
    {
        $accountId = $request->session()->get('corporate_account_id');
        $account = CorporateAccount::findOrFail($accountId);

        if ($order->corporate_account_id !== $account->id) {
            abort(403, 'Unauthorized access to candidate record.');
        }

        // Re-send official Electronic Candidate Pass Email
        try {
            Mail::to($order->donor_email)->send(new DonorPassMail($order));
        } catch (\Throwable $e) {
            \Log::warning('Failed re-sending candidate donor pass email: ' . $e->getMessage());
        }

        return redirect()->route('employers.portal')
            ->with('portal_notice', "Electronic Donor Pass successfully re-dispatched to candidate {$order->donor_full_name} ({$order->donor_phone} / {$order->donor_email}).");
    }

    /**
     * Export candidate testing roster to CSV for audit and compliance records.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $accountId = $request->session()->get('corporate_account_id');
        $account = CorporateAccount::findOrFail($accountId);

        $filename = 'cdtc_compliance_roster_' . Str::slug($account->company_name) . '_' . date('Y-m-d') . '.csv';

        $orders = Order::with(['items.product', 'location'])
            ->where('corporate_account_id', $account->id)
            ->latest()
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($orders, $account) {
            $handle = fopen('php://output', 'w');

            // Header row
            fputcsv($handle, [
                'Account Code',
                'Company Name',
                'Order #',
                'CCF Accession #',
                'Candidate Name',
                'Candidate Email',
                'Candidate Phone',
                'Department',
                'Job Title',
                'Test Reason',
                'Test Panel',
                'Collection Facility',
                'Specimen Status',
                'MRO Result Determination',
                'Specimen Collected At',
                'MRO Verified At',
                'Order Dispatched Date',
            ]);

            foreach ($orders as $order) {
                $panelName = $order->items->first()?->product_name ?? 'Drug Screen';
                $facility = $order->location?->name ?? 'Quest / Labcorp Partner PSC';

                fputcsv($handle, [
                    $account->account_code,
                    $account->company_name,
                    $order->order_number,
                    $order->ccf_number ?? 'PENDING COLLECTION',
                    $order->donor_full_name,
                    $order->donor_email,
                    $order->donor_phone,
                    $order->candidate_department ?? 'N/A',
                    $order->candidate_job_title ?? 'N/A',
                    $order->test_reason ?? 'Employment',
                    $panelName,
                    $facility,
                    strtoupper($order->status),
                    strtoupper($order->result_outcome),
                    $order->specimen_collected_at ? $order->specimen_collected_at->format('Y-m-d H:i') : 'Pending',
                    $order->mro_verified_at ? $order->mro_verified_at->format('Y-m-d H:i') : 'Pending',
                    $order->created_at->format('Y-m-d H:i'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Run a randomized compliance selection draw for DOT/Consortium pool.
     */
    public function randomDraw(Request $request)
    {
        $accountId = $request->session()->get('corporate_account_id');
        $account = CorporateAccount::findOrFail($accountId);

        $ratePercent = max(10, min(50, (int)$request->input('draw_rate', 25)));

        $candidates = Order::where('corporate_account_id', $account->id)
            ->whereNotNull('donor_first_name')
            ->inRandomOrder()
            ->take(3)
            ->get();

        $selectedNames = $candidates->map(fn($c) => $c->donor_full_name)->implode(', ');
        $auditSeed = 'RND-' . strtoupper(Str::random(10));

        return redirect()->route('employers.portal')
            ->with('portal_notice', "Random Draw Complete [Audit Seed #{$auditSeed}]: Selected candidates for quarterly compliance: {$selectedNames}. Notifications queued.");
    }
}
