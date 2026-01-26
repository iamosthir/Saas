<template>
  <div class="salary-list">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4 class="mb-1">قائمة الرواتب</h4>
        <p class="text-muted mb-0">نظرة عامة على الرواتب الشهرية للموظفين النشطين</p>
      </div>
      <router-link :to="{ name: 'employees.list' }" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> العودة للموظفين
      </router-link>
    </div>

    <!-- Summary Card -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="row text-center">
          <div class="col-md-4">
            <h6 class="text-muted mb-1">الموظفون النشطون</h6>
            <h3 class="text-primary mb-0">{{ salaryData.employee_count }}</h3>
          </div>
          <div class="col-md-4">
            <h6 class="text-muted mb-1">إجمالي الرواتب الشهرية</h6>
            <h3 class="text-success mb-0">{{ formatCurrency(salaryData.total_salary) }}</h3>
          </div>
          <div class="col-md-4">
            <h6 class="text-muted mb-1">متوسط الراتب</h6>
            <h3 class="text-info mb-0">{{ formatCurrency(averageSalary) }}</h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Salary Table -->
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">تفصيل الرواتب</h5>
        <button class="btn btn-sm btn-outline-primary" @click="printSalaryList">
          <i class="fas fa-print me-1"></i> طباعة
        </button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table" id="salaryTable">
            <thead>
              <tr>
                <th>#</th>
                <th>اسم الموظف</th>
                <th>المسمى الوظيفي</th>
                <th class="text-end">الراتب الشهري</th>
              </tr>
            </thead>
            <tbody v-if="!loading">
              <tr v-for="(emp, index) in salaryData.employees" :key="emp.id">
                <td>{{ index + 1 }}</td>
                <td><strong>{{ emp.full_name }}</strong></td>
                <td>{{ emp.job_title }}</td>
                <td class="text-end">{{ formatCurrency(emp.monthly_salary) }}</td>
              </tr>
              <tr v-if="salaryData.employees?.length === 0">
                <td colspan="4" class="text-center py-4 text-muted">
                  لم يتم العثور على موظفين نشطين.
                </td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr>
                <td colspan="4" class="text-center py-4">
                  <div class="spinner-border text-primary"></div>
                </td>
              </tr>
            </tbody>
            <tfoot v-if="salaryData.employees?.length > 0">
              <tr class="table-light">
                <th colspan="3" class="text-end">الإجمالي:</th>
                <th class="text-end">{{ formatCurrency(salaryData.total_salary) }}</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>

    <!-- Salary Distribution Chart (simple) -->
    <div class="card mt-4" v-if="salaryData.employees?.length > 0">
      <div class="card-header">
        <h5 class="mb-0">توزيع الرواتب حسب المسمى الوظيفي</h5>
      </div>
      <div class="card-body">
        <div v-for="(group, title) in groupedByJobTitle" :key="title" class="mb-3">
          <div class="d-flex justify-content-between mb-1">
            <span>{{ title }}</span>
            <span>{{ group.count }} موظف - {{ formatCurrency(group.total) }}</span>
          </div>
          <div class="progress" style="height: 20px;">
            <div class="progress-bar" :style="{ width: (group.total / salaryData.total_salary * 100) + '%' }">
              {{ Math.round(group.total / salaryData.total_salary * 100) }}%
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SalaryList',
  data() {
    return {
      loading: false,
      salaryData: {
        employees: [],
        total_salary: 0,
        employee_count: 0,
      },
    };
  },
  computed: {
    averageSalary() {
      if (this.salaryData.employee_count === 0) return 0;
      return this.salaryData.total_salary / this.salaryData.employee_count;
    },
    groupedByJobTitle() {
      const grouped = {};
      (this.salaryData.employees || []).forEach(emp => {
        if (!grouped[emp.job_title]) {
          grouped[emp.job_title] = { count: 0, total: 0 };
        }
        grouped[emp.job_title].count++;
        grouped[emp.job_title].total += parseFloat(emp.monthly_salary || 0);
      });
      return grouped;
    },
  },
  methods: {
    async fetchSalaryList() {
      this.loading = true;
      try {
        const response = await axios.get('/dashboard/api/employees/salary-list');
        this.salaryData = response.data.data;
      } catch (error) {
        toastr.error('فشل تحميل قائمة الرواتب');
      } finally {
        this.loading = false;
      }
    },

    formatCurrency(value) {
      return parseFloat(value || 0).toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    },

    printSalaryList() {
      const printContent = document.getElementById('salaryTable').outerHTML;
      const printWindow = window.open('', '_blank');
      printWindow.document.write(`
        <html>
          <head>
            <title>قائمة الرواتب</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
              body { padding: 20px; }
              @media print { .no-print { display: none; } }
            </style>
          </head>
          <body>
            <h2 class="mb-4">قائمة الرواتب الشهرية</h2>
            <p>تم الإنشاء: ${new Date().toLocaleDateString()}</p>
            ${printContent}
          </body>
        </html>
      `);
      printWindow.document.close();
      printWindow.onload = function() {
        printWindow.print();
      };
    },
  },
  mounted() {
    this.fetchSalaryList();
  },
};
</script>
