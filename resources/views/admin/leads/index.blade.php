@extends('admin.layouts.app', ['title' => 'Inquiries & Leads', 'heading' => 'Corporate & Customer Inquiries'])

@section('content')
<div class="card">
    <div class="card-header" style="flex-wrap:wrap; gap:16px; justify-content:space-between;">
        <form action="{{ route('admin.leads.index') }}" method="GET" style="display:flex; gap:12px; flex-grow:1; max-width:700px; flex-wrap:wrap;">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" style="flex:1; min-width:200px;" placeholder="Search by name, email, company, phone...">
            
            <select name="status" class="form-control" style="width:140px;">
                <option value="">All Statuses</option>
                <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New</option>
                <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Contacted</option>
                <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
            </select>

            <select name="service_type" class="form-control" style="width:170px;">
                <option value="">All Services</option>
                @foreach($serviceTypes as $val => $lbl)
                    <option value="{{ $val }}" {{ request('service_type') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-navy btn-sm">Filter</button>
            @if(request()->anyFilled(['search', 'status', 'service_type']))
                <a href="{{ route('admin.leads.index') }}" class="btn btn-outline btn-sm">Clear</a>
            @endif
        </form>
    </div>

    <div class="card-body" style="padding:0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Contact Info</th>
                    <th>Company</th>
                    <th>Service Needed</th>
                    <th style="width:30%;">Message</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                <tr>
                    <td>
                        <small style="color:#64748B;">{{ $lead->created_at->format('M d, Y') }}</small><br>
                        <small style="color:#94A3B8;">{{ $lead->created_at->format('H:i') }}</small>
                    </td>
                    <td>
                        <strong>{{ $lead->name }}</strong>
                        <div style="font-size:12px; color:#475569;">
                            <a href="mailto:{{ $lead->email }}" style="color:#0B2545;">{{ $lead->email }}</a>
                        </div>
                        @if($lead->phone)
                            <div style="font-size:12px; color:#64748B;">
                                <a href="tel:{{ $lead->phone }}" style="color:#C1121F; text-decoration:none;">{{ $lead->phone }}</a>
                            </div>
                        @endif
                    </td>
                    <td>
                        {{ $lead->company ?: '—' }}
                    </td>
                    <td>
                        @if($lead->service_type === 'corporate-account')
                            <span class="badge" style="background:#F3E8FF; color:#6B21A8; border:1px solid #D8B4FE; font-weight:700;">
                                🏢 Corporate Account
                            </span>
                        @elseif($lead->service_type === 'dot-compliance')
                            <span class="badge" style="background:#FEF3C7; color:#92400E; border:1px solid #FCD34D; font-weight:700;">
                                🚛 DOT Compliance
                            </span>
                        @else
                            <span class="badge" style="background:#EFF6FF; color:#1E40AF; border:1px solid #BFDBFE;">
                                {{ $serviceTypes[$lead->service_type] ?? ucfirst($lead->service_type) }}
                            </span>
                        @endif
                    </td>
                    <td>
                        <div style="font-size:13px; color:#334155; max-height:80px; overflow-y:auto; line-height:1.5;">
                            {{ $lead->message }}
                        </div>
                    </td>
                    <td>
                        <form action="{{ route('admin.leads.update-status', $lead) }}" method="POST" style="margin:0;">
                            @csrf
                            <select name="status" onchange="this.form.submit()" style="font-size:12px; font-weight:700; padding:4px 8px; border-radius:4px; border:1px solid #CBD5E1; cursor:pointer; background: {{ $lead->status === 'new' ? '#FEF2F2' : ($lead->status === 'contacted' ? '#EFF6FF' : '#F1F5F9') }}; color: {{ $lead->status === 'new' ? '#991B1B' : ($lead->status === 'contacted' ? '#1E40AF' : '#475569') }};">
                                <option value="new" {{ $lead->status === 'new' ? 'selected' : '' }}>🔴 New</option>
                                <option value="contacted" {{ $lead->status === 'contacted' ? 'selected' : '' }}>🔵 Contacted</option>
                                <option value="closed" {{ $lead->status === 'closed' ? 'selected' : '' }}>⚪ Closed</option>
                            </select>
                        </form>
                    </td>
                    <td style="text-align:right;">
                        <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" onsubmit="return confirm('Delete this lead record?');" style="display:inline-block; margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline btn-sm" style="color:#C1121F; padding:4px 8px; font-size:12px;">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:40px; color:#64748B;">
                        No customer inquiries found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($leads->hasPages())
    <div style="padding:16px 20px; border-top:1px solid #E2E8F0;">
        {{ $leads->links() }}
    </div>
    @endif
</div>
@endsection
