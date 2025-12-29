<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تسجيل الدخول - بوابة العملاء</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"/>
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

        /* ============================================
           MAGICAL LOGIN BACKGROUND
        ============================================ */
        .login-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow: hidden;
        }

        /* Animated Background Circles */
        .login-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
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
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15), transparent);
            border-radius: 50%;
            top: 10%;
            right: 10%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-30px); }
        }

        /* Floating Particles */
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
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
            0% {
                bottom: -50px;
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                bottom: 100%;
                opacity: 0;
            }
        }

        /* ============================================
           MAGICAL LOGIN CARD
        ============================================ */
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
        }

        .justify-content-center {
            justify-content: center;
        }

        .col-md-6,
        .col-lg-5 {
            width: 100%;
            padding: 0 15px;
        }

        @media (min-width: 768px) {
            .col-md-6 {
                width: 50%;
            }
        }

        @media (min-width: 992px) {
            .col-lg-5 {
                width: 41.666667%;
            }
        }

        .card {
            display: block;
            width: 100%;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            position: relative;
            animation: slideUp 0.8s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
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

        /* Logo/Icon Section */
        .login-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            animation: pulse 2s ease infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
            }
        }

        .login-icon i {
            font-size: 3rem;
            color: white;
        }

        /* Title */
        .card-title {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
            animation: fadeIn 1s ease;
        }

        .help-text {
            text-align: center;
            color: #718096;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* ============================================
           MAGICAL FORM INPUTS
        ============================================ */
        form {
            width: 100%;
        }

        .form-group {
            width: 100%;
            margin-bottom: 1rem;
        }

        .form-outline {
            position: relative;
            margin-bottom: 2rem;
            width: 100%;
        }

        .form-control,
        .form-control-lg,
        input[type="text"] {
            width: 100% !important;
            border: 2px solid rgba(102, 126, 234, 0.2) !important;
            border-radius: 15px !important;
            padding: 1rem 1.25rem !important;
            font-size: 1rem !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            background: rgba(248, 249, 250, 0.5) !important;
            box-sizing: border-box !important;
            outline: none !important;
        }

        .form-control:focus,
        .form-control-lg:focus,
        input[type="text"]:focus {
            border-color: #667eea !important;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1) !important;
            transform: translateY(-2px);
            background: white !important;
            outline: none !important;
        }

        .form-control.is-invalid,
        .is-invalid {
            border-color: #f5576c !important;
        }

        .form-label {
            color: #4a5568;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .invalid-feedback {
            color: #f5576c !important;
            font-size: 0.875rem !important;
            margin-top: 0.5rem !important;
            display: block !important;
            animation: shake 0.5s ease !important;
            width: 100% !important;
        }

        span.invalid-feedback {
            display: block !important;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        /* Remember Me Checkbox */
        .form-check {
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
        }

        .form-check-input,
        input[type="checkbox"] {
            width: 20px !important;
            height: 20px !important;
            min-width: 20px !important;
            border: 2px solid rgba(102, 126, 234, 0.3) !important;
            border-radius: 6px !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            margin: 0 !important;
            padding: 0 !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            background: white !important;
            position: relative !important;
        }

        .form-check-input:checked,
        input[type="checkbox"]:checked {
            background: linear-gradient(135deg, #667eea, #764ba2) !important;
            border-color: #667eea !important;
        }

        .form-check-input:checked::after,
        input[type="checkbox"]:checked::after {
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
            color: #4a5568 !important;
            font-weight: 500 !important;
            cursor: pointer !important;
            margin-right: 0.5rem !important;
            margin-left: 0.5rem !important;
        }

        /* ============================================
           MAGICAL LOGIN BUTTON
        ============================================ */
        .btn-primary,
        button[type="submit"] {
            width: 100% !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border: none !important;
            border-radius: 15px !important;
            padding: 1rem 2rem !important;
            font-size: 1.1rem !important;
            font-weight: 700 !important;
            color: white !important;
            cursor: pointer !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4) !important;
            position: relative !important;
            overflow: hidden !important;
            text-transform: none !important;
            letter-spacing: normal !important;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-primary:hover::before {
            width: 400px;
            height: 400px;
        }

        .btn-primary:hover,
        button[type="submit"]:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.6) !important;
        }

        .btn-primary:active,
        button[type="submit"]:active {
            transform: translateY(-1px) !important;
        }

        /* ============================================
           RESPONSIVE DESIGN
        ============================================ */
        @media (max-width: 768px) {
            .card-body {
                padding: 2rem 1.5rem;
            }

            .login-icon {
                width: 80px;
                height: 80px;
            }

            .login-icon i {
                font-size: 2.5rem;
            }

            .card-title {
                font-size: 1.5rem;
            }
        }

        /* Loading Animation */
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
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card login-card">
                        <div class="card-body">
                            <!-- Login Icon -->
                            <div class="login-icon">
                                <i class="fas fa-user"></i>
                            </div>

                            <h5 class="card-title">بوابة العملاء</h5>
                            <p class="help-text">أدخل رقم هاتفك المسجل للدخول</p>

                            <form action="{{ route('customer.login') }}" method="POST" id="loginForm">
                                @csrf

                                <!-- Phone Input -->
                                <div class="form-outline">
                                    <label class="form-label" for="formPhone">رقم الهاتف</label>
                                    <input type="text"
                                           id="formPhone"
                                           class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                           name="phone"
                                           placeholder="0123456789"
                                           value="{{ old('phone') }}"
                                           required/>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Remember Me -->
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           value="1"
                                           id="rememberMe"
                                           name="remember"
                                           {{ old('remember') ? 'checked' : '' }}/>
                                    <label class="form-check-label" for="rememberMe">
                                        تذكرني
                                    </label>
                                </div>

                                <!-- Login Button -->
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">
                                        دخول <i class="fas fa-sign-in-alt me-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Add loading animation on form submit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('.btn-primary');
            btn.classList.add('loading');
        });

        // Auto-focus first input
        document.getElementById('formPhone').focus();
    </script>
</body>
</html>
