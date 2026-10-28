<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display verified customer & employer reviews.
     */
    public function index(Request $request)
    {
        $allReviews = [
            [
                'id' => 1,
                'author' => 'Sarah M.',
                'title' => 'Director of HR Operations',
                'company' => 'Pinnacle Logistics Corp',
                'location' => 'Atlanta, GA (Quest Diagnostics Site)',
                'category' => 'pre-employment',
                'rating' => 5,
                'date' => 'October 24, 2026',
                'test_taken' => '10-Panel Pre-Employment Urine Screen',
                'review' => 'We onboarded 14 warehouse operators across Georgia and Florida. The electronic donor passes arrived instantly by SMS, candidates walked into nearby Quest facilities without appointments, and every negative result was posted within 24 hours. Phenomenal corporate platform.',
            ],
            [
                'id' => 2,
                'author' => 'David K.',
                'title' => 'Commercial CDL Owner-Operator',
                'company' => 'Lone Star Freight LLC',
                'location' => 'Dallas, TX (Labcorp Site)',
                'category' => 'dot',
                'rating' => 5,
                'date' => 'October 21, 2026',
                'test_taken' => '5-Panel DOT Drug Screen (FMCSA)',
                'review' => 'Needed a mandatory pre-employment DOT screen to activate my commercial authority. Purchased the pass at 8:30 AM, walked into Labcorp on Stemmons Freeway at 9:15 AM with my barcode on my phone. Kept my CDL 100% compliant with zero hassle.',
            ],
            [
                'id' => 3,
                'author' => 'Marcus T.',
                'title' => 'Verified Donor',
                'company' => 'Court & Family Law Case',
                'location' => 'Phoenix, AZ (Quest Diagnostics Site)',
                'category' => 'legal',
                'rating' => 5,
                'date' => 'October 18, 2026',
                'test_taken' => '10-Panel + Expanded Opiates with MRO',
                'review' => 'My family court proceeding required an official MRO-reviewed 10-panel drug test with strict chain of custody. The report was stamped, certified, and accepted by the presiding judge without hesitation. Delivered to my email in 36 hours.',
            ],
            [
                'id' => 4,
                'author' => 'Elena R.',
                'title' => 'Family Health Administrator',
                'company' => 'Personal & Family Health',
                'location' => 'Chicago, IL (Labcorp Site)',
                'category' => 'hair',
                'rating' => 5,
                'date' => 'October 15, 2026',
                'test_taken' => '5-Panel Hair Follicle Test (90-Day Window)',
                'review' => 'I needed 90-day historical testing for personal family peace of mind. The collection technician at Labcorp was courteous and discreet, taking a tiny, invisible hair sample. Detailed laboratory results arrived in 4 business days.',
            ],
            [
                'id' => 5,
                'author' => 'Robert C.',
                'title' => 'Fleet Safety Supervisor',
                'company' => 'Southeast Civil Contracting',
                'location' => 'Orlando, FL (Quest Diagnostics Site)',
                'category' => 'dot',
                'rating' => 5,
                'date' => 'October 12, 2026',
                'test_taken' => 'DOT Random Consortium & MIS Reporting',
                'review' => 'Managing quarterly random testing draws for 45 commercial dump truck drivers used to be a headache. Certified Drug Test Centers automated our random pool, handles Clearinghouse submissions, and provides audit-ready MIS reports.',
            ],
            [
                'id' => 6,
                'author' => 'Amanda W.',
                'title' => 'Registered Nurse Applicant',
                'company' => 'Healthcare Staffing',
                'location' => 'Denver, CO (Quest Diagnostics Site)',
                'category' => 'walk-in',
                'rating' => 5,
                'date' => 'October 08, 2026',
                'test_taken' => '5-Panel Standard NON-DOT Test',
                'review' => 'Ordered online while sitting in my car in the parking lot. Walked inside Quest in Denver, showed the barcode on my phone, gave my sample, and was back in my car in 15 minutes. Best testing experience I have ever had.',
            ],
            [
                'id' => 7,
                'author' => 'Carlos G.',
                'title' => 'Safety & Compliance Manager',
                'company' => 'Gulf Coast Distribution',
                'location' => 'Houston, TX (Mobile Dispatch)',
                'category' => 'pre-employment',
                'rating' => 5,
                'date' => 'October 05, 2026',
                'test_taken' => '24/7 Post-Accident Rapid Response',
                'review' => 'When a minor warehouse forklift collision occurred late in the afternoon, we needed immediate post-accident screening. Certified Drug Test Centers dispatched collection authorization within 40 minutes, completely protecting our liability.',
            ],
            [
                'id' => 8,
                'author' => 'Jennifer L.',
                'title' => 'Talent Acquisition Director',
                'company' => 'Tech Logistics Inc',
                'location' => 'Charlotte, NC (Quest Diagnostics Site)',
                'category' => 'pre-employment',
                'rating' => 5,
                'date' => 'September 29, 2026',
                'test_taken' => '12-Panel Comprehensive Urine Test',
                'review' => 'The employer portal is intuitive and clean. We order passes for remote hires nationwide, receive immediate status updates when specimens are collected, and get consolidated monthly billing.',
            ],
            [
                'id' => 9,
                'author' => 'Brian H.',
                'title' => 'Electrical Contractor',
                'company' => 'Commercial Construction',
                'location' => 'Columbus, OH (Labcorp Site)',
                'category' => 'walk-in',
                'rating' => 5,
                'date' => 'September 24, 2026',
                'test_taken' => '5-Panel Standard NON-DOT Test',
                'review' => 'General contractor required a negative drug test before allowing subcontractors onto a data center jobsite. I ordered on my phone at 7 AM, visited Labcorp at 8 AM, and had my official clearance in time to start work next day.',
            ],
            [
                'id' => 10,
                'author' => 'Patricia N.',
                'title' => 'Verified Donor',
                'company' => 'Legal Monitoring Client',
                'location' => 'Las Vegas, NV (Quest Diagnostics Site)',
                'category' => 'legal',
                'rating' => 5,
                'date' => 'September 18, 2026',
                'test_taken' => 'EtG 80-Hour Alcohol Urine Screen',
                'review' => 'My probation monitoring officer required an EtG test. The chain of custody was flawless and the Medical Review Officer report satisfied all county court requirements. Very affordable price compared to hospital outpatient labs.',
            ],
            [
                'id' => 11,
                'author' => 'Kevin M.',
                'title' => 'Charter Transit Driver',
                'company' => 'Mid-Atlantic Charters',
                'location' => 'Philadelphia, PA (Quest Diagnostics Site)',
                'category' => 'dot',
                'rating' => 5,
                'date' => 'September 14, 2026',
                'test_taken' => 'DOT Breath Alcohol & 5-Panel Screen',
                'review' => 'Quick, certified testing by a knowledgeable collector who understood DOT 49 CFR Part 40 rules. Kept the paper federal custody form properly documented and submitted to my company DER.',
            ],
            [
                'id' => 12,
                'author' => 'Rachel S.',
                'title' => 'Executive Office Manager',
                'company' => 'Horizon Biosystems',
                'location' => 'Seattle, WA (On-Site Collection)',
                'category' => 'pre-employment',
                'rating' => 5,
                'date' => 'September 09, 2026',
                'test_taken' => 'On-Site Mobile Testing (35 Employees)',
                'review' => 'Organized an annual workplace drug screen for our entire headquarters staff. The mobile collector arrived promptly with all supplies, processed everyone smoothly, and minimized employee downtime.',
            ],
        ];

        $filter = $request->input('category', 'all');

        $filteredReviews = $filter === 'all'
            ? $allReviews
            : array_values(array_filter($allReviews, fn($r) => $r['category'] === $filter));

        return view('reviews.index', compact('filteredReviews', 'filter', 'allReviews'));
    }
}
