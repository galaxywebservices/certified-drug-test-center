<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function show()
    {
        $pageTitle = "Contact Certified Drug Test Centers | Nationwide Scheduling & Inquiries";
        $metaDescription = "Get in touch with Certified Drug Test Centers for employer drug testing accounts, background screening quotes, or test scheduling questions. Toll-Free: (800)-985-4339.";
        $canonicalUrl = url('/contact-us');

        return view('pages.contact', compact('pageTitle', 'metaDescription', 'canonicalUrl'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:150',
            'service_type' => 'required|string|max:100',
            'message' => 'required|string|max:3000',
        ]);

        $validated['ip_address'] = $request->ip();
        $validated['status'] = 'new';

        $lead = Lead::create($validated);

        Log::info("New lead submitted: #{$lead->id} from {$lead->name} ({$lead->email})");

        return back()->with('success', 'Thank you for reaching out! A Certified Drug Test Centers specialist will review your inquiry and contact you shortly.');
    }

    public function submitMobileQuote(Request $request)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:150',
            'name' => 'required|string|max:150',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:150',
            'location' => 'required|string|max:150',
            'donors' => 'required|string|max:50',
            'notes' => 'nullable|string|max:2000',
        ]);

        $messageLines = [
            "Mobile On-Site Testing Quote Request",
            "Location: {$validated['location']}",
            "Estimated Donors: {$validated['donors']}",
        ];
        if (!empty($validated['notes'])) {
            $messageLines[] = "Requirements / Date: {$validated['notes']}";
        }

        $lead = Lead::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company'],
            'service_type' => 'mobile-testing',
            'message' => implode("\n", $messageLines),
            'status' => 'new',
            'ip_address' => $request->ip(),
        ]);

        Log::info("New mobile quote lead submitted: #{$lead->id} from {$lead->name} ({$lead->email}) - {$validated['company']}");

        return response()->json([
            'success' => true,
            'message' => 'Mobile testing request received! A corporate coordinator will contact you within 15 minutes.',
        ]);
    }
}
