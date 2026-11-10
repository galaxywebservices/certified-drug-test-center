@extends('admin.layouts.app', ['title' => 'Edit ' . $state->name, 'heading' => 'Edit State Landing Page: ' . $state->name])

@section('topbar_actions')
<a href="{{ url('/locations/' . $state->slug) }}" target="_blank" class="btn btn-outline btn-sm">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
    Live State Page
</a>
<a href="{{ url('/certified-drug-test-centers/' . $state->slug) }}" target="_blank" class="btn btn-outline btn-sm">
    Live Chain State Page
</a>
<button type="button" onclick="document.getElementById('stateEditForm').submit();" class="btn btn-primary btn-sm">
    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    Save State Changes
</button>
@endsection

@section('content')

@if(session('success'))
<div class="alert alert-success" style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
    <span>{{ session('success') }}</span>
    <a href="{{ url('/locations/' . $state->slug) }}" target="_blank" style="color:#166534; font-weight:700; text-decoration:underline;">View live state page →</a>
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

<!-- Quick Metrics Banner -->
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px; margin-bottom:20px;">
    <div class="card" style="margin-bottom:0; padding:16px; display:flex; align-items:center; gap:14px;">
        <div style="font-size:28px;">🏛️</div>
        <div>
            <div style="font-size:12px; color:#64748B; font-weight:700; text-transform:uppercase;">State Jurisdiction</div>
            <div style="font-size:18px; font-weight:800; color:#0B2545;">{{ $state->name }} ({{ $state->abbr }})</div>
        </div>
    </div>
    <div class="card" style="margin-bottom:0; padding:16px; display:flex; align-items:center; gap:14px;">
        <div style="font-size:28px;">🧪</div>
        <div>
            <div style="font-size:12px; color:#64748B; font-weight:700; text-transform:uppercase;">Active Collection Sites</div>
            <div style="font-size:18px; font-weight:800; color:#0B2545;">{{ number_format($locationCount) }} Centers</div>
        </div>
    </div>
    <div class="card" style="margin-bottom:0; padding:16px; display:flex; align-items:center; gap:14px;">
        <div style="font-size:28px;">🏙️</div>
        <div>
            <div style="font-size:12px; color:#64748B; font-weight:700; text-transform:uppercase;">Managed Cities</div>
            <div style="font-size:18px; font-weight:800; color:#0B2545;">
                {{ $state->cities_count }} Cities
                <a href="{{ route('admin.cities.index', ['state_id' => $state->id]) }}" style="font-size:12px; font-weight:600; color:#0284C7; margin-left:4px;">Manage →</a>
            </div>
        </div>
    </div>
</div>

<!-- Tabs -->
<div style="display:flex; gap:8px; margin-bottom:20px; border-bottom:1px solid var(--admin-slate-200); padding-bottom:10px; flex-wrap:wrap;">
    <button type="button" class="state-tab-btn active" data-tab="tab-general" onclick="switchStateTab('tab-general', this)">
        📋 General &amp; SEO
    </button>
    <button type="button" class="state-tab-btn" data-tab="tab-compliance" onclick="switchStateTab('tab-compliance', this)">
        ⚖️ Workplace Laws &amp; Compliance
    </button>
    <button type="button" class="state-tab-btn" data-tab="tab-content" onclick="switchStateTab('tab-content', this)">
        📝 State Overview Content
    </button>
    <button type="button" class="state-tab-btn" data-tab="tab-faqs" onclick="switchStateTab('tab-faqs', this)">
        ❓ State Legal FAQs ({{ count($faqs) }})
    </button>
</div>

