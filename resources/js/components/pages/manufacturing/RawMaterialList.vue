<template>
  <div class="raw-material-list">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4 class="mb-1">المواد الخام</h4>
        <p class="text-muted mb-0">إدارة مخزون المواد الخام والمكونات الخاصة بك</p>
      </div>
      <router-link :to="{ name: 'manufacturing.raw-materials.create' }" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> إضافة مادة خام
      </router-link>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-4">
            <input type="text" class="form-control" v-model="filters.search" placeholder="ابحث بالاسم، رمز التخزين، أو الباركود..." @input="debouncedFetch">
          </div>
          <div class="col-md-3">
            <select class="form-select" v-model="filters.category_id" @change="fetchMaterials">
              <option value="">جميع الفئات</option>
              <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
            </select>
          </div>
          <div class="col-md-3">
            <select class="form-select" v-model="filters.low_stock" @change="fetchMaterials">
              <option value="">جميع مستويات المخزون</option>
              <option value="1">مخزون منخفض فقط</option>
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

    <!-- Materials Table -->
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>الاسم</th>
                <th>رمز التخزين</th>
                <th>الوحدة</th>
                <th>المخزون الحالي</th>
                <th>الحد الأدنى</th>
                <th>متوسط السعر</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
              </tr>
            </thead>
            <tbody v-if="!loading">
              <tr v-for="material in materials" :key="material.id">
                <td>
                  <strong>{{ material.name }}</strong>
                  <br><small class="text-muted">{{ material.category?.name || 'غير مصنف' }}</small>
                </td>
                <td>{{ material.sku || '-' }}</td>
                <td>{{ material.unit?.name }} ({{ material.unit?.symbol }})</td>
                <td :class="{ 'text-danger': isLowStock(material) }">
                  {{ formatNumber(material.current_stock) }} {{ material.unit?.symbol }}
                </td>
                <td>{{ formatNumber(material.min_stock_level) }} {{ material.unit?.symbol }}</td>
                <td>{{ formatCurrency(material.average_price) }}</td>
                <td>
                  <span :class="'badge bg-' + (material.is_active ? 'success' : 'secondary')">
                    {{ material.is_active ? 'نشط' : 'غير نشط' }}
                  </span>
                  <span v-if="isLowStock(material)" class="badge bg-warning ms-1">مخزون منخفض</span>
                </td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-success" @click="openPurchaseModal(material)" title="إضافة مخزون">
                      <i class="fas fa-plus"></i>
                    </button>
                    <router-link :to="{ name: 'manufacturing.raw-materials.edit', params: { id: material.id } }" class="btn btn-outline-primary" title="تعديل">
                      <i class="fas fa-edit"></i>
                    </router-link>
                    <button class="btn btn-outline-info" @click="viewMovements(material)" title="عرض الحركات">
                      <i class="fas fa-history"></i>
                    </button>
                    <button class="btn btn-outline-danger" @click="deleteMaterial(material)" title="حذف">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr>
                <td colspan="8" class="text-center py-4">
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

    <!-- Purchase Modal -->
    <div class="modal fade" id="purchaseModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">إضافة مخزون: {{ selectedMaterial?.name }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">الكمية ({{ selectedMaterial?.unit?.symbol }})</label>
              <input type="number" class="form-control" v-model="purchaseForm.quantity" step="0.0001" min="0">
            </div>
            <div class="mb-3">
              <label class="form-label">تكلفة الوحدة</label>
              <input type="number" class="form-control" v-model="purchaseForm.unit_cost" step="0.01" min="0">
            </div>
            <div class="mb-3">
              <label class="form-label">ملاحظات (اختياري)</label>
              <textarea class="form-control" v-model="purchaseForm.notes" rows="2"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
            <button type="button" class="btn btn-success" @click="submitPurchase" :disabled="purchasing">
              <span v-if="purchasing" class="spinner-border spinner-border-sm me-1"></span>
              إضافة مخزون
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Movements Modal -->
    <div class="modal fade" id="movementsModal" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">حركات المخزون: {{ selectedMaterial?.name }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-sm">
                <thead>
                  <tr>
                    <th>التاريخ</th>
                    <th>النوع</th>
                    <th>الكمية</th>
                    <th>قبل</th>
                    <th>بعد</th>
                    <th>التكلفة</th>
                    <th>ملاحظات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="mov in movements" :key="mov.id">
                    <td>{{ formatDate(mov.created_at) }}</td>
                    <td>
                      <span :class="'badge bg-' + getMovementColor(mov.movement_type)">
                        {{ mov.movement_type }}
                      </span>
                    </td>
                    <td :class="{ 'text-success': mov.quantity > 0, 'text-danger': mov.quantity < 0 }">
                      {{ mov.quantity > 0 ? '+' : '' }}{{ formatNumber(mov.quantity) }}
                    </td>
                    <td>{{ formatNumber(mov.quantity_before) }}</td>
                    <td>{{ formatNumber(mov.quantity_after) }}</td>
                    <td>{{ formatCurrency(mov.unit_cost) }}</td>
                    <td>{{ mov.notes || '-' }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'RawMaterialList',
  data() {
    return {
      loading: false,
      materials: [],
      categories: [],
      filters: {
        search: '',
        category_id: '',
        low_stock: '',
      },
      pagination: {
        total: 0,
        per_page: 20,
        current_page: 1,
        last_page: 1,
      },
      selectedMaterial: null,
      purchaseForm: {
        quantity: '',
        unit_cost: '',
        notes: '',
      },
      purchasing: false,
      movements: [],
      debounceTimer: null,
    };
  },
  methods: {
    async fetchMaterials(page = 1) {
      this.loading = true;
      try {
        const params = {
          page,
          per_page: this.pagination.per_page,
          ...this.filters,
        };
        const response = await axios.get('/dashboard/api/manufacturing/raw-materials', { params });
        this.materials = response.data.data;
        this.pagination = response.data.pagination;
      } catch (error) {
        toastr.error('فشل تحميل المواد الخام');
      } finally {
        this.loading = false;
      }
    },

    async fetchCategories() {
      try {
        const response = await axios.get('/dashboard/api/categories');
        this.categories = response.data.data || response.data;
      } catch (error) {
        console.error('Failed to load categories');
      }
    },

    debouncedFetch() {
      clearTimeout(this.debounceTimer);
      this.debounceTimer = setTimeout(() => {
        this.fetchMaterials();
      }, 300);
    },

    resetFilters() {
      this.filters = { search: '', category_id: '', low_stock: '' };
      this.fetchMaterials();
    },

    goToPage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.fetchMaterials(page);
      }
    },

    isLowStock(material) {
      return material.current_stock <= material.min_stock_level;
    },

    formatNumber(value) {
      return parseFloat(value || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 4 });
    },

    formatCurrency(value) {
      return parseFloat(value || 0).toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    },

    formatDate(date) {
      return new Date(date).toLocaleString();
    },

    openPurchaseModal(material) {
      this.selectedMaterial = material;
      this.purchaseForm = {
        quantity: '',
        unit_cost: material.purchase_price || '',
        notes: '',
      };
      $('#purchaseModal').modal('show');
    },

    async submitPurchase() {
      if (!this.purchaseForm.quantity || !this.purchaseForm.unit_cost) {
        toastr.error('الرجاء إدخال الكمية وتكلفة الوحدة');
        return;
      }

      this.purchasing = true;
      try {
        await axios.post(`/dashboard/api/manufacturing/raw-materials/${this.selectedMaterial.id}/purchase`, this.purchaseForm);
        toastr.success('تم إضافة المخزون بنجاح');
        $('#purchaseModal').modal('hide');
        this.fetchMaterials(this.pagination.current_page);
      } catch (error) {
        toastr.error(error.response?.data?.message || 'فشل إضافة المخزون');
      } finally {
        this.purchasing = false;
      }
    },

    async viewMovements(material) {
      this.selectedMaterial = material;
      try {
        const response = await axios.get(`/dashboard/api/manufacturing/raw-materials/${material.id}/movements`);
        this.movements = response.data.data;
        $('#movementsModal').modal('show');
      } catch (error) {
        toastr.error('فشل تحميل الحركات');
      }
    },

    getMovementColor(type) {
      const colors = {
        purchase: 'success',
        production: 'info',
        adjustment: 'warning',
        waste: 'danger',
        transfer: 'primary',
      };
      return colors[type] || 'secondary';
    },

    async deleteMaterial(material) {
      const result = await swal.fire({
        title: 'حذف المادة الخام؟',
        text: `هل أنت متأكد من حذف "${material.name}"؟`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'نعم، احذفها',
        cancelButtonText: 'إلغاء',
      });

      if (result.isConfirmed) {
        try {
          await axios.delete(`/dashboard/api/manufacturing/raw-materials/${material.id}`);
          toastr.success('تم حذف المادة الخام');
          this.fetchMaterials(this.pagination.current_page);
        } catch (error) {
          toastr.error(error.response?.data?.message || 'فشل الحذف');
        }
      }
    },
  },
  mounted() {
    this.fetchMaterials();
    this.fetchCategories();
  },
};
</script>
