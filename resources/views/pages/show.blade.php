@extends('layouts.main')

@section('content')
<style>
    .cms-hero-bar {
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #fff;
        padding: 40px 0;
        border-bottom: 3px solid #C1121F;
    }

    .cms-layout-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 36px;
        padding: 40px 0 60px;
        align-items: start;
    }

    @media (max-width: 992px) {
        .cms-layout-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        .cms-sidebar {
            position: static !important;
            top: auto !important;
        }
    }

    .cms-article-body {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 36px 40px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        color: #334155;
        font-size: 16px;
        line-height: 1.8;
        min-width: 0;
        box-sizing: border-box;
    }

    @media (max-width: 768px) {
        .cms-article-body {
            padding: 24px 20px;
        }
    }

    .cms-article-body h2 {
        font-size: 24px;
        font-weight: 800;
        color: #0B2545;
        margin: 28px 0 14px;
        border-bottom: 2px solid #F1F5F9;
        padding-bottom: 8px;
    }

    .cms-article-body h3 {
        font-size: 19px;
        font-weight: 700;
        color: #0B2545;
        margin: 22px 0 10px;
    }

    .cms-article-body p { margin-bottom: 18px; }

    .cms-article-body ul, .cms-article-body ol {
        margin: 0 0 20px 24px;
    }

    .cms-article-body li { margin-bottom: 8px; }

    .cms-article-body img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 16px 0;
    }

    .cms-article-body iframe,
    .cms-article-body video {
        max-width: 100%;
    }

    .cms-article-body table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    .cms-article-body table th, .cms-article-body table td {
        padding: 10px 14px;
        border: 1px solid #E2E8F0;
        font-size: 14px;
    }

    .cms-article-body table th {
        background: #F8FAFC;
        font-weight: 700;
        color: #0B2545;
    }

    /* Legacy block styles rendered inside CMS article */
    .cms-article-body .border-box-blue,
    .cms-article-body .border-box-blue-rounded {
        background: #F8FAFC;
        border: 1px solid #CBD5E1;
        border-radius: 10px;
        padding: 24px 28px;
        height: auto !important;
        min-height: auto;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        margin-bottom: 24px;
        box-sizing: border-box;
    }

    .cms-article-body .col-md-6 > .border-box-blue,
    .cms-article-body .col-md-6 > .border-box-blue-rounded {
        height: 100% !important;
    }

    .cms-article-body .row {
        display: flex;
        flex-wrap: wrap;
        margin-left: -10px;
        margin-right: -10px;
        margin-bottom: 24px;
    }

    .cms-article-body .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding: 0 10px;
        box-sizing: border-box;
    }

    @media (max-width: 768px) {
        .cms-article-body .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 16px;
        }
    }

    .cms-article-body .button,
    .cms-article-body a.button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 26px;
        border-radius: 6px;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none !important;
        transition: all 0.2s ease;
        cursor: pointer;
        text-align: center;
    }

    .cms-article-body .button-blue,
    .cms-article-body a.button-blue {
        background: #0B2545;
        color: #ffffff !important;
        border: 2px solid #0B2545;
        box-shadow: 0 2px 6px rgba(11,37,69,0.15);
    }
    .cms-article-body .button-blue:hover,
    .cms-article-body a.button-blue:hover {
        background: #133E6E;
        border-color: #133E6E;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(11,37,69,0.25);
    }

    .cms-article-body .button-yellow,
    .cms-article-body a.button-yellow,
    .cms-article-body .button-red,
    .cms-article-body a.button-red {
        background: #C1121F;
        color: #ffffff !important;
        border: 2px solid #C1121F;
        box-shadow: 0 2px 6px rgba(193,18,31,0.25);
    }
    .cms-article-body .button-yellow:hover,
    .cms-article-body a.button-yellow:hover,
    .cms-article-body .button-red:hover,
    .cms-article-body a.button-red:hover {
        background: #990f19;
        border-color: #990f19;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(193,18,31,0.35);
    }

    .cms-article-body .dynamic-states-section {
        padding: 24px 0 !important;
    }
    .cms-article-body .dynamic-states-grid {
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 10px !important;
    }
    @media (max-width: 992px) {
        .cms-article-body .dynamic-states-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }
    @media (max-width: 480px) {
        .cms-article-body .dynamic-states-grid {
            grid-template-columns: 1fr !important;
        }
    }

    /* Sticky Sidebar */
    .cms-sidebar {
        position: sticky;
        top: 24px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .sidebar-widget {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .sidebar-title {
        font-size: 16px;
        font-weight: 800;
        color: #0B2545;
        margin: 0 0 14px;
        padding-bottom: 10px;
        border-bottom: 2px solid #F1F5F9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .sidebar-tests-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .sidebar-test-item {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 12px;
        transition: all 0.2s ease;
    }

    .sidebar-test-item:hover {
        background: #FFFFFF;
        border-color: #CBD5E1;
        box-shadow: 0 4px 10px rgba(11,37,69,0.05);
    }

    .sidebar-test-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        gap: 8px;
        margin-bottom: 4px;
    }

    .sidebar-test-name {
        font-size: 13.5px;
        font-weight: 800;
        color: #0B2545;
        text-decoration: none;
        line-height: 1.35;
        transition: color 0.15s ease;
    }

    .sidebar-test-name:hover {
        color: #C1121F;
    }

    .sidebar-test-price {
        font-size: 14px;
        font-weight: 900;
        color: #C1121F;
        white-space: nowrap;
    }

    .sidebar-test-meta {
        font-size: 11.5px;
        color: #64748B;
        margin-bottom: 8px;
    }

    .sidebar-order-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        background: #0B2545;
        color: #FFFFFF !important;
        font-size: 12.5px;
        font-weight: 800;
        padding: 8px 12px;
        border-radius: 6px;
        text-decoration: none;
        border: 1px solid #0B2545;
        transition: all 0.15s ease;
        box-shadow: 0 2px 4px rgba(11, 37, 69, 0.12);
        cursor: pointer;
    }

    .sidebar-order-btn:hover {
        background: #C1121F;
        border-color: #C1121F;
        color: #FFFFFF !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(193, 18, 31, 0.3);
    }

    .sidebar-order-btn .arrow {
        transition: transform 0.2s ease;
    }

    .sidebar-order-btn:hover .arrow {
        transform: translateX(3px);
    }

    /* Categories Widget */
    .sidebar-cat-list {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .sidebar-cat-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 12px;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        color: #1E293B;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.15s ease;
    }

    .sidebar-cat-item:hover {
        background: #FFFFFF;
        border-color: #0B2545;
        color: #C1121F;
        padding-left: 14px;
    }

    .sidebar-cat-arrow {
        color: #94A3B8;
        font-weight: 700;
    }

    /* Hotline Box */
    .sidebar-hotline-card {
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #fff;
        border-radius: 10px;
        padding: 24px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(11, 37, 69, 0.15);
    }

    .sidebar-hotline-sub {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: #94A3B8;
    }

    .sidebar-hotline-title {
        font-size: 18px;
        font-weight: 800;
        margin: 6px 0 10px;
        color: #FFFFFF;
    }

    .sidebar-hotline-desc {
        font-size: 12.5px;
        color: #CBD5E1;
        margin-bottom: 16px;
        line-height: 1.5;
    }

    .sidebar-hotline-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        background: #C1121F;
        color: #fff !important;
        padding: 10px 16px;
        border-radius: 6px;
        font-weight: 800;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.15s ease;
        box-shadow: 0 2px 6px rgba(193, 18, 31, 0.3);
    }

    .sidebar-hotline-btn:hover {
        background: #990f19;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(193, 18, 31, 0.45);
    }
