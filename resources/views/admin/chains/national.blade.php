@extends('admin.layouts.app', ['title' => 'National Chain Page Editor', 'heading' => 'National Chain Content & SEO Manager'])

@section('topbar_actions')
<a href="{{ url('/certified-drug-test-centers') }}" target="_blank" class="btn btn-outline btn-sm" style="display:inline-flex; align-items:center; gap:6px;">
    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
    View Live National Page
</a>
<button type="button" onclick="document.getElementById('nationalEditForm').submit();" class="btn btn-primary btn-sm" style="display:inline-flex; align-items:center; gap:6px;">
    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    Save All Changes
</button>
@endsection

@section('content')

@if(session('success'))
<div class="alert alert-success" style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
    <span>{{ session('success') }}</span>
    <a href="{{ url('/certified-drug-test-centers') }}" target="_blank" style="color:#166534; font-weight:700; text-decoration:underline;">View on live site →</a>
</div>
@endif

@if(isset($errors) && $errors->any())
<div class="alert alert-danger" style="margin-bottom:20px;">
    <ul style="margin:0; padding-left:20px;">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Navigation Tabs -->
<div style="display:flex; gap:8px; margin-bottom:20px; border-bottom:1px solid var(--admin-slate-200); padding-bottom:10px; flex-wrap:wrap;">
    <button type="button" class="chain-tab-btn active" data-tab="tab-hero" onclick="switchChainTab('tab-hero', this)">
        🎯 Hero Section
    </button>
    <button type="button" class="chain-tab-btn" data-tab="tab-qa" onclick="switchChainTab('tab-qa', this)">
        💡 Quick Answer &amp; Key Facts
    </button>
    <button type="button" class="chain-tab-btn" data-tab="tab-onsite" onclick="switchChainTab('tab-onsite', this)">
        🏢 Employer &amp; On-Site Mobile
    </button>
    <button type="button" class="chain-tab-btn" data-tab="tab-directory" onclick="switchChainTab('tab-directory', this)">
        🗺️ National Directory Headings
    </button>
    <button type="button" class="chain-tab-btn" data-tab="tab-faqs" onclick="switchChainTab('tab-faqs', this)">
        ❓ National FAQs
    </button>
    <button type="button" class="chain-tab-btn" data-tab="tab-seo" onclick="switchChainTab('tab-seo', this)">
        🔍 SEO Metadata
    </button>
</div>

