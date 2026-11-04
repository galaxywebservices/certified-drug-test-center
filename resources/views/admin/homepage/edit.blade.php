@extends('admin.layouts.app', ['title' => 'HomePage Editor', 'heading' => 'HomePage Content & Section Manager'])

@section('topbar_actions')
<a href="{{ url('/') }}" target="_blank" class="btn btn-outline btn-sm" style="display:inline-flex; align-items:center; gap:6px;">
    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
    View Live Homepage
</a>
<button type="button" onclick="document.getElementById('homepageEditForm').submit();" class="btn btn-primary btn-sm" style="display:inline-flex; align-items:center; gap:6px;">
    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    Save All Changes
</button>
@endsection

@section('content')

@if(session('success'))
<div class="alert alert-success" style="display:flex; align-items:center; justify-content:space-between;">
    <span>{{ session('success') }}</span>
    <a href="{{ url('/') }}" target="_blank" style="color:#166534; font-weight:700; text-decoration:underline;">View on live site →</a>
</div>
@endif

@if(isset($errors) && $errors->any())
<div class="alert alert-danger">
    <ul style="margin:0; padding-left:20px;">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Homepage Navigation Tabs -->
<div style="display:flex; gap:8px; margin-bottom:20px; border-bottom:1px solid var(--admin-slate-200); padding-bottom:10px; flex-wrap:wrap;">
    <button type="button" class="hp-tab-btn active" data-tab="tab-hero" onclick="switchTab('tab-hero', this)">
        🎯 Hero &amp; Estimator
    </button>
    <button type="button" class="hp-tab-btn" data-tab="tab-process" onclick="switchTab('tab-process', this)">
        ⚡ Process &amp; Substance Tool
    </button>
    <button type="button" class="hp-tab-btn" data-tab="tab-sections" onclick="switchTab('tab-sections', this)">
        📋 Catalog, Matrix &amp; Directory
    </button>
    <button type="button" class="hp-tab-btn" data-tab="tab-faqs" onclick="switchTab('tab-faqs', this)">
        ❓ FAQ Accordion
    </button>
    <button type="button" class="hp-tab-btn" data-tab="tab-seo" onclick="switchTab('tab-seo', this)">
        🔍 SEO Metadata
    </button>
</div>