<form id="stateEditForm" action="{{ route('admin.states.update', $state->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- ========================================================== -->
    <!-- TAB 1: GENERAL & SEO -->
    <!-- ========================================================== -->
    <div id="tab-general" class="state-tab-pane active">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">General Information &amp; SEO Metadata</h2>
                    <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                        Basic details, visibility flag, and search engine title tags for {{ $state->name }}.
                    </p>
                </div>
            </div>
            <div class="card-body">
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label class="form-label" for="name">State Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $state->name) }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="abbr">2-Letter Postal Abbreviation *</label>
                        <input type="text" id="abbr" name="abbr" value="{{ old('abbr', $state->abbr) }}" maxlength="2" class="form-control" style="text-transform:uppercase;" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Page Visibility</label>
                        <div style="display:flex; align-items:center; height:42px; gap:8px;">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $state->is_active) ? 'checked' : '' }} style="width:18px; height:18px;">
                            <label for="is_active" style="font-size:14px; font-weight:600; color:#0B2545; cursor:pointer;">
                                State Landing Page Active
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="margin-top:10px;">
                    <label class="form-label" for="meta_title">Meta Title (Browser Tab Title)</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $state->meta_title) }}" class="form-control" placeholder="e.g. {{ $state->name }} Drug Testing Locations & Walk-in Centers">
                    <div style="font-size:12px; color:var(--admin-slate-500); margin-top:4px;">
                        Leave blank to automatically default to: <em>"{{ $state->name }} Drug Testing Locations & Walk-in Centers"</em>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="meta_description">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3" class="form-control" placeholder="Accredited drug testing collection facilities in {{ $state->name }}...">{{ old('meta_description', $state->meta_description) }}</textarea>
                    <div style="font-size:12px; color:var(--admin-slate-500); margin-top:4px;">
                        Appears in Google search snippets. Leave blank to use default template.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================== -->
    <!-- TAB 2: WORKPLACE LAWS & COMPLIANCE -->
    <!-- ========================================================== -->
    <div id="tab-compliance" class="state-tab-pane" style="display:none;">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">{{ $state->name }} Workplace Drug Testing Laws &amp; Regulations</h2>
                    <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                        Displayed in the compliance callout box on the state page to provide high-authority legal guidance.
                    </p>
                </div>
            </div>
            <div class="card-body">
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label class="form-label" for="statute_code">State Statute Code</label>
                        <input type="text" id="statute_code" name="statute_code" value="{{ old('statute_code', $state->statute_code) }}" class="form-control" placeholder="e.g. Fla. Stat. § 440.102">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="medical_marijuana_status">Medical Cannabis Status</label>
                        <input type="text" id="medical_marijuana_status" name="medical_marijuana_status" value="{{ old('medical_marijuana_status', $state->medical_marijuana_status) }}" class="form-control" placeholder="e.g. Legalized">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="recreational_marijuana_status">Recreational Cannabis Status</label>
                        <input type="text" id="recreational_marijuana_status" name="recreational_marijuana_status" value="{{ old('recreational_marijuana_status', $state->recreational_marijuana_status) }}" class="form-control" placeholder="e.g. Prohibited">
                    </div>
                </div>

                <div class="form-group" style="margin-top:10px;">
                    <label class="form-label" for="employer_rights_summary">Employer Rights &amp; Policy Standards</label>
                    <textarea id="employer_rights_summary" name="employer_rights_summary" rows="3" class="form-control">{{ old('employer_rights_summary', $state->employer_rights_summary) }}</textarea>
                    <div style="font-size:12px; color:var(--admin-slate-500); margin-top:4px;">
                        Summarizes employer rights regarding drug-free workplace policies, pre-employment screening, and reasonable suspicion.
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="worker_comp_rules">Workers' Compensation Incentives / Rules</label>
                    <textarea id="worker_comp_rules" name="worker_comp_rules" rows="3" class="form-control">{{ old('worker_comp_rules', $state->worker_comp_rules) }}</textarea>
                    <div style="font-size:12px; color:var(--admin-slate-500); margin-top:4px;">
                        Details premium discounts or statutory defenses available to employers in {{ $state->name }}.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================== -->
    <!-- TAB 3: STATE OVERVIEW CONTENT -->
    <!-- ========================================================== -->
    <div id="tab-content" class="state-tab-pane" style="display:none;">
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">State Overview &amp; Custom Guide Content</h2>
                    <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                        Custom editorial or SEO content for {{ $state->name }}.
                    </p>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="content">Editorial Content / Description (HTML Supported)</label>
                    <textarea id="content" name="content" rows="12" class="form-control">{{ old('content', $state->content) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================== -->
    <!-- TAB 4: LEGAL & STATE FAQS -->
    <!-- ========================================================== -->
    <div id="tab-faqs" class="state-tab-pane" style="display:none;">
        <div class="card">
            <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <h2 class="card-title">Frequently Asked Questions for {{ $state->name }}</h2>
                    <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                        Rendered in the accordion at the bottom of the state page.
                    </p>
                </div>
                <button type="button" onclick="addStateFaqRow()" class="btn btn-primary btn-sm">+ Add New State FAQ</button>
            </div>
            <div class="card-body">
                <div id="stateFaqsContainer" style="display:flex; flex-direction:column; gap:16px;">
                    @forelse($faqs as $i => $faq)
                    <div class="state-faq-row" style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:16px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                            <span style="font-size:13px; font-weight:700; color:var(--admin-navy);">FAQ Item #<span class="faq-num">{{ $loop->iteration }}</span></span>
                            <button type="button" onclick="this.closest('.state-faq-row').remove(); renumberStateFaqs();" class="btn btn-sm btn-outline" style="color:#DC2626;" title="Remove this FAQ">✕ Remove</button>
                        </div>
                        <div class="form-group" style="margin-bottom:10px;">
                            <label class="form-label">Question</label>
                            <input type="text" name="faqs[{{ $i }}][question]" value="{{ $faq['question'] ?? '' }}" class="form-control" placeholder="Enter question...">
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Answer</label>
                            <textarea name="faqs[{{ $i }}][answer]" rows="3" class="form-control" placeholder="Enter answer...">{{ $faq['answer'] ?? '' }}</textarea>
                        </div>
                    </div>
                    @empty
                    <div id="noFaqsNotice" style="text-align:center; padding:24px; color:#64748B;">
                        No custom FAQs defined yet for {{ $state->name }}. Click "+ Add New State FAQ" above to add one.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px; padding-bottom:60px;">
        <a href="{{ route('admin.states.index') }}" class="btn btn-outline">Back to States List</a>
        <button type="submit" class="btn btn-primary" style="font-size:15px; padding:12px 28px;">
            Save All State Changes
        </button>
    </div>
</form>

<style>
.state-tab-btn {
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
.state-tab-btn:hover {
    background: var(--admin-slate-50);
    color: var(--admin-navy);
}
.state-tab-btn.active {
    background: var(--admin-navy);
    color: #FFFFFF;
    border-color: var(--admin-navy);
}
</style>

<script>
function switchStateTab(tabId, btn) {
    document.querySelectorAll('.state-tab-pane').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.state-tab-btn').forEach(b => b.classList.remove('active'));

    var target = document.getElementById(tabId);
    if (target) {
        target.style.display = 'block';
    }
    btn.classList.add('active');
}

var stateFaqIndex = {{ count($faqs) }};
function addStateFaqRow() {
    var notice = document.getElementById('noFaqsNotice');
    if (notice) notice.remove();

    var container = document.getElementById('stateFaqsContainer');
    var idx = stateFaqIndex++;
    var card = document.createElement('div');
    card.className = 'state-faq-row';
    card.style.cssText = 'background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:16px;';
    card.innerHTML = `
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
            <span style="font-size:13px; font-weight:700; color:var(--admin-navy);">FAQ Item #<span class="faq-num">${container.children.length + 1}</span> (New)</span>
            <button type="button" onclick="this.closest('.state-faq-row').remove(); renumberStateFaqs();" class="btn btn-sm btn-outline" style="color:#DC2626;" title="Remove">✕ Remove</button>
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

function renumberStateFaqs() {
    var numSpans = document.querySelectorAll('#stateFaqsContainer .faq-num');
    numSpans.forEach(function(span, i) {
        span.textContent = i + 1;
    });
}
</script>
@endsection

