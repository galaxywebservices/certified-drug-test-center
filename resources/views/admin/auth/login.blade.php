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
            background: #07172C;
            color: #0F172A;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-card {
            background: #fff;
            width: 100%;
            max-width: 440px;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            padding: 40px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
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
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .login-title {
            font-size: 22px;
            font-weight: 800;
            color: #0B2545;
            letter-spacing: -0.5px;
        }

        .login-subtitle {
            font-size: 13px;
            color: #64748B;
            margin-top: 6px;
        }

        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; }
        .form-control {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #CBD5E1;
            border-radius: 6px;
            font-family: inherit;
            font-size: 14px;
            background: #F8FAFC;
        }
        .form-control:focus { outline: none; border-color: #0B2545; background: #fff; }

        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #475569;
            margin-bottom: 24px;
        }

        .btn-submit {
            width: 100%;
            background: #C1121F;
            color: #fff;
            border: none;
            padding: 12px;
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-submit:hover { background: #9E0F1A; }

        .alert-error {
            background: #FEE2E2;
            border: 1px solid #FECACA;
            color: #991B1B;
            padding: 12px 14px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <span class="login-badge">Super Admin Portal</span>
            <h1 class="login-title">Certified Drug Test Center</h1>
            <p class="login-subtitle">Sign in to access catalog, page builder, and settings</p>
        </div>

        @if($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Admin Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', 'admin@certifieddrugtesting.com') }}" class="form-control" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required placeholder="Enter password">
            </div>

            <div class="form-check">
                <input type="checkbox" id="remember" name="remember" value="1">
                <label for="remember">Remember me on this browser</label>
            </div>

            <button type="submit" class="btn-submit">Sign In to Dashboard</button>
        </form>
    </div>
</body>
</html>
