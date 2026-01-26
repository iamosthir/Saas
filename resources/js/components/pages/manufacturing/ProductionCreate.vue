<template>
  <div class="production-create">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4 class="mb-1">بدء إنتاج جديد</h4>
        <p class="text-muted mb-0">اختر وصفة وأنشئ دفعة إنتاج</p>
      </div>
      <router-link :to="{ name: 'manufacturing.production' }" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> العودة للقائمة
      </router-link>
    </div>

    <div class="row">
      <div class="col-md-8">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">تفاصيل الإنتاج</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">الوصفة <span class="text-danger">*</span></label>
                  <select class="form-select" v-model="form.recipe_id" @change="onRecipeChange" required>
                    <option value="">اختر الوصفة</option>
                    <option v-for="recipe in recipes" :key="recipe.id" :value="recipe.id">
                      {{ recipe.name }} ({{ recipe.product?.name }})
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">مضاعف الدفعة</label>
                  <input type="number" class="form-control" v-model="form.multiplier" min="0.1" step="0.1" @change="checkAvailability">
                  <small class="text-muted">1 = دفعة واحدة، 2 = دفعة مضاعفة، إلخ.</small>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">تاريخ الإنتاج</label>
                  <input type="date" class="form-control" v-model="form.production_date">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">تاريخ انتهاء الصلاحية</label>
                  <input type="date" class="form-control" v-model="form.expiry_date">
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">ملاحظات</label>
              <textarea class="form-control" v-model="form.notes" rows="3" placeholder="ملاحظات إنتاج اختيارية..."></textarea>
            </div>
          </div>
        </div>

        <!-- Ingredient Availability -->
        <div class="card" v-if="availability">
          <div class="card-header" :class="{ 'bg-success text-white': availability.can_produce, 'bg-danger text-white': !availability.can_produce }">
            <h5 class="mb-0">
              <i :class="availability.can_produce ? 'fas fa-check-circle' : 'fas fa-exclamation-circle'" class="me-2"></i>
              {{ availability.can_produce ? 'جاهز للإنتاج' : 'مخزون غير كافي' }}
            </h5>
          </div>
          <div class="card-body">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>المادة</th>
                  <th>المطلوب</th>
                  <th>المتوفر</th>
                  <th>الحالة</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="ing in availability.ingredients" :key="ing.raw_material_id">
                  <td>{{ ing.name }}</td>
                  <td>{{ ing.required }} {{ ing.unit }}</td>
                  <td>{{ ing.available }} {{ ing.unit }}</td>
                  <td>
                    <span v-if="ing.sufficient" class="badge bg-success">متوفر</span>
                    <span v-else class="badge bg-danger">نقص: {{ ing.shortage }} {{ ing.unit }}</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card sticky-top" style="top: 20px;">
          <div class="card-header">
            <h5 class="mb-0">ملخص الإنتاج</h5>
          </div>
          <div class="card-body" v-if="selectedRecipe">
            <div class="mb-3">
              <strong>المنتج:</strong><br>
              {{ selectedRecipe.product?.name }}
              <span v-if="selectedRecipe.product_variation" class="text-muted">
                ({{ selectedRecipe.product_variation.var_name }})
              </span>
            </div>
            <div class="mb-3">
              <strong>كمية الإنتاج:</strong><br>
              <span class="fs-4 text-primary">{{ (selectedRecipe.output_quantity * form.multiplier).toFixed(2) }}</span> وحدة
            </div>
            <hr>
            <div v-if="availability">
              <div class="d-flex justify-content-between mb-2">
                <span>تكلفة المواد:</span>
                <strong>{{ formatCurrency(availability.estimated_material_cost) }}</strong>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>تكلفة العمالة:</span>
                <strong>{{ formatCurrency(selectedRecipe.labor_cost * form.multiplier) }}</strong>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>التكاليف الإضافية:</span>
                <strong>{{ formatCurrency(selectedRecipe.overhead_cost * form.multiplier) }}</strong>
              </div>
              <hr>
              <div class="d-flex justify-content-between mb-2">
                <span>التكلفة الإجمالية:</span>
                <strong class="text-primary">{{ formatCurrency(availability.estimated_total_cost) }}</strong>
              </div>
              <div class="d-flex justify-content-between">
                <span>تكلفة الوحدة:</span>
                <strong class="text-success">{{ formatCurrency(availability.estimated_unit_cost) }}</strong>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="button" class="btn btn-primary w-100" @click="createBatch" :disabled="saving || !form.recipe_id || !availability?.can_produce">
              <span v-if="saving" class="spinner-border spinner-border-sm me-1"></span>
              إنشاء دفعة إنتاج
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ProductionCreate',
  data() {
    return {
      saving: false,
      form: {
        recipe_id: '',
        multiplier: 1,
        production_date: new Date().toISOString().split('T')[0],
        expiry_date: '',
        notes: '',
      },
      recipes: [],
      selectedRecipe: null,
      availability: null,
    };
  },
  methods: {
    async fetchRecipes() {
      try {
        const response = await axios.get('/dashboard/api/manufacturing/recipes?active_only=1&per_page=1000');
        this.recipes = response.data.data;

        // Check if recipe_id was passed via query
        if (this.$route.query.recipe_id) {
          this.form.recipe_id = parseInt(this.$route.query.recipe_id);
          this.onRecipeChange();
        }
      } catch (error) {
        toastr.error('فشل تحميل الوصفات');
      }
    },

    async onRecipeChange() {
      this.selectedRecipe = this.recipes.find(r => r.id === this.form.recipe_id);
      if (this.selectedRecipe) {
        await this.checkAvailability();
      } else {
        this.availability = null;
      }
    },

    async checkAvailability() {
      if (!this.form.recipe_id) return;

      try {
        const response = await axios.get(`/dashboard/api/manufacturing/recipes/${this.form.recipe_id}/availability`, {
          params: { multiplier: this.form.multiplier },
        });
        this.availability = response.data.data;
      } catch (error) {
        console.error('Failed to check availability');
      }
    },

    formatCurrency(value) {
      return parseFloat(value || 0).toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    },

    async createBatch() {
      this.saving = true;
      try {
        const response = await axios.post('/dashboard/api/manufacturing/batches', this.form);
        toastr.success('تم إنشاء دفعة الإنتاج');
        this.$router.push({ name: 'manufacturing.production' });
      } catch (error) {
        toastr.error(error.response?.data?.message || 'فشل إنشاء الدفعة');
      } finally {
        this.saving = false;
      }
    },
  },
  mounted() {
    this.fetchRecipes();
  },
};
</script>
