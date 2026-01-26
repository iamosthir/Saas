<template>
  <div class="dashboard-modern">
    <!-- Stats Section -->
    <div class="stats-section">
      <div class="container">
        <div class="row g-3">
          <div class="col-md-6">
            <div class="stat-card">
              <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <div class="stat-content">
                <h6 class="stat-label">عدد المنتجات</h6>
                <h3 class="stat-value" v-cloak>{{ settingData.product_stock }}</h3>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="stat-card">
              <div class="stat-icon">
                <i class="fas fa-coins"></i>
              </div>
              <div class="stat-content">
                <h6 class="stat-label">السعر الإجمالي للمنتج</h6>
                <h3 class="stat-value" v-cloak>{{ settingData.total_price }} <small>IQD</small></h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="container dashboard-content" v-if="!loading">
      <!-- Quick Actions Section -->
      <div class="section-header">
        <h2><i class="fas fa-bolt"></i> الإجراءات السريعة</h2>
      </div>
      <div class="row g-4 mb-5">
        <!-- إنشاء فاتورة -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'create-invoice'}" class="dashboard-card primary">
            <div class="card-icon">
              <i class="fas fa-file-invoice"></i>
            </div>
            <h3 class="card-title">إنشاء فاتورة</h3>
            <p class="card-description">إنشاء فاتورة جديدة بسرعة</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- قائمة الفواتير -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'invoice-list'}" class="dashboard-card success">
            <div class="card-icon">
              <i class="fas fa-clipboard-list"></i>
            </div>
            <h3 class="card-title">قائمة الفواتير</h3>
            <p class="card-description">عرض وإدارة جميع الفواتير</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- قوالب الفواتير -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'invoice-templates'}" class="dashboard-card gradient-purple">
            <div class="card-icon">
              <i class="fas fa-file-alt"></i>
            </div>
            <h3 class="card-title">Invoice Templates</h3>
            <p class="card-description">Manage custom invoice templates</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- إنشاء فاتورة مخصصة -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'custom-invoice-create'}" class="dashboard-card gradient-blue">
            <div class="card-icon">
              <i class="fas fa-file-invoice"></i>
            </div>
            <h3 class="card-title">Create Custom Invoice</h3>
            <p class="card-description">Create invoice using templates</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- إدارة المخزون -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'product-stock'}" class="dashboard-card warning">
            <div class="card-icon">
              <i class="fas fa-boxes-stacked"></i>
            </div>
            <h3 class="card-title">إدارة المخزون</h3>
            <p class="card-description">متابعة المخزون والمنتجات</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- كشف حساب -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div @click="printStatement" class="dashboard-card info" style="cursor: pointer;">
            <div class="card-icon">
              <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <h3 class="card-title">كشف حساب</h3>
            <p class="card-description">طباعة كشف حساب شامل</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </div>
        </div>

        <!-- إدارة الخزينة -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'treasury'}" class="dashboard-card gradient-green">
            <div class="card-icon">
              <i class="fas fa-cash-register"></i>
            </div>
            <h3 class="card-title">إدارة الخزينة</h3>
            <p class="card-description">متابعة الإيرادات والمصروفات</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- فاتورة سريعة -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'quick-invoice'}" class="dashboard-card warning">
            <div class="card-icon">
              <i class="fas fa-bolt"></i>
            </div>
            <h3 class="card-title">فاتورة سريعة</h3>
            <p class="card-description">ملخص العميل وإنشاء فاتورة</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- تسديد دفعات جملة -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'customer-payments'}" class="dashboard-card gradient-blue">
            <div class="card-icon">
              <i class="fas fa-money-bill-wave"></i>
            </div>
            <h3 class="card-title">دفعات جملة</h3>
            <p class="card-description">تسديد عدة فواتير دفعة واحدة</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- نقطة البيع -->
        <div class="col-lg-3 col-md-4 col-sm-6" v-if="canAccessPos">
          <router-link :to="{name: 'pos'}" class="dashboard-card pos-card">
            <div class="card-icon">
              <i class="fas fa-cash-register"></i>
            </div>
            <h3 class="card-title">نقطة البيع</h3>
            <p class="card-description">نظام البيع السريع POS</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- سجل المبيعات والمرتجعات -->
        <div class="col-lg-3 col-md-4 col-sm-6" v-if="canAccessPos">
          <router-link :to="{name: 'pos.history'}" class="dashboard-card gradient-orange">
            <div class="card-icon">
              <i class="fas fa-history"></i>
            </div>
            <h3 class="card-title">سجل المبيعات</h3>
            <p class="card-description">عرض المبيعات والمرتجعات</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- إعدادات نقطة البيع -->
        <div class="col-lg-3 col-md-4 col-sm-6" v-if="role == 'super' && canAccessPos">
          <router-link :to="{name: 'pos.settings'}" class="dashboard-card info">
            <div class="card-icon">
              <i class="fas fa-cog"></i>
            </div>
            <h3 class="card-title">إعدادات POS</h3>
            <p class="card-description">تهيئة نظام نقطة البيع</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- قوالب العقود -->
        <div class="col-lg-3 col-md-4 col-sm-6" v-if="canAccessContracts">
          <router-link :to="{name: 'contract-templates'}" class="dashboard-card gradient-purple">
            <div class="card-icon">
              <i class="fas fa-file-contract"></i>
            </div>
            <h3 class="card-title">قوالب العقود</h3>
            <p class="card-description">إدارة قوالب العقود المخصصة</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- العقود -->
        <div class="col-lg-3 col-md-4 col-sm-6" v-if="canAccessContracts">
          <router-link :to="{name: 'contracts.list'}" class="dashboard-card gradient-blue">
            <div class="card-icon">
              <i class="fas fa-file-signature"></i>
            </div>
            <h3 class="card-title">العقود</h3>
            <p class="card-description">عرض وإدارة جميع العقود</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>
      </div>

      <!-- Manufacturing Section -->
      <div class="section-header" v-if="canAccessManufacturing">
        <h2><i class="fas fa-industry"></i> التصنيع والإنتاج</h2>
      </div>
      <div class="row g-4 mb-5" v-if="canAccessManufacturing">
        <!-- لوحة التصنيع -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'manufacturing.dashboard'}" class="dashboard-card gradient-teal">
            <div class="card-icon">
              <i class="fas fa-industry"></i>
            </div>
            <h3 class="card-title">لوحة التصنيع</h3>
            <p class="card-description">نظرة عامة على التصنيع والإنتاج</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- المواد الخام -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'manufacturing.raw-materials'}" class="dashboard-card gradient-orange">
            <div class="card-icon">
              <i class="fas fa-cubes"></i>
            </div>
            <h3 class="card-title">المواد الخام</h3>
            <p class="card-description">إدارة المواد الخام والمخزون</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- الوصفات -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'manufacturing.recipes'}" class="dashboard-card gradient-purple">
            <div class="card-icon">
              <i class="fas fa-clipboard-list"></i>
            </div>
            <h3 class="card-title">الوصفات</h3>
            <p class="card-description">إدارة وصفات الإنتاج</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- دفعات الإنتاج -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'manufacturing.production'}" class="dashboard-card gradient-green">
            <div class="card-icon">
              <i class="fas fa-cogs"></i>
            </div>
            <h3 class="card-title">دفعات الإنتاج</h3>
            <p class="card-description">إدارة دفعات الإنتاج</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- إنشاء دفعة إنتاج -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'manufacturing.production.create'}" class="dashboard-card primary">
            <div class="card-icon">
              <i class="fas fa-plus-circle"></i>
            </div>
            <h3 class="card-title">إنشاء دفعة إنتاج</h3>
            <p class="card-description">بدء دفعة إنتاج جديدة</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>
      </div>

      <!-- Employees Section -->
      <div class="section-header" v-if="role == 'super'">
        <h2><i class="fas fa-user-tie"></i> الموظفين والرواتب</h2>
      </div>
      <div class="row g-4 mb-5" v-if="role == 'super'">
        <!-- قائمة الموظفين -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'employees.list'}" class="dashboard-card gradient-blue">
            <div class="card-icon">
              <i class="fas fa-users"></i>
            </div>
            <h3 class="card-title">قائمة الموظفين</h3>
            <p class="card-description">إدارة بيانات الموظفين</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- جدول الرواتب -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'employees.salaries'}" class="dashboard-card warning">
            <div class="card-icon">
              <i class="fas fa-money-check-alt"></i>
            </div>
            <h3 class="card-title">جدول الرواتب</h3>
            <p class="card-description">عرض وإدارة رواتب الموظفين</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>
      </div>

      <!-- Products Section -->
      <div class="section-header">
        <h2><i class="fas fa-box-open"></i> المنتجات</h2>
      </div>
      <div class="row g-4 mb-5">
        <!-- قائمة المنتجات -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'product.list'}" class="dashboard-card gradient-blue">
            <div class="card-icon">
              <i class="fas fa-list-ul"></i>
            </div>
            <h3 class="card-title">قائمة المنتجات</h3>
            <p class="card-description">عرض وتعديل المنتجات</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- إضافة منتج -->
        <div class="col-lg-3 col-md-4 col-sm-6" v-if="role == 'super'">
          <router-link :to="{name: 'products.add'}" class="dashboard-card gradient-green">
            <div class="card-icon">
              <i class="fas fa-plus-square"></i>
            </div>
            <h3 class="card-title">إضافة منتج</h3>
            <p class="card-description">إضافة منتج جديد للمخزون</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- التصنيفات -->
        <div class="col-lg-3 col-md-4 col-sm-6" v-if="role == 'super'">
          <router-link :to="{name: 'categories'}" class="dashboard-card gradient-purple">
            <div class="card-icon">
              <i class="fas fa-tags"></i>
            </div>
            <h3 class="card-title">التصنيفات</h3>
            <p class="card-description">إدارة تصنيفات المنتجات</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- الخصائص -->
        <div class="col-lg-3 col-md-4 col-sm-6" v-if="role == 'super'">
          <router-link :to="{name: 'attributes'}" class="dashboard-card">
            <div class="card-icon">
              <i class="fas fa-sliders-h"></i>
            </div>
            <h3 class="card-title">الخصائص</h3>
            <p class="card-description">إدارة خصائص المنتجات</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>
      </div>

      <!-- Management Section -->
      <div class="section-header">
        <h2><i class="fas fa-cogs"></i> الإدارة</h2>
      </div>
      <div class="row g-4 mb-5">
        <!-- الموردين -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'supplier.list'}" class="dashboard-card">
            <div class="card-icon">
              <i class="fas fa-truck-loading"></i>
            </div>
            <h3 class="card-title">الموردين</h3>
            <p class="card-description">إدارة الموردين والمشتريات</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- الزبائن -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'customers.list'}" class="dashboard-card">
            <div class="card-icon">
              <i class="fas fa-user-friends"></i>
            </div>
            <h3 class="card-title">الزبائن</h3>
            <p class="card-description">إدارة قاعدة بيانات الزبائن</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- شركات الشحن -->
        <div class="col-lg-3 col-md-4 col-sm-6" v-if="role == 'super'">
          <router-link :to="{name: 'shipping.list'}" class="dashboard-card">
            <div class="card-icon">
              <i class="fas fa-truck-moving"></i>
            </div>
            <h3 class="card-title">شركات الشحن</h3>
            <p class="card-description">إدارة شركات الشحن</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- الصفحات -->
        <div class="col-lg-3 col-md-4 col-sm-6" v-if="role == 'super'">
          <router-link :to="{name: 'page.list'}" class="dashboard-card">
            <div class="card-icon">
              <i class="fab fa-facebook"></i>
            </div>
            <h3 class="card-title">الصفحات</h3>
            <p class="card-description">إدارة صفحات البيع</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- المصروفات -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'expense'}" class="dashboard-card">
            <div class="card-icon">
              <i class="fas fa-wallet"></i>
            </div>
            <h3 class="card-title">المصروفات</h3>
            <p class="card-description">تتبع وإدارة المصروفات</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- الأقسام -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'departments'}" class="dashboard-card">
            <div class="card-icon">
              <i class="fas fa-building"></i>
            </div>
            <h3 class="card-title">الأقسام</h3>
            <p class="card-description">تنظيم الأقسام</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- المبيعات بالجملة -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'whole-sale'}" class="dashboard-card">
            <div class="card-icon">
              <i class="fas fa-store"></i>
            </div>
            <h3 class="card-title">المبيعات بالجملة</h3>
            <p class="card-description">إدارة المبيعات بالجملة</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- الشركاء -->
        <div class="col-lg-3 col-md-4 col-sm-6">
          <router-link :to="{name: 'partner.list'}" class="dashboard-card gradient-purple">
            <div class="card-icon">
              <i class="fas fa-handshake"></i>
            </div>
            <h3 class="card-title">الشركاء</h3>
            <p class="card-description">إدارة الشركاء وتقسيم الأرباح</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>
      </div>

      <!-- Reports Section -->
      <div class="section-header">
        <h2><i class="fas fa-chart-line"></i> التقارير والإحصائيات</h2>
      </div>
      <div class="row g-4 mb-5">
        <!-- تقرير المصروفات -->
        <div class="col-lg-3 col-md-6">
          <router-link :to="{name: 'expenses.report'}" class="dashboard-card gradient-red">
            <div class="card-icon">
              <i class="fas fa-money-bill-wave"></i>
            </div>
            <h3 class="card-title">تقرير المصروفات</h3>
            <p class="card-description">تحليل شامل للمصروفات</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- تقرير المبيعات -->
        <div class="col-lg-3 col-md-6">
          <router-link :to="{name: 'sales.report'}" class="dashboard-card gradient-green">
            <div class="card-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <h3 class="card-title">تقرير المبيعات</h3>
            <p class="card-description">تحليل أداء المبيعات</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- تقرير المشتريات -->
        <div class="col-lg-3 col-md-6">
          <router-link :to="{name: 'purchases.report'}" class="dashboard-card gradient-blue">
            <div class="card-icon">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <h3 class="card-title">تقرير المشتريات</h3>
            <p class="card-description">تحليل عمليات الشراء</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- تقرير الأرباح والخسائر -->
        <div class="col-lg-3 col-md-6">
          <router-link :to="{name: 'profitloss.report'}" class="dashboard-card gradient-purple">
            <div class="card-icon">
              <i class="fas fa-balance-scale"></i>
            </div>
            <h3 class="card-title">الأرباح والخسائر</h3>
            <p class="card-description">تحليل الربحية الشامل</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>
      </div>

      <!-- System Section -->
      <div class="section-header" v-if="role == 'super'">
        <h2><i class="fas fa-shield-alt"></i> النظام</h2>
      </div>
      <div class="row g-4 mb-5" v-if="role == 'super'">
        <!-- الموظفين -->
        <div class="col-lg-3 col-md-6">
          <router-link :to="{name: 'user.list'}" class="dashboard-card">
            <div class="card-icon">
              <i class="fas fa-users"></i>
            </div>
            <h3 class="card-title">الموظفين</h3>
            <p class="card-description">إدارة المستخدمين والصلاحيات</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- باركود -->
        <div class="col-lg-3 col-md-6">
          <router-link :to="{name: 'invoice-list-barcode'}" class="dashboard-card">
            <div class="card-icon">
              <i class="fas fa-barcode"></i>
            </div>
            <h3 class="card-title">باركود</h3>
            <p class="card-description">طباعة الباركود</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>

        <!-- حسابي -->
        <div class="col-lg-3 col-md-6">
          <router-link :to="{name: 'my-profile'}" class="dashboard-card">
            <div class="card-icon">
              <i class="fas fa-user-cog"></i>
            </div>
            <h3 class="card-title">حسابي</h3>
            <p class="card-description">إدارة الحساب الشخصي</p>
            <div class="card-arrow">
              <i class="fas fa-arrow-left"></i>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return{
            role: role,
            permissions: {
                can_access_pos: false,
                can_access_contracts: false,
                can_access_manufacturing: false
            },
            loading: true,
            settingData: {
                product_stock: 0,
                total_price: 0
            }
        }
    },
    computed: {
        canAccessPos() {
            return this.permissions.can_access_pos;
        },
        canAccessContracts() {
            return this.permissions.can_access_contracts;
        },
        canAccessManufacturing() {
            return this.permissions.can_access_manufacturing;
        }
    },
    mounted() {
        this.getSettingData();
        this.getMerchantPermissions();
    },
    methods: {
        async getSettingData() {
            try {
                const response = await axios.get("/dashboard/api/get-setting-data");
                if(response.data) {
                    this.settingData = response.data;
                }
            } catch(err) {
                console.error('Error fetching setting data:', err);
            }
        },
        async getMerchantPermissions() {
            try {
                const response = await axios.get("/dashboard/api/get-merchant-permissions");
                console.log('Merchant permissions response:', response.data);
                if(response.data) {
                    this.permissions = response.data;
                    console.log('Permissions set to:', this.permissions);
                }
            } catch(err) {
                console.error('Error fetching merchant permissions:', err);
                // Keep default false values if API fails
            } finally {
                this.loading = false;
            }
        },
        printStatement() {
            window.open("/dashboard/print-statement","_blank");
        } ,
        deleteorder() {

            swal.fire({
                title: 'هل انت متأكد من حذف',
                text: " جميع طلبات الراجع ؟",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'ألغاء',
                confirmButtonText: 'تأكيد'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open("/dashboard/del-invoice","_blank");
                }
            })

        }
    },

}
</script>

