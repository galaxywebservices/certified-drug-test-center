<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Login | Certified Drug Test Center</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #07172C 0%, #0B2545 100%);
            color: #0F172A;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
        }

        .login-card {
            background: #fff;
            width: 100%;
            max-width: 450px;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            padding: 40px 36px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .login-logo-wrap {
            margin-bottom: 18px;
            display: inline-block;
        }

        .login-logo {
            max-height: 52px;
            width: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .login-badge {
            display: inline-block;
            background: #C1121F;
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 10px;
        }

        .login-title {
            font-size: 20px;
            font-weight: 800;
            color: #0B2545;
            letter-spacing: -0.4px;
        }

        .login-subtitle {
            font-size: 13px;
            color: #64748B;
            margin-top: 4px;
        }

        .form-group { margin-bottom: 20px; }
        .form-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }
        .form-label { font-size: 13px; font-weight: 700; color: #334155; }
        .form-forgot-link {
            font-size: 12px;
            color: #0B2545;
            font-weight: 600;
            text-decoration: none;
        }
        .form-forgot-link:hover { text-decoration: underline; color: #C1121F; }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            background: #F8FAFC;
            transition: all 0.15s;
        }
        .form-control:focus { outline: none; border-color: #0B2545; background: #fff; box-shadow: 0 0 0 3px rgba(11,37,69,0.1); }

        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #475569;
            margin-bottom: 24px;
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            background: #C1121F;
            color: #fff;
            border: none;
            padding: 13px;
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s;
            box-shadow: 0 4px 12px rgba(193, 18, 31, 0.25);
        }
        .btn-submit:hover { background: #9E0F1A; }
        .btn-submit:active { transform: translateY(1px); }

        .alert-error {
            background: #FEE2E2;
            border: 1px solid #FECACA;
            color: #991B1B;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #DCFCE7;
            border: 1px solid #BBF7D0;
            color: #166534;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo-wrap">
                <img src="{{ asset('images/logo.png') }}" alt="Certified Drug Test Centers" class="login-logo">
            </div>
            <div>
                <span class="login-badge">Super Admin Portal</span>
                <h1 class="login-title">Control Panel Sign In</h1>
                <p class="login-subtitle">Sign in to manage catalog, orders, and site settings</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Admin Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email', 'admin@certifieddrugtesting.com') }}" class="form-control" required autofocus placeholder="admin@domain.com">
            </div>

            <div class="form-group">
                <div class="form-label-row">
                    <label class="form-label" for="password">Password</label>
                    <a href="{{ route('admin.password.request') }}" class="form-forgot-link">Forgot password?</a>
                </div>
                <input type="password" id="password" name="password" class="form-control" required placeholder="Enter password">
            </div>

            <label class="form-check" for="remember">
                <input type="checkbox" id="remember" name="remember" value="1">
                <span>Remember me on this workstation</span>
            </label>

            <button type="submit" class="btn-submit">Sign In to Dashboard &rarr;</button>
        </form>

        <div style="margin-top:24px; text-align:center; border-top:1px solid #F1F5F9; padding-top:16px;">
            <a href="{{ url('/') }}" style="font-size:12px; color:#64748B; text-decoration:none;">&larr; Return to Certified Drug Test Center Website</a>
        </div>
    </div>
</body>
</html>
