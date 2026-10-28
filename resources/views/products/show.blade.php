@extends('layouts.main')

@section('content')
<style>
    .product-hero-bar {
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #fff;
        padding: 40px 0;
        border-bottom: 3px solid #C1121F;
    }

    .breadcrumbs {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #94A3B8;
        margin-bottom: 12px;
    }
    .breadcrumbs a { color: #CBD5E1; text-decoration: none; }
    .breadcrumbs a:hover { color: #fff; text-decoration: underline; }

    .product-title {
        font-size: 32px;
        font-weight: 800;
        letter-spacing: -0.5px;
        color: #fff;
        margin-bottom: 10px;
    }

    .product-meta-badges {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .prod-badge {
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 700;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .prod-badge-specimen { background: #E0F2FE; color: #0369A1; }
    .prod-badge-turnaround { background: #DCFCE7; color: #15803D; }
    .prod-badge-dot { background: #FEE2E2; color: #B91C1C; }

    .product-layout-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 36px;
        padding: 40px 0 60px;
    }

    @media (max-width: 992px) {
        .product-layout-grid { grid-template-columns: 1fr; }
    }

    .prod-section {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .prod-section-title {
        font-size: 20px;
        font-weight: 800;
        color: #0B2545;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 2px solid #F1F5F9;
    }

    .panels-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 12px;
        margin-top: 14px;
    }

    .panel-item {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        padding: 10px 14px;
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .panel-item-check { color: #16A34A; font-weight: 800; font-size: 16px; }

    /* Order Sticky Card */
    .order-sidebar-card {
        background: #fff;
        border: 2px solid #0B2545;
        border-radius: 12px;
        padding: 28px;
        box-shadow: 0 10px 25px rgba(11,37,69,0.08);
        position: sticky;
        top: 24px;
    }

    .order-card-price-row {
        display: flex;
        align-items: baseline;
        gap: 12px;
        margin-bottom: 6px;
    }

    .order-card-price {
        font-size: 38px;
        font-weight: 900;
        color: #C1121F;
        line-height: 1;
    }

    .order-card-retail {
        font-size: 16px;
        text-decoration: line-through;
        color: #94A3B8;
        font-weight: 600;
    }

    .order-card-badge {
        display: inline-block;
        background: #FEF2F2;
        border: 1px solid #FECACA;
        color: #991B1B;
        font-size: 12px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        margin-bottom: 18px;
    }

    .order-checklist {
        list-style: none;
        padding: 0;
        margin: 18px 0 24px;
        font-size: 13px;
        color: #475569;
    }

    .order-checklist li {
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .order-checklist svg { color: #16A34A; flex-shrink: 0; }
</style>

<!-- Hero Section -->
<div class="product-hero-bar">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span>&rsaquo;</span>
            @if($category)
                <a href="{{ url('/category/' . $category->slug) }}">{{ $category->display_name ?: $category->name }}</a>
                <span>&rsaquo;</span>
            @endif
            <span style="color:#fff;">{{ $product->name }}</span>
        </nav>

        <h1 class="product-title">{{ $product->name }}</h1>

        <div class="product-meta-badges">
            <span class="prod-badge prod-badge-specimen">{{ ucfirst($product->specimen_type) }} Specimen</span>
            <span class="prod-badge prod-badge-turnaround">{{ $product->turnaround_time }}</span>
            @if($product->dot_required)
                <span class="prod-badge prod-badge-dot">DOT Federal Regulated</span>
            @else
                <span class="prod-badge" style="background:#F1F5F9; color:#475569;">Non-DOT Commercial</span>
            @endif
            <span style="color:#CBD5E1; font-size:13px;">• SAMHSA Certified Labs • MRO Physician Review</span>
        </div>
    </div>
</div>

<div class="container">
    <div class="product-layout-grid">
        <!-- Main Content Column -->
        <div>
            @if($product->short_description)
            <div class="prod-section">
                <h2 class="prod-section-title">Test Overview</h2>
                <div style="font-size:15px; color:#334155; line-height:1.7;">
                    {!! nl2br(e($product->short_description)) !!}
                </div>
            </div>
            @endif

            @if(!empty($product->included_panels) && count($product->included_panels))
            <div class="prod-section">
                <h2 class="prod-section-title">Screened Substances &amp; Drug Classes</h2>
                <p style="font-size:14px; color:#64748B;">
                    This comprehensive panel tests for the following illicit drugs and prescription metabolites to federal cutoff thresholds:
                </p>
                <div class="panels-grid">
                    @foreach($product->included_panels as $panel)
                    <div class="panel-item">
                        <span class="panel-item-check">✓</span>
                        <span>{{ $panel }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($product->details)
            <div class="prod-section">
                <h2 class="prod-section-title">Detailed Scientific Description</h2>
                <div style="font-size:14px; color:#334155; line-height:1.7;">
                    {!! nl2br(e($product->details)) !!}
                </div>
            </div>
            @endif

            @if($product->preparation_instructions)
            <div class="prod-section">
                <h2 class="prod-section-title">Donor Preparation &amp; Collection Guidelines</h2>
                <div style="font-size:14px; color:#334155; line-height:1.7; background:#F8FAFC; padding:16px; border-radius:8px; border-left:4px solid #0B2545;">
                    {!! nl2br(e($product->preparation_instructions)) !!}
                </div>
            </div>
            @endif

            <!-- Clinical Protocol & Laboratory Standards -->
            <div class="prod-section">
                <h2 class="prod-section-title">Clinical Testing Protocols &amp; Chain of Custody</h2>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:18px;">
                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:16px;">
                        <h3 style="font-size:14.5px; font-weight:800; color:#0B2545; margin:0 0 6px;">
                            🔬 SAMHSA-Certified Laboratories
                        </h3>
                        <p style="font-size:13px; color:#475569; margin:0; line-height:1.5;">
                            All samples are analyzed at CAP-accredited, SAMHSA-certified Quest Diagnostics and Labcorp reference laboratories utilizing state-of-the-art immunoassay analyzers and GC/MS / LC-MS/MS confirmatory instrumentation.
                        </p>
                    </div>
                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:16px;">
                        <h3 style="font-size:14.5px; font-weight:800; color:#0B2545; margin:0 0 6px;">
                            👨‍⚕️ Medical Review Officer (MRO)
                        </h3>
                        <p style="font-size:13px; color:#475569; margin:0; line-height:1.5;">
                            Every drug screen is supervised by a licensed Medical Review Officer. If a non-negative result occurs, the MRO contacts the donor to verify legitimate prescribed medications prior to reporting results.
                        </p>
                    </div>
                </div>

                <div style="border-top:1px solid #F1F5F9; padding-top:16px;">
                    <h3 style="font-size:15px; font-weight:800; color:#0B2545; margin-bottom:12px;">3-Step Express Testing Process</h3>
                    <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:14px;">
                        <div style="text-align:center; padding:14px; background:#F8FAFC; border-radius:8px; border:1px solid #E2E8F0;">
                            <div style="font-size:22px; font-weight:900; color:#C1121F; margin-bottom:4px;">1</div>
                            <div style="font-size:13px; font-weight:700; color:#0B2545; margin-bottom:4px;">Register Online</div>
                            <div style="font-size:11.5px; color:#64748B;">Select your panel and get an instant electronic Donor Pass with barcode.</div>
                        </div>
                        <div style="text-align:center; padding:14px; background:#F8FAFC; border-radius:8px; border:1px solid #E2E8F0;">
                            <div style="font-size:22px; font-weight:900; color:#0B2545; margin-bottom:4px;">2</div>
                            <div style="font-size:13px; font-weight:700; color:#0B2545; margin-bottom:4px;">Walk In Today</div>
                            <div style="font-size:11.5px; color:#64748B;">Visit any of 20,000+ Quest or Labcorp partner sites. No appointment needed.</div>
                        </div>
                        <div style="text-align:center; padding:14px; background:#F8FAFC; border-radius:8px; border:1px solid #E2E8F0;">
                            <div style="font-size:22px; font-weight:900; color:#10B981; margin-bottom:4px;">3</div>
                            <div style="font-size:13px; font-weight:700; color:#0B2545; margin-bottom:4px;">Get Verified Results</div>
                            <div style="font-size:11.5px; color:#64748B;">Fast turnaround (1-2 business days) securely sent to your confidential email.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Express Checkout Sidebar -->
        <div>
            <div class="order-sidebar-card">
                <div class="order-card-price-row">
                    <div class="order-card-price">${{ number_format($product->price, 2) }}</div>
                    @if($product->retail_price > $product->price)
                        <div class="order-card-retail">${{ number_format($product->retail_price, 2) }}</div>
                    @endif
                </div>

                <div class="order-card-badge">
                    {{ $product->subtitle ?: 'Online Discount Applied' }}
                </div>

                <ul class="order-checklist">
                    <li>
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Instant Electronic Donor Pass via Email
                    </li>
                    <li>
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Walk-in Same-Day at 20,000+ Centers
                    </li>
                    <li>
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Quest Diagnostics &amp; Labcorp Partner Sites
                    </li>
                    <li>
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Medical Review Officer (MRO) Included
                    </li>
                </ul>

                <a href="{{ route('checkout.index', $product->slug) }}" class="btn btn-primary" style="width:100%; justify-content:center; padding:14px; font-size:16px;">
                    Order Test Online Now &rarr;
                </a>

                <div style="text-align:center; margin-top:14px;">
                    <span style="font-size:12px; color:#64748B;">Need help or have questions?</span><br>
                    <a href="tel:18002214291" style="color:#0B2545; font-weight:700; font-size:14px; text-decoration:none;">
                        Call Toll-Free: (800) 221-4291
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