<style scoped>
/* Dashboard Modern Design */
.dashboard-modern {
    min-height: 100vh;
    background: #f8f9fa;
}

/* Stats Section */
.stats-section {
    position: relative;
    z-index: 4;
    margin-top: -3rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.2);
    border-color: #667eea;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
}

.stat-content {
    flex: 1;
}

.stat-label {
    font-size: 0.9rem;
    color: #718096;
    margin-bottom: 0.25rem;
    font-weight: 500;
}

.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
}

.stat-value small {
    font-size: 1rem;
    color: #718096;
    font-weight: 600;
}

/* Content */
.dashboard-content {
    padding-bottom: 3rem;
    position: relative;
    z-index: 3;
}

/* Section Header */
.section-header {
    margin-bottom: 2rem;
}

.section-header h2 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #2d3748;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-header h2 i {
    color: #667eea;
    font-size: 1.5rem;
}

/* Dashboard Cards */
.dashboard-card {
    display: block;
    background: white;
    border-radius: 15px;
    padding: 1.75rem;
    height: 100%;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.dashboard-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.dashboard-card:hover::before {
    transform: scaleX(1);
}

.dashboard-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.2);
    border-color: #667eea;
}

.card-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.25rem;
    font-size: 1.75rem;
    color: white;
    transition: all 0.4s ease;
}

