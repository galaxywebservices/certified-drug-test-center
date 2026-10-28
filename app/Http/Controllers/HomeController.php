<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Common data for products, categories, states, and FAQs
     */
    protected function getSharedData(): array
    {
        $products = [
            // Urine Drug Tests
            [
                'id' => '5-panel-non-dot',
                'name' => '5 Panel NON-DOT Drug Test',
                'category' => 'urine',
                'category_label' => 'Urine Testing',
                'price' => 89.99,
                'regular_price' => 119.99,
                'badge' => 'Most Popular',
                'description' => 'The standard 5 Panel Non-DOT screens for the five most abused illicit drug groups with lab verification.',
                'substances' => ['Amphetamines (Meth)', 'Cocaine Metabolites', 'Marijuana (THC)', 'Opiates (Codeine, Morphine, 6-AM Heroin)', 'Phencyclidine (PCP)'],
                'turnaround' => '1 - 2 Business Days',
                'method' => 'Urine Specimen Collection',
                'is_featured' => true,
            ],
            [
                'id' => '5-panel-dot',
                'name' => '5 Panel DOT Drug Test',
                'category' => 'dot',
                'category_label' => 'DOT Regulated',
                'price' => 99.99,
                'regular_price' => 129.99,
                'badge' => 'DOT Mandated',
                'description' => 'Meets all FMCSA, FAA, FRA, FTA, PHMSA and USCG federal drug testing requirements using SAMHSA labs.',
                'substances' => ['Marijuana Metabolites', 'Cocaine Metabolites', 'Phencyclidine (PCP)', 'Opioids (Codeine, Heroin, Morphine, Oxycodone, Oxymorphone, Hydrocodone, Hydromorphone)', 'Amphetamines (Amphetamine, Methamphetamine, MDMA, MDA)'],
                'turnaround' => '24 - 48 Hours',
                'method' => 'DOT Federal Chain of Custody (CCF)',
                'is_featured' => true,
            ],
            [
                'id' => '5-panel-exp-opiates',
                'name' => '5 Panel + Expanded Opiates',
                'category' => 'urine',
                'category_label' => 'Urine Testing',
                'price' => 99.99,
                'regular_price' => 129.99,
                'badge' => 'Prescription Pain Meds',
                'description' => 'Standard 5 panel plus expanded prescription pain medications including Oxycodone, Hydrocodone, and Dilaudid.',
                'substances' => ['Amphetamines', 'Cocaine', 'Marijuana', 'Opiates & Heroin', 'Hydrocodone (Vicodin, Lortab)', 'Hydromorphone (Dilaudid)', 'Oxycodone (OxyContin, Percocet)', 'Oxymorphone (Opana)'],
                'turnaround' => '1 - 2 Business Days',
                'method' => 'Urine Specimen Collection',
                'is_featured' => false,
            ],
            [
                'id' => '10-panel',
                'name' => '10 Panel Drug Test',
                'category' => 'urine',
                'category_label' => 'Urine Testing',
                'price' => 109.99,
                'regular_price' => 149.99,
                'badge' => 'Best Value for Employers',
                'description' => 'Comprehensive 10 panel drug screen covering illicit drugs, prescription sedatives, narcotics, and pain medications.',
                'substances' => ['Amphetamines', 'Barbiturates', 'Benzodiazepines (Xanax, Valium)', 'Cocaine', 'Marijuana', 'MDA / MDMA', 'Methadone', 'Methaqualone (Quaaludes)', 'Opiates', 'PCP', 'Propoxyphene'],
                'turnaround' => '1 - 2 Business Days',
                'method' => 'Urine Specimen Collection',
                'is_featured' => true,
            ],
            [
                'id' => '10-panel-exp-opiates',
                'name' => '10 Panel + Expanded Opiates',
                'category' => 'urine',
                'category_label' => 'Urine Testing',
                'price' => 119.99,
                'regular_price' => 159.99,
                'badge' => 'Healthcare & Probation',
                'description' => 'Full 10 panel screen with expanded semi-synthetic opiate compounds, widely used for safety-sensitive roles.',
                'substances' => ['Amphetamines', 'Barbiturates', 'Benzodiazepines', 'Cocaine', 'Marijuana', 'Methadone', 'Methaqualone', 'PCP', 'Propoxyphene', 'Expanded Opiates (Oxycodone, Oxymorphone, Hydrocodone, Hydromorphone)'],
                'turnaround' => '1 - 2 Business Days',
                'method' => 'Urine Specimen Collection',
                'is_featured' => false,
            ],
            [
                'id' => '12-panel-comprehensive',
                'name' => '12 Panel Comprehensive Drug Test',
                'category' => 'urine',
                'category_label' => 'Urine Testing',
                'price' => 139.99,
                'regular_price' => 179.99,
                'badge' => 'Maximum Detection',
                'description' => 'The ultimate urine screening panel covering all common illicit drugs, sedatives, painkillers, Tramadol, and Meperidine.',
                'substances' => ['Amphetamines', 'Barbiturates', 'Benzodiazepines', 'Cocaine', 'Marijuana', 'Methadone', 'Methaqualone', 'Tramadol (Ultram)', 'Meperidine (Demerol)', 'Opiates & Expanded Opiates', 'PCP', 'Propoxyphene'],
                'turnaround' => '24 - 48 Hours',
                'method' => 'Urine Specimen Collection',
                'is_featured' => true,
            ],
            [
                'id' => 'hair-follicle-5-panel',
                'name' => 'Hair Follicle 5 Panel Drug Test',
                'category' => 'hair',
                'category_label' => 'Hair Testing',
                'price' => 169.99,
                'regular_price' => 209.99,
                'badge' => '90-Day Window',
                'description' => 'Provides an extended 90-day detection window. Cannot be cleansed, diluted, or adulterated.',
                'substances' => ['Amphetamines & Methamphetamine', 'Cocaine Metabolites', 'Marijuana Metabolite', 'Opiates (Codeine, Morphine, 6-AM)', 'Phencyclidine (PCP)'],
                'turnaround' => '2 - 3 Business Days',
                'method' => 'Hair Specimen (1.5 inches from root)',
                'is_featured' => true,
            ],
            [
                'id' => 'hair-follicle-10-panel',
                'name' => 'Hair Follicle 10 Panel Drug Test',
                'category' => 'hair',
                'category_label' => 'Hair Testing',
                'price' => 249.99,
                'regular_price' => 299.99,
                'badge' => 'Long-Term Screening',
                'description' => 'Comprehensive 90-day history testing for 10 substance classes including prescription sedatives and painkillers.',
                'substances' => ['Amphetamines', 'Cocaine', 'Marijuana', 'Opiates & Expanded Opiates', 'PCP', 'Barbiturates', 'Benzodiazepines', 'Methadone', 'Propoxyphene', 'Oxycodone'],
                'turnaround' => '2 - 4 Business Days',
                'method' => 'Hair Specimen Collection',
                'is_featured' => false,
            ],
            [
                'id' => 'dot-breath-alcohol',
                'name' => 'DOT Breath Alcohol Test (BAT)',
                'category' => 'alcohol',
                'category_label' => 'Alcohol Testing',
                'price' => 89.99,
                'regular_price' => 119.99,
                'badge' => 'Immediate Results',
                'description' => 'Conducted by certified Breath Alcohol Technicians (BAT) using Evidential Breath Testing (EBT) devices.',
                'substances' => ['Alcohol Concentration (BAC >= 0.02 Confirmation Protocol)'],
                'turnaround' => 'Instant / Immediate on-site reading',
                'method' => 'Evidential Breath Testing Device (EBT)',
                'is_featured' => false,
            ],
            [
                'id' => 'etg-alcohol-urine',
                'name' => 'EtG Alcohol Test (Urine 80-Hour)',
                'category' => 'alcohol',
                'category_label' => 'Alcohol Testing',
                'price' => 89.99,
                'regular_price' => 119.99,
                'badge' => 'Zero Tolerance / Court',
                'description' => 'Ethyl Glucuronide (EtG) metabolite detects alcohol consumption up to 80 hours after ingestion. Ideal for court or probation.',
                'substances' => ['Ethyl Glucuronide (EtG) & Ethyl Sulfate (EtS)'],
                'turnaround' => '1 - 2 Business Days',
                'method' => 'Urine Specimen Collection',
                'is_featured' => false,
            ],
            [
                'id' => 'dot-physical',
                'name' => 'DOT Physical Examination (FMCSA)',
                'category' => 'occupational',
                'category_label' => 'Occupational Health',
                'price' => 159.99,
                'regular_price' => 199.99,
                'badge' => 'National Registry Doctor',
                'description' => 'FMCSA medical exam conducted by certified NRCME medical examiners. Includes official Medical Examiner Certificate (MEC).',
                'substances' => ['Vision, Hearing, Blood Pressure, Urinalysis dipstick, Physical exam'],
                'turnaround' => 'Same-Day Medical Card Issuance',
                'method' => 'In-Clinic Physical Exam',
                'is_featured' => true,
            ],
            [
                'id' => 'dot-consortium-1-year',
                'name' => '1-Year DOT Consortium Enrollment',
                'category' => 'dot',
                'category_label' => 'DOT Regulated',
                'price' => 99.99,
                'regular_price' => 149.99,
                'badge' => 'Compliance Guaranteed',
                'description' => 'Includes official Certificate of Enrollment for FMCSA audit compliance, random pool selection, and c/TPA administration.',
                'substances' => ['Complete Random Testing Pool Management', 'Annual Compliance Reporting', 'MIS Data Assistance'],
                'turnaround' => 'Instant Certificate Delivery (Email)',
                'method' => 'Automated Random Selection Program',
                'is_featured' => false,
            ],
        ];

        $categories = [
            [
                'id' => 'urine',
                'title' => 'Urine Drug Testing',
                'subtitle' => '5, 10, 12, 14 Panels & Rapid Results',
                'icon' => 'flask',
                'description' => 'Accurate, lab-based urine screenings for pre-employment, post-accident, court-ordered, and personal testing. FDA approved instant cups and SAMHSA certified lab options.',
                'link' => '#pricing-panels',
            ],
            [
                'id' => 'dot',
                'title' => 'DOT Testing & Compliance',
                'subtitle' => 'FMCSA, USCG, FAA, FTA, PHMSA',
                'icon' => 'truck',
                'description' => 'Mandated 5-panel DOT urine drug testing, DOT breath alcohol, physical exams, Clearinghouse management, and DOT random consortium enrollment.',
                'link' => '#pricing-panels',
            ],
            [
                'id' => 'hair',
                'title' => 'Hair Follicle Drug Testing',
                'subtitle' => '90-Day Extended Detection Window',
                'icon' => 'search',
                'description' => 'Cannot be cheated, masked, or cleansed by shampoos. Ideal for legal proceedings, safety-critical hiring, and long-term abstinence verification.',
                'link' => '#pricing-panels',
            ],
            [
                'id' => 'alcohol',
                'title' => 'Alcohol & EtG Testing',
                'subtitle' => 'Breath Alcohol & 80-Hour EtG Urine',
                'icon' => 'shield-check',
                'description' => 'Evidential breath testing for immediate BAC readings or EtG lab tests detecting alcohol consumption up to 80 hours prior.',
                'link' => '#pricing-panels',
            ],
            [
                'id' => 'clinical',
                'title' => 'Lab & Clinical Blood Testing',
                'subtitle' => 'Wellness, STD, Hormones & Titers',
                'icon' => 'heart-pulse',
                'description' => 'Direct access clinical laboratory blood tests with no doctor visit required. Fast confidential electronic results.',
                'link' => '#categories',
            ],
            [
                'id' => 'occupational',
                'title' => 'Occupational Health',
                'subtitle' => 'Physicals, Respirator Fit & TB Tests',
                'icon' => 'user-check',
                'description' => 'Keep your workforce safe and compliant with pre-placement medical physicals, TB skin tests, and respirator evaluations.',
                'link' => '#categories',
            ],
            [
                'id' => 'dna',
                'title' => 'DNA & Paternity Testing',
                'subtitle' => 'Legal AABB & Peace of Mind',
                'icon' => 'dna',
                'description' => 'Court-admissible AABB certified legal DNA paternity tests and non-legal home reference tests with 99.99% accuracy.',
                'link' => '#categories',
            ],
            [
                'id' => 'mobile',
                'title' => 'Onsite Mobile Testing',
                'subtitle' => 'We Bring The Collection Site To You',
                'icon' => 'location-arrow',
                'description' => 'Certified collectors dispatch to your jobsite, construction project, or corporate headquarters for bulk group testing.',
                'link' => '#mobile-testing',
            ],
        ];

        $comparisonPanels = [
            [
                'substance' => 'Amphetamines / Methamphetamine',
                'panel5' => true,
                'panel10' => true,
                'panel12' => true,
                'category' => 'Stimulant',
            ],
            [
                'substance' => 'Cocaine Metabolites',
                'panel5' => true,
                'panel10' => true,
                'panel12' => true,
                'category' => 'Stimulant',
            ],
            [
                'substance' => 'Marijuana (THC)',
                'panel5' => true,
                'panel10' => true,
                'panel12' => true,
                'category' => 'Cannabinoid',
            ],
            [
                'substance' => 'Opiates (Codeine, Morphine, Heroin)',
                'panel5' => true,
                'panel10' => true,
                'panel12' => true,
                'category' => 'Opiate',
            ],
            [
                'substance' => 'Phencyclidine (PCP)',
                'panel5' => true,
                'panel10' => true,
                'panel12' => true,
                'category' => 'Hallucinogen',
            ],
            [
                'substance' => 'Barbiturates',
                'panel5' => false,
                'panel10' => true,
                'panel12' => true,
                'category' => 'Sedative',
            ],
            [
                'substance' => 'Benzodiazepines (Xanax, Valium)',
                'panel5' => false,
                'panel10' => true,
                'panel12' => true,
                'category' => 'Sedative',
            ],
            [
                'substance' => 'Methadone',
                'panel5' => false,
                'panel10' => true,
                'panel12' => true,
                'category' => 'Opioid',
            ],
            [
                'substance' => 'Methaqualone (Quaaludes)',
                'panel5' => false,
                'panel10' => true,
                'panel12' => true,
                'category' => 'Hypnotic',
            ],
            [
                'substance' => 'Propoxyphene (Darvon)',
                'panel5' => false,
                'panel10' => true,
                'panel12' => true,
                'category' => 'Opioid',
            ],
            [
                'substance' => 'Tramadol (Ultram)',
                'panel5' => false,
                'panel10' => false,
                'panel12' => true,
                'category' => 'Opioid Analgesic',
            ],
            [
                'substance' => 'Meperidine (Demerol)',
                'panel5' => false,
                'panel10' => false,
                'panel12' => true,
                'category' => 'Opioid Analgesic',
            ],
            [
                'substance' => 'Expanded Opiates (Oxycodone, Hydrocodone)',
                'panel5' => false,
                'panel10' => 'Add-on',
                'panel12' => true,
                'category' => 'Semi-Synthetic Opiate',
            ],
        ];

        $states = [
            ['name' => 'Alabama', 'abbr' => 'AL', 'centers' => 340],
            ['name' => 'Alaska', 'abbr' => 'AK', 'centers' => 85],
            ['name' => 'Arizona', 'abbr' => 'AZ', 'centers' => 420],
            ['name' => 'Arkansas', 'abbr' => 'AR', 'centers' => 210],
            ['name' => 'California', 'abbr' => 'CA', 'centers' => 1950],
            ['name' => 'Colorado', 'abbr' => 'CO', 'centers' => 380],
            ['name' => 'Connecticut', 'abbr' => 'CT', 'centers' => 240],
            ['name' => 'Delaware', 'abbr' => 'DE', 'centers' => 95],
            ['name' => 'Florida', 'abbr' => 'FL', 'centers' => 1420],
            ['name' => 'Georgia', 'abbr' => 'GA', 'centers' => 760],
            ['name' => 'Hawaii', 'abbr' => 'HI', 'centers' => 90],
            ['name' => 'Idaho', 'abbr' => 'ID', 'centers' => 140],
            ['name' => 'Illinois', 'abbr' => 'IL', 'centers' => 890],
            ['name' => 'Indiana', 'abbr' => 'IN', 'centers' => 480],
            ['name' => 'Iowa', 'abbr' => 'IA', 'centers' => 260],
            ['name' => 'Kansas', 'abbr' => 'KS', 'centers' => 220],
            ['name' => 'Kentucky', 'abbr' => 'KY', 'centers' => 310],
            ['name' => 'Louisiana', 'abbr' => 'LA', 'centers' => 390],
            ['name' => 'Maine', 'abbr' => 'ME', 'centers' => 110],
            ['name' => 'Maryland', 'abbr' => 'MD', 'centers' => 410],
            ['name' => 'Massachusetts', 'abbr' => 'MA', 'centers' => 490],
            ['name' => 'Michigan', 'abbr' => 'MI', 'centers' => 690],
            ['name' => 'Minnesota', 'abbr' => 'MN', 'centers' => 380],
            ['name' => 'Mississippi', 'abbr' => 'MS', 'centers' => 230],
            ['name' => 'Missouri', 'abbr' => 'MO', 'centers' => 440],
            ['name' => 'Montana', 'abbr' => 'MT', 'centers' => 110],
            ['name' => 'Nebraska', 'abbr' => 'NE', 'centers' => 160],
            ['name' => 'Nevada', 'abbr' => 'NV', 'centers' => 240],
            ['name' => 'New Hampshire', 'abbr' => 'NH', 'centers' => 130],
            ['name' => 'New Jersey', 'abbr' => 'NJ', 'centers' => 670],
            ['name' => 'New Mexico', 'abbr' => 'NM', 'centers' => 180],
            ['name' => 'New York', 'abbr' => 'NY', 'centers' => 1380],
            ['name' => 'North Carolina', 'abbr' => 'NC', 'centers' => 710],
            ['name' => 'North Dakota', 'abbr' => 'ND', 'centers' => 95],
            ['name' => 'Ohio', 'abbr' => 'OH', 'centers' => 840],
            ['name' => 'Oklahoma', 'abbr' => 'OK', 'centers' => 320],
            ['name' => 'Oregon', 'abbr' => 'OR', 'centers' => 290],
            ['name' => 'Pennsylvania', 'abbr' => 'PA', 'centers' => 920],
            ['name' => 'Rhode Island', 'abbr' => 'RI', 'centers' => 85],
            ['name' => 'South Carolina', 'abbr' => 'SC', 'centers' => 380],
            ['name' => 'South Dakota', 'abbr' => 'SD', 'centers' => 90],
            ['name' => 'Tennessee', 'abbr' => 'TN', 'centers' => 540],
            ['name' => 'Texas', 'abbr' => 'TX', 'centers' => 1890],
            ['name' => 'Utah', 'abbr' => 'UT', 'centers' => 220],
            ['name' => 'Vermont', 'abbr' => 'VT', 'centers' => 75],
            ['name' => 'Virginia', 'abbr' => 'VA', 'centers' => 590],
            ['name' => 'Washington', 'abbr' => 'WA', 'centers' => 520],
            ['name' => 'West Virginia', 'abbr' => 'WV', 'centers' => 170],
            ['name' => 'Wisconsin', 'abbr' => 'WI', 'centers' => 430],
            ['name' => 'Wyoming', 'abbr' => 'WY', 'centers' => 80],
        ];

        $faqs = [
            [
                'question' => 'How does the test scheduling process work?',
                'answer' => 'Scheduling is simple and takes less than 2 minutes. First, select and purchase your test online or over the phone at (800) 221-4291. Second, enter the donor zip code to locate the nearest testing center. You will instantly receive an electronic Donor Registration Pass by email with the testing center address, operating hours, and instructions. Third, walk into the facility with your pass and a photo ID—no appointment is necessary!',
            ],
            [
                'question' => 'How fast do I get drug test results?',
                'answer' => 'Negative lab results are typically reported within 24 to 48 hours of specimen collection. If an initial screen is non-negative, the specimen undergoes gas chromatography-mass spectrometry (GC/MS) confirmation testing and is reviewed by a licensed Medical Review Officer (MRO), which may take an additional 24 to 72 hours.',
            ],
            [
                'question' => 'Do I need an appointment at the testing center?',
                'answer' => 'No appointment is needed in 95% of locations! Once you register and purchase your test online or by phone, you can walk in during standard collection hours at your convenience. Testing centers do not accept payment directly on-site; all tests must be registered prior to walking in.',
            ],
            [
                'question' => 'What is the difference between a 5-panel and 10-panel drug test?',
                'answer' => 'A standard 5-panel drug test screens for Amphetamines, Cocaine, Marijuana (THC), Opiates, and PCP. A 10-panel drug test screens for all five of those substances plus Barbiturates, Benzodiazepines (sedatives), Methadone, Methaqualone, and Propoxyphene. 10-panel tests are heavily favored by healthcare, executive, and safety-sensitive employers.',
            ],
            [
                'question' => 'Are your laboratories certified and results legally defensible?',
                'answer' => 'Yes. All laboratory testing is conducted through SAMHSA-certified (Substance Abuse and Mental Health Services Administration) and CAP-accredited laboratories, including our partner network of Quest Diagnostics and Labcorp. Every non-negative result is validated by an independent licensed Medical Review Officer (MRO), ensuring strict chain-of-custody and complete legal defensibility.',
            ],
            [
                'question' => 'Can you perform on-site mobile drug testing at my company location?',
                'answer' => 'Yes! We provide mobile on-site drug and alcohol testing nationwide for job sites, warehouses, construction projects, and offices. Our certified collection specialists arrive at your facility equipped to handle 1 to 500+ employees with minimal disruption to your workday.',
            ],
        ];

        return compact('products', 'categories', 'comparisonPanels', 'states', 'faqs');
    }

    /**
     * Default Home Page: Set to Client's Chosen Look 2 (Corporate Clean Trust & Speed)
     */
    public function index()
    {
        return $this->design2();
    }

    /**
     * Design Look 1: Modern Patriotic Healthcare & Direct Portal (Archived)
     */
    public function design1()
    {
        $data = $this->getSharedData();
        $data['currentDesign'] = 1;
        $data['pageTitle'] = 'Certified Drug Test Centers | Local, Convenient & Confidential Testing Nationwide';
        $data['metaDescription'] = 'Certified Drug Test Centers provides fast, confidential same-day drug testing, DOT compliance, urine, hair, alcohol, and DNA testing at 20,000+ certified local centers nationwide.';
        return view('home-design-1', $data);
    }

    /**
     * Design Look 2: Corporate Clean Trust & Speed (Primary Client Approved Look)
     */
    public function design2()
    {
        $data = $this->getSharedData();
        $data['currentDesign'] = 2;
        $data['pageTitle'] = 'Express Drug & Alcohol Testing | Certified Drug Test Centers';
        $data['metaDescription'] = 'Order your drug test online in 2 minutes. Instant electronic donor pass, 20,000+ Quest & Labcorp collection centers, SAMHSA accredited labs, MRO verified results.';
        return view('home-design-2', $data);
    }
}
