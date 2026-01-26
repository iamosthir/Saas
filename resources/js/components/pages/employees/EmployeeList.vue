<template>
  <div class="employee-list">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4 class="mb-1">إدارة الموظفين</h4>
        <p class="text-muted mb-0">إدارة موظفيك ومعلوماتهم</p>
      </div>
      <div>
        <router-link :to="{ name: 'employees.salary-list' }" class="btn btn-outline-info me-2">
          <i class="fas fa-file-invoice-dollar me-1"></i> قائمة الرواتب
        </router-link>
        <button class="btn btn-primary" @click="openModal()">
          <i class="fas fa-plus me-1"></i> إضافة موظف
        </button>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card bg-primary text-white">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title mb-0">إجمالي الموظفين</h6>
                <h3 class="mb-0">{{ stats.total }}</h3>
              </div>
              <i class="fas fa-users fa-2x opacity-50"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bg-success text-white">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title mb-0">النشطون</h6>
                <h3 class="mb-0">{{ stats.active }}</h3>
              </div>
              <i class="fas fa-user-check fa-2x opacity-50"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card bg-warning text-dark">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title mb-0">الرواتب الشهرية</h6>
                <h3 class="mb-0">{{ formatCurrency(stats.totalSalary) }}</h3>
              </div>
              <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-6">
            <input type="text" class="form-control" v-model="filters.search" placeholder="البحث بالاسم، الهاتف، أو المسمى الوظيفي..." @input="debouncedFetch">
          </div>
          <div class="col-md-4">
            <select class="form-select" v-model="filters.status" @change="fetchEmployees">
              <option value="">جميع الموظفين</option>
              <option value="active">النشطون فقط</option>
              <option value="inactive">غير النشطين فقط</option>
            </select>
          </div>
          <div class="col-md-2">
            <button class="btn btn-outline-secondary w-100" @click="resetFilters">
              <i class="fas fa-redo me-1"></i> إعادة تعيين
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Employees Table -->
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>الاسم</th>
                <th>الهاتف</th>
                <th>المسمى الوظيفي</th>
                <th>الراتب الشهري</th>
                <th>تاريخ التوظيف</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
              </tr>
            </thead>
            <tbody v-if="!loading">
              <tr v-for="emp in employees" :key="emp.id">
                <td><strong>{{ emp.full_name }}</strong></td>
                <td>{{ emp.phone || '-' }}</td>
                <td>{{ emp.job_title }}</td>
                <td>{{ formatCurrency(emp.monthly_salary) }}</td>
                <td>{{ emp.hire_date ? formatDate(emp.hire_date) : '-' }}</td>
                <td>
                  <span :class="'badge bg-' + (emp.status === 'active' ? 'success' : 'secondary')">
                    {{ emp.status === 'active' ? 'نشط' : 'غير نشط' }}
                  </span>
                </td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary" @click="openModal(emp)" title="تعديل">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-outline-warning" @click="toggleStatus(emp)" :title="emp.status === 'active' ? 'تعطيل' : 'تفعيل'">
                      <i :class="emp.status === 'active' ? 'fas fa-user-slash' : 'fas fa-user-check'"></i>
                    </button>
                    <button class="btn btn-outline-danger" @click="deleteEmployee(emp)" title="حذف">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="employees.length === 0">
                <td colspan="7" class="text-center py-4 text-muted">
                  لم يتم العثور على موظفين. انقر على "إضافة موظف" للبدء.
                </td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr>
                <td colspan="7" class="text-center py-4">
                  <div class="spinner-border text-primary"></div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3" v-if="pagination.total > 0">
          <div class="text-muted">
            عرض {{ (pagination.current_page - 1) * pagination.per_page + 1 }} - {{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }} من {{ pagination.total }}
          </div>
          <nav>
            <ul class="pagination pagination-sm mb-0">
              <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                <a class="page-link" href="#" @click.prevent="goToPage(pagination.current_page - 1)">السابق</a>
              </li>
              <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                <a class="page-link" href="#" @click.prevent="goToPage(pagination.current_page + 1)">التالي</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>

    <!-- Employee Modal -->
    <div class="modal fade" id="employeeModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ editingEmployee ? 'تعديل موظف' : 'إضافة موظف' }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form @submit.prevent="submitForm">
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">الاسم الكامل <span class="text-danger">*</span></label>
                <input type="text" class="form-control" v-model="form.full_name" required>
              </div>
              <div class="mb-3">
                <label class="form-label">الهاتف</label>
                <input type="tel" class="form-control" v-model="form.phone">
              </div>
              <div class="mb-3">
                <label class="form-label">المسمى الوظيفي <span class="text-danger">*</span></label>
                <input type="text" class="form-control" v-model="form.job_title" required placeholder="مثل: خباز، كاشير، مدير">
              </div>
              <div class="mb-3">
                <label class="form-label">الراتب الشهري <span class="text-danger">*</span></label>
                <input type="number" class="form-control" v-model="form.monthly_salary" required min="0" step="0.01">
              </div>
              <div class="mb-3">
                <label class="form-label">تاريخ التوظيف</label>
                <input type="date" class="form-control" v-model="form.hire_date">
              </div>
              <div class="mb-3" v-if="editingEmployee">
                <label class="form-label">الحالة</label>
                <select class="form-select" v-model="form.status">
                  <option value="active">نشط</option>
                  <option value="inactive">غير نشط</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">ملاحظات</label>
                <textarea class="form-control" v-model="form.notes" rows="2"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
              <button type="submit" class="btn btn-primary" :disabled="saving">
                <span v-if="saving" class="spinner-border spinner-border-sm me-1"></span>
                {{ editingEmployee ? 'تحديث' : 'إنشاء' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EmployeeList',
  data() {
    return {
      loading: false,
      saving: false,
      employees: [],
      filters: {
        search: '',
        status: '',
      },
      pagination: {
        total: 0,
        per_page: 20,
        current_page: 1,
        last_page: 1,
      },
      stats: {
        total: 0,
        active: 0,
        totalSalary: 0,
      },
      editingEmployee: null,
      form: {
        full_name: '',
        phone: '',
        job_title: '',
        monthly_salary: '',
        hire_date: '',
        status: 'active',
        notes: '',
      },
      employeeModal: null,
      debounceTimer: null,
    };
  },
  methods: {
    async fetchEmployees(page = 1) {
      this.loading = true;
      try {
        const params = { page, per_page: this.pagination.per_page, ...this.filters };
        const response = await axios.get('/dashboard/api/employees', { params });
        this.employees = response.data.data;
        this.pagination = response.data.pagination;

        this.calculateStats();
      } catch (error) {
        toastr.error('فشل تحميل الموظفين');
      } finally {
        this.loading = false;
      }
    },

    calculateStats() {
      this.stats.total = this.pagination.total;
      this.stats.active = this.employees.filter(e => e.status === 'active').length;
      this.stats.totalSalary = this.employees
        .filter(e => e.status === 'active')
        .reduce((sum, e) => sum + parseFloat(e.monthly_salary || 0), 0);
    },

    debouncedFetch() {
      clearTimeout(this.debounceTimer);
      this.debounceTimer = setTimeout(() => {
        this.fetchEmployees();
      }, 300);
    },

    resetFilters() {
      this.filters = { search: '', status: '' };
      this.fetchEmployees();
    },

    goToPage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.fetchEmployees(page);
      }
    },

    formatCurrency(value) {
      return parseFloat(value || 0).toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    },

    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },

    openModal(employee = null) {
      this.editingEmployee = employee;
      if (employee) {
        this.form = {
          full_name: employee.full_name,
          phone: employee.phone || '',
          job_title: employee.job_title,
          monthly_salary: employee.monthly_salary,
          hire_date: employee.hire_date || '',
          status: employee.status,
          notes: employee.notes || '',
        };
      } else {
        this.form = {
          full_name: '',
          phone: '',
          job_title: '',
          monthly_salary: '',
          hire_date: '',
          status: 'active',
          notes: '',
        };
      }
      this.employeeModal = new bootstrap.Modal(document.getElementById('employeeModal'));
      this.employeeModal.show();
    },

    async submitForm() {
      this.saving = true;
      try {
        if (this.editingEmployee) {
          await axios.put(`/dashboard/api/employees/${this.editingEmployee.id}`, this.form);
          toastr.success('تم تحديث الموظف');
        } else {
          await axios.post('/dashboard/api/employees', this.form);
          toastr.success('تم إنشاء الموظف');
        }
        this.employeeModal.hide();
        this.fetchEmployees(this.pagination.current_page);
      } catch (error) {
        toastr.error(error.response?.data?.message || 'فشل حفظ الموظف');
      } finally {
        this.saving = false;
      }
    },

    async toggleStatus(employee) {
      try {
        await axios.post(`/dashboard/api/employees/${employee.id}/toggle-status`);
        toastr.success('تم تحديث الحالة');
        this.fetchEmployees(this.pagination.current_page);
      } catch (error) {
        toastr.error('فشل تحديث الحالة');
      }
    },

    async deleteEmployee(employee) {
      const result = await swal.fire({
        title: 'حذف الموظف؟',
        text: `هل أنت متأكد من حذف "${employee.full_name}"؟`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'نعم، احذف',
      });

      if (result.isConfirmed) {
        try {
          await axios.delete(`/dashboard/api/employees/${employee.id}`);
          toastr.success('تم حذف الموظف');
          this.fetchEmployees(this.pagination.current_page);
        } catch (error) {
          toastr.error('فشل حذف الموظف');
        }
      }
    },
  },
  mounted() {
    this.fetchEmployees();
  },
};
</script>
