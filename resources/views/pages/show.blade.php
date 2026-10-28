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
        grid-template-columns: 2.8fr 1.2fr;
        gap: 40px;
        padding: 40px 0 60px;
    }

    @media (max-width: 992px) {
        .cms-layout-grid { grid-template-columns: 1fr; }
    }

    .cms-article-body {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 36px 40px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        color: #334155;
        font-size: 16px;
        line-height: 1.8;
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

    .sidebar-widget {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .sidebar-title {
        font-size: 16px;
        font-weight: 800;
        color: #0B2545;
        margin-bottom: 14px;
        padding-bottom: 8px;
        border-bottom: 1px solid #F1F5F9;
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

        <h1 style="font-size:32px; font-weight:800; color:#fff; line-height:1.2;">
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
                            <a href="{{ $block['btn_url'] ?? 'tel:18002214291' }}" class="btn btn-primary" style="display:inline-flex; font-size:15px; padding:12px 24px;">
                                {{ $block['btn_text'] ?? 'Call Toll-Free: (800) 221-4291' }}
                            </a>
                        </div>
                    @endif
                @endforeach
            @endif
        </article>

        <!-- Right Side: Popular Tests & Immediate Assistance -->
        <aside>
            <div class="sidebar-widget">
                <h3 class="sidebar-title">Popular Tests Available Today</h3>
                <div style="display:flex; flex-direction:column; gap:12px;">
                    @foreach($popularTests as $t)
                    <div style="display:flex; justify-content:space-between; align-items:center; padding-bottom:10px; border-bottom:1px solid #F8FAFC;">
                        <div>
                            <a href="{{ url('/product/' . $t->slug) }}" style="font-size:14px; font-weight:700; color:#0B2545; text-decoration:none;">
                                {{ $t->name }}
                            </a>
                            <div style="font-size:12px; color:#64748B;">{{ $t->turnaround_time }}</div>
                        </div>
                        <div style="text-align:right;">
                            <strong style="color:#C1121F; font-size:14px;">${{ number_format($t->price, 2) }}</strong>
                            <a href="{{ route('checkout.index', $t->slug) }}" class="btn btn-outline btn-sm" style="margin-top:2px; display:block; padding:3px 8px; font-size:11px;">
                                Order
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Certified Testing Locations Hotline -->
            <div style="background:#0B2545; color:#fff; border-radius:10px; padding:26px; text-align:center;">
                <div style="font-size:11px; font-weight:800; letter-spacing:0.8px; text-transform:uppercase; color:#94A3B8;">Walk-In Drug Testing</div>
                <h4 style="font-size:19px; font-weight:800; margin:8px 0 14px;">20,000+ Collection Sites</h4>
                <p style="font-size:13px; color:#CBD5E1; margin-bottom:18px;">
                    Walk in today at Quest Diagnostics &amp; Labcorp facilities. No doctor order or appointment required.
                </p>
                <a href="tel:18002214291" style="display:block; background:#C1121F; color:#fff; padding:12px; border-radius:6px; font-weight:700; font-size:15px; text-decoration:none;">
                    Call Toll-Free (800) 221-4291
                </a>
            </div>
        </aside>
    </div>
</div>
@endsection