<form id="nationalEditForm" action="{{ route('admin.chains.national.update') }}" method="POST">
    @csrf
    @method('PUT')

    <!-- ========================================================== -->
    <!-- TAB 1: HERO SECTION -->
    <!-- ========================================================== -->
    <div id="tab-hero" class="chain-tab-pane active">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">National Hero Section (/certified-drug-test-centers)</h2>
                    <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                        Main headline, introductory narrative, and key credential badges visible at the top of the National page.
                    </p>
                </div>
                <span class="badge badge-info">Top of Page</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="hero_eyebrow">Hero Eyebrow Tagline</label>
                    <input type="text" id="hero_eyebrow" name="hero_eyebrow" value="{{ old('hero_eyebrow', $chainSettings['hero_eyebrow']) }}" class="form-control" placeholder="Nationwide · All 50 States">
                </div>

                <div class="form-group">
                    <label class="form-label" for="hero_title">Primary H1 Headline *</label>
                    <input type="text" id="hero_title" name="hero_title" value="{{ old('hero_title', $chainSettings['hero_title']) }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="hero_lead">Hero Narrative Paragraph *</label>
                    <textarea id="hero_lead" name="hero_lead" rows="4" class="form-control" required>{{ old('hero_lead', $chainSettings['hero_lead']) }}</textarea>
                    <div style="font-size:12px; color:var(--admin-slate-500); margin-top:4px;">HTML formatting like &lt;strong&gt; tags is supported.</div>
                </div>

                <div class="form-group" style="margin-top:24px;">
                    <label class="form-label" style="display:flex; justify-content:space-between; align-items:center;">
                        <span>Hero Credential Checkmarks (List of Features)</span>
                        <button type="button" onclick="addHeroCheck()" class="btn btn-sm btn-outline">+ Add Checkmark</button>
                    </label>
                    <div id="heroChecksContainer" style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:8px;">
                        @foreach($chainSettings['hero_checks'] ?? [] as $idx => $check)
                        <div class="hero-check-row" style="display:flex; gap:6px; align-items:center;">
                            <span style="color:#16A34A; font-weight:800;">✓</span>
                            <input type="text" name="hero_checks[]" value="{{ $check }}" class="form-control" placeholder="e.g. 20,000+ Quest & Labcorp sites">
                            <button type="button" onclick="this.closest('.hero-check-row').remove()" class="btn btn-sm btn-outline" style="color:#DC2626;" title="Remove">✕</button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================== -->
    <!-- TAB 2: QUICK ANSWER & KEY FACTS -->
    <!-- ========================================================== -->
    <div id="tab-qa" class="chain-tab-pane" style="display:none;">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Quick Answer &amp; Key Facts (AEO Search Optimization)</h2>
                    <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                        Direct answer box optimized for Google AI Overviews and key statistical highlights.
                    </p>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="quick_answer_title">Quick Answer Box Headline</label>
                    <input type="text" id="quick_answer_title" name="quick_answer_title" value="{{ old('quick_answer_title', $chainSettings['quick_answer_title']) }}" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label" for="quick_answer_text">Quick Answer Explanatory Content</label>
                    <textarea id="quick_answer_text" name="quick_answer_text" rows="4" class="form-control">{{ old('quick_answer_text', $chainSettings['quick_answer_text']) }}</textarea>
                </div>

                <h3 style="font-size:15px; font-weight:700; color:var(--admin-navy); margin:24px 0 14px; border-bottom:1px solid #E2E8F0; padding-bottom:6px;">
                    Key Statistical Highlight Counters
                </h3>
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; padding:14px; border-radius:8px;">
                        <label class="form-label">Stat 1 Value</label>
                        <input type="text" name="fact_sites" value="{{ old('fact_sites', $chainSettings['fact_sites']) }}" class="form-control" style="font-weight:700;">
                        <label class="form-label" style="margin-top:8px;">Stat 1 Label</label>
                        <input type="text" name="fact_sites_label" value="{{ old('fact_sites_label', $chainSettings['fact_sites_label']) }}" class="form-control">
                    </div>

                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; padding:14px; border-radius:8px;">
                        <label class="form-label">Stat 2 Value</label>
                        <input type="text" name="fact_states" value="{{ old('fact_states', $chainSettings['fact_states']) }}" class="form-control" style="font-weight:700;">
                        <label class="form-label" style="margin-top:8px;">Stat 2 Label</label>
                        <input type="text" name="fact_states_label" value="{{ old('fact_states_label', $chainSettings['fact_states_label']) }}" class="form-control">
                    </div>

                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; padding:14px; border-radius:8px;">
                        <label class="form-label">Stat 3 Value</label>
                        <input type="text" name="fact_results" value="{{ old('fact_results', $chainSettings['fact_results']) }}" class="form-control" style="font-weight:700;">
                        <label class="form-label" style="margin-top:8px;">Stat 3 Label</label>
                        <input type="text" name="fact_results_label" value="{{ old('fact_results_label', $chainSettings['fact_results_label']) }}" class="form-control">
                    </div>

                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; padding:14px; border-radius:8px;">
                        <label class="form-label">Stat 4 Value</label>
                        <input type="text" name="fact_price" value="{{ old('fact_price', $chainSettings['fact_price']) }}" class="form-control" style="font-weight:700;">
                        <label class="form-label" style="margin-top:8px;">Stat 4 Label</label>
                        <input type="text" name="fact_price_label" value="{{ old('fact_price_label', $chainSettings['fact_price_label']) }}" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================== -->
    <!-- TAB 3: EMPLOYER & ON-SITE MOBILE SECTION -->
    <!-- ========================================================== -->
    <div id="tab-onsite" class="chain-tab-pane" style="display:none;">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Employer &amp; On-Site Mobile Testing Section</h2>
                    <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                        Corporate services, on-site job facility testing, and employer drug-free workplace benefits.
                    </p>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="onsite_eyebrow">Section Eyebrow</label>
                    <input type="text" id="onsite_eyebrow" name="onsite_eyebrow" value="{{ old('onsite_eyebrow', $chainSettings['onsite_eyebrow']) }}" class="form-control" placeholder="For employers">
                </div>

                <div class="form-group">
                    <label class="form-label" for="onsite_title">Section H2 Title</label>
                    <input type="text" id="onsite_title" name="onsite_title" value="{{ old('onsite_title', $chainSettings['onsite_title']) }}" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label" for="onsite_lead">Introductory Lead Paragraph</label>
                    <textarea id="onsite_lead" name="onsite_lead" rows="3" class="form-control">{{ old('onsite_lead', $chainSettings['onsite_lead']) }}</textarea>
                </div>

                <div class="form-group" style="margin-top:20px;">
                    <label class="form-label" style="display:flex; justify-content:space-between; align-items:center;">
                        <span>Employer Key Capabilities &amp; Mobile Testing Bullets</span>
                        <button type="button" onclick="addOnsiteCheck()" class="btn btn-sm btn-outline">+ Add Bullet</button>
                    </label>
                    <div id="onsiteChecksContainer" style="display:flex; flex-direction:column; gap:10px; margin-top:8px;">
                        @foreach($chainSettings['onsite_checks'] ?? [] as $idx => $check)
                        <div class="onsite-check-row" style="display:flex; gap:8px; align-items:center;">
                            <span style="color:#16A34A; font-weight:800;">✓</span>
                            <input type="text" name="onsite_checks[]" value="{{ $check }}" class="form-control" placeholder="e.g. On-site mobile collections for employees at job sites, warehouses and offices">
                            <button type="button" onclick="this.closest('.onsite-check-row').remove()" class="btn btn-sm btn-outline" style="color:#DC2626;" title="Remove">✕</button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================== -->
    <!-- TAB 4: DIRECTORY HEADINGS -->
    <!-- ========================================================== -->
    <div id="tab-directory" class="chain-tab-pane" style="display:none;">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">National State Directory Section Headings</h2>
                    <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                        The heading and lead text that appears immediately above the 50-state directory grid on the National page.
                    </p>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="directory_eyebrow">Directory Eyebrow</label>
                    <input type="text" id="directory_eyebrow" name="directory_eyebrow" value="{{ old('directory_eyebrow', $chainSettings['directory_eyebrow']) }}" class="form-control" placeholder="National directory">
                </div>

                <div class="form-group">
                    <label class="form-label" for="directory_title">Directory Section H2 Title *</label>
                    <input type="text" id="directory_title" name="directory_title" value="{{ old('directory_title', $chainSettings['directory_title']) }}" class="form-control" placeholder="Find drug and alcohol testing centers by State" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="directory_lead">Directory Lead Paragraph</label>
                    <textarea id="directory_lead" name="directory_lead" rows="3" class="form-control">{{ old('directory_lead', $chainSettings['directory_lead']) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================== -->
    <!-- TAB 5: FAQS REPEATER -->
    <!-- ========================================================== -->
    <div id="tab-faqs" class="chain-tab-pane" style="display:none;">
        <div class="card">
            <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <h2 class="card-title">National Frequently Asked Questions (FAQ Accordion)</h2>
                    <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                        Manage the 20 FAQ questions and answers displayed at the bottom of the national chain page.
                    </p>
                </div>
                <button type="button" onclick="addFaqRow()" class="btn btn-primary btn-sm">+ Add New FAQ</button>
            </div>
            <div class="card-body">
                <div id="faqsContainer" style="display:flex; flex-direction:column; gap:16px;">
                    @foreach($faqs as $i => $faq)
                    <div class="faq-row-card" style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:16px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                            <span style="font-size:13px; font-weight:700; color:var(--admin-navy);">FAQ Item #<span class="faq-number">{{ $i + 1 }}</span></span>
                            <button type="button" onclick="this.closest('.faq-row-card').remove(); renumberFaqs();" class="btn btn-sm btn-outline" style="color:#DC2626;" title="Delete this FAQ">✕ Remove</button>
                        </div>
                        <div class="form-group" style="margin-bottom:10px;">
                            <label class="form-label">Question</label>
                            <input type="text" name="faqs[{{ $i }}][question]" value="{{ $faq['question'] ?? '' }}" class="form-control" placeholder="e.g. Where can I get a drug test near me?">
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Answer</label>
                            <textarea name="faqs[{{ $i }}][answer]" rows="3" class="form-control" placeholder="Provide complete answer...">{{ $faq['answer'] ?? '' }}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================== -->
    <!-- TAB 6: SEO METADATA -->
    <!-- ========================================================== -->
    <div id="tab-seo" class="chain-tab-pane" style="display:none;">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Search Engine Optimization (SEO)</h2>
                    <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                        Meta title, meta description, and keywords for /certified-drug-test-centers
                    </p>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="meta_title">Meta Title (Browser Tab Title) *</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $chainSettings['meta_title']) }}" class="form-control" required>
                    <div style="font-size:12px; color:var(--admin-slate-500); margin-top:4px;">Recommended: 50–65 characters.</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="meta_description">Meta Description *</label>
                    <textarea id="meta_description" name="meta_description" rows="3" class="form-control" required>{{ old('meta_description', $chainSettings['meta_description']) }}</textarea>
                    <div style="font-size:12px; color:var(--admin-slate-500); margin-top:4px;">Recommended: 150–160 characters. Appears in Google search snippets.</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="meta_keywords">Meta Keywords</label>
                    <textarea id="meta_keywords" name="meta_keywords" rows="3" class="form-control">{{ old('meta_keywords', $chainSettings['meta_keywords']) }}</textarea>
                    <div style="font-size:12px; color:var(--admin-slate-500); margin-top:4px;">Comma separated search phrases.</div>
                </div>
            </div>
        </div>
    </div>

    <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px; padding-bottom:60px;">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Cancel</a>
        <button type="submit" class="btn btn-primary" style="font-size:15px; padding:12px 28px;">
            Save All National Page Changes
        </button>
    </div>
