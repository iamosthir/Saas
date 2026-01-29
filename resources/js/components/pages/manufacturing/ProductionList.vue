<template>
  <div class="production-list">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4 class="mb-1">دفعات الإنتاج</h4>
        <p class="text-muted mb-0">إدارة وتتبع عمليات الإنتاج الخاصة بك</p>
      </div>
      <router-link :to="{ name: 'manufacturing.production.create' }" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> إنتاج جديد
      </router-link>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-3">
            <select class="form-select" v-model="filters.status" @change="fetchBatches">
              <option value="">جميع الحالات</option>
              <option value="draft">مسودة</option>
              <option value="in_progress">قيد التنفيذ</option>
              <option value="completed">مكتمل</option>
              <option value="cancelled">ملغي</option>
            </select>
          </div>
          <div class="col-md-3">
            <input type="date" class="form-control" v-model="filters.date_from" @change="fetchBatches" placeholder="من تاريخ">
          </div>
          <div class="col-md-3">
            <input type="date" class="form-control" v-model="filters.date_to" @change="fetchBatches" placeholder="إلى تاريخ">
          </div>
          <div class="col-md-3">
            <button class="btn btn-outline-secondary w-100" @click="resetFilters">
              <i class="fas fa-redo me-1"></i> إعادة تعيين
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Batches Table -->
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>رقم الدفعة</th>
                <th>المنتج</th>
                <th>الوصفة</th>
                <th>التاريخ</th>
                <th>المخطط</th>
                <th>الفعلي</th>
                <th>التكلفة الإجمالية</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
              </tr>
            </thead>
            <tbody v-if="!loading">
              <tr v-for="batch in batches" :key="batch.id">
                <td><strong>{{ batch.batch_number }}</strong></td>
                <td>
                  {{ batch.product?.name }}
                  <span v-if="batch.product_variation" class="text-muted">
                    ({{ batch.product_variation.var_name }})
                  </span>
                </td>
                <td>{{ batch.recipe?.name }}</td>
                <td>{{ formatDate(batch.production_date) }}</td>
                <td>{{ batch.planned_quantity }}</td>
                <td>{{ batch.actual_quantity || '-' }}</td>
                <td>{{ formatCurrency(batch.total_cost) }}</td>
                <td>
                  <span :class="'badge bg-' + getStatusColor(batch.status)">
                    {{ formatStatus(batch.status) }}
                  </span>
                </td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <button v-if="batch.status === 'draft'" class="btn btn-outline-primary" @click="startBatch(batch)" title="بدء الإنتاج">
                      <i class="fas fa-play"></i>
                    </button>
                    <button v-if="['draft', 'in_progress'].includes(batch.status)" class="btn btn-outline-success" @click="openCompleteModal(batch)" title="إكمال">
                      <i class="fas fa-check"></i>
                    </button>
                    <button class="btn btn-outline-info" @click="viewDetails(batch)" title="عرض التفاصيل">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button v-if="batch.status === 'completed'" class="btn btn-outline-secondary" @click="cloneBatch(batch)" title="استنساخ">
                      <i class="fas fa-copy"></i>
                    </button>
                    <button v-if="['draft', 'in_progress', 'completed'].includes(batch.status)" class="btn btn-outline-warning" @click="openEditModal(batch)" title="تعديل">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button v-if="['draft', 'in_progress'].includes(batch.status)" class="btn btn-outline-danger" @click="cancelBatch(batch)" title="إلغاء">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="batches.length === 0">
                <td colspan="9" class="text-center py-4 text-muted">
                  لم يتم العثور على دفعات إنتاج. <router-link :to="{ name: 'manufacturing.production.create' }">ابدأ إنتاجك الأول</router-link>
                </td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr>
                <td colspan="9" class="text-center py-4">
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

    <!-- Complete Modal -->
    <div class="modal fade" id="completeModal" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">إكمال الإنتاج: {{ selectedBatch?.batch_number }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body" v-if="selectedBatch">
            <div class="mb-3">
              <label class="form-label">كمية الإنتاج الفعلية <span class="text-danger">*</span></label>
              <input type="number" class="form-control" v-model="completeForm.actual_quantity" min="0" step="0.01">
              <small class="text-muted">المخطط: {{ selectedBatch.planned_quantity }}</small>
            </div>

            <h6 class="mb-3">الاستخدام الفعلي للمكونات</h6>
            <p class="text-muted small">اترك فارغاً لاستخدام الكميات المطلوبة</p>
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>المادة</th>
                  <th>المطلوب</th>
                  <th>المستخدم فعلياً</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="ing in selectedBatch.ingredients" :key="ing.id">
                  <td>{{ ing.raw_material?.name }}</td>
                  <td>{{ ing.required_quantity }} {{ ing.unit?.symbol }}</td>
                  <td>
                    <input type="number" class="form-control form-control-sm" v-model="completeForm.actual_ingredients[ing.raw_material_id]" min="0" step="0.0001" :placeholder="ing.required_quantity">
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
            <button type="button" class="btn btn-success" @click="submitComplete" :disabled="completing">
              <span v-if="completing" class="spinner-border spinner-border-sm me-1"></span>
              إكمال الإنتاج
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">تعديل الإنتاج: {{ selectedBatch?.batch_number }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body" v-if="selectedBatch">
            <div class="mb-3">
              <label class="form-label">تاريخ الإنتاج</label>
              <input type="date" class="form-control" v-model="editForm.production_date">
            </div>
            <div class="mb-3">
              <label class="form-label">تاريخ انتهاء الصلاحية</label>
              <input type="date" class="form-control" v-model="editForm.expiry_date">
            </div>
            <div class="mb-3">
              <label class="form-label">تكلفة العمالة</label>
              <input type="number" class="form-control" v-model="editForm.labor_cost" min="0" step="0.01">
            </div>
            <div class="mb-3">
              <label class="form-label">التكاليف الإضافية</label>
              <input type="number" class="form-control" v-model="editForm.overhead_cost" min="0" step="0.01">
            </div>
            <div class="mb-3">
              <label class="form-label">ملاحظات</label>
              <textarea class="form-control" v-model="editForm.notes" rows="3"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
            <button type="button" class="btn btn-primary" @click="submitEdit" :disabled="editing">
              <span v-if="editing" class="spinner-border spinner-border-sm me-1"></span>
              حفظ التغييرات
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">الدفعة: {{ selectedBatch?.batch_number }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body" v-if="selectedBatch">
            <div class="row mb-3">
              <div class="col-md-4">
                <strong>المنتج:</strong><br>
                {{ selectedBatch.product?.name }}
              </div>
              <div class="col-md-4">
                <strong>الحالة:</strong><br>
                <span :class="'badge bg-' + getStatusColor(selectedBatch.status)">
                  {{ formatStatus(selectedBatch.status) }}
                </span>
              </div>
              <div class="col-md-4">
                <strong>تاريخ الإنتاج:</strong><br>
                {{ formatDate(selectedBatch.production_date) }}
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-4">
                <strong>الكمية المخططة:</strong><br>
                {{ selectedBatch.planned_quantity }}
              </div>
              <div class="col-md-4">
                <strong>الكمية الفعلية:</strong><br>
                {{ selectedBatch.actual_quantity || '-' }}
              </div>
              <div class="col-md-4">
                <strong>تكلفة الوحدة:</strong><br>
                {{ formatCurrency(selectedBatch.unit_cost) }}
              </div>
            </div>

            <h6 class="mt-4 mb-3">تفصيل التكاليف</h6>
            <div class="row">
              <div class="col-md-4">
                <strong>تكلفة المواد:</strong> {{ formatCurrency(selectedBatch.material_cost) }}
              </div>
              <div class="col-md-4">
                <strong>تكلفة العمالة:</strong> {{ formatCurrency(selectedBatch.labor_cost) }}
              </div>
              <div class="col-md-4">
                <strong>التكاليف الإضافية:</strong> {{ formatCurrency(selectedBatch.overhead_cost) }}
              </div>
            </div>
            <div class="mt-2">
              <strong>التكلفة الإجمالية:</strong> <span class="text-primary fs-5">{{ formatCurrency(selectedBatch.total_cost) }}</span>
            </div>

            <h6 class="mt-4 mb-3">المكونات المستخدمة</h6>
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>المادة</th>
                  <th>المطلوب</th>
                  <th>الفعلي</th>
                  <th>التكلفة</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="ing in selectedBatch.ingredients" :key="ing.id">
                  <td>{{ ing.raw_material?.name }}</td>
                  <td>{{ ing.required_quantity }} {{ ing.unit?.symbol }}</td>
                  <td>{{ ing.actual_quantity || '-' }} {{ ing.unit?.symbol }}</td>
                  <td>{{ formatCurrency(ing.total_cost) }}</td>
                </tr>
              </tbody>
            </table>

            <div v-if="selectedBatch.notes" class="mt-3">
              <h6>ملاحظات</h6>
              <p class="mb-0">{{ selectedBatch.notes }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ProductionList',
  data() {
    return {
      loading: false,
      batches: [],
      filters: {
        status: '',
        date_from: '',
        date_to: '',
      },
      pagination: {
        total: 0,
        per_page: 20,
        current_page: 1,
        last_page: 1,
      },
      selectedBatch: null,
      completeForm: {
        actual_quantity: '',
        actual_ingredients: {},
      },
      completing: false,
      editForm: {
        production_date: '',
        expiry_date: '',
        labor_cost: 0,
        overhead_cost: 0,
        notes: '',
      },
      editing: false,
    };
  },
  methods: {
    async fetchBatches(page = 1) {
      this.loading = true;
      try {
        const params = { page, per_page: this.pagination.per_page, ...this.filters };
        const response = await axios.get('/dashboard/api/manufacturing/batches', { params });
        this.batches = response.data.data;
        this.pagination = response.data.pagination;
      } catch (error) {
        toastr.error('فشل تحميل دفعات الإنتاج');
      } finally {
        this.loading = false;
      }
    },

    goToPage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.fetchBatches(page);
      }
    },

    resetFilters() {
      this.filters = { status: '', date_from: '', date_to: '' };
      this.fetchBatches();
    },

    getStatusColor(status) {
      const colors = {
        draft: 'secondary',
        in_progress: 'primary',
        completed: 'success',
        cancelled: 'danger',
      };
      return colors[status] || 'secondary';
    },

    formatStatus(status) {
      return status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
    },

    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },

    formatCurrency(value) {
      const amount = parseFloat(value || 0);
      // Check if the value has decimal places
      const hasDecimals = amount % 1 !== 0;

      const formattedNumber = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: hasDecimals ? 1 : 0,
        maximumFractionDigits: hasDecimals ? 2 : 0,
      }).format(amount);

      // Get currency from window.currency (set globally in master.blade.php)
      const currency = window.currency || 'IQD';

      return `${formattedNumber} ${currency}`;
    },

    async startBatch(batch) {
      const result = await swal.fire({
        title: 'بدء الإنتاج؟',
        text: 'سيتم وضع علامة على الدفعة كقيد التنفيذ.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'ابدأ',
        cancelButtonText: 'إلغاء',
      });

      if (result.isConfirmed) {
        try {
          await axios.post(`/dashboard/api/manufacturing/batches/${batch.id}/start`);
          toastr.success('تم بدء الإنتاج');
          this.fetchBatches(this.pagination.current_page);
        } catch (error) {
          toastr.error(error.response?.data?.message || 'فشل بدء الإنتاج');
        }
      }
    },

    openCompleteModal(batch) {
      this.selectedBatch = batch;
      this.completeForm = {
        actual_quantity: batch.planned_quantity,
        actual_ingredients: {},
      };
      $('#completeModal').modal('show');
    },

    async submitComplete() {
      if (!this.completeForm.actual_quantity) {
        toastr.error('الرجاء إدخال الكمية الفعلية');
        return;
      }

      this.completing = true;
      try {
        await axios.post(`/dashboard/api/manufacturing/batches/${this.selectedBatch.id}/complete`, this.completeForm);
        toastr.success('تم إكمال الإنتاج');
        $('#completeModal').modal('hide');
        this.fetchBatches(this.pagination.current_page);
      } catch (error) {
        toastr.error(error.response?.data?.message || 'فشل إكمال الإنتاج');
      } finally {
        this.completing = false;
      }
    },

    viewDetails(batch) {
      this.selectedBatch = batch;
      $('#detailsModal').modal('show');
    },

    async cancelBatch(batch) {
      const result = await swal.fire({
        title: 'إلغاء الإنتاج؟',
        text: 'هل أنت متأكد من إلغاء هذه الدفعة؟',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'نعم، ألغها',
        cancelButtonText: 'إلغاء',
        input: 'text',
        inputLabel: 'السبب (اختياري)',
      });

      if (result.isConfirmed) {
        try {
          await axios.post(`/dashboard/api/manufacturing/batches/${batch.id}/cancel`, {
            reason: result.value,
          });
          toastr.success('تم إلغاء الإنتاج');
          this.fetchBatches(this.pagination.current_page);
        } catch (error) {
          toastr.error(error.response?.data?.message || 'فشل الإلغاء');
        }
      }
    },

    openEditModal(batch) {
      this.selectedBatch = batch;
      this.editForm = {
        production_date: batch.production_date,
        expiry_date: batch.expiry_date || '',
        labor_cost: batch.labor_cost || 0,
        overhead_cost: batch.overhead_cost || 0,
        notes: batch.notes || '',
      };
      $('#editModal').modal('show');
    },

    async submitEdit() {
      this.editing = true;
      try {
        await axios.put(`/dashboard/api/manufacturing/batches/${this.selectedBatch.id}`, this.editForm);
        toastr.success('تم تحديث الإنتاج بنجاح');
        $('#editModal').modal('hide');
        this.fetchBatches(this.pagination.current_page);
      } catch (error) {
        toastr.error(error.response?.data?.message || 'فشل تحديث الإنتاج');
      } finally {
        this.editing = false;
      }
    },

    async cloneBatch(batch) {
      const result = await swal.fire({
        title: 'استنساخ الدفعة؟',
        text: 'سيتم إنشاء دفعة جديدة بنفس المواصفات وتعيينها كمكتملة',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'استنساخ',
        cancelButtonText: 'إلغاء',
      });

      if (result.isConfirmed) {
        try {
          await axios.post(`/dashboard/api/manufacturing/batches/${batch.id}/clone`);
          toastr.success('تم استنساخ الدفعة بنجاح');
          this.fetchBatches(this.pagination.current_page);
        } catch (error) {
          toastr.error(error.response?.data?.message || 'فشل استنساخ الدفعة');
        }
      }
    },
  },
  mounted() {
    this.fetchBatches();
  },
};
</script>
