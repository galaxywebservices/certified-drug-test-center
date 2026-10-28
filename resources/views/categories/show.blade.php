@extends('layouts.main')

@section('content')
<style>
    .cat-hero-bar {
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #fff;
        padding: 40px 0;
        border-bottom: 3px solid #C1121F;
    }

    .cat-grid-layout {
        display: grid;
        grid-template-columns: 3fr 1fr;
        gap: 36px;
        padding: 40px 0 60px;
    }

    @media (max-width: 992px) {
        .cat-grid-layout { grid-template-columns: 1fr; }
    }

    .prod-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .cat-prod-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .cat-prod-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.06);
        border-color: #CBD5E1;
    }

    .cat-prod-title {
        font-size: 18px;
        font-weight: 800;
        color: #0B2545;
        margin-bottom: 6px;
    }
    .cat-prod-title a { color: inherit; text-decoration: none; }
    .cat-prod-title a:hover { color: #C1121F; }

    .cat-prod-price {
        font-size: 26px;
        font-weight: 900;
        color: #C1121F;
    }
</style>

<div class="cat-hero-bar">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Breadcrumb" style="display:flex; gap:8px; font-size:13px; color:#94A3B8; margin-bottom:12px;">
            <a href="{{ url('/') }}" style="color:#CBD5E1; text-decoration:none;">Home</a>
            <span>&rsaquo;</span>
            <span style="color:#fff;">{{ $displayName }}</span>
        </nav>

        <h1 style="font-size:32px; font-weight:800; color:#fff; margin-bottom:8px;">{{ $displayName }}</h1>
        <p style="font-size:16px; color:#E2E8F0; max-width:750px;">
            {{ $category->subtitle ?: 'Select a test below to order online with same-day walk-in testing at over 20,000 certified collection facilities nationwide.' }}
        </p>
    </div>
</div>

<div class="container">
    <div class="cat-grid-layout">
        <!-- Products Grid -->
        <div>
            @if($category->description)
            <div style="background:#fff; border:1px solid #E2E8F0; border-radius:10px; padding:24px; margin-bottom:28px; font-size:14px; color:#334155; line-height:1.7;">
                {!! nl2br(e($category->description)) !!}
            </div>
            @endif

            <h2 style="font-size:22px; font-weight:800; color:#0B2545; margin-bottom:20px;">
                Available Testing Options ({{ $products->count() }})
            </h2>

            <div class="prod-cards-grid">
                @forelse($products as $p)
                <div class="cat-prod-card">
                    <div>
                        <div style="display:flex; gap:6px; margin-bottom:8px;">
                            <span class="badge" style="background:#E0F2FE; color:#0369A1; font-size:11px; text-transform:uppercase;">{{ $p->specimen_type }}</span>
                            @if($p->dot_required)
                                <span class="badge" style="background:#FEE2E2; color:#B91C1C; font-size:11px;">DOT</span>
                            @endif
                        </div>
                        <h3 class="cat-prod-title">
                            <a href="{{ url('/product/' . $p->slug) }}">{{ $p->name }}</a>
                        </h3>
                        <p style="font-size:13px; color:#64748B; margin-bottom:16px; line-height:1.5;">
                            {{ Str::limit($p->short_description ?: strip_tags($p->details), 90) }}
                        </p>
                    </div>

                    <div style="padding-top:16px; border-top:1px solid #F1F5F9; display:flex; align-items:center; justify-content:space-between;">
                        <div>
                            <div class="cat-prod-price">${{ number_format($p->price, 2) }}</div>
                            <small style="color:#64748B; font-size:11px;">{{ $p->turnaround_time }}</small>
                        </div>
                        <a href="{{ route('checkout.index', $p->slug) }}" class="btn btn-primary btn-sm">
                            Order Test &rarr;
                        </a>
                    </div>
                </div>
                @empty
                <div style="grid-column: 1 / -1; padding:40px; text-align:center; background:#fff; border-radius:10px; border:1px solid #E2E8F0;">
                    No tests currently listed under this category.
                </div>
                @endforelse
            </div>

            <!-- Substance Detection Comparison Matrix -->
            <div class="substance-matrix-card">
                <div style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                    <div>
                        <span class="badge" style="background:#E0F2FE; color:#0369A1; font-size:11.5px; font-weight:700; text-transform:uppercase;">Panel Breakdown Guide</span>
                        <h3 style="font-size:20px; font-weight:800; color:#0B2545; margin-top:6px; margin-bottom:4px;">Substance Detection Comparison Matrix</h3>
                        <p style="font-size:13.5px; color:#64748B; margin:0;">Compare which illicit drugs, prescription opioids, and stimulants are screened across panel tiers.</p>
                    </div>
                    <a href="tel:18002214291" style="font-size:13px; font-weight:700; color:#C1121F; text-decoration:none;">Custom Panels Available: (800) 221-4291 &rarr;</a>
                </div>

                <div style="overflow-x:auto;">
                    <table class="substance-matrix-table">
                        <thead>
                            <tr>
                                <th>Drug / Substance Class</th>
                                <th>5-Panel Standard</th>
                                <th>10-Panel Comprehensive</th>
                                <th>12-Panel Maximum</th>
                                <th>Estimated Detection Window</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Amphetamines & Methamphetamine (AMP / mAMP)</td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td>1 - 3 Days (Urine) / 90 Days (Hair)</td>
                            </tr>
                            <tr>
                                <td>Cocaine Metabolite (COC)</td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td>2 - 4 Days (Urine) / 90 Days (Hair)</td>
                            </tr>
                            <tr>
                                <td>Marijuana / Cannabinoids (THC)</td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td>1 - 30+ Days (Urine) / 90 Days (Hair)</td>
                            </tr>
                            <tr>
                                <td>Basic Opiates (Codeine, Morphine, Heroin)</td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td>1 - 3 Days (Urine) / 90 Days (Hair)</td>
                            </tr>
                            <tr>
                                <td>Phencyclidine (PCP)</td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td>7 - 14 Days (Urine) / 90 Days (Hair)</td>
                            </tr>
                            <tr>
                                <td>Barbiturates (BAR)</td>
                                <td><span class="check-no">—</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td>1 - 7 Days (Urine) / 90 Days (Hair)</td>
                            </tr>
                            <tr>
                                <td>Benzodiazepines (Xanax, Valium - BZO)</td>
                                <td><span class="check-no">—</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td>1 - 7 Days (Urine) / 90 Days (Hair)</td>
                            </tr>
                            <tr>
                                <td>Methadone (MTD)</td>
                                <td><span class="check-no">—</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td>2 - 4 Days (Urine) / 90 Days (Hair)</td>
                            </tr>
                            <tr>
                                <td>Propoxyphene (PPX)</td>
                                <td><span class="check-no">—</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td>1 - 3 Days (Urine) / 90 Days (Hair)</td>
                            </tr>
                            <tr>
                                <td>Methaqualone (Quaaludes)</td>
                                <td><span class="check-no">—</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td>2 - 4 Days (Urine) / 90 Days (Hair)</td>
                            </tr>
                            <tr>
                                <td>Expanded Prescription Opioids (Oxycodone, Oxymorphone)</td>
                                <td><span class="check-no">—</span></td>
                                <td><span class="check-yes">✓ (Exp Opiates)</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td>1 - 4 Days (Urine) / 90 Days (Hair)</td>
                            </tr>
                            <tr>
                                <td>Ecstasy / MDMA / Molly</td>
                                <td><span class="check-no">—</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td>1 - 3 Days (Urine) / 90 Days (Hair)</td>
                            </tr>
                            <tr>
                                <td>Buprenorphine (Suboxone) / Fentanyl</td>
                                <td><span class="check-no">—</span></td>
                                <td><span class="check-no">—</span></td>
                                <td><span class="check-yes">✓ Included</span></td>
                                <td>2 - 4 Days (Urine) / 90 Days (Hair)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="margin-top:16px; padding:14px; background:#F8FAFC; border-radius:6px; font-size:12.5px; color:#64748B; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <div>
                        <strong>Need Court-Admissible or DOT Lab Testing?</strong> All specimens are analyzed at SAMHSA-certified Quest Diagnostics & Labcorp reference laboratories under strict chain-of-custody.
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-sm">Order Online Now &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Sidebar Navigation -->
        <div>
            <div style="background:#fff; border:1px solid #E2E8F0; border-radius:10px; padding:24px;">
                <h3 style="font-size:16px; font-weight:800; color:#0B2545; margin-bottom:14px;">All Testing Categories</h3>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:8px;">
                    @foreach($allCategories as $c)
                    <li>
                        <a href="{{ url('/category/' . $c->slug) }}" style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px; border-radius:6px; text-decoration:none; color:{{ $c->id == $category->id ? '#C1121F' : '#334155' }}; font-weight:{{ $c->id == $category->id ? '700' : '500' }}; background:{{ $c->id == $category->id ? '#FEF2F2' : 'transparent' }}; font-size:14px;">
                            <span>{{ $c->display_name ?: $c->name }}</span>
                            <span style="font-size:12px; color:#94A3B8;">&rsaquo;</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Hotline Box -->
            <div style="background:#0B2545; color:#fff; border-radius:10px; padding:24px; margin-top:20px; text-align:center;">
                <div style="font-size:12px; font-weight:700; text-transform:uppercase; color:#94A3B8;">Immediate Assistance</div>
                <h4 style="font-size:18px; font-weight:800; margin:6px 0 12px;">Need Help Ordering?</h4>
                <a href="tel:18002214291" style="display:inline-block; background:#C1121F; color:#fff; padding:10px 18px; border-radius:6px; font-weight:700; text-decoration:none; font-size:15px;">
                    (800) 221-4291
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
