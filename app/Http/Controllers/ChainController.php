<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\State;
use Illuminate\Http\Request;

class ChainController extends Controller
{
    /**
     * Default FAQs for the National Chain Page
     */
    public static function getDefaultFaqs(): array
    {
        return [
            [
                'question' => 'Where can I get a drug test near me?',
                'answer' => 'Certified Drug Test Centers schedules drug and alcohol tests at more than 20,000 certified collection sites in all 50 states, including Quest Diagnostics and Labcorp patient service centers. Enter your ZIP code online or call (800) 985-4339 to find the closest site, register within minutes, and walk in the same day.',
            ],
            [
                'question' => 'How much does a drug test cost?',
                'answer' => 'A 5-panel urine drug test costs $89.99, a 10-panel costs $109.99, a 12-panel costs $139.99, a DOT 5-panel costs $99.99, and a 5-panel hair follicle test costs $169.99. Prices include the collection, laboratory analysis and Medical Review Officer (MRO) review, with no fees paid at the testing site.',
            ],
            [
                'question' => 'Can I get a same-day drug test?',
                'answer' => 'Yes. Most people order and test on the same day. Once you register online or by phone, your electronic donor pass arrives within minutes, and you can walk in to a nearby certified drug testing center that day during its collection hours. No appointment is needed at most locations.',
            ],
            [
                'question' => 'Where can I get a pre-employment drug test near me?',
                'answer' => "You can get a pre-employment drug test at any of 20,000+ certified collection sites nationwide, including Quest Diagnostics and Labcorp locations. Order the panel your employer requested (usually a 5-panel or 10-panel urine test), get your donor pass within minutes, and walk in with a photo ID.",
            ],
            [
                'question' => 'Can I get a drug test at Quest Diagnostics or Labcorp?',
                'answer' => 'Yes. Certified Drug Test Centers schedules drug tests at Quest Diagnostics and Labcorp patient service centers across the country. Quest and Labcorp sites require pre-registration and do not take payment on site, so you order through us first and receive a donor pass to bring with you.',
            ],
            [
                'question' => 'Where can I get a DOT drug test near me?',
                'answer' => "DOT drug tests are available at certified collection sites in all 50 states. Order the DOT 5-panel drug test ($99.99), choose the closest site by ZIP code, and bring your donor pass, photo ID and CDL or employee ID. Collections follow 49 CFR Part 40 using a Federal Custody and Control Form.",
            ],
            [
                'question' => 'Can I get a drug test at urgent care?',
                'answer' => 'Some urgent care clinics offer drug testing, but prices, panels and lab standards vary and many add office-visit fees. Ordering through Certified Drug Test Centers gives you upfront all-inclusive pricing, a SAMHSA-certified lab and MRO review at a certified collection site near you.',
            ],
            [
                'question' => 'What is the most affordable way to get a drug test?',
                'answer' => 'Ordering online is usually the most affordable way to get a certified drug test. A 5-panel urine drug test costs $89.99 all-inclusive — collection, SAMHSA-certified lab analysis and MRO review — with no extra fees at the testing site.',
            ],
            [
                'question' => 'Can I walk in for a drug test without an appointment?',
                'answer' => "Yes. Most collection sites accept walk-ins, but you must register and pay before you go. After you order, you receive an electronic donor pass that you show at the site along with a photo ID. Testing sites do not accept payment on site.",
            ],
            [
                'question' => 'How long do drug test results take?',
                'answer' => 'Negative urine results are typically available within 24–48 hours of collection. Hair tests take 2–4 business days. If an initial screen is non-negative, the sample is confirmed by GC/MS or LC/MS and reviewed by a Medical Review Officer, which can add 24–72 hours. Breath alcohol results are immediate.',
            ],
            [
                'question' => 'What is the difference between a 5-panel and a 10-panel drug test?',
                'answer' => 'A 5-panel drug test screens for amphetamines (including methamphetamine), cocaine, marijuana (THC), opiates and PCP. A 10-panel test screens for those five plus barbiturates, benzodiazepines, methadone, methaqualone and propoxyphene. A 12-panel adds tramadol, meperidine and expanded opiates such as oxycodone and hydrocodone.',
            ],
            [
                'question' => 'What does a DOT drug test check for?',
                'answer' => 'A DOT drug test under 49 CFR Part 40 screens urine for five drug classes: marijuana metabolites, cocaine metabolites, amphetamines (amphetamine, methamphetamine, MDMA, MDA), opioids (codeine, morphine, 6-acetylmorphine/heroin, hydrocodone, hydromorphone, oxycodone, oxymorphone) and phencyclidine (PCP). It must use a Federal Custody and Control Form, a SAMHSA/HHS-certified laboratory and MRO review.',
            ],
            [
                'question' => 'How far back does a drug test go?',
                'answer' => 'A urine test usually detects drug use from the past 1–3 days for most substances, and up to 30 days or more for heavy, chronic marijuana use. A hair follicle test covers about the past 90 days. A saliva (oral fluid) test detects use from roughly the past 24–48 hours. An EtG urine alcohol test detects drinking up to about 80 hours prior.',
            ],
            [
                'question' => 'What do I need to bring to my drug test?',
                'answer' => "Bring your electronic donor pass (on your phone or printed) and a valid government-issued photo ID such as a driver's license or passport. For DOT tests, also have your CDL or employee ID number. Do not drink excessive fluids beforehand, as a diluted sample may require a retest.",
            ],
            [
                'question' => 'Are your drug test results legally defensible?',
                'answer' => 'Yes. Specimens are collected under strict chain-of-custody procedures and analyzed by SAMHSA-certified laboratories. Non-negative results are confirmed by GC/MS or LC/MS and reviewed by an independent, licensed Medical Review Officer, making results suitable for employment, DOT compliance and court purposes.',
            ],
            [
                'question' => 'Do you offer drug testing for court or probation?',
                'answer' => 'Yes. Court-ordered and probation testing is available with chain-of-custody documentation, including urine panels, EtG alcohol tests that detect drinking up to about 80 hours prior, and 90-day hair follicle tests. Always confirm the exact test your court or probation officer requires before ordering.',
            ],
            [
                'question' => 'Can I order a drug test for myself or a family member?',
                'answer' => "Yes. Individuals can order personal or family drug tests online without an employer or doctor's order. Results are confidential and sent only to the email provided at registration.",
            ],
            [
                'question' => 'Do you offer on-site mobile drug testing for employers?',
                'answer' => 'Yes. Certified collectors can travel to job sites, offices, warehouses and construction projects nationwide to test employees at job sites, warehouses and offices, including post-accident and reasonable-suspicion testing. Employers can also open a corporate account for volume pricing and an online results portal.',
            ],
            [
                'question' => 'What is a Medical Review Officer (MRO)?',
                'answer' => 'A Medical Review Officer is a licensed physician trained to review laboratory drug test results. Before a non-negative result is reported, the MRO contacts the donor to check for legitimate medical explanations, such as a valid prescription. Every test ordered through Certified Drug Test Centers includes MRO review.',
            ],
            [
                'question' => 'Do you test in Spanish?',
                'answer' => 'Yes. Our scheduling team speaks Spanish. Call (800) 985-4339 for help ordering a test in Spanish.',
            ],
        ];
    }