</style>

<!-- Top Hero Header -->
<div class="cms-hero-bar">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Breadcrumb" style="display:flex; gap:8px; font-size:13px; color:#94A3B8; margin-bottom:12px;">
            <a href="{{ url('/') }}" style="color:#CBD5E1; text-decoration:none;">Home</a>
            <span>&rsaquo;</span>
            <span style="color:#fff;">{{ $page->title }}</span>
        </nav>

        <h1 style="font-size:32px; font-weight:800; color:#fff; line-height:1.2; margin:0;">
            {{ $page->page_heading ?: $page->title }}
        </h1>
    </div>
</div>

<div class="container">
    <div class="cms-layout-grid">
        <!-- Main Formatted Article -->
        <article class="cms-article-body">
            @if($page->featured_image)
                <div style="margin-bottom:24px;">
                    <img src="{{ $page->featured_image }}" alt="{{ $page->title }}" style="width:100%; max-height:400px; object-fit:cover; border-radius:8px;">
                </div>
            @endif

            {!! $page->content !!}

            @if(!empty($page->blocks_json) && is_array($page->blocks_json))
                @foreach($page->blocks_json as $block)
                    @if(($block['type'] ?? '') === 'faq' && !empty($block['items']))
                        <div class="cms-faq-section" style="margin-top:36px; padding-top:28px; border-top:2px solid #F1F5F9;">
                            <h3 style="font-size:22px; font-weight:800; color:#0B2545; margin-bottom:18px;">Frequently Asked Questions</h3>
                            @foreach($block['items'] as $item)
                                <div style="margin-bottom:16px; background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:18px 20px;">
                                    <strong style="color:#0B2545; font-size:16px; display:block; margin-bottom:6px;">Q: {{ $item['question'] }}</strong>
                                    <p style="color:#475569; font-size:14.5px; margin:0; line-height:1.6;">{{ $item['answer'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @elseif(($block['type'] ?? '') === 'cta')
                        <div class="cms-cta-callout" style="background:linear-gradient(135deg, #0B2545, #133E6E); color:#fff; border-radius:10px; padding:32px 24px; margin-top:36px; text-align:center;">
                            <h3 style="font-size:22px; font-weight:800; color:#fff; margin-bottom:8px;">{{ $block['title'] ?? 'Need Testing Assistance?' }}</h3>
                            <p style="color:#CBD5E1; font-size:14px; max-width:600px; margin:0 auto 18px;">{{ $block['subtitle'] ?? 'Our nationwide drug testing specialists are available 24/7 to assist with walk-in registrations.' }}</p>
                            <a href="{{ $block['btn_url'] ?? 'tel:18009854339' }}" class="btn btn-primary" style="display:inline-flex; font-size:15px; padding:12px 24px;">
                                {{ $block['btn_text'] ?? 'Call Toll-Free: (800)-985-4339' }}
                            </a>
                        </div>
                    @endif
                @endforeach
            @endif
        </article>

        <!-- Right Side: Sticky Sidebar with Tests, Categories & Hotline -->
        <aside class="cms-sidebar">
            @if(isset($popularTests) && $popularTests->count())
            <div class="sidebar-widget">
                <h3 class="sidebar-title">Popular Tests Available Today</h3>
                <div class="sidebar-tests-list">
                    @foreach($popularTests as $t)
                    <div class="sidebar-test-item">
                        <div class="sidebar-test-header">
                            <a href="{{ url('/product/' . $t->slug) }}" class="sidebar-test-name">
                                {{ $t->name }}
                            </a>
                            <span class="sidebar-test-price">${{ number_format($t->price, 2) }}</span>
                        </div>
                        <div class="sidebar-test-meta">
                            <span>⚡ {{ $t->turnaround_time }}</span>
                        </div>
                        <a href="{{ route('checkout.index', $t->slug) }}" class="sidebar-order-btn">
                            <span>Order This Test</span>
                            <span class="arrow">&rarr;</span>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if(isset($categories) && $categories->count())
            <div class="sidebar-widget">
                <h3 class="sidebar-title">Clinical Testing Services</h3>
                <div class="sidebar-cat-list">
                    @foreach($categories as $cat)
                    <a href="{{ url('/category/' . $cat->slug) }}" class="sidebar-cat-item">
                        <span>{{ $cat->name }}</span>
                        <span class="sidebar-cat-arrow">&rsaquo;</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Certified Testing Locations Hotline -->
            <div class="sidebar-hotline-card">
                <div class="sidebar-hotline-sub">Walk-In Drug Testing</div>
                <h4 class="sidebar-hotline-title">20,000+ Collection Sites</h4>
                <p class="sidebar-hotline-desc">
                    Walk in today at Quest Diagnostics &amp; Labcorp facilities. No doctor order or appointment required.
                </p>
                <a href="tel:18009854339" class="sidebar-hotline-btn">
                    <svg width="15" height="15" fill="currentColor" viewBox="0 0 20 20" style="margin-right:6px;"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 4V3z"></path></svg>
                    Call Toll-Free (800)-985-4339
                </a>
            </div>
        </aside>
    </div>
</div>
@endsection
