<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تسجيل دخول المدير - Super Admin</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            overflow: hidden;
        }

        .login-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            overflow: hidden;
        }

        .login-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
            animation: rotate 30s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .login-section::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(233, 69, 96, 0.15), transparent);
            border-radius: 50%;
            top: 10%;
            right: 10%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-30px); }
        }

        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            background: rgba(233, 69, 96, 0.4);
            border-radius: 50%;
            animation: rise 15s infinite ease-in;
        }

        .particle:nth-child(1) { width: 10px; height: 10px; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 15px; height: 15px; left: 20%; animation-delay: 2s; }
        .particle:nth-child(3) { width: 8px; height: 8px; left: 30%; animation-delay: 4s; }
        .particle:nth-child(4) { width: 12px; height: 12px; left: 40%; animation-delay: 1s; }
        .particle:nth-child(5) { width: 10px; height: 10px; left: 50%; animation-delay: 3s; }
        .particle:nth-child(6) { width: 14px; height: 14px; left: 60%; animation-delay: 5s; }
        .particle:nth-child(7) { width: 9px; height: 9px; left: 70%; animation-delay: 2.5s; }
        .particle:nth-child(8) { width: 11px; height: 11px; left: 80%; animation-delay: 4.5s; }
        .particle:nth-child(9) { width: 13px; height: 13px; left: 90%; animation-delay: 1.5s; }

        @keyframes rise {
            0% { bottom: -50px; opacity: 0; }
            50% { opacity: 1; }
            100% { bottom: 100%; opacity: 0; }
        }

        .container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
            justify-content: center;
        }

        .col-md-6 {
            width: 100%;
            padding: 0 15px;
        }

        @media (min-width: 768px) {
            .col-md-6 { width: 50%; }
        }

        @media (min-width: 992px) {
            .col-lg-5 { width: 41.666667%; }
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            position: relative;
            animation: slideUp 0.8s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #e94560, #1a1a2e, #e94560);
            background-size: 200% 100%;
            animation: gradientMove 3s ease infinite;
        }

        @keyframes gradientMove {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .card-body {
            padding: 3rem 2.5rem;
        }

        .login-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #e94560, #1a1a2e);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(233, 69, 96, 0.4);
            animation: pulse 2s ease infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 10px 30px rgba(233, 69, 96, 0.4); }
            50% { transform: scale(1.05); box-shadow: 0 15px 40px rgba(233, 69, 96, 0.6); }
        }

        .login-icon i {
            font-size: 3rem;
            color: white;
        }

        .card-title {
            background: linear-gradient(135deg, #e94560, #1a1a2e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-outline {
            position: relative;
            margin-bottom: 1.5rem;
            width: 100%;
        }

        .form-label {
            color: #4a5568;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            width: 100%;
            border: 2px solid rgba(233, 69, 96, 0.2);
            border-radius: 15px;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(248, 249, 250, 0.5);
            box-sizing: border-box;
            outline: none;
        }

        .form-control:focus {
            border-color: #e94560;
            box-shadow: 0 0 0 4px rgba(233, 69, 96, 0.1);
            transform: translateY(-2px);
            background: white;
        }

        .form-control.is-invalid {
            border-color: #f5576c;
        }

        .invalid-feedback {
            color: #f5576c;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .form-check {
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            min-width: 20px;
            border: 2px solid rgba(233, 69, 96, 0.3);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0;
            padding: 0;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background: white;
            position: relative;
        }

        .form-check-input:checked {
            background: linear-gradient(135deg, #e94560, #1a1a2e);
            border-color: #e94560;
        }

        .form-check-input:checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
        }

        .form-check-label {
            color: #4a5568;
            font-weight: 500;
            cursor: pointer;
            margin-right: 0.5rem;
            margin-left: 0.5rem;
        }

        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, #e94560 0%, #1a1a2e 100%);
            border: none;
            border-radius: 15px;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(233, 69, 96, 0.4);
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(233, 69, 96, 0.6);
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        .btn-primary.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-primary.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .card-body { padding: 2rem 1.5rem; }
            .login-icon { width: 80px; height: 80px; }
            .login-icon i { font-size: 2.5rem; }
            .card-title { font-size: 1.5rem; }
        }

        .admin-badge {
            background: linear-gradient(135deg, #e94560, #1a1a2e);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1rem;
            text-align: center;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Floating Particles -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <section class="login-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-5">
                    <div class="login-card">
                        <div class="card-body">
                            <!-- Login Icon -->
                            <div class="login-icon">
                                <i class="fas fa-user-shield"></i>
                            </div>

                            <div class="admin-badge">
                                <i class="fas fa-crown me-1"></i> لوحة تحكم المدير العام
                            </div>

                            <h5 class="card-title">تسجيل الدخول</h5>

                            <form action="{{ route('admin.login.submit') }}" method="POST" id="loginForm">
                                @csrf

                                <!-- Email Input -->
                                <div class="form-outline">
                                    <label class="form-label" for="email">البريد الإلكتروني</label>
                                    <input type="email"
                                           id="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email"
                                           placeholder="admin@example.com"
                                           value="{{ old('email') }}"
                                           required/>
                                    @error('email')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Password Input -->
                                <div class="form-outline">
                                    <label class="form-label" for="password">كلمة المرور</label>
                                    <input type="password"
                                           id="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password"
                                           placeholder="••••••••"
                                           required/>
                                    @error('password')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Remember Me -->
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="remember"
                                           name="remember"
                                           {{ old('remember') ? 'checked' : '' }}/>
                                    <label class="form-check-label" for="remember">
                                        تذكرني
                                    </label>
                                </div>

                                <!-- Login Button -->
                                <button class="btn btn-primary" type="submit">
                                    دخول <i class="fas fa-sign-in-alt me-2"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('.btn-primary');
            btn.classList.add('loading');
        });

        document.getElementById('email').focus();
    </script>
</body>
</html>