    /**
     * Retrieve all customizable national chain page settings with defaults
     */
    public static function getNationalChainSettings(): array
    {
        $heroChecks = Setting::get('chain_national_hero_checks');
        if (!empty($heroChecks)) {
            $decoded = is_string($heroChecks) ? json_decode($heroChecks, true) : $heroChecks;
            $heroChecks = (is_array($decoded) && count($decoded) > 0) ? $decoded : null;
        } else {
            $heroChecks = null;
        }

        $onsiteChecks = Setting::get('chain_national_onsite_checks');
        if (!empty($onsiteChecks)) {
            $decoded = is_string($onsiteChecks) ? json_decode($onsiteChecks, true) : $onsiteChecks;
            $onsiteChecks = (is_array($decoded) && count($decoded) > 0) ? $decoded : null;
        } else {
            $onsiteChecks = null;
        }

        $storedFaqs = Setting::get('chain_national_faqs');
        if (!empty($storedFaqs)) {
            $decoded = is_string($storedFaqs) ? json_decode($storedFaqs, true) : $storedFaqs;
            $faqs = (is_array($decoded) && count($decoded) > 0) ? $decoded : null;
        } else {
            $faqs = null;
        }

        return [
            // SEO Meta
            'meta_title' => Setting::get('chain_national_meta_title', 'Certified Drug Test Centers - (800) 985-4339'),
            'meta_description' => Setting::get('chain_national_meta_description', 'Certified Drug Test Centers are located in all cities and in most cases within minutes of your home or office. Order a drug or alcohol test online or call and receive an electronic donor pass via email or text immediately. Same-day testing available for employment, DOT, probation and personal purposes at more than 20,000 certified drug testing centers — including Quest Diagnostics, Labcorp and affiliated locations. Negative results are typically available within 24–48 hours.'),
            'meta_keywords' => Setting::get('chain_national_meta_keywords', 'Drug Test near me, DOT Drug Test near me, Alcohol test near me, Drug Testing, Drug testing center near me, employer drug testing programs, 5 panel urine test, 5 panel drug test, 10 panel drug test, DOT consortium Enrollment, where can i get a drug test, Hair drug test'),

            // Hero section
            'hero_eyebrow' => Setting::get('chain_national_hero_eyebrow', 'Nationwide · All 50 States'),
            'hero_title' => Setting::get('chain_national_hero_title', 'Certified Drug Test Centers Near You'),
            'hero_lead' => Setting::get('chain_national_hero_lead', '<strong>Certified Drug Test Centers</strong> are located in all cities and in most cases within minutes of your home or office. Order a drug or alcohol test online or call and receive an electronic donor pass via email or text immediately. Same-day testing available for employment, DOT, probation and personal purposes at more than 20,000 certified drug testing centers — including Quest Diagnostics, Labcorp and affiliated locations. Negative results are typically available within <strong>24–48 hours</strong>.'),
            'hero_checks' => $heroChecks ?? [
                '20,000+ Quest & Labcorp sites',
                'SAMHSA-certified laboratories',
                'Physician MRO review included',
                'DOT-compliant & legally defensible',
                'Order Today, Test Today',
                'No hidden fees at the testing site',
            ],

            // Quick Answer & Key Facts
            'quick_answer_title' => Setting::get('chain_national_quick_answer_title', 'Quick answer: how to get a drug or alcohol test near you today'),
            'quick_answer_text' => Setting::get('chain_national_quick_answer_text', 'To get a drug or alcohol test near you, order the test online or by phone and within minutes receive your electronic donor pass by email and text, then walk in with a photo ID to the nearest certified collection site. Certified Drug Test Centers schedules same-day urine, hair follicle, saliva, breath alcohol, EtG and DOT drug tests at 20,000+ drug testing centers in all 50 states, with prices from $89.99 and results in 24–48 hours for most negative urine tests.'),
            'fact_sites' => Setting::get('chain_national_fact_sites', '20,000+'),
            'fact_sites_label' => Setting::get('chain_national_fact_sites_label', 'certified collection sites'),
            'fact_states' => Setting::get('chain_national_fact_states', '50'),
            'fact_states_label' => Setting::get('chain_national_fact_states_label', 'states covered'),
            'fact_results' => Setting::get('chain_national_fact_results', '24–48 hrs'),
            'fact_results_label' => Setting::get('chain_national_fact_results_label', 'typical negative results'),
            'fact_price' => Setting::get('chain_national_fact_price', '$89.99'),
            'fact_price_label' => Setting::get('chain_national_fact_price_label', 'starting price, all-inclusive'),

            // National Directory Heading
            'directory_eyebrow' => Setting::get('chain_national_directory_eyebrow', 'National directory'),
            'directory_title' => Setting::get('chain_national_directory_title', 'Find drug and alcohol testing centers by State'),
            'directory_lead' => Setting::get('chain_national_directory_lead', 'Certified Drug Test Centers has collection sites in all 50 states, from major metro areas to rural communities. Choose your state to see drug testing locations by city, including Quest Diagnostics and Labcorp drug test sites, or search by ZIP code. Walk-ins are accepted at most sites once you\'ve registered.'),

            // Employer & On-Site Mobile Section
            'onsite_eyebrow' => Setting::get('chain_national_onsite_eyebrow', 'For employers'),
            'onsite_title' => Setting::get('chain_national_onsite_title', 'Employer drug testing programs & on-site mobile testing'),
            'onsite_lead' => Setting::get('chain_national_onsite_lead', 'Businesses of every size use Certified Drug Test Centers for employee drug screening and compliant, nationwide drug-free workplace programs from one account — whether you hire one employee a year or manage a multi-state fleet.'),
            'onsite_checks' => $onsiteChecks ?? [
                'Corporate accounts with volume pricing and an online results portal',
                'Pre-employment, random, post-accident and reasonable-suspicion testing',
                'On-site mobile collections for employees at job sites, warehouses and offices',
                'DOT consortium/TPA services and MIS reporting assistance',
                'Background checks and motor vehicle records (MVR)',
            ],

            // FAQs
            'faqs' => $faqs ?? self::getDefaultFaqs(),
        ];
    }

