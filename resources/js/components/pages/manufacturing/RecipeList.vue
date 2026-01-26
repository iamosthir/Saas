<template>
  <div class="recipe-list">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4 class="mb-1">الوصفات (قائمة المواد)</h4>
        <p class="text-muted mb-0">إدارة الوصفات التي تحدد كيفية تصنيع المنتجات</p>
      </div>
      <router-link :to="{ name: 'manufacturing.recipes.create' }" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> إنشاء وصفة
      </router-link>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-4">
            <select class="form-select" v-model="filters.product_id" @change="fetchRecipes">
              <option value="">جميع المنتجات</option>
              <option v-for="prod in products" :key="prod.id" :value="prod.id">{{ prod.name }}</option>
            </select>
          </div>
          <div class="col-md-4">
            <select class="form-select" v-model="filters.active_only" @change="fetchRecipes">
              <option value="">جميع الوصفات</option>
              <option value="1">النشطة فقط</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Recipes Table -->
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>اسم الوصفة</th>
                <th>المنتج</th>
                <th>كمية الإنتاج</th>
                <th>المكونات</th>
                <th>التكلفة المقدرة</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
              </tr>
            </thead>
            <tbody v-if="!loading">
              <tr v-for="recipe in recipes" :key="recipe.id">
                <td><strong>{{ recipe.name }}</strong></td>
                <td>
                  {{ recipe.product?.name }}
                  <span v-if="recipe.product_variation" class="text-muted">
                    ({{ recipe.product_variation.var_name }})
                  </span>
                </td>
                <td>{{ recipe.output_quantity }}</td>
                <td>{{ recipe.ingredients?.length || 0 }} عنصر</td>
                <td>{{ formatCurrency(calculateRecipeCost(recipe)) }}</td>
                <td>
                  <span :class="'badge bg-' + (recipe.is_active ? 'success' : 'secondary')">
                    {{ recipe.is_active ? 'نشط' : 'غير نشط' }}
                  </span>
                </td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <router-link :to="{ name: 'manufacturing.production.create', query: { recipe_id: recipe.id } }" class="btn btn-outline-success" title="بدء الإنتاج">
                      <i class="fas fa-play"></i>
                    </router-link>
                    <router-link :to="{ name: 'manufacturing.recipes.edit', params: { id: recipe.id } }" class="btn btn-outline-primary" title="تعديل">
                      <i class="fas fa-edit"></i>
                    </router-link>
                    <button class="btn btn-outline-info" @click="viewDetails(recipe)" title="عرض التفاصيل">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-outline-danger" @click="deleteRecipe(recipe)" title="حذف">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="recipes.length === 0">
                <td colspan="7" class="text-center py-4 text-muted">
                  لم يتم العثور على وصفات. <router-link :to="{ name: 'manufacturing.recipes.create' }">إنشاء أول وصفة</router-link>
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

    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">الوصفة: {{ selectedRecipe?.name }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body" v-if="selectedRecipe">
            <div class="row mb-3">
              <div class="col-md-6">
                <strong>المنتج:</strong> {{ selectedRecipe.product?.name }}
              </div>
              <div class="col-md-6">
                <strong>كمية الإنتاج:</strong> {{ selectedRecipe.output_quantity }}
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-4">
                <strong>تكلفة العمالة:</strong> {{ formatCurrency(selectedRecipe.labor_cost) }}
              </div>
              <div class="col-md-4">
                <strong>التكاليف الإضافية:</strong> {{ formatCurrency(selectedRecipe.overhead_cost) }}
              </div>
              <div class="col-md-4">
                <strong>وقت التحضير:</strong> {{ selectedRecipe.prep_time_minutes || 'غير متاح' }} دقيقة
              </div>
            </div>

            <h6 class="mt-4 mb-3">المكونات</h6>
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>المادة</th>
                  <th>الكمية</th>
                  <th>الوحدة</th>
                  <th>نسبة الهدر %</th>
                  <th>التكلفة المقدرة</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="ing in selectedRecipe.ingredients" :key="ing.id">
                  <td>{{ ing.raw_material?.name }}</td>
                  <td>{{ ing.quantity }}</td>
                  <td>{{ ing.unit?.symbol }}</td>
                  <td>{{ ing.waste_percentage }}%</td>
                  <td>{{ formatCurrency(ing.quantity * (ing.raw_material?.average_price || 0)) }}</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="4" class="text-end">إجمالي تكلفة المواد:</th>
                  <th>{{ formatCurrency(calculateRecipeCost(selectedRecipe)) }}</th>
                </tr>
              </tfoot>
            </table>

            <div v-if="selectedRecipe.instructions" class="mt-3">
              <h6>التعليمات</h6>
              <p class="mb-0">{{ selectedRecipe.instructions }}</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            <router-link :to="{ name: 'manufacturing.production.create', query: { recipe_id: selectedRecipe?.id } }" class="btn btn-success" @click="hideModal">
              <i class="fas fa-play me-1"></i> بدء الإنتاج
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'RecipeList',
  data() {
    return {
      loading: false,
      recipes: [],
      products: [],
      filters: {
        product_id: '',
        active_only: '',
      },
      pagination: {
        total: 0,
        per_page: 20,
        current_page: 1,
        last_page: 1,
      },
      selectedRecipe: null,
    };
  },
  methods: {
    async fetchRecipes(page = 1) {
      this.loading = true;
      try {
        const params = { page, per_page: this.pagination.per_page, ...this.filters };
        const response = await axios.get('/dashboard/api/manufacturing/recipes', { params });
        this.recipes = response.data.data;
        this.pagination = response.data.pagination;
      } catch (error) {
        toastr.error('فشل تحميل الوصفات');
      } finally {
        this.loading = false;
      }
    },

    async fetchProducts() {
      try {
        const response = await axios.get('/dashboard/api/product-list');
        this.products = response.data.data || response.data;
      } catch (error) {
        console.error('Failed to load products');
      }
    },

    goToPage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.fetchRecipes(page);
      }
    },

    calculateRecipeCost(recipe) {
      if (!recipe.ingredients) return 0;
      return recipe.ingredients.reduce((sum, ing) => {
        const baseQty = ing.quantity * (1 + (ing.waste_percentage || 0) / 100);
        return sum + (baseQty * (ing.raw_material?.average_price || 0));
      }, 0);
    },

    formatCurrency(value) {
      return parseFloat(value || 0).toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    },

    viewDetails(recipe) {
      this.selectedRecipe = recipe;
      $('#detailsModal').modal('show');
    },

    hideModal() {
      $('#detailsModal').modal('hide');
    },

    async deleteRecipe(recipe) {
      const result = await swal.fire({
        title: 'حذف الوصفة؟',
        text: `هل أنت متأكد من حذف "${recipe.name}"؟`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'نعم، احذفها',
        cancelButtonText: 'إلغاء',
      });

      if (result.isConfirmed) {
        try {
          await axios.delete(`/dashboard/api/manufacturing/recipes/${recipe.id}`);
          toastr.success('تم حذف الوصفة');
          this.fetchRecipes(this.pagination.current_page);
        } catch (error) {
          toastr.error(error.response?.data?.message || 'فشل الحذف');
        }
      }
    },
  },
  mounted() {
    this.fetchRecipes();
    this.fetchProducts();
  },
};
</script>