</form>

<style>
.chain-tab-btn {
    background: #FFFFFF;
    border: 1px solid var(--admin-slate-300);
    color: var(--admin-slate-700);
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
}
.chain-tab-btn:hover {
    background: var(--admin-slate-50);
    color: var(--admin-navy);
}
.chain-tab-btn.active {
    background: var(--admin-navy);
    color: #FFFFFF;
    border-color: var(--admin-navy);
}
</style>

<script>
function switchChainTab(tabId, btn) {
    document.querySelectorAll('.chain-tab-pane').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.chain-tab-btn').forEach(b => b.classList.remove('active'));

    var target = document.getElementById(tabId);
    if (target) {
        target.style.display = 'block';
    }
    btn.classList.add('active');
}

function addHeroCheck() {
    var container = document.getElementById('heroChecksContainer');
    var row = document.createElement('div');
    row.className = 'hero-check-row';
    row.style.cssText = 'display:flex; gap:6px; align-items:center;';
    row.innerHTML = `
        <span style="color:#16A34A; font-weight:800;">✓</span>
        <input type="text" name="hero_checks[]" class="form-control" placeholder="New credential checkmark">
        <button type="button" onclick="this.closest('.hero-check-row').remove()" class="btn btn-sm btn-outline" style="color:#DC2626;" title="Remove">✕</button>
    `;
    container.appendChild(row);
}

