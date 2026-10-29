<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Super Admin Portal</title>
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
            max-width: 460px;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            padding: 40px 36px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .login-logo {
            max-height: 52px;
            width: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto 16px;
        }

        .login-badge {
            display: inline-block;
            background: #0B2545;
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 8px;
        }

        .login-title {
            font-size: 20px;
            font-weight: 800;
            color: #0B2545;
        }

        .login-subtitle {
            font-size: 13px;
            color: #64748B;
            margin-top: 6px;
            line-height: 1.5;
        }

        .form-group { margin-bottom: 22px; }
        .form-label { display: block; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px; }
        .form-control {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            background: #F8FAFC;
        }
        .form-control:focus { outline: none; border-color: #0B2545; background: #fff; box-shadow: 0 0 0 3px rgba(11,37,69,0.1); }

        .btn-submit {
            width: 100%;
            background: #0B2545;
            color: #fff;
            border: none;
            padding: 13px;
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s;
            box-shadow: 0 4px 12px rgba(11, 37, 69, 0.25);
        }
        .btn-submit:hover { background: #133E6E; }

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
            padding: 14px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('images/logo.png') }}" alt="Certified Drug Test Centers" class="login-logo">
            <span class="login-badge">Account Recovery</span>
            <h1 class="login-title">Reset Administrator Password</h1>
            <p class="login-subtitle">Enter your registered admin email address to generate secure password reset instructions.</p>
        </div>

        @if(session('status'))
            <div class="alert-success">
                <strong>{{ session('status') }}</strong>
                @if(session('reset_url'))
                    <div style="margin-top:10px; padding-top:10px; border-top:1px solid #86EFAC;">
                        <a href="{{ session('reset_url') }}" style="display:inline-block; font-weight:800; color:#14532D; text-decoration:underline;">
                            &rarr; Proceed to Reset Password Now
                        </a>
                    </div>
                @endif
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.password.email') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Admin Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email', 'admin@certifieddrugtesting.com') }}" class="form-control" required autofocus placeholder="admin@domain.com">
            </div>

            <button type="submit" class="btn-submit">Generate Reset Instructions &rarr;</button>
        </form>

        <div style="margin-top:24px; text-align:center; border-top:1px solid #F1F5F9; padding-top:16px;">
            <a href="{{ route('admin.login') }}" style="font-size:13px; color:#0B2545; font-weight:700; text-decoration:none;">
                &larr; Back to Administrator Sign In
            </a>
        </div>
    </div>
</body>
</html>
