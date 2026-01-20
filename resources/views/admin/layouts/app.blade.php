<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة تحكم المدير') - Super Admin</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <!-- Bootstrap RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #e94560 0%, #1a1a2e 100%);
            --sidebar-width: 280px;
            --primary-color: #e94560;
            --dark-color: #1a1a2e;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem 1rem;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: -5px 0 20px rgba(0, 0, 0, 0.1);
        }

        .admin-sidebar .logo {
            font-size: 1.4rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .admin-sidebar .logo i {
            font-size: 2rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        .admin-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateX(-5px);
        }

        .admin-sidebar .nav-link i {
            width: 25px;
            margin-left: 0.75rem;
            font-size: 1.1rem;
        }

        .admin-sidebar hr {
            border-color: rgba(255, 255, 255, 0.2);
            margin: 1rem 0;
        }

        .admin-sidebar .logout-btn {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            border-radius: 10px;
            width: 100%;
            text-align: right;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }

        .admin-sidebar .logout-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .admin-sidebar .logout-btn i {
            width: 25px;
            margin-left: 0.75rem;
        }

        /* Main Content */
        .admin-content {
            margin-right: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
        }

        .admin-header {
            background: white;
            padding: 1.25rem 2rem;
            margin: -2rem -2rem 2rem -2rem;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid var(--primary-color);
        }

        .admin-header h4 {
            margin: 0;
            color: var(--dark-color);
            font-weight: 600;
        }

        .admin-header .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-header .user-info .avatar {
            width: 40px;
            height: 40px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-card h6 {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .stat-card h3 {
            margin: 0;
            font-weight: 700;
            color: var(--dark-color);
        }

        /* Table Card */
        .table-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .table-card .card-header {
            background: var(--primary-gradient);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            border: none;
        }

        .table-card .table {
            margin: 0;
        }

        .table-card .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: var(--dark-color);
            border-bottom: 2px solid #dee2e6;
        }

        .table-card .table td {
            vertical-align: middle;
        }

        /* Buttons */
        .btn-gradient {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s;
            font-weight: 500;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(233, 69, 96, 0.4);
            color: white;
        }

        .btn-sm.btn-gradient {
            padding: 0.35rem 1rem;
            font-size: 0.85rem;
        }

        /* Badges */
        .badge-status {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .badge-active {
            background: #d4edda;
            color: #155724;
        }

        .badge-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-expired {
            background: #fff3cd;
            color: #856404;
        }

        .badge-expiring {
            background: #cce5ff;
            color: #004085;
        }

        /* Form Controls */
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        /* Alerts */
        .alert {
            border-radius: 10px;
            border: none;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        /* Pagination */
        .pagination .page-link {
            border-radius: 10px;
            margin: 0 3px;
            color: var(--primary-color);
            border: none;
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-gradient);
            border: none;
        }

        /* Mobile Responsive */
        @media (max-width: 991px) {
            .admin-sidebar {
                transform: translateX(100%);
                transition: transform 0.3s;
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-content {
                margin-right: 0;
            }

            .mobile-toggle {
                display: block !important;
            }
        }

        .mobile-toggle {
            display: none;
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 10px;
        }

        /* Card */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background: var(--primary-gradient);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Back Link */
        .back-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s;
        }

        .back-link:hover {
            color: var(--dark-color);
            transform: translateX(5px);
        }

        /* Action Buttons */
        .action-btns {
            display: flex;
            gap: 0.5rem;
        }

        .action-btns .btn {
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="sidebar">
        <div class="logo">
            <i class="fas fa-shield-alt"></i>
            Super Admin
        </div>

        <nav class="nav flex-column">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> الرئيسية
            </a>
            <a href="{{ route('admin.merchants.index') }}" class="nav-link {{ request()->routeIs('admin.merchants.*') ? 'active' : '' }}">
                <i class="fas fa-store"></i> التجار
            </a>
            <a href="{{ route('admin.subscriptions.index') }}" class="nav-link {{ request()->routeIs('admin.subscriptions.index') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i> الاشتراكات
            </a>
            <a href="{{ route('admin.subscriptions.plans') }}" class="nav-link {{ request()->routeIs('admin.subscriptions.plans') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> باقات الاشتراك
            </a>
            <a href="{{ route('admin.profile.edit') }}" class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i> الملف الشخصي
            </a>

            <hr>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="admin-content">
        <div class="admin-header">
            <div class="d-flex align-items-center gap-3">
                <button class="mobile-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h4>@yield('page-title', 'لوحة التحكم')</h4>
            </div>
            <div class="user-info">
                <span class="d-none d-md-inline">{{ auth()->guard('admin')->user()->name }}</span>
                <div class="avatar">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-toggle');
            if (window.innerWidth <= 991) {
                if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