<form id="homepageEditForm" action="{{ route('admin.homepage.update') }}" method="POST">
    @csrf
    @method('PUT')

    <!-- ========================================================== -->
    <!-- TAB 1: HERO & ESTIMATOR CARD -->
    <!-- ========================================================== -->
    <div id="tab-hero" class="hp-tab-pane active">
        <div style="display:grid; grid-template-columns:1.2fr 0.8fr; gap:24px;">
            <!-- Hero Left Side -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <h2 class="card-title">Main Hero Banner</h2>
                        <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                            Primary value proposition visible above the fold on the homepage
                        </p>
                    </div>
                    <span class="badge badge-info">Top of Page</span>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="hero_badge">Hero Top Tagline / Pill Badge</label>
                        <input type="text" id="hero_badge" name="hero_badge" value="{{ old('hero_badge', $homeSettings['hero_badge']) }}" class="form-control" placeholder="Express Online Drug & Alcohol Testing">
                        <div class="form-hint">Displayed between two red stars inside the top pill badge.</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hero_title">Primary H1 Headline *</label>
                        <textarea id="hero_title" name="hero_title" rows="2" class="form-control" required style="font-family:monospace; font-size:13px;">{{ old('hero_title', $homeSettings['hero_title']) }}</textarea>
                        <div class="form-hint">
                            HTML allowed. Wrap text in <code>&lt;span class="highlight-red"&gt;Text&lt;/span&gt;</code> to render in crimson red.
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="hero_subtitle">Hero Paragraph Description *</label>
                        <textarea id="hero_subtitle" name="hero_subtitle" rows="3" class="form-control" required>{{ old('hero_subtitle', $homeSettings['hero_subtitle']) }}</textarea>
                        <div class="form-hint">Clear summary describing the 2-minute registration and walk-in network.</div>
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Hero Checklist Bullet Points (4 Badges)</label>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                            @php
                                $bullets = old('hero_bullets', $homeSettings['hero_bullets'] ?? []);
                            @endphp
                            <div>
                                <label style="font-size:11px; color:#64748B; font-weight:600;">Bullet 1</label>
                                <input type="text" name="hero_bullets[]" value="{{ $bullets[0] ?? '20,000+ Quest & Labcorp Sites' }}" class="form-control">
                            </div>
                            <div>
                                <label style="font-size:11px; color:#64748B; font-weight:600;">Bullet 2</label>
                                <input type="text" name="hero_bullets[]" value="{{ $bullets[1] ?? 'SAMHSA Certified Laboratories' }}" class="form-control">
                            </div>
                            <div>
                                <label style="font-size:11px; color:#64748B; font-weight:600;">Bullet 3</label>
                                <input type="text" name="hero_bullets[]" value="{{ $bullets[2] ?? 'Physician MRO Verification' }}" class="form-control">
                            </div>
                            <div>
                                <label style="font-size:11px; color:#64748B; font-weight:600;">Bullet 4</label>
                                <input type="text" name="hero_bullets[]" value="{{ $bullets[3] ?? 'Court & DOT Legally Defensible' }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Express Online Scheduling Card Right Side -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <h2 class="card-title">Express Online Scheduling Card</h2>
                        <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                            Interactive test selector and scheduling box on the right of hero
                        </p>
                    </div>
                    <span class="badge badge-success">Interactive</span>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="estimator_title">Card Heading</label>
                        <input type="text" id="estimator_title" name="estimator_title" value="{{ old('estimator_title', $homeSettings['estimator_title']) }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="estimator_subtitle">Card Subtitle</label>
                        <textarea id="estimator_subtitle" name="estimator_subtitle" rows="2" class="form-control">{{ old('estimator_subtitle', $homeSettings['estimator_subtitle']) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="estimator_button">Call to Action Button Text</label>
                        <input type="text" id="estimator_button" name="estimator_button" value="{{ old('estimator_button', $homeSettings['estimator_button']) }}" class="form-control">
                        <div class="form-hint">Triggers the registration &amp; checkout drawer modal.</div>
                    </div>

                    <div style="background:#F8FAFC; border:1px dashed #CBD5E1; border-radius:6px; padding:12px; font-size:12px; color:#64748B; margin-top:20px;">
                        <strong>Note:</strong> Pricing options inside the estimator card dropdown automatically synchronize with your test catalog.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================== -->
    <!-- TAB 2: PROCESS & SUBSTANCE TOOL -->
    <!-- ========================================================== -->
    <div id="tab-process" class="hp-tab-pane" style="display:none;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
            <!-- Substance Checker Tool -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <h2 class="card-title">Smart Substance Lookup Tool</h2>
                        <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                            Section header above the interactive drug search box
                        </p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="substance_eyebrow">Eyebrow Tag</label>
                        <input type="text" id="substance_eyebrow" name="substance_eyebrow" value="{{ old('substance_eyebrow', $homeSettings['substance_eyebrow']) }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="substance_title">Section Title</label>
                        <input type="text" id="substance_title" name="substance_title" value="{{ old('substance_title', $homeSettings['substance_title']) }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="substance_subtitle">Section Subtitle / Instructions</label>
                        <textarea id="substance_subtitle" name="substance_subtitle" rows="2" class="form-control">{{ old('substance_subtitle', $homeSettings['substance_subtitle']) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 3-Step Process Header -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <h2 class="card-title">3-Step Express Timeline Header</h2>
                        <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                            Introduces the 3-step testing procedure
                        </p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="timeline_eyebrow">Timeline Eyebrow</label>
                        <input type="text" id="timeline_eyebrow" name="timeline_eyebrow" value="{{ old('timeline_eyebrow', $homeSettings['timeline_eyebrow']) }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="timeline_title">Timeline Title</label>
                        <input type="text" id="timeline_title" name="timeline_title" value="{{ old('timeline_title', $homeSettings['timeline_title']) }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="timeline_subtitle">Timeline Subtitle</label>
                        <textarea id="timeline_subtitle" name="timeline_subtitle" rows="2" class="form-control">{{ old('timeline_subtitle', $homeSettings['timeline_subtitle']) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3 Step Cards Detail -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Timeline Steps 01, 02 &amp; 03</h2>
            </div>
            <div class="card-body">
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px;">
                    <!-- Step 1 -->
                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:16px;">
                        <span style="font-size:20px; font-weight:800; color:var(--admin-crimson); display:block; margin-bottom:8px;">01.</span>
                        <div class="form-group">
                            <label class="form-label">Step 1 Title</label>
                            <input type="text" name="step1_title" value="{{ old('step1_title', $homeSettings['step1_title']) }}" class="form-control">
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Step 1 Description</label>
                            <textarea name="step1_desc" rows="3" class="form-control">{{ old('step1_desc', $homeSettings['step1_desc']) }}</textarea>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:16px;">
                        <span style="font-size:20px; font-weight:800; color:var(--admin-crimson); display:block; margin-bottom:8px;">02.</span>
                        <div class="form-group">
                            <label class="form-label">Step 2 Title</label>
                            <input type="text" name="step2_title" value="{{ old('step2_title', $homeSettings['step2_title']) }}" class="form-control">
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Step 2 Description</label>
                            <textarea name="step2_desc" rows="3" class="form-control">{{ old('step2_desc', $homeSettings['step2_desc']) }}</textarea>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:16px;">
                        <span style="font-size:20px; font-weight:800; color:var(--admin-crimson); display:block; margin-bottom:8px;">03.</span>
                        <div class="form-group">
                            <label class="form-label">Step 3 Title</label>
                            <input type="text" name="step3_title" value="{{ old('step3_title', $homeSettings['step3_title']) }}" class="form-control">
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Step 3 Description</label>
                            <textarea name="step3_desc" rows="3" class="form-control">{{ old('step3_desc', $homeSettings['step3_desc']) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================== -->
    <!-- TAB 3: SECTIONS (CATALOG, MATRIX, LOCATIONS) -->
    <!-- ========================================================== -->
    <div id="tab-sections" class="hp-tab-pane" style="display:none;">
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px;">
            <!-- Catalog Header -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">1. Test Catalog Section</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="catalog_eyebrow">Eyebrow</label>
                        <input type="text" id="catalog_eyebrow" name="catalog_eyebrow" value="{{ old('catalog_eyebrow', $homeSettings['catalog_eyebrow']) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="catalog_title">Title</label>
                        <input type="text" id="catalog_title" name="catalog_title" value="{{ old('catalog_title', $homeSettings['catalog_title']) }}" class="form-control">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="catalog_subtitle">Subtitle</label>
                        <textarea id="catalog_subtitle" name="catalog_subtitle" rows="3" class="form-control">{{ old('catalog_subtitle', $homeSettings['catalog_subtitle']) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Matrix Header -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">2. Detection Matrix Section</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="matrix_eyebrow">Eyebrow</label>
                        <input type="text" id="matrix_eyebrow" name="matrix_eyebrow" value="{{ old('matrix_eyebrow', $homeSettings['matrix_eyebrow']) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="matrix_title">Title</label>
                        <input type="text" id="matrix_title" name="matrix_title" value="{{ old('matrix_title', $homeSettings['matrix_title']) }}" class="form-control">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="matrix_subtitle">Subtitle</label>
                        <textarea id="matrix_subtitle" name="matrix_subtitle" rows="3" class="form-control">{{ old('matrix_subtitle', $homeSettings['matrix_subtitle']) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Locations Header -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">3. State Directory Section</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="locations_eyebrow">Eyebrow</label>
                        <input type="text" id="locations_eyebrow" name="locations_eyebrow" value="{{ old('locations_eyebrow', $homeSettings['locations_eyebrow']) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="locations_title">Title</label>
                        <input type="text" id="locations_title" name="locations_title" value="{{ old('locations_title', $homeSettings['locations_title']) }}" class="form-control">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="locations_subtitle">Subtitle</label>
                        <textarea id="locations_subtitle" name="locations_subtitle" rows="3" class="form-control">{{ old('locations_subtitle', $homeSettings['locations_subtitle']) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================== -->
    <!-- TAB 4: FAQ ACCORDION -->
    <!-- ========================================================== -->
    <div id="tab-faqs" class="hp-tab-pane" style="display:none;">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">FAQ Section Header &amp; Accordion Items</h2>
                    <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                        Add, edit, or remove questions &amp; answers displayed at the bottom of the homepage
                    </p>
                </div>
                <button type="button" onclick="addFaqRow()" class="btn btn-primary btn-sm">
                    + Add New FAQ Question
                </button>
            </div>
            <div class="card-body">
                <div style="display:grid; grid-template-columns:1fr 2fr; gap:20px; margin-bottom:24px; padding-bottom:20px; border-bottom:1px solid #E2E8F0;">
                    <div>
                        <label class="form-label" for="faq_eyebrow">FAQ Eyebrow Tag</label>
                        <input type="text" id="faq_eyebrow" name="faq_eyebrow" value="{{ old('faq_eyebrow', $homeSettings['faq_eyebrow']) }}" class="form-control">
                    </div>
                    <div>
                        <label class="form-label" for="faq_title">FAQ Section Title</label>
                        <input type="text" id="faq_title" name="faq_title" value="{{ old('faq_title', $homeSettings['faq_title']) }}" class="form-control">
                    </div>
                </div>

                <div id="faqsContainer" style="display:flex; flex-direction:column; gap:16px;">
                    @php
                        $faqList = old('faqs', $faqs);
                    @endphp
                    @foreach($faqList as $idx => $faq)
                    <div class="faq-row-card" id="faq-row-{{ $idx }}" style="background:#F8FAFC; border:1px solid #CBD5E1; border-radius:8px; padding:16px; position:relative;">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                            <span class="faq-number-badge" style="font-size:12px; font-weight:700; color:#0B2545;">Question #{{ $loop->iteration }}</span>
                            <button type="button" onclick="removeFaqRow('faq-row-{{ $idx }}')" class="btn btn-outline btn-sm" style="color:#C1121F; border-color:#FCA5A5; padding:3px 8px; font-size:11px;">
                                Remove
                            </button>
                        </div>
                        <div class="form-group" style="margin-bottom:10px;">
                            <label class="form-label">Question *</label>
                            <input type="text" name="faqs[{{ $idx }}][question]" value="{{ $faq['question'] ?? '' }}" class="form-control" required placeholder="e.g. How does the test scheduling process work?">
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Answer *</label>
                            <textarea name="faqs[{{ $idx }}][answer]" rows="3" class="form-control" required placeholder="Provide clear explanation for the patient or employer...">{{ $faq['answer'] ?? '' }}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div style="text-align:center; margin-top:20px;">
                    <button type="button" onclick="addFaqRow()" class="btn btn-outline btn-sm" style="display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Another Question
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================== -->
    <!-- TAB 5: SEO METADATA -->
    <!-- ========================================================== -->
    <div id="tab-seo" class="hp-tab-pane" style="display:none;">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">Homepage SEO &amp; Google Search Meta Tags</h2>
                    <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                        Controls what shows up in Google search results and browser title tabs
                    </p>
                </div>
                <span class="badge badge-success">SEO Critical</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="meta_title">Homepage Meta Title *</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $homeSettings['meta_title']) }}" class="form-control" required maxlength="120" oninput="updateSeoPreview()">
                    <div class="form-hint" id="titleCount">Target: 50-60 characters. Recommended for high click-through rates.</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="meta_description">Homepage Meta Description *</label>
                    <textarea id="meta_description" name="meta_description" rows="3" class="form-control" required maxlength="300" oninput="updateSeoPreview()">{{ old('meta_description', $homeSettings['meta_description']) }}</textarea>
                    <div class="form-hint" id="descCount">Target: 150-160 characters. Highlight 2-minute registration and 20,000+ certified sites.</div>
                </div>

                <!-- Google SERP Snippet Preview -->
                <div style="margin-top:24px; padding:18px; background:#F8FAFC; border:1px solid #CBD5E1; border-radius:8px;">
                    <div style="font-size:12px; font-weight:700; text-transform:uppercase; color:#64748B; margin-bottom:8px;">
                        Live Google Search Result Preview
                    </div>
                    <div style="font-family:arial, sans-serif;">
                        <div style="font-size:12px; color:#202124; line-height:1.3;">
                            {{ url('/') }}
                        </div>
                        <div id="serpTitle" style="font-size:18px; color:#1a0dab; line-height:1.3; cursor:pointer; text-decoration:underline;">
                            {{ $homeSettings['meta_title'] }}
                        </div>
                        <div id="serpDesc" style="font-size:13px; color:#4d5156; line-height:1.4; margin-top:3px;">
                            {{ $homeSettings['meta_description'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Sticky Floating Save Bar -->
    <div style="position:sticky; bottom:20px; z-index:90; background:#0B2545; color:#fff; padding:14px 24px; border-radius:10px; display:flex; align-items:center; justify-content:space-between; box-shadow:0 10px 25px -5px rgba(0,0,0,0.3);">
        <div style="display:flex; align-items:center; gap:10px;">
            <svg width="20" height="20" fill="none" stroke="#10B981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span style="font-size:14px; font-weight:600;">HomePage Content Management Mode</span>
        </div>
        <div style="display:flex; gap:12px; align-items:center;">
            <a href="{{ url('/') }}" target="_blank" class="btn btn-outline btn-sm" style="background:transparent; color:#fff; border-color:rgba(255,255,255,0.3);">
                Preview Live Site
            </a>
            <button type="submit" class="btn btn-primary" style="padding:8px 20px;">
                Save All Changes
            </button>
        </div>
    </div>
</form>

<style>
.hp-tab-btn {
    background: transparent;
    border: none;
    padding: 10px 18px;
    font-size: 13px;
    font-weight: 600;
    color: var(--admin-slate-500);
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.15s ease;
}
.hp-tab-btn:hover {
    background: var(--admin-slate-200);
    color: var(--admin-navy);
}
.hp-tab-btn.active {
    background: var(--admin-navy);
    color: #FFFFFF;
}
</style>

<script>
function switchTab(tabId, btn) {
    document.querySelectorAll('.hp-tab-pane').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.hp-tab-btn').forEach(el => el.classList.remove('active'));
    
    const target = document.getElementById(tabId);
    if (target) {
        target.style.display = 'block';
    }
    btn.classList.add('active');
}

let faqIndex = {{ count($faqList) }};

function addFaqRow() {
    faqIndex++;
    const container = document.getElementById('faqsContainer');
    const newCard = document.createElement('div');
    newCard.className = 'faq-row-card';
    newCard.id = 'faq-row-' + faqIndex;
    newCard.style.cssText = 'background:#F8FAFC; border:1px solid #CBD5E1; border-radius:8px; padding:16px; position:relative;';
    
    newCard.innerHTML = `
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
            <span class="faq-number-badge" style="font-size:12px; font-weight:700; color:#0B2545;">New Question</span>
            <button type="button" onclick="removeFaqRow('faq-row-${faqIndex}')" class="btn btn-outline btn-sm" style="color:#C1121F; border-color:#FCA5A5; padding:3px 8px; font-size:11px;">
                Remove
            </button>
        </div>
        <div class="form-group" style="margin-bottom:10px;">
            <label class="form-label">Question *</label>
            <input type="text" name="faqs[${faqIndex}][question]" class="form-control" required placeholder="e.g. Can I walk in without an appointment?">
        </div>
        <div class="form-group" style="margin-bottom:0;">
            <label class="form-label">Answer *</label>
            <textarea name="faqs[${faqIndex}][answer]" rows="3" class="form-control" required placeholder="Provide clear answer..."></textarea>
        </div>
    `;
    
    container.appendChild(newCard);
    newCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function removeFaqRow(rowId) {
    const el = document.getElementById(rowId);
    if (el) {
        el.remove();
    }
}

function updateSeoPreview() {
    const titleVal = document.getElementById('meta_title').value;
    const descVal = document.getElementById('meta_description').value;
    
    document.getElementById('serpTitle').textContent = titleVal || 'Certified Drug Test Centers';
    document.getElementById('serpDesc').textContent = descVal || 'Certified drug testing services nationwide.';
    
    document.getElementById('titleCount').textContent = `Length: ${titleVal.length} characters (Target: 50-60 characters)`;
    document.getElementById('descCount').textContent = `Length: ${descVal.length} characters (Target: 150-160 characters)`;
}

document.addEventListener('DOMContentLoaded', updateSeoPreview);
</script>

@endsection