.dashboard-card:hover .card-icon {
    transform: rotate(10deg) scale(1.1);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.5rem;
    transition: color 0.3s ease;
}

.dashboard-card:hover .card-title {
    color: #667eea;
}

.card-description {
    font-size: 0.9rem;
    color: #718096;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.card-arrow {
    position: absolute;
    bottom: 1.5rem;
    left: 1.5rem;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(102, 126, 234, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #667eea;
    font-size: 1rem;
    opacity: 0;
    transform: translateX(10px);
    transition: all 0.4s ease;
}

.dashboard-card:hover .card-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* Color Variants */
.dashboard-card.primary .card-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.dashboard-card.success .card-icon {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.dashboard-card.warning .card-icon {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.dashboard-card.info .card-icon {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}

.dashboard-card.gradient-red .card-icon {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.dashboard-card.gradient-green .card-icon {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.dashboard-card.gradient-blue .card-icon {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}

.dashboard-card.gradient-purple .card-icon {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
}

.dashboard-card.gradient-orange .card-icon {
    background: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
}

.dashboard-card.pos-card .card-icon {
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
}

.dashboard-card.gradient-teal .card-icon {
    background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
}

/* Hover Color Effects */
.dashboard-card.primary:hover {
    border-color: #667eea;
}

.dashboard-card.success:hover {
    border-color: #10b981;
}

.dashboard-card.warning:hover {
    border-color: #f59e0b;
}

.dashboard-card.info:hover {
    border-color: #3b82f6;
}

.dashboard-card.gradient-red:hover {
    border-color: #ef4444;
}

.dashboard-card.gradient-green:hover {
    border-color: #10b981;
}

.dashboard-card.gradient-blue:hover {
    border-color: #3b82f6;
}

.dashboard-card.gradient-purple:hover {
    border-color: #8b5cf6;
}

.dashboard-card.gradient-orange:hover {
    border-color: #fb923c;
}

.dashboard-card.pos-card:hover {
    border-color: #14b8a6;
}

.dashboard-card.gradient-teal:hover {
    border-color: #14b8a6;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-title {
        font-size: 1.75rem;
    }

    .dashboard-subtitle {
        font-size: 0.95rem;
    }

    .section-header h2 {
        font-size: 1.4rem;
    }

    .dashboard-card {
        padding: 1.5rem;
    }

    .card-icon {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }

    .card-title {
        font-size: 1.1rem;
    }

    .card-description {
        font-size: 0.85rem;
    }
}

/* Animation Delays for Staggered Effect */
.dashboard-card {
    animation: fadeInUp 0.6s ease backwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.col-lg-3:nth-child(1) .dashboard-card { animation-delay: 0.1s; }
.col-lg-3:nth-child(2) .dashboard-card { animation-delay: 0.2s; }
.col-lg-3:nth-child(3) .dashboard-card { animation-delay: 0.3s; }
.col-lg-3:nth-child(4) .dashboard-card { animation-delay: 0.4s; }
.col-lg-3:nth-child(5) .dashboard-card { animation-delay: 0.5s; }
.col-lg-3:nth-child(6) .dashboard-card { animation-delay: 0.6s; }
</style>
