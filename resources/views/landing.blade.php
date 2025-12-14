<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختر خطتك</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="#">
                    <i class="fas fa-store"></i> مركز التجار
                </a>
                <div class="me-auto">
                    <a href="{{ route('login') }}" class="btn btn-login">
                        <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Banner with Curve -->
    <section class="hero-banner">
        <div class="container">
            <div class="hero-content">
                <h1>اختر الخطة المثالية لك</h1>
                <p>اختر خطة الاشتراك التي تناسب احتياجات عملك وابدأ بالنمو اليوم</p>
            </div>
        </div>
    </section>

    <!-- Plans Section -->
    <section class="plans-section">
        <div class="container">
            <div class="section-title">
                <h2>خطط الاشتراك لدينا</h2>
                <p>خيارات تسعير مرنة مصممة للشركات من جميع الأحجام</p>
            </div>

            <div class="row">
                @forelse($plans as $index => $plan)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="plan-card {{ $index === 1 ? 'featured' : '' }}">
                        @if($index === 1)
                        <div class="plan-badge">الأكثر شعبية</div>
                        @endif

                        <div class="plan-icon">
                            <i class="fas fa-{{ $index === 0 ? 'rocket' : ($index === 1 ? 'star' : ($index === 2 ? 'crown' : 'gem')) }}"></i>
                        </div>

                        <h3 class="plan-name">{{ $plan->name }}</h3>
                        <p class="plan-description">{{ $plan->description ?? 'مثالي للأعمال المتنامية' }}</p>

                        <div class="plan-divider"></div>

                        @if($plan->price > 0)
                        <div class="plan-price">
                            {{ number_format($plan->price, 0) }} <small style="font-size: 1.2rem; font-weight: 600;">دينار</small>
                        </div>
                        @else
                        <div class="plan-price" style="color: #10b981;">
                            مجاني
                        </div>
                        @endif
                        <p class="plan-duration">اشتراك لمدة {{ $plan->duration }} يوم</p>

                        <div class="plan-divider"></div>

                        <a href="{{ route('merchant.register.form', $plan->id) }}" class="btn btn-get-now">
                            ابدأ الآن
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> لا توجد خطط اشتراك متاحة في الوقت الحالي.
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; {{ date('Y') }} مركز التجار. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
