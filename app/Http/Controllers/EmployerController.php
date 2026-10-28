<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmployerController extends Controller
{
    /**
     * Display the Employer & Corporate Testing Solutions page.
     */
    public function index()
    {
        // Reference products for calculator and rate benchmark
        $benchmarkProducts = [
            '5-panel-nondot' => Product::where('slug', '5-panel-nondot')->first() ?? (object)[
                'name' => '5-Panel Standard Urine',
                'price' => 89.99,
                'specimen_type' => 'Urine',
                'turnaround' => '24 - 48 Hours',
            ],
            '10-panel' => Product::where('slug', '10-panel')->first() ?? (object)[
                'name' => '10-Panel Comprehensive Urine',
                'price' => 109.99,
                'specimen_type' => 'Urine',
                'turnaround' => '24 - 48 Hours',
            ],
            '5-panel-dot' => Product::where('slug', '5-panel-dot')->first() ?? (object)[
                'name' => '5-Panel DOT Drug Screen',
                'price' => 99.99,
                'specimen_type' => 'DOT Urine',
                'turnaround' => '24 - 48 Hours',
            ],
            '5-panel-hair' => Product::where('slug', '5-panel-hair')->first() ?? (object)[
                'name' => '5-Panel Hair Follicle',
                'price' => 139.99,
                'specimen_type' => 'Hair Follicle',
                'turnaround' => '3 - 5 Business Days',
            ],
        ];

        $faqs = [
            [
                'question' => 'How quickly can our company set up an active corporate testing account?',
                'answer' => 'Corporate accounts can be established in as little as 2 hours. Once activated, your authorized HR and safety managers can order donor passes directly, track live specimen status, and review MRO-verified results via your secure portal.',
            ],
            [
                'question' => 'Do you provide consolidated monthly Net-30 invoicing for employers?',
                'answer' => 'Yes. Qualified employers conducting regular pre-employment or random compliance testing can be approved for consolidated monthly Net-30 billing with itemized donor breakdowns, eliminating individual employee credit card expense reports.',
            ],
            [
                'question' => 'How are electronic donor passes delivered to our remote job candidates?',
                'answer' => 'Our system instantly delivers electronic donor passes directly to candidates via SMS text and secure email. Each pass contains a scannable barcoded authorization, specimen collection instructions, and turn-by-turn directions to the closest certified Quest Diagnostics or Labcorp facility.',
            ],
            [
                'question' => 'Does Certified Drug Test Centers manage DOT Consortium & Random Testing Pools?',
                'answer' => 'Yes. We administer complete DOT drug and alcohol consortium compliance for FMCSA, FAA, FRA, FTA, PHMSA, and USCG regulated employers. This includes quarterly computerized random draws, MIS audit reporting, and FMCSA Clearinghouse query management.',
            ],
            [
                'question' => 'How are non-negative or inconclusive results handled?',
                'answer' => 'All non-negative laboratory screening results undergo mandatory gas chromatography-mass spectrometry (GC/MS or LC/MS) confirmation testing and are reviewed by a licensed Medical Review Officer (MRO) who contacts the donor to verify legitimate prescription medications before issuing a final report.',
            ],
        ];

        return view('employers.index', compact('benchmarkProducts', 'faqs'));
    }

    /**
     * Handle corporate account registration and bulk candidate intake.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:150',
            'industry' => 'nullable|string|max:100',
            'contact_name' => 'required|string|max:150',
            'job_title' => 'nullable|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:50',
            'monthly_volume' => 'nullable|string|max:50',
            'billing_preference' => 'nullable|string|max:100',
            'programs' => 'nullable|array',
            'dot_regulated' => 'nullable|string|in:yes,no,both',
            'notes' => 'nullable|string|max:3000',
            'candidates' => 'nullable|array',
            'candidates.*.name' => 'nullable|string|max:150',
            'candidates.*.email' => 'nullable|email|max:150',
            'candidates.*.phone' => 'nullable|string|max:50',
            'candidates.*.test_panel' => 'nullable|string|max:100',
            'candidates.*.zip' => 'nullable|string|max:10',
        ]);

        $referenceCode = 'CDTC-CORP-' . strtoupper(Str::random(6));

        // Format detailed structured message
        $programsList = !empty($validated['programs']) ? implode(', ', $validated['programs']) : 'General Corporate Screening';
        $dotStatus = match ($validated['dot_regulated'] ?? 'no') {
            'yes' => 'DOT Regulated (FMCSA/FAA/FTA/PHMSA/FRA/USCG)',
            'both' => 'Mixed Fleet (Both DOT and Non-DOT Workforce)',
            default => 'Non-DOT Commercial Workforce',
        };

        $messageLines = [
            "=== CORPORATE ACCOUNT APPLICATION [{$referenceCode}] ===",
            "Company: {$validated['company_name']}",
            "Industry: " . ($validated['industry'] ?? 'Not specified'),
            "Contact: {$validated['contact_name']} (" . ($validated['job_title'] ?? 'Administrator') . ")",
            "Email: {$validated['email']}",
            "Phone: {$validated['phone']}",
            "Estimated Monthly Volume: " . ($validated['monthly_volume'] ?? '1-10 tests/mo'),
            "Billing Preference: " . ($validated['billing_preference'] ?? 'Credit Card on File'),
            "DOT Compliance Status: {$dotStatus}",
            "Required Programs: {$programsList}",
        ];

        if (!empty($validated['notes'])) {
            $messageLines[] = "\nSpecial Requirements / Notes:\n" . trim($validated['notes']);
        }

        // Process candidate roster if submitted
        $candidates = array_filter($validated['candidates'] ?? [], function ($c) {
            return !empty($c['name']) || !empty($c['email']);
        });

        if (!empty($candidates)) {
            $messageLines[] = "\n--- INITIAL CANDIDATE ROSTER (" . count($candidates) . " Candidates) ---";
            foreach ($candidates as $idx => $candidate) {
                $num = $idx + 1;
                $cName = $candidate['name'] ?? 'Candidate';
                $cEmail = $candidate['email'] ?? 'No email';
                $cPhone = $candidate['phone'] ?? 'No phone';
                $cPanel = $candidate['test_panel'] ?? 'Standard 5-Panel';
                $cZip = $candidate['zip'] ?? 'N/A';
                $messageLines[] = "{$num}. {$cName} | {$cEmail} | {$cPhone} | Panel: {$cPanel} | Preferred ZIP: {$cZip}";
            }
        }

        $formattedMessage = implode("\n", $messageLines);

        Lead::create([
            'name' => $validated['contact_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company_name'],
            'service_type' => 'corporate-account',
            'message' => $formattedMessage,
            'status' => 'new',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('employers.index')
            ->with('corporate_success', true)
            ->with('reference_code', $referenceCode)
            ->with('company_name', $validated['company_name'])
            ->with('candidate_count', count($candidates));
    }
}
