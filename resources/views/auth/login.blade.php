<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMAK | Log in</title>

    <!-- Google Font: Inter + Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <!-- Button Loading Styles -->
    <link rel="stylesheet" href="{{ asset('css/button-loading.css') }}">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #3b82f6;
            --accent: #06b6d4;
            --surface: #ffffff;
            --bg-start: #0f172a;
            --bg-end: #1e293b;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border: #e2e8f0;
            --input-bg: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body.login-page {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-start);
            background: linear-gradient(135deg, var(--bg-start) 0%, var(--bg-end) 50%, #0c1d3a 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animated background elements */
        body.login-page::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(37, 99, 235, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(6, 182, 212, 0.06) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 80%, rgba(37, 99, 235, 0.05) 0%, transparent 50%);
            animation: bgShift 15s ease-in-out infinite alternate;
        }

        @keyframes bgShift {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-2%, -2%) rotate(1deg); }
        }

        /* Floating geometric shapes */
        .bg-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.04;
            pointer-events: none;
        }

        .bg-shape-1 {
            width: 400px;
            height: 400px;
            background: var(--primary);
            top: -100px;
            right: -100px;
            animation: float1 20s ease-in-out infinite;
        }

        .bg-shape-2 {
            width: 300px;
            height: 300px;
            background: var(--accent);
            bottom: -80px;
            left: -80px;
            animation: float2 25s ease-in-out infinite;
        }

        .bg-shape-3 {
            width: 200px;
            height: 200px;
            background: var(--primary-light);
            top: 50%;
            left: 60%;
            animation: float3 18s ease-in-out infinite;
        }

        @keyframes float1 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-30px, 30px) scale(1.05); }
        }

        @keyframes float2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(20px, -20px) scale(1.08); }
        }

        @keyframes float3 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-15px, 15px) scale(0.95); }
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            padding: 20px;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card {
            background: var(--surface);
            border-radius: 20px;
            box-shadow:
                0 4px 6px -1px rgba(0, 0, 0, 0.1),
                0 25px 50px -12px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.05);
            overflow: hidden;
        }

        /* Top gradient bar */
        .login-card::before {
            content: '';
            display: block;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent), var(--primary-light));
            background-size: 200% auto;
            animation: gradientBar 4s ease infinite;
        }

        @keyframes gradientBar {
            0%, 100% { background-position: 0% center; }
            50% { background-position: 100% center; }
        }

        .login-header {
            text-align: center;
            padding: 40px 40px 10px;
        }

        .login-icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
            position: relative;
        }

        .login-icon i {
            font-size: 32px;
            color: #ffffff;
        }

        .login-header h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 6px;
            letter-spacing: -0.3px;
        }

        .login-header p {
            font-size: 14px;
            color: var(--text-secondary);
            font-weight: 400;
        }

        .login-body {
            padding: 24px 40px 40px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
            letter-spacing: 0.01em;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 15px;
            transition: color 0.2s;
            z-index: 2;
        }

        .input-wrapper .form-control {
            width: 100%;
            height: 48px;
            padding: 0 16px 0 46px;
            border: 2px solid var(--border);
            border-radius: 12px;
            background: var(--input-bg);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            transition: all 0.2s ease;
            outline: none;
        }

        .input-wrapper .form-control::placeholder {
            color: #94a3b8;
        }

        .input-wrapper .form-control:focus {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .input-wrapper .form-control:focus ~ .input-icon {
            color: var(--primary);
        }

        .input-wrapper .form-control.is-invalid {
            border-color: #ef4444;
        }

        .input-wrapper .form-control.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .invalid-feedback {
            font-size: 12px;
            color: #ef4444;
            margin-top: 6px;
            display: block;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 4px;
            font-size: 15px;
            transition: color 0.2s;
            z-index: 2;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        .btn-login {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.02em;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.35);
        }

        .btn-login:hover::before {
            opacity: 1;
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .btn-login span {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-reset {
            width: 100%;
            height: 48px;
            border: 2px solid var(--border);
            border-radius: 12px;
            background: transparent;
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-reset:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
            color: var(--text-primary);
        }

        .btn-row {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        .btn-row .btn-col-login {
            flex: 2;
        }

        .btn-row .btn-col-reset {
            flex: 1;
        }

        .login-footer {
            text-align: center;
            padding: 0 40px 32px;
        }

        .login-footer p {
            font-size: 12px;
            color: var(--text-secondary);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 16px;
            }

            .login-header {
                padding: 32px 24px 8px;
            }

            .login-body {
                padding: 20px 24px 32px;
            }

            .login-footer {
                padding: 0 24px 24px;
            }

            .login-header h1 {
                font-size: 20px;
            }

            .btn-row {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>

<body class="hold-transition login-page">
    <!-- Background shapes -->
    <div class="bg-shape bg-shape-1"></div>
    <div class="bg-shape bg-shape-2"></div>
    <div class="bg-shape bg-shape-3"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h1>SIMAK</h1>
                <p>Sistem Informasi Akuntansi Keuangan</p>
            </div>

            <div class="login-body">
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Masukkan email anda" value="{{ old('email') }}" autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Masukkan password anda">
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="btn-row">
                        <div class="btn-col-login">
                            <button type="submit" class="btn-login">
                                <span><i class="fas fa-sign-in-alt"></i> Masuk</span>
                            </button>
                        </div>
                        <div class="btn-col-reset">
                            <button type="reset" class="btn-reset">Reset</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="login-footer">
                <p>&copy; {{ date('Y') }} Tim Developer &mdash; v1.0.0</p>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
    <!-- Button Loading Script -->
    <script src="{{ asset('js/button-loading.js') }}"></script>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
