<template>
  <div class="manufacturing-dashboard">
    <!-- Stats Cards -->
    <div class="row mb-4">
      <div class="col-md-3">
        <div class="card bg-primary text-white">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title mb-0">المواد الخام</h6>
                <h3 class="mb-0">{{ stats.totalMaterials }}</h3>
              </div>
              <i class="fas fa-boxes fa-2x opacity-50"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-warning text-dark">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title mb-0">مخزون منخفض</h6>
                <h3 class="mb-0">{{ stats.lowStockCount }}</h3>
              </div>
              <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-info text-white">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title mb-0">الوصفات النشطة</h6>
                <h3 class="mb-0">{{ stats.totalRecipes }}</h3>
              </div>
              <i class="fas fa-receipt fa-2x opacity-50"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-success text-white">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title mb-0">إنتاج اليوم</h6>
                <h3 class="mb-0">{{ stats.todayProduction }}</h3>
              </div>
              <i class="fas fa-industry fa-2x opacity-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">إجراءات سريعة</h5>
          </div>
          <div class="card-body">
            <router-link :to="{ name: 'manufacturing.raw-materials.create' }" class="btn btn-primary me-2">
              <i class="fas fa-plus me-1"></i> إضافة مادة خام
            </router-link>
            <router-link :to="{ name: 'manufacturing.recipes.create' }" class="btn btn-info me-2">
              <i class="fas fa-plus me-1"></i> إنشاء وصفة
            </router-link>
            <router-link :to="{ name: 'manufacturing.production.create' }" class="btn btn-success">
              <i class="fas fa-play me-1"></i> بدء الإنتاج
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <!-- Low Stock Alerts -->
    <div class="row mb-4" v-if="lowStockMaterials.length > 0">
      <div class="col-12">
        <div class="card border-warning">
          <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>تنبيهات المخزون المنخفض</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-sm">
                <thead>
                  <tr>
                    <th>المادة</th>
                    <th>المخزون الحالي</th>
                    <th>الحد الأدنى</th>
                    <th>الإجراء</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="material in lowStockMaterials" :key="material.id">
                    <td>{{ material.name }}</td>
                    <td class="text-danger">{{ material.current_stock }} {{ material.unit?.symbol }}</td>
                    <td>{{ material.min_stock_level }} {{ material.unit?.symbol }}</td>
                    <td>
                      <button @click="openPurchaseModal(material)" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> إضافة مخزون
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Production -->
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">دفعات الإنتاج الأخيرة</h5>
            <router-link :to="{ name: 'manufacturing.production' }" class="btn btn-sm btn-outline-primary">
              عرض الكل
            </router-link>
          </div>
          <div class="card-body">
            <div class="table-responsive" v-if="recentBatches.length > 0">
              <table class="table table-sm">
                <thead>
                  <tr>
                    <th>رقم الدفعة</th>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>الحالة</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="batch in recentBatches" :key="batch.id">
                    <td>{{ batch.batch_number }}</td>
                    <td>{{ batch.product?.name }}</td>
                    <td>{{ batch.actual_quantity || batch.planned_quantity }}</td>
                    <td>
                      <span :class="'badge bg-' + getStatusColor(batch.status)">
                        {{ batch.status }}
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p v-else class="text-muted mb-0">لا توجد دفعات إنتاج حديثة</p>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">الوصفات الشائعة</h5>
            <router-link :to="{ name: 'manufacturing.recipes' }" class="btn btn-sm btn-outline-primary">
              عرض الكل
            </router-link>
          </div>
          <div class="card-body">
            <div class="list-group list-group-flush" v-if="recipes.length > 0">
              <div v-for="recipe in recipes.slice(0, 5)" :key="recipe.id" class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">{{ recipe.name }}</h6>
                  <small class="text-muted">{{ recipe.product?.name }}</small>
                </div>
                <router-link :to="{ name: 'manufacturing.production.create', query: { recipe_id: recipe.id } }" class="btn btn-sm btn-outline-success">
                  إنتاج
                </router-link>
              </div>
            </div>
            <p v-else class="text-muted mb-0">لم يتم إنشاء وصفات بعد</p>
          </div>
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
              <input type="number" class="form-control" v-model="purchaseForm.quantity" step="0.01" min="0">
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
  </div>
</template>

<script>
export default {
  name: 'ManufacturingDashboard',
  data() {
    return {
      loading: true,
      stats: {
        totalMaterials: 0,
        lowStockCount: 0,
        totalRecipes: 0,
        todayProduction: 0,
      },
      lowStockMaterials: [],
      recentBatches: [],
      recipes: [],
      selectedMaterial: null,
      purchaseForm: {
        quantity: '',
        unit_cost: '',
        notes: '',
      },
      purchasing: false,
    };
  },
  methods: {
    async fetchData() {
      this.loading = true;
      try {
        // Fetch low stock materials
        const lowStockRes = await axios.get('/dashboard/api/manufacturing/raw-materials/low-stock');
        this.lowStockMaterials = lowStockRes.data.data || [];
        this.stats.lowStockCount = this.lowStockMaterials.length;

        // Fetch all materials count
        const materialsRes = await axios.get('/dashboard/api/manufacturing/raw-materials?per_page=1');
        this.stats.totalMaterials = materialsRes.data.pagination?.total || 0;

        // Fetch recipes
        const recipesRes = await axios.get('/dashboard/api/manufacturing/recipes?active_only=1');
        this.recipes = recipesRes.data.data || [];
        this.stats.totalRecipes = this.recipes.length;

        // Fetch recent batches
        const batchesRes = await axios.get('/dashboard/api/manufacturing/batches?per_page=5');
        this.recentBatches = batchesRes.data.data || [];

        // Count today's production
        const todayBatches = this.recentBatches.filter(b =>
          b.status === 'completed' &&
          new Date(b.production_date).toDateString() === new Date().toDateString()
        );
        this.stats.todayProduction = todayBatches.reduce((sum, b) => sum + (b.actual_quantity || 0), 0);

      } catch (error) {
        console.error('Error fetching dashboard data:', error);
        toastr.error('فشل تحميل بيانات لوحة التحكم');
      } finally {
        this.loading = false;
      }
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
        this.fetchData();
      } catch (error) {
        toastr.error(error.response?.data?.message || 'فشل إضافة المخزون');
      } finally {
        this.purchasing = false;
      }
    },
  },
  mounted() {
    this.fetchData();
  },
};
</script>

<style scoped>
.manufacturing-dashboard .card {
  border-radius: 10px;
}
.manufacturing-dashboard .card-header {
  background: transparent;
  border-bottom: 1px solid #eee;
}
</style>
