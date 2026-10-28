@extends('layouts.main')

@section('title', 'Verified Patient & Client Reviews | Certified Drug Test Centers')
@section('meta_description', 'Read 4,850+ verified customer and employer reviews for Certified Drug Test Centers. Rated 4.9/5 stars for same-day walk-in drug testing, DOT compliance, and fast MRO results.')

@section('content')
<div class="reviews-page">

    <!-- Hero Header -->
    <section class="reviews-hero">
        <div class="container" style="text-align:center; max-width:800px;">
            <div class="reviews-trust-pill">
                <span style="color:#F59E0B;">★★★★★</span>
                <span>4.9 / 5.0 Rating • 4,850+ Verified Patient &amp; Client Reviews</span>
            </div>
            <h1 class="reviews-hero-title">Verified Customer &amp; Employer Reviews</h1>
            <p class="reviews-hero-lead">
                Read real experiences from job applicants, commercial fleet safety managers, court-ordered donors, and corporate HR directors who rely on Certified Drug Test Centers nationwide.
            </p>
        </div>
    </section>

    <!-- Rating Summary Bar -->
    <section class="reviews-summary-bar">
        <div class="container">
            <div class="summary-card">
                <div class="summary-score-col">
                    <span class="big-score">4.9</span>
                    <div class="stars-gold">★★★★★</div>
                    <span class="score-subtext">Based on 4,850+ Verified Reviews</span>
                </div>

                <div class="summary-breakdown-col">
                    <div class="rating-bar-row">
                        <span>5 Stars</span>
                        <div class="bar-track"><div class="bar-fill" style="width: 92%;"></div></div>
                        <span>92%</span>
                    </div>
                    <div class="rating-bar-row">
                        <span>4 Stars</span>
                        <div class="bar-track"><div class="bar-fill" style="width: 7%;"></div></div>
                        <span>7%</span>
                    </div>
                    <div class="rating-bar-row">
                        <span>3 Stars</span>
                        <div class="bar-track"><div class="bar-fill" style="width: 1%;"></div></div>
                        <span>1%</span>
                    </div>
                    <div class="rating-bar-row">
                        <span>2 Stars</span>
                        <div class="bar-track"><div class="bar-fill" style="width: 0%;"></div></div>
                        <span>&lt;1%</span>
                    </div>
                    <div class="rating-bar-row">
                        <span>1 Star</span>
                        <div class="bar-track"><div class="bar-fill" style="width: 0%;"></div></div>
                        <span>&lt;1%</span>
                    </div>
                </div>

                <div class="summary-badges-col">
                    <div class="trust-check-badge">
                        <span class="check-icon">✓</span>
                        <div>
                            <strong>100% Verified Donors</strong>
                            <p>Authentic reviews from registered Quest &amp; Labcorp patients.</p>
                        </div>
                    </div>
                    <div class="trust-check-badge">
                        <span class="check-icon">✓</span>
                        <div>
                            <strong>SAMHSA Accredited</strong>
                            <p>All laboratory testing processed by certified reference labs.</p>
                        </div>
                    </div>
                    <div class="trust-check-badge">
                        <span class="check-icon">✓</span>
                        <div>
                            <strong>MRO Quality Assurance</strong>
                            <p>Every non-negative result verified by licensed medical review officers.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews Grid Section -->
    <section class="reviews-content-section">
        <div class="container">

            <!-- Category Filter Tabs -->
            <div class="reviews-filter-bar">
                <a href="{{ route('reviews.index', ['category' => 'all']) }}" class="filter-tab {{ $filter === 'all' ? 'active' : '' }}">
                    All Reviews ({{ count($allReviews) }})
                </a>
                <a href="{{ route('reviews.index', ['category' => 'pre-employment']) }}" class="filter-tab {{ $filter === 'pre-employment' ? 'active' : '' }}">
                    Pre-Employment Screening
                </a>
                <a href="{{ route('reviews.index', ['category' => 'dot']) }}" class="filter-tab {{ $filter === 'dot' ? 'active' : '' }}">
                    DOT Commercial Drivers
                </a>
                <a href="{{ route('reviews.index', ['category' => 'legal']) }}" class="filter-tab {{ $filter === 'legal' ? 'active' : '' }}">
                    Court &amp; Legal Compliance
                </a>
                <a href="{{ route('reviews.index', ['category' => 'hair']) }}" class="filter-tab {{ $filter === 'hair' ? 'active' : '' }}">
                    Hair Follicle (90-Day)
                </a>
                <a href="{{ route('reviews.index', ['category' => 'walk-in']) }}" class="filter-tab {{ $filter === 'walk-in' ? 'active' : '' }}">
                    Walk-in Experience
                </a>
            </div>

            <!-- Reviews Cards Grid -->
            <div class="reviews-grid">
                @foreach($filteredReviews as $rev)
                <div class="review-card">
                    <div class="review-card-header">
                        <div class="review-stars">
                            @for($i = 0; $i < $rev['rating']; $i++)
                                ★
                            @endfor
                        </div>
                        <span class="review-verified-pill">✓ Verified Patient</span>
                    </div>

                    <h3 class="review-test-badge">
                        {{ $rev['test_taken'] }}
                    </h3>

                    <p class="review-body-text">
                        "{{ $rev['review'] }}"
                    </p>

                    <div class="review-author-block">
                        <div class="author-avatar">
                            {{ substr($rev['author'], 0, 1) }}
                        </div>
                        <div>
                            <strong class="author-name">{{ $rev['author'] }}</strong>
                            <span class="author-title">{{ $rev['title'] }} • {{ $rev['company'] }}</span>
                            <span class="author-loc">{{ $rev['location'] }} • {{ $rev['date'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Bottom CTA Banner -->
            <div class="reviews-cta-banner">
                <div style="max-width:650px;">
                    <h3 style="color:#0B2545; font-size:24px; font-weight:800; margin-bottom:8px;">
                        Ready for Fast, Certified Drug &amp; Alcohol Testing?
                    </h3>
                    <p style="color:#64748B; font-size:15px; margin:0;">
                        Join over 4,800 satisfied clients. Walk in today at over 7,382 certified collection facilities nationwide with your electronic donor pass.
                    </p>
                </div>
                <div style="display:flex; gap:12px; flex-wrap:wrap;">
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="padding:14px 28px; font-weight:800;">
                        Schedule A Test Online &rarr;
                    </a>
                    <a href="{{ route('test-finder.index') }}" class="btn btn-outline" style="padding:14px 22px; font-weight:700; color:#0B2545; border-color:#CBD5E1;">
                        Find My Test Wizard
                    </a>
                </div>
            </div>

        </div>
    </section>

</div>

<!-- Styles for Reviews Page -->
<style>
.reviews-page {
    background: #F8FAFC;
    padding-bottom: 60px;
}
.reviews-hero {
    background: linear-gradient(135deg, #0B2545 0%, #153E6B 100%);
    color: #fff;
    padding: 50px 0 70px;
}
.reviews-trust-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 16px;
}
.reviews-hero-title {
    font-size: 38px;
    font-weight: 900;
    color: #fff;
    margin-bottom: 12px;
}
.reviews-hero-lead {
    font-size: 16.5px;
    color: #CBD5E1;
    line-height: 1.6;
    margin: 0;
}

/* Summary Card */
.reviews-summary-bar {
    margin-top: -40px;
    margin-bottom: 40px;
}
.summary-card {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    display: grid;
    grid-template-columns: 0.8fr 1.2fr 1.2fr;
    gap: 36px;
    align-items: center;
}
.summary-score-col {
    text-align: center;
    border-right: 1px solid #F1F5F9;
    padding-right: 20px;
}
.big-score {
    font-size: 54px;
    font-weight: 900;
    color: #0B2545;
    line-height: 1;
    display: block;
}
.stars-gold {
    color: #F59E0B;
    font-size: 22px;
    letter-spacing: 2px;
    margin: 6px 0;
}
.score-subtext {
    font-size: 13px;
    color: #64748B;
    font-weight: 600;
}

.summary-breakdown-col {
    border-right: 1px solid #F1F5F9;
    padding-right: 20px;
}
.rating-bar-row {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12.5px;
    color: #64748B;
    margin-bottom: 6px;
}
.rating-bar-row span:first-child {
    width: 50px;
}
.bar-track {
    flex: 1;
    height: 8px;
    background: #F1F5F9;
    border-radius: 4px;
    overflow: hidden;
}
.bar-fill {
    height: 100%;
    background: #F59E0B;
    border-radius: 4px;
}

.summary-badges-col {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.trust-check-badge {
    display: flex;
    gap: 12px;
    align-items: flex-start;
}
.check-icon {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: #ECFDF5;
    color: #059669;
    font-weight: 900;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
}
.trust-check-badge strong {
    display: block;
    font-size: 13.5px;
    color: #0B2545;
}
.trust-check-badge p {
    font-size: 12px;
    color: #64748B;
    margin: 0;
    line-height: 1.3;
}

/* Filter Bar */
.reviews-filter-bar {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}
.filter-tab {
    background: #fff;
    border: 1px solid #CBD5E1;
    color: #475569;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13.5px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.15s;
}
.filter-tab:hover {
    border-color: #0B2545;
    color: #0B2545;
}
.filter-tab.active {
    background: #0B2545;
    border-color: #0B2545;
    color: #fff;
}

/* Reviews Grid */
.reviews-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-bottom: 40px;
}
.review-card {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 14px rgba(0,0,0,0.03);
    transition: transform 0.2s, box-shadow 0.2s;
}
.review-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(11,37,69,0.07);
}
.review-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}
.review-stars {
    color: #F59E0B;
    font-size: 16px;
    letter-spacing: 2px;
}
.review-verified-pill {
    background: #ECFDF5;
    color: #065F46;
    border: 1px solid #A7F3D0;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 12px;
}
.review-test-badge {
    font-size: 13.5px;
    font-weight: 800;
    color: #0B2545;
    background: #F1F5F9;
    padding: 6px 10px;
    border-radius: 6px;
    margin: 0 0 14px;
}
.review-body-text {
    font-size: 14px;
    color: #334155;
    line-height: 1.6;
    flex: 1;
    margin-bottom: 20px;
    font-style: italic;
}
.review-author-block {
    display: flex;
    align-items: center;
    gap: 12px;
    border-top: 1px solid #F1F5F9;
    padding-top: 14px;
}
.author-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #0B2545;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 15px;
    flex-shrink: 0;
}
.author-name {
    display: block;
    color: #0B2545;
    font-size: 13.5px;
}
.author-title {
    display: block;
    color: #64748B;
    font-size: 12px;
}
.author-loc {
    display: block;
    color: #94A3B8;
    font-size: 11.5px;
}

/* CTA Banner */
.reviews-cta-banner {
    background: #fff;
    border: 2px solid #0B2545;
    border-radius: 16px;
    padding: 36px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 24px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

@media (max-width: 991px) {
    .summary-card {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    .summary-score-col, .summary-breakdown-col {
        border-right: none;
        border-bottom: 1px solid #F1F5F9;
        padding-right: 0;
        padding-bottom: 20px;
    }
    .reviews-grid {
        grid-template-columns: 1fr 1fr;
    }
}
@media (max-width: 640px) {
    .reviews-grid {
        grid-template-columns: 1fr;
    }
    .reviews-cta-banner {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>
@endsection
