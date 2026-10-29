<?php

namespace Database\Seeders;

use App\Models\CorporateAccount;
use App\Models\Location;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CorporateAccountSeeder extends Seeder
{
    public function run(): void
    {
        $account = CorporateAccount::updateOrCreate(
            ['account_code' => 'CDTC-CORP-DEMO'],
            [
                'company_name' => 'Apex Logistics & Fleet Services Inc.',
                'contact_name' => 'Sarah Jenkins',
                'email' => 'sjenkins@apexlogistics-demo.com',
                'phone' => '(800) 555-0192',
                'industry' => 'Transportation, Warehousing & Fleet Logistics',
                'billing_type' => 'net30',
                'credit_limit' => 25000.00,
                'active_balance' => 3420.00,
                'is_dot_regulated' => true,
                'dot_agency' => 'FMCSA & Non-DOT Commercial',
                'access_pin' => '123456',
                'access_token' => 'demo-corp-token-apex-logistics-99',
                'status' => 'active',
                'settings' => [
                    'auto_email_results' => true,
                    'sms_donor_reminder' => true,
                    'random_pool_enrolled' => true,
                    'random_rate_drug' => 50,
                    'random_rate_alcohol' => 10,
                ],
            ]
        );

        $defaultLocation = Location::first() ?? Location::create([
            'name' => 'Quest Diagnostics - Orlando Clinical PSC',
            'slug' => 'quest-diagnostics-orlando-fl',
            'city_id' => 1,
            'address' => '2501 N Orange Ave, Suite 340',
            'postal_code' => '32804',
            'phone' => '(407) 555-0199',
            'latitude' => 28.5721,
            'longitude' => -81.3742,
            'lab_type' => 'Quest Diagnostics',
            'hours' => 'Mon-Fri 7:00am - 4:30pm, Sat 8:00am - 12:00pm',
            'is_active' => true,
        ]);

        $dotProduct = Product::where('slug', '5-panel-dot')->first();
        $tenProduct = Product::where('slug', '10-panel')->first();
        $fiveProduct = Product::where('slug', '5-panel-nondot')->first();
        $hairProduct = Product::where('slug', '5-panel-hair')->first();

        $candidates = [
            [
                'order_number' => 'CDTC-CORP-001',
                'first' => 'Marcus',
                'last' => 'Vance',
                'email' => 'm.vance@apexlogistics-demo.com',
                'phone' => '(407) 555-0111',
                'dept' => 'Heavy Duty CDL Drivers',
                'job' => 'Interstate Class-A Driver',
                'reason' => 'Pre-Employment DOT',
                'product' => $dotProduct,
                'status' => 'completed',
                'result' => 'negative',
                'ccf' => 'CCF-8829104-DOT',
                'collected_at' => now()->subDays(3),
                'verified_at' => now()->subDays(2),
                'token' => 'corp-donor-pass-001-vance',
            ],
            [
                'order_number' => 'CDTC-CORP-002',
                'first' => 'Elena',
                'last' => 'Rostova',
                'email' => 'e.rostova@apexlogistics-demo.com',
                'phone' => '(407) 555-0122',
                'dept' => 'Regional Fulfillment Terminal',
                'job' => 'Forklift & Reach Truck Operator',
                'reason' => 'Pre-Employment Non-DOT',
                'product' => $tenProduct,
                'status' => 'completed',
                'result' => 'negative',
                'ccf' => 'CCF-9014821-ND',
                'collected_at' => now()->subDays(2),
                'verified_at' => now()->subDay(),
                'token' => 'corp-donor-pass-002-rostova',
            ],
            [
                'order_number' => 'CDTC-CORP-003',
                'first' => 'David',
                'last' => 'Chen',
                'email' => 'd.chen@apexlogistics-demo.com',
                'phone' => '(407) 555-0133',
                'dept' => 'Operations & Logistics Dispatch',
                'job' => 'Fleet Routing Coordinator',
                'reason' => 'Annual Compliance',
                'product' => $fiveProduct,
                'status' => 'completed',
                'result' => 'negative',
                'ccf' => 'CCF-7719283-ND',
                'collected_at' => now()->subDays(4),
                'verified_at' => now()->subDays(3),
                'token' => 'corp-donor-pass-003-chen',
            ],
            [
                'order_number' => 'CDTC-CORP-004',
                'first' => 'Michael',
                'last' => 'Thorne',
                'email' => 'm.thorne@apexlogistics-demo.com',
                'phone' => '(407) 555-0144',
                'dept' => 'Heavy Duty CDL Drivers',
                'job' => 'Hazmat Tanker Operator',
                'reason' => 'Quarterly DOT Random Draw',
                'product' => $dotProduct,
                'status' => 'in_progress',
                'result' => 'pending',
                'ccf' => 'CCF-9921473-DOT',
                'collected_at' => now()->subDay(),
                'verified_at' => null,
                'token' => 'corp-donor-pass-004-thorne',
            ],
            [
                'order_number' => 'CDTC-CORP-005',
                'first' => 'Brianna',
                'last' => 'Morales',
                'email' => 'b.morales@apexlogistics-demo.com',
                'phone' => '(407) 555-0155',
                'dept' => 'Corporate Safety & Compliance',
                'job' => 'Regional Safety Auditor',
                'reason' => 'Executive Pre-Placement',
                'product' => $hairProduct,
                'status' => 'in_progress',
                'result' => 'pending',
                'ccf' => 'CCF-6610394-HF',
                'collected_at' => now()->subDays(2),
                'verified_at' => null,
                'token' => 'corp-donor-pass-005-morales',
            ],
            [
                'order_number' => 'CDTC-CORP-006',
                'first' => 'Andre',
                'last' => 'Washington',
                'email' => 'a.washington@apexlogistics-demo.com',
                'phone' => '(407) 555-0166',
                'dept' => 'Terminal Cross-Dock Services',
                'job' => 'Yard Hostler & Equipment Handler',
                'reason' => 'Pre-Employment Non-DOT',
                'product' => $tenProduct,
                'status' => 'registered',
                'result' => 'pending',
                'ccf' => null,
                'collected_at' => null,
                'verified_at' => null,
                'token' => 'corp-donor-pass-006-washington',
            ],
            [
                'order_number' => 'CDTC-CORP-007',
                'first' => 'Jessica',
                'last' => 'Ramirez',
                'email' => 'j.ramirez@apexlogistics-demo.com',
                'phone' => '(407) 555-0177',
                'dept' => 'Fleet Maintenance & Engineering',
                'job' => 'Master Diesel Technician',
                'reason' => 'Pre-Employment DOT',
                'product' => $dotProduct,
                'status' => 'registered',
                'result' => 'pending',
                'ccf' => null,
                'collected_at' => null,
                'verified_at' => null,
                'token' => 'corp-donor-pass-007-ramirez',
            ],
            [
                'order_number' => 'CDTC-CORP-008',
                'first' => 'Trevor',
                'last' => 'Campbell',
                'email' => 't.campbell@apexlogistics-demo.com',
                'phone' => '(407) 555-0188',
                'dept' => 'Terminal Cross-Dock Services',
                'job' => 'Freight Sorter',
                'reason' => 'Reasonable Suspicion',
                'product' => $tenProduct,
                'status' => 'completed',
                'result' => 'positive',
                'ccf' => 'CCF-4412903-ND',
                'collected_at' => now()->subDays(5),
                'verified_at' => now()->subDays(4),
                'token' => 'corp-donor-pass-008-campbell',
            ],
        ];

        foreach ($candidates as $cand) {
            $product = $cand['product'] ?? $fiveProduct;
            $price = $product ? (float)$product->price : 89.99;

            $order = Order::updateOrCreate(
                ['order_number' => $cand['order_number']],
                [
                    'corporate_account_id' => $account->id,
                    'donor_first_name' => $cand['first'],
                    'donor_last_name' => $cand['last'],
                    'donor_email' => $cand['email'],
                    'donor_phone' => $cand['phone'],
                    'donor_dob' => '1988-06-14',
                    'donor_ssn_last4' => '4921',
                    'candidate_department' => $cand['dept'],
                    'candidate_job_title' => $cand['job'],
                    'test_reason' => $cand['reason'],
                    'location_id' => $defaultLocation->id,
                    'subtotal' => $price,
                    'discount' => 0.00,
                    'total' => $price,
                    'payment_status' => 'approved',
                    'payment_gateway' => 'corporate_net30',
                    'paytrace_transaction_id' => 'NET30-' . strtoupper(Str::random(8)),
                    'donor_pass_token' => $cand['token'],
                    'ccf_number' => $cand['ccf'],
                    'status' => $cand['status'],
                    'result_outcome' => $cand['result'],
                    'specimen_collected_at' => $cand['collected_at'],
                    'mro_verified_at' => $cand['verified_at'],
                    'mro_notes' => $cand['result'] === 'positive'
                        ? 'Confirmatory GC/MS analysis verified positive. Donor interviewed by Medical Review Officer.'
                        : ($cand['result'] === 'negative' ? 'SAMHSA Certified Lab screening and MRO verification negative for all tested metabolites.' : null),
                ]
            );

            if ($product && $order->items()->count() === 0) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $price,
                    'quantity' => 1,
                ]);
            }
        }
    }
}
