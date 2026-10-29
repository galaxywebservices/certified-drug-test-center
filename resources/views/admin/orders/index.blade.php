@extends('admin.layouts.app', ['title' => 'Orders & Registrations', 'heading' => 'Donor Registrations & Orders'])

@section('content')
<div class="card">
    <div class="card-header" style="flex-wrap:wrap; gap:16px; justify-content:space-between;">
        <form action="{{ route('admin.orders.index') }}" method="GET" style="display:flex; gap:12px; flex-grow:1; max-width:600px;">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search order #, donor name or email...">
            <button type="submit" class="btn btn-navy btn-sm">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm">Clear</a>
            @endif
        </form>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('admin.orders.export') }}" class="btn btn-outline btn-sm" style="display:inline-flex; align-items:center; gap:6px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Export CSV
            </a>
        </div>
    </div>

    <div class="card-body" style="padding:0;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Donor Name</th>
                    <th>Ordered Test</th>
                    <th>Total</th>
                    <th>Payment Status</th>
                    <th>PayTrace Ref</th>
                    <th>Date</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong>{{ $order->order_number }}</strong></td>
                    <td>
                        <div>{{ $order->donor_full_name }}</div>
                        <small style="color:#64748B;">{{ $order->donor_email }}</small>
                    </td>
                    <td>
                        {{ $order->items->first()?->product_name ?? 'Drug Test' }}
                    </td>
                    <td>
                        <strong>${{ number_format($order->total, 2) }}</strong>
                    </td>
                    <td>
                        @if($order->payment_status == 'paid')
                            <span class="badge badge-success">Paid</span>
                        @else
                            <span class="badge badge-danger">{{ ucfirst($order->payment_status) }}</span>
                        @endif
                    </td>
                    <td>
                        <small><code>{{ $order->paytrace_transaction_id ?: 'N/A' }}</code></small>
                    </td>
                    <td>
                        <small style="color:#64748B;">{{ $order->created_at->format('M d, Y H:i') }}</small>
                    </td>
                    <td style="text-align:right;">
                        <div class="action-btn-group">
                            <a href="{{ route('admin.orders.show', $order) }}" class="action-btn action-btn-edit" title="Order Details & Verification" aria-label="Details">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </a>
                            <a href="{{ route('checkout.confirmation', $order->donor_pass_token) }}" target="_blank" class="action-btn action-btn-view" title="View Electronic Donor Pass" aria-label="Donor Pass">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:40px; color:#64748B;">
                        No orders recorded yet. As donors register online via PayTrace, they will show here.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div style="padding:16px 24px; border-top:1px solid var(--admin-slate-200);">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
