<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Merchant - {{ $plan->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .plan-badge {
            background: rgba(255,255,255,0.2);
            display: inline-block;
            padding: 10px 20px;
            border-radius: 20px;
            margin-top: 10px;
        }

        .form-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .section-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }

        .form-section {
            margin-bottom: 40px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group label.required::after {
            content: '*';
            color: #e74c3c;
            margin-left: 4px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .error-message {
            background: #fee;
            color: #c33;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .form-card {
                padding: 20px;
            }

            .header h1 {
                font-size: 28px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body dir="rtl" style="text-align: right;">
    <div class="container">
        <div class="header">
            <h1>تسجيل حساب التاجر</h1>
            <div class="plan-badge">
                الخطة المختارة: <strong>{{ $plan->name }}</strong> - ${{ number_format($plan->price, 2) }} / {{ $plan->duration }} يوم
            </div>
        </div>

        <div class="form-card">
            @if ($errors->any())
                <div class="error-message">
                    <strong>يرجى تصحيح الأخطاء التالية:</strong>
                    <ul style="margin-top: 10px; margin-right: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('merchant.register') }}" method="POST">
                @csrf
                <input type="hidden" name="subscription_plan_id" value="{{ $plan->id }}">

                <div class="form-section">
                    <h2 class="section-title">معلومات التاجر</h2>

                    <div class="form-group">
                        <label for="merchant_name" class="required">اسم التاجر</label>
                        <input type="text" id="merchant_name" name="merchant_name" value="{{ old('merchant_name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="phone_primary" class="required">رقم الهاتف</label>
                        <input type="text" id="phone_primary" name="phone_primary" value="{{ old('phone_primary') }}" required>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title">بيانات الدخول</h2>

                    <div class="form-group">
                        <label for="user_name" class="required">اسم المسؤول</label>
                        <input type="text" id="user_name" name="user_name" value="{{ old('user_name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="user_phone" class="required">هاتف المسؤول</label>
                        <input type="text" id="user_phone" name="user_phone" value="{{ old('user_phone') }}" required>
                    </div>

                    <div class="form-row" style="display: flex; gap: 20px;">
                        <div class="form-group" style="flex: 1;">
                            <label for="user_password" class="required">كلمة المرور</label>
                            <input type="password" id="user_password" name="user_password" required>
                        </div>

                        <div class="form-group" style="flex: 1;">
                            <label for="user_password_confirmation" class="required">تأكيد كلمة المرور</label>
                            <input type="password" id="user_password_confirmation" name="user_password_confirmation" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="submit-btn">إكمال التسجيل</button>
            </form>
        </div>

        <div class="back-link">
            <a href="{{ route('home') }}">← الرجوع إلى الخطط</a>
        </div>
    </div>
</body>

</html>
