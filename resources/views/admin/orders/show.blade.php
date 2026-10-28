@extends('admin.layouts.app', ['title' => 'Order Details', 'heading' => 'Order #' . $order->order_number])

@section('topbar_actions')
<form action="{{ route('admin.orders.resend-pass', $order) }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit" class="btn btn-outline btn-sm" onclick="return confirm('Resend Electronic Donor Pass email to {{ $order->donor_email }}?');">
        Resend Donor Pass Email
    </button>
</form>
<a href="{{ route('checkout.confirmation', $order->donor_pass_token) }}" target="_blank" class="btn btn-primary btn-sm">
    Print Electronic Donor Pass
</a>
<a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm">
    &larr; Back to Orders
</a>
@endsection

@section('content')
<div style="display:grid; grid-template-columns:2fr 1fr; gap:24px;">
    <div>
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Donor &amp; Test Information</h2>
            </div>
            <div class="card-body">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                    <div>
                        <div style="font-size:12px; color:#64748B; font-weight:700; text-transform:uppercase;">Donor Full Name</div>
                        <div style="font-size:16px; font-weight:700; color:var(--admin-navy); margin-top:4px;">{{ $order->donor_full_name }}</div>
                    </div>
                    <div>
                        <div style="font-size:12px; color:#64748B; font-weight:700; text-transform:uppercase;">Contact Info</div>
                        <div style="font-size:14px; margin-top:4px;">
                            {{ $order->donor_email }}<br>
                            {{ $order->donor_phone }}
                        </div>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; padding-top:16px; border-top:1px solid var(--admin-slate-200);">
                    <div>
                        <div style="font-size:12px; color:#64748B; font-weight:700; text-transform:uppercase;">Testing Reason</div>
                        <div style="font-size:14px; margin-top:4px;">{{ ucfirst($order->test_reason) }}</div>
                    </div>
                    <div>
                        <div style="font-size:12px; color:#64748B; font-weight:700; text-transform:uppercase;">Assigned Collection Site</div>
                        <div style="font-size:14px; margin-top:4px;">
                            @if($order->location)
                                {{ $order->location->name }}<br>
                                <small style="color:#64748B;">{{ $order->location->address1 }}, {{ $order->location->city }}, {{ $order->location->state }} {{ $order->location->zip }}</small>
                            @else
                                Any Quest / Labcorp Certified Location
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ordered Items -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Order Items</h2>
            </div>
            <div class="card-body" style="padding:0;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Test Description</th>
                            <th>Quantity</th>
                            <th style="text-align:right;">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td><strong>{{ $item->product_name }}</strong></td>
                            <td>{{ $item->quantity }}</td>
                            <td style="text-align:right;">${{ number_format($item->price, 2) }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" style="text-align:right; font-weight:700;">Total Charged:</td>
                            <td style="text-align:right; font-weight:800; color:var(--admin-crimson); font-size:16px;">
                                ${{ number_format($order->total, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Side: PayTrace Gateway & Status Update -->
    <div>
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">PayTrace Transaction</h2>
            </div>
            <div class="card-body" style="font-size:13px; line-height:1.8;">
                <div><strong>Gateway:</strong> {{ ucfirst($order->payment_gateway) }}</div>
                <div><strong>Transaction ID:</strong> <code>{{ $order->paytrace_transaction_id ?: 'Simulated Sandbox' }}</code></div>
                <div><strong>Approval Code:</strong> <code>{{ $order->paytrace_approval_code ?: 'AP123456' }}</code></div>
                <div><strong>Payment Status:</strong> <span class="badge badge-success">{{ strtoupper($order->payment_status) }}</span></div>
                <div><strong>Donor Token:</strong> <code style="word-break:break-all;">{{ $order->donor_pass_token }}</code></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Update Registration Status</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="status">Testing Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="registered" {{ $order->status == 'registered' ? 'selected' : '' }}>Registered (Pass Issued)</option>
                            <option value="specimen_collected" {{ $order->status == 'specimen_collected' ? 'selected' : '' }}>Specimen Collected at Lab</option>
                            <option value="lab_processing" {{ $order->status == 'lab_processing' ? 'selected' : '' }}>In Lab Processing</option>
                            <option value="mro_review" {{ $order->status == 'mro_review' ? 'selected' : '' }}>Under MRO Doctor Review</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Results Released)</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="payment_status">Payment Status</label>
                        <select id="payment_status" name="payment_status" class="form-control">
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="notes">Internal Admin Notes</label>
                        <textarea id="notes" name="notes" rows="3" class="form-control">{{ old('notes', $order->notes) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-navy" style="width:100%; justify-content:center;">
                        Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
