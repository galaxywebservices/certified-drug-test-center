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
                        <div style="display:inline-flex; gap:6px;">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-navy btn-sm">Details</a>
                            <a href="{{ route('checkout.confirmation', $order->donor_pass_token) }}" target="_blank" class="btn btn-outline btn-sm">Donor Pass</a>
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
