<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renew Subscription</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            width: 100%;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
        }

        .icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 40px;
            color: white;
        }

        h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 15px;
        }

        .message {
            color: #666;
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .info-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
        }

        .info-box h3 {
            color: #333;
            font-size: 18px;
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #666;
            font-weight: 500;
        }

        .info-value {
            color: #333;
            font-weight: 600;
        }

        .expired {
            color: #e74c3c;
        }

        .contact-message {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: left;
            color: #856404;
        }

        .contact-message strong {
            display: block;
            margin-bottom: 5px;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .card {
                padding: 30px 20px;
            }

            h1 {
                font-size: 24px;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="icon">⚠️</div>

            <h1>Subscription Expired</h1>

            <p class="message">
                Your subscription has expired and you need to renew it to continue using our services.
            </p>

            @if(auth()->user()->merchant)
            <div class="info-box">
                <h3>Subscription Details</h3>
                <div class="info-row">
                    <span class="info-label">Merchant Name:</span>
                    <span class="info-value">{{ auth()->user()->merchant->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Plan:</span>
                    <span class="info-value">
                        @if(auth()->user()->merchant->subscriptionPlan)
                            {{ auth()->user()->merchant->subscriptionPlan->name }}
                        @else
                            N/A
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Subscription End Date:</span>
                    <span class="info-value expired">
                        {{ auth()->user()->merchant->subscription_end_date ? auth()->user()->merchant->subscription_end_date->format('M d, Y') : 'N/A' }}
                    </span>
                </div>
            </div>
            @endif

            <div class="contact-message">
                <strong>How to Renew?</strong>
                Please contact our support team to renew your subscription and regain access to all features.
            </div>

            <div class="button-group">
                <a href="mailto:support@example.com" class="btn btn-primary">Contact Support</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Logout</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
