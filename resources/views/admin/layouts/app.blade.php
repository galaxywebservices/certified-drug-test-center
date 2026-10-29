<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Super Admin' }} | Certified Drug Test Center</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --admin-navy: #0B2545;
            --admin-navy-dark: #07172C;
            --admin-navy-light: #133E6E;
            --admin-crimson: #C1121F;
            --admin-crimson-hover: #9E0F1A;
            --admin-slate-50: #F8FAFC;
            --admin-slate-100: #F1F5F9;
            --admin-slate-200: #E2E8F0;
            --admin-slate-300: #CBD5E1;
            --admin-slate-500: #64748B;
            --admin-slate-700: #334155;
            --admin-slate-900: #0F172A;
            --admin-emerald: #10B981;
            --admin-amber: #F59E0B;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background-color: var(--admin-slate-100); color: var(--admin-slate-900); display: flex; min-height: 100vh; }

        /* Sidebar */
        .admin-sidebar {
            width: 260px;
            background: var(--admin-navy-dark);
            color: #fff;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            border-right: 1px solid rgba(255,255,255,0.06);
            z-index: 100;
        }

        .sidebar-brand-box {
            padding: 16px 18px;
            background: rgba(255,255,255,0.03);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .sidebar-logo-card {
            background: #FFFFFF;
            border-radius: 8px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.25);
            text-decoration: none;
        }

        .sidebar-logo-img {
            max-height: 38px;
            width: auto;
            object-fit: contain;
            display: block;
        }

        .sidebar-badge-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-brand-badge {
            background: var(--admin-crimson);
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            padding: 3px 7px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sidebar-nav {
            list-style: none;
            padding: 16px 12px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .sidebar-section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--admin-slate-500);
            padding: 12px 12px 6px;
        }

        .sidebar-nav-item { margin-bottom: 4px; }
        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: #CBD5E1;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.15s ease;
        }

        .sidebar-nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }

        .sidebar-nav-link.active {
            background: var(--admin-navy-light);
            color: #fff;
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
            background: rgba(0, 0, 0, 0.25);
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex-shrink: 0;
        }

        .sidebar-user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #E2E8F0;
            padding: 6px 8px;
            border-radius: 6px;
            transition: background 0.15s;
        }
        .sidebar-user-card:hover { background: rgba(255, 255, 255, 0.08); }

        .sidebar-user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--admin-crimson);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 13px;
            flex-shrink: 0;
        }

        .sidebar-user-info { flex-grow: 1; min-width: 0; }
        .sidebar-user-name { font-size: 13px; font-weight: 700; color: #F8FAFC; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-user-email { font-size: 11px; color: #94A3B8; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        .sidebar-actions-row { display: flex; gap: 8px; }
        .sidebar-btn-profile {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.08);
            color: #E2E8F0;
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 8px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.15s;
        }
        .sidebar-btn-profile:hover { background: rgba(255, 255, 255, 0.16); color: #fff; }

        .sidebar-btn-logout {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: rgba(193, 18, 31, 0.15);
            color: #FCA5A5;
            border: 1px solid rgba(193, 18, 31, 0.35);
            padding: 8px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }
        .sidebar-btn-logout:hover { background: #C1121F; color: #fff; border-color: #C1121F; }

        /* Modern Action Icon Buttons */
        .action-btn-group {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.15s ease;
            background: transparent;
            padding: 0;
        }
        .action-btn svg {
            width: 15px;
            height: 15px;
            display: block;
        }
        .action-btn-view {
            background: #F0F9FF;
            color: #0284C7;
            border-color: #BAE6FD;
        }
        .action-btn-view:hover {
            background: #0284C7;
            color: #FFFFFF;
            border-color: #0284C7;
            box-shadow: 0 2px 4px rgba(2, 132, 199, 0.25);
        }
        .action-btn-edit {
            background: #F1F5F9;
            color: #0B2545;
            border-color: #CBD5E1;
        }
        .action-btn-edit:hover {
            background: #0B2545;
            color: #FFFFFF;
            border-color: #0B2545;
            box-shadow: 0 2px 4px rgba(11, 37, 69, 0.25);
        }
        .action-btn-delete {
            background: #FEF2F2;
            color: #DC2626;
            border-color: #FECACA;
        }
        .action-btn-delete:hover {
            background: #DC2626;
            color: #FFFFFF;
            border-color: #DC2626;
            box-shadow: 0 2px 4px rgba(220, 38, 38, 0.25);
        }

        /* Modern Admin Pagination */
        .admin-pagination-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            width: 100%;
        }
        .admin-pagination-info {
            font-size: 13px;
            color: #64748B;
        }
        .admin-pagination-info .font-bold {
            font-weight: 700;
            color: #1E293B;
        }
        .admin-pagination-list {
            display: inline-flex;
            align-items: center;
            list-style: none;
            gap: 4px;
            margin: 0;
            padding: 0;
        }
        .page-item .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            background: #FFFFFF;
            border: 1px solid #CBD5E1;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .page-item .page-link:hover {
            background: #F1F5F9;
            border-color: #94A3B8;
            color: #0B2545;
        }
        .page-item.active .page-link {
            background: #0B2545;
            color: #FFFFFF;
            border-color: #0B2545;
            box-shadow: 0 2px 4px rgba(11, 37, 69, 0.2);
        }
        .page-item.disabled .page-link {
            background: #F8FAFC;
            color: #94A3B8;
            border-color: #E2E8F0;
            cursor: not-allowed;
            opacity: 0.7;
        }
        .page-item .page-link.dots {
            border: none;
            background: transparent;
            color: #94A3B8;
            min-width: 24px;
        }

        /* Main Workspace */
        .admin-main { flex-grow: 1; display: flex; flex-direction: column; min-width: 0; }

        .admin-topbar {
            background: #fff;
            height: 64px;
            border-bottom: 1px solid var(--admin-slate-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .topbar-title { font-size: 18px; font-weight: 700; color: var(--admin-navy); }
        .topbar-actions { display: flex; align-items: center; gap: 14px; }

        .admin-content {
            padding: 32px;
            flex-grow: 1;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
        }

        /* Buttons & Badges */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            padding: 9px 18px;
            border-radius: 6px;
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .btn-primary { background: var(--admin-crimson); color: #fff; }
        .btn-primary:hover { background: var(--admin-crimson-hover); }

        .btn-navy { background: var(--admin-navy); color: #fff; }
        .btn-navy:hover { background: var(--admin-navy-dark); }

        .btn-outline { background: #fff; border-color: var(--admin-slate-300); color: var(--admin-slate-700); }
        .btn-outline:hover { background: var(--admin-slate-50); border-color: var(--admin-slate-400); color: var(--admin-navy); }

        .btn-sm { padding: 6px 12px; font-size: 12px; }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 8px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 9999px;
        }

        .badge-success { background: #DCFCE7; color: #166534; }
        .badge-danger { background: #FEE2E2; color: #991B1B; }
        .badge-info { background: #E0F2FE; color: #075985; }
        .badge-neutral { background: var(--admin-slate-200); color: var(--admin-slate-700); }

        /* Cards */
        .card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid var(--admin-slate-200);
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--admin-slate-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title { font-size: 16px; font-weight: 700; color: var(--admin-navy); }
        .card-body { padding: 24px; }

        /* Tables */
        .table-responsive { width: 100%; overflow-x: auto; }
        .admin-table { width: 100%; border-collapse: collapse; text-align: left; }
        .admin-table th {
            background: var(--admin-slate-50);
            padding: 12px 18px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--admin-slate-500);
            border-bottom: 1px solid var(--admin-slate-200);
        }
        .admin-table td {
            padding: 14px 18px;
            font-size: 14px;
            border-bottom: 1px solid var(--admin-slate-200);
            vertical-align: middle;
        }
        .admin-table tr:hover td { background-color: #F8FAFC; }

        /* Forms */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--admin-slate-700); margin-bottom: 6px; }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--admin-slate-300);
            border-radius: 6px;
            font-family: inherit;
            font-size: 14px;
            color: var(--admin-slate-900);
            background: #fff;
            transition: border-color 0.15s;
        }
        .form-control:focus { outline: none; border-color: var(--admin-navy-light); box-shadow: 0 0 0 3px rgba(19,62,110,0.1); }
        .form-hint { font-size: 12px; color: var(--admin-slate-500); margin-top: 4px; }

        /* Flash messages */
        .alert { padding: 14px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 14px; font-weight: 500; }
        .alert-success { background: #DCFCE7; color: #166534; border: 1px solid #BBF7D0; }
        .alert-danger { background: #FEE2E2; color: #991B1B; border: 1px solid #FECACA; }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="admin-sidebar">
        <div class="sidebar-brand-box">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-logo-card" title="Certified Drug Test Centers Control Panel">
                <img src="{{ asset('images/logo.png') }}" alt="Certified Drug Test Centers" class="sidebar-logo-img">
            </a>
            <div class="sidebar-badge-row">
                <span class="sidebar-brand-badge">Super Admin</span>
                <span style="font-size:11px; color:#94A3B8; font-weight:600;">Control Center</span>
            </div>
        </div>

        <ul class="sidebar-nav">
            <li class="sidebar-section-title">Core Management</li>
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.profile') }}" class="sidebar-nav-link {{ request()->routeIs('admin.profile*') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Admin Profile &amp; Password
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.products.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Products &amp; Tests
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.categories.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                    Categories
                </a>
            </li>

            <li class="sidebar-section-title">Content &amp; SEO</li>
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.pages.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Page Builder &amp; CMS
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.locations.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Collection Facilities (7,382)
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.cities.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.cities.*') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    City SEO Guides (1,000)
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('sitemap') }}" target="_blank" class="sidebar-nav-link">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    XML Sitemap
                </a>
            </li>

            <li class="sidebar-section-title">Finance &amp; Operations</li>
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.leads.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Inquiries &amp; Leads
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.orders.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Orders &amp; Registrations
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.settings.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    PayTrace &amp; Settings
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="{{ route('admin.profile') }}" class="sidebar-user-card" title="Administrator Profile & Security">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'SA', 0, 2)) }}
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ auth()->user()->name ?? 'Administrator' }}</div>
                    <div class="sidebar-user-email">{{ auth()->user()->email ?? 'admin' }}</div>
                </div>
            </a>
            <div class="sidebar-actions-row">
                <a href="{{ route('admin.profile') }}" class="sidebar-btn-profile" title="Admin Profile & Security">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Profile</span>
                </a>
                <form action="{{ route('admin.logout') }}" method="POST" style="flex:1; margin:0;">
                    @csrf
                    <button type="submit" class="sidebar-btn-logout" title="Sign Out of Admin Portal" style="width:100%;">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="admin-main">
        <header class="admin-topbar">
            <h1 class="topbar-title">{{ $heading ?? ($title ?? 'Dashboard') }}</h1>
            <div class="topbar-actions">
                <a href="{{ url('/') }}" target="_blank" class="btn btn-outline btn-sm">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    View Live Site
                </a>
                @yield('topbar_actions')
            </div>
        </header>

        <div class="admin-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>
