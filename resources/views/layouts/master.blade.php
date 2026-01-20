<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"/>
    {{-- MDB --}}
    <link rel="stylesheet" href="{{ asset("css/mdb.rtl.min.css") }}">
    {{-- End --}}
    {{-- css --}}
    <link rel="stylesheet" href="{{ asset("css/app.css") }}">
    {{-- end --}}
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
        .nav-link:nth-child(3) i { color: #4facfe; }
        .nav-link:nth-child(4) i { color: #43e97b; }
        .nav-link:nth-child(5) i { color: #fa709a; }
        .nav-link:nth-child(6) i { color: #feca57; }
        .nav-link:nth-child(7) i { color: #ff6b6b; }

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
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white !important;
            border-color: #4facfe;
        }
        .nav-link:nth-child(4):hover {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white !important;
            border-color: #43e97b;
        }
        .nav-link:nth-child(5):hover {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white !important;
            border-color: #fa709a;
        }
        .nav-link:nth-child(6):hover {
            background: linear-gradient(135deg, #feca57 0%, #ff9ff3 100%);
            color: white !important;
            border-color: #feca57;
        }
        .nav-link:nth-child(7):hover {
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa502 100%);
            color: white !important;
            border-color: #ff6b6b;
        }

        .navbar-nav .nav-link:hover i {
            color: white !important;
        }

        .navbar-nav .nav-link.router-link-active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white !important;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            transform: translateY(-5px);
        }

        .navbar-nav .nav-link.router-link-active i {
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
           SIDEBAR STYLES
        ============================================ */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(102, 126, 234, 0.4);
            backdrop-filter: blur(8px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s ease;
            z-index: 9999;
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .sidebar {
            position: fixed;
            top: 0;
            right: -450px;
            width: 420px;
            height: 100vh;
            background: white;
            box-shadow: -10px 0 40px rgba(0, 0, 0, 0.2);
            transition: all 0.5s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar-overlay.show .sidebar {
            right: 0;
        }

        .sidebar-head {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem 1.5rem;
            color: white;
            position: relative;
        }

        .sidebar-head h6 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
        }

        .sidebar-head h6 span {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-right: 0.5rem;
        }

        .close-btn {
            position: absolute;
            top: 1.5rem;
            left: 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .sidebar-body {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
        }

        .sidebar-body .list-group-item {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 1rem 1.25rem !important;
            margin-bottom: 0.75rem !important;
            color: white !important;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .sidebar-body .list-group-item:hover {
            transform: translateX(-5px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .sidebar-body .badge {
            background: rgba(255, 255, 255, 0.25) !important;
            color: white !important;
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            background: #f8f9fa;
        }

        .sidebar-footer label {
            color: #4a5568;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .sidebar-footer .form-control,
        .sidebar-footer .form-select {
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .sidebar-footer .form-control:focus,
        .sidebar-footer .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .sidebar .btn {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            margin: 0.25rem;
        }

        .sidebar .btn-success {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%) !important;
            box-shadow: 0 4px 15px rgba(86, 171, 47, 0.3);
        }

        .sidebar .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(86, 171, 47, 0.5);
        }

        .sidebar div[style*="display: flex"] {
            display: flex !important;
            gap: 0.5rem !important;
            flex-wrap: wrap;
            padding: 1.5rem;
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
            margin-bottom: 4.5rem;
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
        }

        /* ============================================
           RESPONSIVE DESIGN
        ============================================ */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                right: -100%;
            }

            .navbar h5 {
                font-size: 1rem;
            }
        }
    </style>

</head>
<body>
    <section id="dashboard">
        <vue-progress-bar></vue-progress-bar>
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
                        <a class="navbar-brand mt-2 mt-lg-0" href="/dashboard/home">
                            <img src="{{ auth()->user()->merchant->logo ?? asset('/images/logo.png') }}" alt="Logo" loading="lazy"/>
                        </a>


                        <!-- Navigation links -->
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <router-link :to="{name: 'dashboard'}" class="nav-link">
                                    <i class="fas fa-home"></i> الرئيسية
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'create-invoice'}" class="nav-link">
                                    <i class="fas fa-plus"></i> أنشاء طلب
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'invoice-list'}" class="nav-link">
                                    <i class="fas fa-list"></i> قائمة الطلبات
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'invoice-list-padding'}" class="nav-link">
                                    <i class="fas fa-shipping-fast"></i> جاري الشحن
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'invoice-list-complate'}" class="nav-link">
                                    <i class="fas fa-check-circle"></i> تم التوصيل
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'invoice-list-cancel'}" class="nav-link">
                                    <i class="fas fa-undo"></i> الراجع
                                </router-link>
                            </li>
                            @if(auth()->user()->role=='super')
                            <li class="nav-item">
                                <router-link :to="{name: 'user.list'}" class="nav-link">
                                    <i class="fas fa-users"></i> الموظفين
                                </router-link>
                            </li>
                            @endif
                            @if(auth()->user()->merchant && auth()->user()->merchant->canAccessPos())
                            <li class="nav-item">
                                <router-link :to="{name: 'pos'}" class="nav-link">
                                    <i class="fas fa-cash-register"></i> نقطة البيع
                                </router-link>
                            </li>
                            @endif
                            @if(auth()->user()->merchant && auth()->user()->merchant->canAccessContracts())
                            <li class="nav-item">
                                <router-link :to="{name: 'contracts.list'}" class="nav-link">
                                    <i class="fas fa-file-contract"></i> العقود
                                </router-link>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Right elements -->
                    <div class="d-flex align-items-center">
                        <button v-cloak @click="showSidebar2=true" v-if="editinvoiceQuee.length > 0" class="btn btn-sm btn-warning me-3">
                            <i class="fas fa-edit me-1"></i> تعديل (@{{ editinvoiceQuee.length }})
                        </button>
                        <button v-cloak @click="showSidebar=true" v-if="printQuee.length > 0" class="btn btn-sm btn-warning me-3">
                            <i class="fas fa-print me-1"></i> طبع (@{{ printQuee.length }})
                        </button>

                        <h5 class="me-3 d-none d-md-block"><strong>{{ auth()->user()->name }}</strong></h5>

                        <div class="dropdown">
                            <a class="dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownMenuAvatar" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                                <img src="{{ auth()->user()->merchant->logo ?? asset('/images/logo.png') }}" alt="Avatar" loading="lazy"/>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                                <li>
                                    <router-link :to="{name: 'my-profile'}" class="dropdown-item">
                                        <i class="fas fa-user"></i> حسابي
                                    </router-link>
                                </li>
                                @if (auth()->user()->role == "super")
                                <li>
                                    <router-link :to="{name: 'merchant-profile'}" class="dropdown-item">
                                        <i class="fas fa-building"></i> الملف التجاري
                                    </router-link>
                                </li>
                                <li>
                                    <router-link :to="{name: 'user.list'}" class="dropdown-item">
                                        <i class="fas fa-user-group"></i> جميع المستخدمين
                                    </router-link>
                                </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item text-danger" href="#">
                                        <i class="fas fa-sign-out-alt"></i> تسجيل خروج
                                    </a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
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
                    <i :class="pageIcon"></i>
                    @{{ pageTitle }}
                </h1>
                <p class="page-subtitle" v-if="pageSubtitle">@{{ pageSubtitle }}</p>
            </div>
        </div>

        <section class="content">
            @yield("content")
        </section>

        <!-- Print Sidebar -->
        <div class="sidebar-overlay" :class="{'show' : showSidebar}" v-if="printQuee.length > 0">
            <div class="sidebar">
                <div class="sidebar-head">
                    <button @click="showSidebar=false" class="close-btn ripple"><i class="fas fa-times"></i></button>
                    <h6>PRINT JOB - <span>@{{ printQuee.length }} invoices</span></h6>
                </div>
                <div class="sidebar-body">
                    <ul class="list-group list-group-light">
                        <li v-for="(quee,i) in printQuee" :key="i" class="list-group-item px-3 border-0 active mb-1" aria-current="true">
                          <b>@{{ i+1 }} - </b><span class="badge badge-warning">#@{{ quee }}</span>
                        </li>
                    </ul>
                </div>

                <div style="display: flex; gap: 10px;">
                     <button @click="sendviapi" class="btn btn-success">ارسال الى شركة شحن</button>
                     <button @click="printInvoice" class="btn btn-success">طباعة</button>
                    <button @click="printInvoiceimages" class="btn btn-success">طباعة مع صور المنتج</button>
                </div>

                <div class="sidebar-footer">
                    <label for="">عدد النسخ</label>
                    <input class="form-control mb-2" type="number" placeholder="عدد النسخ" v-model="printCopy" >
                </div>
            </div>
        </div>

        <!-- Edit Sidebar -->
        <div class="sidebar-overlay" :class="{'show' : showSidebar2}" v-if="editinvoiceQuee.length > 0">
            <div class="sidebar">
                <div class="sidebar-head">
                    <button @click="showSidebar2=false" class="close-btn ripple"><i class="fas fa-times"></i></button>
                    <h6>EDIT JOB - <span>@{{ editinvoiceQuee.length }} invoices</span></h6>
                </div>
                <div class="sidebar-body">
                    <ul class="list-group list-group-light">
                        <li v-for="(quee,i) in editinvoiceQuee" :key="i" class="list-group-item px-3 border-0 active mb-1" aria-current="true">
                          <b>@{{ i+1 }} - </b><span class="badge badge-warning">#@{{ quee }}</span>
                        </li>
                    </ul>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button @click="sendviapi" class="btn btn-success">ارسال الى شركة شحن</button>
                    <button @click="changestatus" class="btn btn-success">تغيير الحالة</button>
                    <button @click="editinvoice" class="btn btn-success">طباعة</button>
                    <button @click="printInvoiceimages" class="btn btn-success">طباعة مع صور المنتج</button>
                </div>

                <div class="sidebar-footer">
                    <label for="">عدد النسخ</label>
                    <input class="form-control mb-2" type="number" placeholder="عدد النسخ" v-model="printCopy" >

                    <label for="">الحالة</label>
                    <select class="form-select" v-model="status">
                        <option value="">الكل</option>
                        <option value="pending">جاري شحن</option>
                        <option value="completed">واصل تم</option>
                        <option value="canceled">راجع</option>
                        <option value="delayed">مؤجل</option>
                    </select>
                </div>
            </div>
        </div>

    </section>

    <script>
        window.role = "{{ auth()->user()->role }}";
    </script>
    <script>
        function editInvoiceimages() {
          window.location.href = '/dashboard/changeStatus/' + string + '/changeto/' + this.status;
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script>
        // window.permission =
    </script>

    {{-- TinyMCE WYSIWYG Editor CDN --}}
    <script src="https://cdn.tiny.cloud/1/8hgwz05ibupwpkaf95wj0q1h0dflp1fiivbr4ip2q0jr2343/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

    {{-- script --}}
    <script type="text/javascript" src="{{ asset("js/app.js") }}"></script>

</body>
</html>
