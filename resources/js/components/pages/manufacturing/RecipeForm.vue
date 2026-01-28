<template>
  <div class="recipe-form">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4 class="mb-1">{{ isEdit ? 'تعديل الوصفة' : 'إنشاء وصفة' }}</h4>
        <p class="text-muted mb-0">حدد المكونات والكميات المطلوبة لإنتاج المنتج</p>
      </div>
      <router-link :to="{ name: 'manufacturing.recipes' }" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> العودة للقائمة
      </router-link>
    </div>

    <form @submit.prevent="submitForm">
      <div class="row">
        <!-- Basic Info -->
        <div class="col-md-8">
          <div class="card mb-4">
            <div class="card-header">
              <h5 class="mb-0">تفاصيل الوصفة</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">اسم الوصفة <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" v-model="form.name" required placeholder="مثال: وصفة كعكة الشوكولاتة">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">كمية الإنتاج <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" v-model="form.output_quantity" required min="0.01" step="0.01" placeholder="كم وحدة تنتج هذه الوصفة؟">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">المنتج <span class="text-danger">*</span></label>
                    <select class="form-select" v-model="form.product_id" required @change="onProductChange">
                      <option value="">اختر المنتج</option>
                      <option v-for="prod in products" :key="prod.id" :value="prod.id">{{ prod.name }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">نوع المنتج</label>
                    <select class="form-select" v-model="form.product_variation_id" :disabled="!variations.length">
                      <option value="">بدون نوع (المنتج الرئيسي)</option>
                      <option v-for="v in variations" :key="v.id" :value="v.id">{{ v.var_name }}</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="mb-3">
                    <label class="form-label">تكلفة العمالة</label>
                    <input type="number" class="form-control" v-model="form.labor_cost" min="0" step="0.01">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="mb-3">
                    <label class="form-label">التكاليف الإضافية</label>
                    <input type="number" class="form-control" v-model="form.overhead_cost" min="0" step="0.01">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="mb-3">
                    <label class="form-label">وقت التحضير (دقائق)</label>
                    <input type="number" class="form-control" v-model="form.prep_time_minutes" min="0">
                  </div>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">التعليمات</label>
                <textarea class="form-control" v-model="form.instructions" rows="3" placeholder="تعليمات التحضير الاختيارية..."></textarea>
              </div>

              <div class="form-check" v-if="isEdit">
                <input type="checkbox" class="form-check-input" id="isActive" v-model="form.is_active">
                <label class="form-check-label" for="isActive">نشط</label>
              </div>
            </div>
          </div>

          <!-- Ingredients -->
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">المكونات</h5>
              <button type="button" class="btn btn-sm btn-outline-primary" @click="addIngredient">
                <i class="fas fa-plus me-1"></i> إضافة مكون
              </button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th style="width: 35%">المادة الخام</th>
                      <th style="width: 20%">الكمية</th>
                      <th style="width: 20%">الوحدة</th>
                      <th style="width: 15%">نسبة الهدر %</th>
                      <th style="width: 10%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(ing, index) in form.ingredients" :key="index">
                      <td>
                        <select class="form-select form-select-sm" v-model="ing.raw_material_id" required @change="onMaterialChange(ing)">
                          <option value="">اختر المادة</option>
                          <option v-for="mat in rawMaterials" :key="mat.id" :value="mat.id">
                            {{ mat.name }} ({{ mat.current_stock }} {{ mat.unit?.symbol }})
                          </option>
                        </select>
                      </td>
                      <td>
                        <input type="number" class="form-control form-control-sm" v-model="ing.quantity" min="0.0001" step="0.0001" required>
                      </td>
                      <td>
                        <select class="form-select form-select-sm" v-model="ing.unit_id" required>
                          <option value="">الوحدة</option>
                          <option v-for="unit in units" :key="unit.id" :value="unit.id">{{ unit.symbol }}</option>
                        </select>
                      </td>
                      <td>
                        <input type="number" class="form-control form-control-sm" v-model="ing.waste_percentage" min="0" max="100" step="0.1">
                      </td>
                      <td>
                        <button type="button" class="btn btn-sm btn-outline-danger" @click="removeIngredient(index)">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                    <tr v-if="form.ingredients.length === 0">
                      <td colspan="5" class="text-center text-muted py-3">
                        لم تتم إضافة مكونات. انقر على "إضافة مكون" للبدء.
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Cost Summary -->
        <div class="col-md-4">
          <div class="card sticky-top" style="top: 20px;">
            <div class="card-header">
              <h5 class="mb-0">ملخص التكاليف</h5>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-between mb-2">
                <span>تكلفة المواد:</span>
                <strong>{{ formatCurrency(materialCost) }}</strong>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>تكلفة العمالة:</span>
                <strong>{{ formatCurrency(form.labor_cost || 0) }}</strong>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>التكاليف الإضافية:</span>
                <strong>{{ formatCurrency(form.overhead_cost || 0) }}</strong>
              </div>
              <hr>
              <div class="d-flex justify-content-between mb-2">
                <span>إجمالي تكلفة الدفعة:</span>
                <strong class="text-primary">{{ formatCurrency(totalCost) }}</strong>
              </div>
              <div class="d-flex justify-content-between">
                <span>تكلفة الوحدة:</span>
                <strong class="text-success">{{ formatCurrency(unitCost) }}</strong>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary w-100" :disabled="saving || form.ingredients.length === 0">
                <span v-if="saving" class="spinner-border spinner-border-sm me-1"></span>
                {{ isEdit ? 'تحديث' : 'إنشاء' }} الوصفة
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: 'RecipeForm',
  data() {
    return {
      isEdit: false,
      saving: false,
      form: {
        name: '',
        product_id: '',
        product_variation_id: '',
        output_quantity: 1,
        labor_cost: 0,
        overhead_cost: 0,
        prep_time_minutes: null,
        instructions: '',
        is_active: true,
        ingredients: [],
      },
      products: [],
      variations: [],
      rawMaterials: [],
      units: [],
    };
  },
  computed: {
    materialCost() {
      return this.form.ingredients.reduce((sum, ing) => {
        const material = this.rawMaterials.find(m => m.id == ing.raw_material_id);
        if (!material || !ing.quantity) return sum;
        const effectiveQty = ing.quantity * (1 + (ing.waste_percentage || 0) / 100);
        const avgPrice = parseFloat(material.average_price) || 0;
        return sum + (effectiveQty * avgPrice);
      }, 0);
    },
    totalCost() {
      return this.materialCost + parseFloat(this.form.labor_cost || 0) + parseFloat(this.form.overhead_cost || 0);
    },
    unitCost() {
      const output = parseFloat(this.form.output_quantity) || 1;
      return this.totalCost / output;
    },
  },
  methods: {
    async fetchData() {
      try {
        const [productsRes, materialsRes, unitsRes] = await Promise.all([
          axios.get('/dashboard/api/product-list'),
          axios.get('/dashboard/api/manufacturing/raw-materials?per_page=1000'),
          axios.get('/dashboard/api/manufacturing/units'),
        ]);
        this.products = productsRes.data.data || productsRes.data;
        this.rawMaterials = materialsRes.data.data;
        this.units = unitsRes.data.data;
      } catch (error) {
        toastr.error('فشل تحميل بيانات النموذج');
      }
    },

    async fetchRecipe(id) {
      try {
        const response = await axios.get(`/dashboard/api/manufacturing/recipes/${id}`);
        const recipe = response.data.data;
        this.form = {
          name: recipe.name,
          product_id: recipe.product_id,
          product_variation_id: recipe.product_variation_id || '',
          output_quantity: recipe.output_quantity,
          labor_cost: recipe.labor_cost,
          overhead_cost: recipe.overhead_cost,
          prep_time_minutes: recipe.prep_time_minutes,
          instructions: recipe.instructions || '',
          is_active: recipe.is_active,
          ingredients: recipe.ingredients.map(ing => ({
            raw_material_id: ing.raw_material_id,
            unit_id: ing.unit_id,
            quantity: ing.quantity,
            waste_percentage: ing.waste_percentage || 0,
          })),
        };
        this.onProductChange();
      } catch (error) {
        toastr.error('فشل تحميل الوصفة');
        this.$router.push({ name: 'manufacturing.recipes' });
      }
    },

    async onProductChange() {
      this.variations = [];
      this.form.product_variation_id = '';
      if (this.form.product_id) {
        try {
          const response = await axios.get(`/dashboard/api/get-product-variations?product_id=${this.form.product_id}`);
          this.variations = response.data.data || response.data || [];
        } catch (error) {
          console.error('Failed to load variations');
        }
      }
    },

    onMaterialChange(ingredient) {
      const material = this.rawMaterials.find(m => m.id === ingredient.raw_material_id);
      if (material) {
        ingredient.unit_id = material.unit_id;
      }
    },

    addIngredient() {
      this.form.ingredients.push({
        raw_material_id: '',
        unit_id: '',
        quantity: '',
        waste_percentage: 0,
      });
    },

    removeIngredient(index) {
      this.form.ingredients.splice(index, 1);
    },

    formatCurrency(value) {
      return parseFloat(value || 0).toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    },

    async submitForm() {
      if (this.form.ingredients.length === 0) {
        toastr.error('الرجاء إضافة مكون واحد على الأقل');
        return;
      }

      this.saving = true;
      try {
        if (this.isEdit) {
          await axios.put(`/dashboard/api/manufacturing/recipes/${this.$route.params.id}`, this.form);
          toastr.success('تم تحديث الوصفة بنجاح');
          this.$router.push({ name: 'manufacturing.recipes' });
        } else {
          const response = await axios.post('/dashboard/api/manufacturing/recipes', this.form);
          toastr.success('تم إنشاء الوصفة بنجاح');
          // Redirect to production creation page with the new recipe
          const recipeId = response.data.data?.id;
          if (recipeId) {
            this.$router.push({
              name: 'manufacturing.production.create',
              query: { recipe_id: recipeId }
            });
          } else {
            this.$router.push({ name: 'manufacturing.production.create' });
          }
        }
      } catch (error) {
        toastr.error(error.response?.data?.message || 'فشل حفظ الوصفة');
      } finally {
        this.saving = false;
      }
    },
  },
  mounted() {
    this.fetchData();
    if (this.$route.params.id) {
      this.isEdit = true;
      this.fetchRecipe(this.$route.params.id);
    }
  },
};
</script>