    /**
     * Nationalize Page for Certified Drug Test Centers (/certified-drug-test-centers)
     */
    public function certifiedDrugTestCenters(Request $request)
    {
        $chainSettings = self::getNationalChainSettings();

        // 50 US States with accurate center counts
        $stateCounts = [
            'alabama' => '340+ centers',
            'alaska' => '85+ centers',
            'arizona' => '420+ centers',
            'arkansas' => '210+ centers',
            'california' => '1,950+ centers',
            'colorado' => '380+ centers',
            'connecticut' => '240+ centers',
            'delaware' => '95+ centers',
            'florida' => '1,420+ centers',
            'georgia' => '760+ centers',
            'hawaii' => '90+ centers',
            'idaho' => '140+ centers',
            'illinois' => '890+ centers',
            'indiana' => '480+ centers',
            'iowa' => '260+ centers',
            'kansas' => '220+ centers',
            'kentucky' => '310+ centers',
            'louisiana' => '390+ centers',
            'maine' => '110+ centers',
            'maryland' => '410+ centers',
            'massachusetts' => '490+ centers',
            'michigan' => '690+ centers',
            'minnesota' => '380+ centers',
            'mississippi' => '230+ centers',
            'missouri' => '440+ centers',
            'montana' => '110+ centers',
            'nebraska' => '160+ centers',
            'nevada' => '240+ centers',
            'new-hampshire' => '130+ centers',
            'new-jersey' => '670+ centers',
            'new-mexico' => '180+ centers',
            'new-york' => '1,380+ centers',
            'north-carolina' => '710+ centers',
            'north-dakota' => '95+ centers',
            'ohio' => '840+ centers',
            'oklahoma' => '320+ centers',
            'oregon' => '290+ centers',
            'pennsylvania' => '920+ centers',
            'rhode-island' => '85+ centers',
            'south-carolina' => '380+ centers',
            'south-dakota' => '90+ centers',
            'tennessee' => '540+ centers',
            'texas' => '1,890+ centers',
            'utah' => '220+ centers',
            'vermont' => '75+ centers',
            'virginia' => '590+ centers',
            'washington' => '520+ centers',
            'west-virginia' => '170+ centers',
            'wisconsin' => '430+ centers',
            'wyoming' => '80+ centers',
        ];

        $states = State::where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(function ($st) use ($stateCounts) {
                return [
                    'name' => $st->name,
                    'slug' => $st->slug,
                    'abbr' => $st->abbr,
                    'centers' => $stateCounts[$st->slug] ?? '150+ centers',
                    'url' => url('/locations/' . $st->slug),
                    'chain_url' => url('/certified-drug-test-centers/' . $st->slug),
                ];
            });

        $pageTitle = $chainSettings['meta_title'] ?? 'Certified Drug Test Centers - (800) 985-4339';
        $metaDescription = $chainSettings['meta_description'] ?? 'Certified Drug Test Centers are located in all cities and in most cases within minutes of your home or office. Order a drug or alcohol test online or call and receive an electronic donor pass via email or text immediately. Same-day testing available for employment, DOT, probation and personal purposes at more than 20,000 certified drug testing centers — including Quest Diagnostics, Labcorp and affiliated locations. Negative results are typically available within 24–48 hours.';
        $metaKeywords = $chainSettings['meta_keywords'] ?? 'Drug Test near me, DOT Drug Test near me, Alcohol test near me, Drug Testing, Drug testing center near me, employer drug testing programs, 5 panel urine test, 5 panel drug test, 10 panel drug test, DOT consortium Enrollment, where can i get a drug test, Hair drug test';
        $canonicalUrl = rtrim(url('/certified-drug-test-centers'), '/');

        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Certified Drug Test Centers', 'url' => $canonicalUrl],
        ];

        // Load structured data graph
        $schemaGraph = null;
        $jsonPath = resource_path('schemas/certified-drug-test-centers.json');
        if (file_exists($jsonPath)) {
            $raw = file_get_contents($jsonPath);
            $raw = str_replace(
                [
                    'https://certifieddrugtestingcenters.com/drug-testing-centers',
                    'https://certifieddrugtestingcenters.com/demo/certified-drug-test-centers',
                    'https://certifieddrugtestingcenters.com',
                ],
                [
                    $canonicalUrl,
                    $canonicalUrl,
                    url('/'),
                ],
                $raw
            );
            $schemaGraph = json_decode($raw, true);
        }

        return view('chains.certified-drug-test-centers', compact(
            'states',
            'chainSettings',
            'pageTitle',
            'metaDescription',
            'metaKeywords',
            'canonicalUrl',
            'breadcrumbs',
            'schemaGraph'
        ));
    }
}
