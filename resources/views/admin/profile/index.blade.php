@extends('admin.layouts.app', ['title' => 'Admin Profile & Security', 'heading' => 'Super Administrator Profile & Security'])

@section('content')
<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap:24px;">

    <!-- Profile Details Card -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title" style="display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span>Administrator Account Details</span>
            </h2>
            <span class="badge badge-danger">Super Administrator</span>
        </div>
        <div class="card-body">
            <div style="display:flex; align-items:center; gap:16px; margin-bottom:24px; padding-bottom:20px; border-bottom:1px solid var(--admin-slate-200);">
                <div style="width:56px; height:56px; border-radius:50%; background:#0B2545; color:#fff; display:flex; align-items:center; justify-content:center; font-size:20px; font-weight:800; flex-shrink:0;">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <h3 style="font-size:16px; font-weight:800; color:var(--admin-navy); margin:0;">{{ $user->name }}</h3>
                    <p style="font-size:13px; color:var(--admin-slate-500); margin:2px 0 0;">{{ $user->email }}</p>
                    <small style="font-size:11px; color:#10B981; font-weight:600;">● Active Session &bull; Full Permissions</small>
                </div>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="name">Full Name <span style="color:#C1121F;">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                    @error('name')
                        <p style="color:#DC2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Admin Email Address <span style="color:#C1121F;">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                    <small class="form-hint">Used for sign-in and system security notifications.</small>
                    @error('email')
                        <p style="color:#DC2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="phone">Direct Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control" placeholder="(800)-985-4339">
                </div>

                <div style="margin-top:24px; padding-top:16px; border-top:1px solid var(--admin-slate-200); display:flex; justify-content:flex-end;">
                    <button type="submit" class="btn btn-navy">
                        Save Profile Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Password Card -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title" style="display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <span>Change Account Password</span>
            </h2>
            <span class="badge badge-neutral">Security</span>
        </div>
        <div class="card-body">
            <p style="font-size:13px; color:var(--admin-slate-500); margin-bottom:20px; line-height:1.5;">
                To protect portal access and sensitive medical donor records, ensure your password uses a minimum of 8 characters with a mix of letters, numbers, and symbols.
            </p>

            <form action="{{ route('admin.profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="current_password">Current Password <span style="color:#C1121F;">*</span></label>
                    <input type="password" id="current_password" name="current_password" class="form-control" required placeholder="Enter your current password">
                    @error('current_password')
                        <p style="color:#DC2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">New Password <span style="color:#C1121F;">*</span></label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Minimum 8 characters">
                    @error('password')
                        <p style="color:#DC2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm New Password <span style="color:#C1121F;">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required placeholder="Re-type new password">
                </div>

                <div style="margin-top:24px; padding-top:16px; border-top:1px solid var(--admin-slate-200); display:flex; justify-content:flex-end;">
                    <button type="submit" class="btn btn-primary">
                        Update Security Password
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
