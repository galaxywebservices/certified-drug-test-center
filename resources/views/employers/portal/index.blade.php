@extends('layouts.main')

@section('title', $account->company_name . ' | Corporate Employer Testing Portal')
@section('meta_description', 'Secure employer self-service dashboard for candidate drug test pass dispatch, real-time lab status tracking, and official MRO result certificates.')

@section('content')
<style>
    .dash-topbar {
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #FFFFFF;
        padding: 32px 20px;
        border-bottom: 4px solid #C1121F;
    }
    .dash-topbar-inner {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    .dash-company-info h1 {
        font-size: 26px;
        font-weight: 800;
        margin: 8px 0 4px;
        color: #FFFFFF;
    }
    .dash-company-meta {
        font-size: 13px;
        color: #94A3B8;
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }
    .dash-badges {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }
    .dash-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .dash-badge-blue { background: #2563EB; color: #FFFFFF; }
    .dash-badge-mono { background: #1E293B; color: #FCD34D; border: 1px solid #334155; font-family: monospace; }
    .dash-badge-dot { background: rgba(245, 158, 11, 0.2); color: #FCD34D; border: 1px solid rgba(245, 158, 11, 0.4); }

    .dash-account-box {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 10px;
        padding: 12px 18px;
        display: flex;
        align-items: center;
        gap: 18px;
    }
    .dash-terms-title {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94A3B8;
        font-weight: 700;
    }
    .dash-terms-credit {
        font-size: 14px;
        font-weight: 700;
        color: #F8FAFC;
        margin-top: 2px;
    }
    .dash-btn-logout {
        background: #1E293B;
        color: #E2E8F0;
        border: 1px solid #334155;
        padding: 8px 14px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.15s;
    }
    .dash-btn-logout:hover {
        background: #334155;
        color: #FFFFFF;
    }

    /* Main Content Container */
    .dash-body {
        background: #F1F5F9;
        padding: 36px 20px 80px;
        min-height: 700px;
    }
    .dash-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Notice Banners */
    .dash-alert {
        padding: 14px 18px;
        border-radius: 8px;
        margin-bottom: 24px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .dash-alert-blue { background: #EFF6FF; border: 1px solid #BFDBFE; color: #1E3A8A; }
    .dash-alert-green { background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; }

    /* 4 KPI Cards */
    .dash-kpis {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 28px;
    }
    .dash-kpi-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(11, 37, 69, 0.04);
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .dash-kpi-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .kpi-blue { background: #EFF6FF; color: #2563EB; }
    .kpi-green { background: #ECFDF5; color: #059669; }
    .kpi-amber { background: #FFFBEB; color: #D97706; }
    .kpi-sky { background: #F0F9FF; color: #0284C7; }

    .dash-kpi-label {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748B;
    }
    .dash-kpi-value {
        font-size: 26px;
        font-weight: 900;
        color: #0F172A;
        margin: 2px 0;
    }
    .dash-kpi-sub {
        font-size: 11px;
        color: #94A3B8;
    }

    /* Actions & Filters Toolbar */
    .dash-toolbar {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(11, 37, 69, 0.04);
        margin-bottom: 24px;
    }
    .dash-toolbar-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding-bottom: 16px;
        border-bottom: 1px solid #F1F5F9;
    }
    .dash-btn-primary {
        background: #0B2545;
        color: #FFFFFF;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }
    .dash-btn-primary:hover { background: #133E6E; }
    .dash-btn-outline {
        background: #FFFFFF;
        color: #334155;
        border: 1px solid #CBD5E1;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .dash-btn-outline:hover { background: #F8FAFC; border-color: #94A3B8; }
    .dash-btn-amber {
        background: #FFFBEB;
        color: #92400E;
        border: 1px solid #FCD34D;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .dash-btn-amber:hover { background: #FEF3C7; }

    .dash-filter-form {
        display: grid;
        grid-template-columns: 2fr 1.2fr 1.2fr auto;
        gap: 12px;
        margin-top: 16px;
    }
    .dash-filter-input, .dash-filter-select {
        padding: 10px 14px;
        font-size: 13px;
        border: 1px solid #CBD5E1;
        border-radius: 6px;
        box-sizing: border-box;
        width: 100%;
        color: #0F172A;
    }

    /* Roster Data Table */
    .dash-table-wrap {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(11, 37, 69, 0.04);
        overflow: hidden;
    }
    .dash-table-header {
        padding: 18px 24px;
        border-bottom: 1px solid #E2E8F0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .dash-table-header h2 {
        font-size: 16px;
        font-weight: 800;
        color: #0F172A;
        margin: 0;
    }
    .dash-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }
    .dash-table th {
        background: #F8FAFC;
        padding: 12px 18px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
        border-bottom: 1px solid #E2E8F0;
    }
    .dash-table td {
        padding: 14px 18px;
        border-bottom: 1px solid #F1F5F9;
        color: #1E293B;
        vertical-align: middle;
    }
    .dash-table tr:hover td {
        background: #F8FAFC;
    }
    .badge-status {
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
    }
    .status-completed { background: #ECFDF5; color: #047857; }
    .status-inprogress { background: #FFFBEB; color: #B45309; }
    .status-registered { background: #EFF6FF; color: #1D4ED8; }

    .badge-outcome-pass {
        background: #059669;
        color: #FFFFFF;
        font-weight: 800;
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .badge-outcome-flag {
        background: #DC2626;
        color: #FFFFFF;
        font-weight: 800;
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .badge-outcome-pending {
        background: #F1F5F9;
        color: #64748B;
        font-weight: 600;
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 4px;
    }

    .btn-mro-cert {
        background: #EFF6FF;
        color: #1D4ED8;
        border: 1px solid #BFDBFE;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s;
    }
    .btn-mro-cert:hover {
        background: #DBEAFE;
        color: #1E40AF;
    }
    .btn-resend {
        background: #F8FAFC;
        color: #475569;
        border: 1px solid #CBD5E1;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-resend:hover { background: #E2E8F0; }

    /* Modal Overlay & Card */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(11, 37, 69, 0.7);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
        overflow-y: auto;
    }
    .modal-overlay.active {
        display: flex;
    }
    .modal-card {
        background: #FFFFFF;
        border-radius: 14px;
        max-width: 640px;
        width: 100%;
        box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        overflow: hidden;
        margin: auto;
    }
    .modal-head {
        background: #0B2545;
        color: #FFFFFF;
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-head h3 { margin: 0; font-size: 18px; font-weight: 800; color: #FFFFFF; }
    .modal-head button { background: transparent; border: none; color: #CBD5E1; font-size: 20px; cursor: pointer; }
    .modal-body { padding: 28px; }
    .modal-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }

    /* Compliance Banner */
    .dash-compliance-banner {
        background: #0B2545;
        border-radius: 12px;
        padding: 24px 30px;
        color: #FFFFFF;
        margin-top: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }
    .dash-compliance-banner h4 { margin: 0 0 6px; font-size: 16px; font-weight: 800; color: #FFFFFF; }
    .dash-compliance-banner p { margin: 0; font-size: 13px; color: #CBD5E1; max-width: 680px; line-height: 1.5; }

    @media (max-width: 900px) {
        .dash-kpis { grid-template-columns: repeat(2, 1fr); }
        .dash-filter-form { grid-template-columns: 1fr; }
        .modal-grid-2 { grid-template-columns: 1fr; }
    }
    @media (max-width: 600px) {
        .dash-kpis { grid-template-columns: 1fr; }
    }
</style>

<!-- Corporate Header Topbar -->
<div class="dash-topbar">
    <div class="dash-topbar-inner">
        <div class="dash-company-info">
            <div class="dash-badges">
                <span class="dash-badge dash-badge-blue">Corporate Portal</span>
                <span class="dash-badge dash-badge-mono">{{ $account->account_code }}</span>
                @if($account->is_dot_regulated)
                    <span class="dash-badge dash-badge-dot">● DOT Regulated ({{ $account->dot_agency ?? 'FMCSA' }})</span>
                @else
                    <span class="dash-badge" style="background:#1E293B; color:#CBD5E1;">Commercial Workforce</span>
                @endif
            </div>

            <h1>{{ $account->company_name }}</h1>

            <div class="dash-company-meta">
                <span>Authorized Contact: <strong style="color:#FFFFFF;">{{ $account->contact_name }}</strong></span>
                <span>&bull;</span>
                <span>{{ $account->email }}</span>
                <span>&bull;</span>
                <span>{{ $account->phone }}</span>
            </div>
        </div>

        <div class="dash-account-box">
            <div>
                <div class="dash-terms-title">Consolidated Billing</div>
                <div class="dash-terms-credit">
                    Net-30 &bull;
                    <span style="color:#34D399;">${{ number_format($account->remaining_credit, 2) }}</span> available
                </div>
                <div style="font-size:11px; color:#94A3B8; margin-top:2px;">
                    Current Balance: ${{ number_format($account->active_balance, 2) }} / ${{ number_format($account->credit_limit, 2) }}
                </div>
            </div>

            <form action="{{ route('employers.portal.logout') }}" method="POST">
                @csrf
                <button type="submit" class="dash-btn-logout">
                    Sign Out
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Main Body -->
<div class="dash-body">
    <div class="dash-container">

        <!-- Flash Notices -->
        @if(session('portal_notice'))
            <div class="dash-alert dash-alert-blue">
                <span style="font-size:18px;">ℹ️</span>
                <span>{{ session('portal_notice') }}</span>
            </div>
        @endif

        @if(session('portal_success'))
            <div class="dash-alert dash-alert-green">
                <span style="font-size:18px;">✅</span>
                <span>{{ session('portal_success') }}</span>
            </div>
        @endif

        <!-- 4 KPI Cards -->
        <div class="dash-kpis">
            <div class="dash-kpi-card">
                <div class="dash-kpi-icon kpi-blue">👥</div>
                <div>
                    <div class="dash-kpi-label">Total Enrolled</div>
                    <div class="dash-kpi-value">{{ $totalCandidates }}</div>
                    <div class="dash-kpi-sub">Candidate testing roster</div>
                </div>
            </div>

            <div class="dash-kpi-card">
                <div class="dash-kpi-icon kpi-green">✓</div>
                <div>
                    <div class="dash-kpi-label" style="color:#059669;">Verified Negative</div>
                    <div class="dash-kpi-value" style="color:#059669;">{{ $completedNegative }}</div>
                    <div class="dash-kpi-sub">Cleared for active duty</div>
                </div>
            </div>

            <div class="dash-kpi-card">
                <div class="dash-kpi-icon kpi-amber">⏳</div>
                <div>
                    <div class="dash-kpi-label" style="color:#D97706;">In Lab / MRO</div>
                    <div class="dash-kpi-value" style="color:#D97706;">{{ $inLabOrMro }}</div>
                    <div class="dash-kpi-sub">Turnaround 24-48 hours</div>
                </div>
            </div>

            <div class="dash-kpi-card">
                <div class="dash-kpi-icon kpi-sky">📲</div>
                <div>
                    <div class="dash-kpi-label" style="color:#0284C7;">Passes Dispatched</div>
                    <div class="dash-kpi-value" style="color:#0284C7;">{{ $registeredPasses }}</div>
                    <div class="dash-kpi-sub">Pending donor check-in</div>
                </div>
            </div>
        </div>

        <!-- Action Toolbar -->
        <div class="dash-toolbar">
            <div class="dash-toolbar-actions">
                <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                    <button type="button" onclick="openDispatchModal()" class="dash-btn-primary">
                        <span style="font-size:16px;">+</span>
                        <span>Dispatch New Candidate Pass</span>
                    </button>

                    <a href="{{ route('employers.portal.export') }}" class="dash-btn-outline">
                        <span>📥</span>
                        <span>Export Compliance CSV</span>
                    </a>

                    @if($account->is_dot_regulated)
                        <form action="{{ route('employers.portal.random-draw') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit"
                                    onclick="return confirm('Execute randomized DOT compliance draw from active driver roster?')"
                                    class="dash-btn-amber">
                                <span>🎲</span>
                                <span>DOT Random Draw</span>
                            </button>
                        </form>
                    @endif
                </div>

                <div style="font-size:12px; color:#64748B; font-weight:600; display:flex; align-items:center; gap:6px;">
                    <span style="display:inline-block; width:8px; height:8px; background:#10B981; border-radius:50%;"></span>
                    <span>HL7 Direct Lab Feed Connected (Quest Diagnostics &amp; Labcorp)</span>
                </div>
            </div>

            <!-- Filter Controls -->
            <form action="{{ route('employers.portal') }}" method="GET" class="dash-filter-form">
                <div>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search candidate name, order #, CCF #, or job title..."
                           class="dash-filter-input">
                </div>

                <div>
                    <select name="status" class="dash-filter-select">
                        <option value="">All Specimen Statuses</option>
                        <option value="negative" {{ request('status') === 'negative' ? 'selected' : '' }}>Verified Negative (Passed)</option>
                        <option value="positive" {{ request('status') === 'positive' ? 'selected' : '' }}>Verified Positive (Flagged)</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Laboratory / MRO Review</option>
                        <option value="registered" {{ request('status') === 'registered' ? 'selected' : '' }}>Pass Dispatched (Pending)</option>
                    </select>
                </div>

                <div>
                    <select name="department" class="dash-filter-select">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}" {{ request('department') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display:flex; gap:6px;">
                    <button type="submit" class="dash-btn-primary" style="padding:10px 18px;">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status', 'department']))
                        <a href="{{ route('employers.portal') }}" class="dash-btn-outline" style="padding:10px 12px;" title="Reset filters">
                            ✕
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Roster Data Table -->
        <div class="dash-table-wrap">
            <div class="dash-table-header">
                <div>
                    <h2>Active Candidate Testing Pipeline</h2>
                    <div style="font-size:12px; color:#64748B; margin-top:2px;">
                        Showing {{ $orders->total() }} candidate records registered under this corporate account
                    </div>
                </div>
            </div>

            @if($orders->isEmpty())
                <div style="padding:60px 20px; text-align:center; color:#64748B;">
                    <div style="font-size:40px; margin-bottom:12px;">📋</div>
                    <div style="font-weight:700; font-size:16px; color:#1E293B;">No candidate records match your query</div>
                    <p style="font-size:13px; margin:4px 0 0;">Try adjusting your search filters or dispatch a new candidate pass.</p>
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>Candidate &amp; Contact</th>
                                <th>Dept / Job Title</th>
                                <th>Test Panel</th>
                                <th>Order / CCF #</th>
                                <th>Specimen Status</th>
                                <th>MRO Outcome</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <div style="font-weight:800; color:#0F172A; font-size:14px;">{{ $order->donor_full_name }}</div>
                                        <div style="font-size:11px; color:#64748B; margin-top:2px;">{{ $order->donor_email }}</div>
                                        <div style="font-size:11px; color:#94A3B8;">{{ $order->donor_phone }}</div>
                                    </td>

                                    <td>
                                        <div style="font-weight:700; color:#1E293B;">{{ $order->candidate_job_title ?? 'Candidate' }}</div>
                                        <div style="font-size:11px; color:#64748B; margin-top:2px;">{{ $order->candidate_department ?? 'Operations' }}</div>
                                        <span style="display:inline-block; margin-top:4px; font-size:10px; font-weight:700; padding:2px 6px; background:#F1F5F9; color:#475569; border-radius:4px;">
                                            {{ $order->test_reason ?? 'Pre-Employment' }}
                                        </span>
                                    </td>

                                    <td>
                                        <div style="font-weight:600; color:#1E293B;">
                                            {{ $order->items->first()?->product_name ?? '5-Panel Drug Test' }}
                                        </div>
                                        <div style="font-size:11px; color:#64748B; margin-top:2px;">
                                            {{ $order->location?->name ?? 'Quest / Labcorp Partner PSC' }}
                                        </div>
                                    </td>

                                    <td style="font-family:monospace; font-size:12px;">
                                        <div style="font-weight:700; color:#0B2545;">{{ $order->order_number }}</div>
                                        @if($order->ccf_number)
                                            <div style="color:#64748B; margin-top:2px;">{{ $order->ccf_number }}</div>
                                        @else
                                            <div style="color:#D97706; font-style:italic;">CCF Pending</div>
                                        @endif
                                    </td>

                                    <td>
                                        @if($order->status === 'completed')
                                            <span class="badge-status status-completed">● Completed</span>
                                        @elseif($order->status === 'in_progress')
                                            <span class="badge-status status-inprogress">⏳ In Lab / MRO</span>
                                        @else
                                            <span class="badge-status status-registered">📲 Pass Sent</span>
                                        @endif
                                        <div style="font-size:11px; color:#94A3B8; margin-top:4px;">
                                            {{ $order->created_at->format('M d, Y') }}
                                        </div>
                                    </td>

                                    <td>
                                        @if($order->status === 'completed' && $order->result_outcome === 'negative')
                                            <span class="badge-outcome-pass">
                                                <span>✓</span> PASSED (NEG)
                                            </span>
                                        @elseif($order->status === 'completed' && $order->result_outcome === 'positive')
                                            <span class="badge-outcome-flag">
                                                <span>⚠️</span> POSITIVE
                                            </span>
                                        @else
                                            <span class="badge-outcome-pending">Pending MRO</span>
                                        @endif
                                    </td>

                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; align-items:center; gap:6px;">
                                            @if($order->status === 'completed')
                                                <a href="{{ route('orders.certificate', $order->donor_pass_token) }}"
                                                   target="_blank"
                                                   class="btn-mro-cert"
                                                   title="View Official MRO Lab Result Certificate">
                                                    <span>📄 MRO Certificate &rarr;</span>
                                                </a>
                                            @else
                                                <form action="{{ route('employers.portal.resend-pass', $order->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn-resend" title="Resend Electronic Pass via SMS & Email">
                                                        <span>📲 Resend Pass</span>
                                                    </button>
                                                </form>
                                            @endif

                                            <a href="{{ route('order.track', ['token' => $order->donor_pass_token]) }}"
                                               target="_blank"
                                               style="font-size:12px; font-weight:600; color:#64748B; text-decoration:none; padding:4px 6px;"
                                               title="Live Specimen Tracker">
                                                Track &rarr;
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($orders->hasPages())
                    <div style="padding:16px 24px; background:#F8FAFC; border-top:1px solid #E2E8F0;">
                        {{ $orders->links() }}
                    </div>
                @endif
            @endif
        </div>

        <!-- Compliance & Regulatory Banner -->
        <div class="dash-compliance-banner">
            <div>
                <h4>Automated DOT &amp; Non-DOT Compliance Standards</h4>
                <p>
                    All specimens are tested in SAMHSA-certified laboratories (Quest Diagnostics and Labcorp) with GC/MS or LC-MS confirmation and reviewed by a licensed Medical Review Officer (MRO) certified by AAMRO / MROCC. CLIA # 10D0953841.
                </p>
            </div>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <span style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); padding:6px 12px; border-radius:6px; font-size:11px; font-weight:700;">
                    FMCSA Clearinghouse Ready
                </span>
                <span style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); padding:6px 12px; border-radius:6px; font-size:11px; font-weight:700;">
                    24-48h Electronic Results
                </span>
            </div>
        </div>

    </div>
</div>

<!-- Dispatch Candidate Pass Modal -->
<div id="dispatchModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-head">
            <div>
                <h3>Dispatch Electronic Candidate Pass</h3>
                <p style="margin:2px 0 0; font-size:12px; color:#94A3B8;">Instant delivery to candidate via SMS text and secure email</p>
            </div>
            <button type="button" onclick="closeDispatchModal()">&times;</button>
        </div>

        <div class="modal-body">
            <form action="{{ route('employers.portal.dispatch') }}" method="POST">
                @csrf

                <div class="modal-grid-2">
                    <div>
                        <label class="portal-form-label" style="font-size:11px; font-weight:800; color:#334155; margin-bottom:6px; display:block;">Candidate First Name *</label>
                        <input type="text" name="first_name" required class="portal-input" placeholder="e.g. Brandon">
                    </div>
                    <div>
                        <label class="portal-form-label" style="font-size:11px; font-weight:800; color:#334155; margin-bottom:6px; display:block;">Candidate Last Name *</label>
                        <input type="text" name="last_name" required class="portal-input" placeholder="e.g. Miller">
                    </div>
                </div>

                <div class="modal-grid-2">
                    <div>
                        <label class="portal-form-label" style="font-size:11px; font-weight:800; color:#334155; margin-bottom:6px; display:block;">Candidate Email *</label>
                        <input type="email" name="email" required class="portal-input" placeholder="candidate@email.com">
                    </div>
                    <div>
                        <label class="portal-form-label" style="font-size:11px; font-weight:800; color:#334155; margin-bottom:6px; display:block;">Candidate Mobile Phone *</label>
                        <input type="text" name="phone" required class="portal-input" placeholder="(555) 000-0000">
                    </div>
                </div>

                <div class="modal-grid-2">
                    <div>
                        <label class="portal-form-label" style="font-size:11px; font-weight:800; color:#334155; margin-bottom:6px; display:block;">Department / Facility</label>
                        <input type="text" name="candidate_department" class="portal-input" placeholder="e.g. Fleet Logistics, Terminal 4">
                    </div>
                    <div>
                        <label class="portal-form-label" style="font-size:11px; font-weight:800; color:#334155; margin-bottom:6px; display:block;">Job Position / Title</label>
                        <input type="text" name="candidate_job_title" class="portal-input" placeholder="e.g. CDL Driver, Equipment Operator">
                    </div>
                </div>

                <div class="modal-grid-2">
                    <div>
                        <label class="portal-form-label" style="font-size:11px; font-weight:800; color:#334155; margin-bottom:6px; display:block;">Reason for Testing *</label>
                        <select name="test_reason" required class="dash-filter-select" style="height:44px;">
                            <option value="Pre-Employment">Pre-Employment Screening</option>
                            <option value="Random Compliance Pool">Quarterly Random Pool Draw</option>
                            <option value="Post-Accident">Post-Accident Investigation</option>
                            <option value="Reasonable Suspicion">Reasonable Suspicion / Cause</option>
                            <option value="Return-to-Duty">Return-to-Duty / Follow-Up</option>
                            <option value="Annual Physical">Annual Employment Physical</option>
                        </select>
                    </div>
                    <div>
                        <label class="portal-form-label" style="font-size:11px; font-weight:800; color:#334155; margin-bottom:6px; display:block;">Corporate Test Panel *</label>
                        <select name="product_id" required class="dash-filter-select" style="height:44px;">
                            @foreach($availableProducts as $prod)
                                <option value="{{ $prod->id }}">
                                    {{ $prod->name }} - ${{ number_format($prod->price, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="margin-bottom:20px;">
                    <label class="portal-form-label" style="font-size:11px; font-weight:800; color:#334155; margin-bottom:6px; display:block;">Preferred Collection Site</label>
                    <select name="location_id" class="dash-filter-select" style="height:44px;">
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}">
                                {{ $loc->name }} ({{ $loc->city->name ?? 'FL' }}, {{ $loc->postal_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:12px; padding-top:16px; border-top:1px solid #F1F5F9;">
                    <button type="button" onclick="closeDispatchModal()" class="dash-btn-outline">
                        Cancel
                    </button>
                    <button type="submit" class="dash-btn-primary" style="padding:12px 24px; font-size:14px;">
                        <span>Dispatch Electronic Pass Now &rarr;</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openDispatchModal() {
        document.getElementById('dispatchModal').classList.add('active');
    }
    function closeModal() {
        document.getElementById('dispatchModal').classList.remove('active');
    }
    function closeDispatchModal() {
        document.getElementById('dispatchModal').classList.remove('active');
    }
    // Close modal on click outside
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('dispatchModal');
        if (e.target === modal) {
            closeDispatchModal();
        }
    });
</script>
@endsection