function addOnsiteCheck() {
    var container = document.getElementById('onsiteChecksContainer');
    var row = document.createElement('div');
    row.className = 'onsite-check-row';
    row.style.cssText = 'display:flex; gap:8px; align-items:center;';
    row.innerHTML = `
        <span style="color:#16A34A; font-weight:800;">✓</span>
        <input type="text" name="onsite_checks[]" class="form-control" placeholder="New capability or mobile testing bullet">
        <button type="button" onclick="this.closest('.onsite-check-row').remove()" class="btn btn-sm btn-outline" style="color:#DC2626;" title="Remove">✕</button>
    `;
    container.appendChild(row);
}

var faqIndex = {{ count($faqs) }};
function addFaqRow() {
    var container = document.getElementById('faqsContainer');
    var idx = faqIndex++;
    var card = document.createElement('div');
    card.className = 'faq-row-card';
    card.style.cssText = 'background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:16px;';
    card.innerHTML = `
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
            <span style="font-size:13px; font-weight:700; color:var(--admin-navy);">FAQ Item #<span class="faq-number">${container.children.length + 1}</span> (New)</span>
            <button type="button" onclick="this.closest('.faq-row-card').remove(); renumberFaqs();" class="btn btn-sm btn-outline" style="color:#DC2626;" title="Delete this FAQ">✕ Remove</button>
        </div>
        <div class="form-group" style="margin-bottom:10px;">
            <label class="form-label">Question</label>
            <input type="text" name="faqs[${idx}][question]" class="form-control" placeholder="Enter question...">
        </div>
        <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Answer</label>
            <textarea name="faqs[${idx}][answer]" rows="3" class="form-control" placeholder="Enter answer..."></textarea>
        </div>
    `;
    container.appendChild(card);
}

function renumberFaqs() {
    var numSpans = document.querySelectorAll('#faqsContainer .faq-number');
    numSpans.forEach(function(span, i) {
        span.textContent = i + 1;
    });
}
</script>
@endsection

