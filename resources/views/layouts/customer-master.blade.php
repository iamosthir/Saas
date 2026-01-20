<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>بوابة العملاء</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"/>
    {{-- MDB --}}
    <link rel="stylesheet" href="{{ asset("css/mdb.rtl.min.css") }}">
    {{-- End --}}
    <style>
        /* ============================================
           COLORFUL HEADER STYLES
        ============================================ */
        header {
            margin-bottom: 0 !important;
        }

        .navbar {
            background: #ffffff !important;
            padding: 1.5rem 0;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            border-bottom: 3px solid #f0f0f0;
        }

        .navbar-brand img {
            height: 20px;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.1) rotate(5deg);
        }

        .navbar-toggler {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1rem;
        }

        .navbar-toggler i {
            color: white;
            font-size: 1.2rem;
        }

        .navbar-nav {
            gap: 0.5rem;
        }

        .navbar-nav .nav-link {
            color: #2d3748 !important;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border-radius: 16px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            margin: 0.25rem;
            background: #f7fafc;
            border: 2px solid transparent;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            min-width: 100px;
        }

        .navbar-nav .nav-link i {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        /* Colorful Icons */
        .nav-link:nth-child(1) i { color: #667eea; }
        .nav-link:nth-child(2) i { color: #f093fb; }
        .nav-link:nth-child(3) i { color: #ff6b6b; }

        .navbar-nav .nav-link:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }

        .navbar-nav .nav-link:hover i {
            transform: scale(1.2) rotate(10deg);
        }

        /* Hover colors */
        .nav-link:nth-child(1):hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            border-color: #667eea;
        }
        .nav-link:nth-child(2):hover {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white !important;
            border-color: #f093fb;
        }
        .nav-link:nth-child(3):hover {
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa502 100%);
            color: white !important;
            border-color: #ff6b6b;
        }

        .navbar-nav .nav-link:hover i {
            color: white !important;
        }

        .navbar-nav .nav-link.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white !important;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            transform: translateY(-5px);
        }

        .navbar-nav .nav-link.active i {
            color: white !important;
            transform: scale(1.15);
        }

        .navbar .dropdown-toggle {
            border: 4px solid #f0f0f0;
            border-radius: 50%;
            padding: 0.3rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            transition: all 0.4s ease;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }

        .navbar .dropdown-toggle:hover {
            transform: rotate(360deg) scale(1.15);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.5);
        }

        .navbar .dropdown-toggle img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            object-fit: cover;
            border: 3px solid white;
        }

        .navbar h5 {
            color: #2d3748;
            margin: 0;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
            border-radius: 16px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .dropdown-item {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: translateX(-5px);
        }

        .dropdown-item i {
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }

        /* ============================================
           PAGE HEADER BANNER
        ============================================ */
        .page-header-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 3rem 0 4rem 0;
            position: relative;
            color: white;
            margin: 0;
            width: 100%;
        }

        .page-header-banner::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: #f8f9fa;
            border-radius: 50% 50% 0 0 / 100% 100% 0 0;
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .page-title {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
            position: relative;
            z-index: 2;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .page-title i {
            margin-left: 1rem;
        }

        .page-subtitle {
            text-align: center;
            font-size: 1rem;
            opacity: 0.95;
            position: relative;
            z-index: 2;
            margin-bottom: 0;
        }

        .content {
            margin-top: 0 !important;
            padding: 2rem 1rem;
            background: #f8f9fa;
            min-height: calc(100vh - 400px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ============================================
           RESPONSIVE DESIGN
        ============================================ */
        @media (max-width: 768px) {
            .navbar h5 {
                font-size: 1rem;
            }
        }
    </style>
    @yield('extra-css')
</head>
<body>
    <section id="customer-portal">
        <header>
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <!-- Toggle button -->
                    <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>

                    <!-- Collapsible wrapper -->
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Navbar brand -->
                        <a class="navbar-brand mt-2 mt-lg-0" href="{{ route('customer.dashboard') }}">
                            <img src="{{ auth()->guard('customer')->user()->merchant->logo ?? asset('/images/logo.png') }}" alt="Logo" loading="lazy"/>
                        </a>

                        <!-- Navigation links -->
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a href="{{ route('customer.dashboard') }}" class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-home"></i> الرئيسية
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('customer.invoices') }}" class="nav-link {{ request()->routeIs('customer.invoices*') ? 'active' : '' }}">
                                    <i class="fas fa-file-invoice"></i> فواتيري
                                </a>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('customer.logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="nav-link" style="background: none; border: none; cursor: pointer;">
                                        <i class="fas fa-sign-out-alt"></i> تسجيل خروج
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <!-- Right elements -->
                    <div class="d-flex align-items-center">
                        <h5 class="me-3 d-none d-md-block"><strong>{{ auth()->guard('customer')->user()->customer_name }}</strong></h5>

                        <div class="dropdown">
                            <a class="dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownMenuAvatar" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                                <img src="{{ auth()->guard('customer')->user()->merchant->logo ?? asset('/images/logo.png') }}" alt="Avatar" loading="lazy"/>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                                <li>
                                    <a href="{{ route('customer.dashboard') }}" class="dropdown-item">
                                        <i class="fas fa-home"></i> الرئيسية
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('customer.invoices') }}" class="dropdown-item">
                                        <i class="fas fa-file-invoice"></i> فواتيري
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('customer.logout') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger" style="background: none; border: none; width: 100%; text-align: right; cursor: pointer;">
                                            <i class="fas fa-sign-out-alt"></i> تسجيل خروج
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Page Header Banner -->
        <div class="page-header-banner">
            <div class="hero-container">
                <h1 class="page-title">
                    @yield('page-icon', '<i class="fas fa-user"></i>')
                    @yield('page-title', 'بوابة العملاء')
                </h1>
                @if(View::hasSection('page-subtitle'))
                    <p class="page-subtitle">@yield('page-subtitle')</p>
                @endif
            </div>
        </div>

        <section class="content">
            @yield("content")
        </section>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset("js/mdb.min.js") }}"></script>
    @yield('extra-js')
</body>
</html>
