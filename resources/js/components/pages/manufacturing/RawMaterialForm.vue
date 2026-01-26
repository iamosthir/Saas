<template>
  <div class="raw-material-form">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4 class="mb-1">{{ isEdit ? 'تعديل مادة خام' : 'إضافة مادة خام' }}</h4>
        <p class="text-muted mb-0">{{ isEdit ? 'تحديث تفاصيل المادة الخام' : 'أضف مكوناً جديداً إلى مخزونك' }}</p>
      </div>
      <router-link :to="{ name: 'manufacturing.raw-materials' }" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> العودة للقائمة
      </router-link>
    </div>

    <div class="card">
      <div class="card-body">
        <form @submit.prevent="submitForm">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">الاسم <span class="text-danger">*</span></label>
                <input type="text" class="form-control" v-model="form.name" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">وحدة القياس <span class="text-danger">*</span></label>
                <select class="form-select" v-model="form.unit_id" required>
                  <option value="">اختر الوحدة</option>
                  <option v-for="unit in units" :key="unit.id" :value="unit.id">
                    {{ unit.name }} ({{ unit.symbol }})
                  </option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">الفئة</label>
                <select class="form-select" v-model="form.category_id">
                  <option value="">بدون فئة</option>
                  <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">المورد</label>
                <select class="form-select" v-model="form.supplier_id">
                  <option value="">بدون مورد</option>
                  <option v-for="sup in suppliers" :key="sup.id" :value="sup.id">{{ sup.name }}</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">رمز التخزين التعريفي</label>
                <input type="text" class="form-control" v-model="form.sku" placeholder="اختياري">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">الباركود</label>
                <input type="text" class="form-control" v-model="form.barcode" placeholder="اختياري">
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">الحد الأدنى للمخزون</label>
                <input type="number" class="form-control" v-model="form.min_stock_level" step="0.01" min="0">
              </div>
            </div>
            <div class="col-md-4" v-if="!isEdit">
              <div class="mb-3">
                <label class="form-label">سعر الشراء</label>
                <input type="number" class="form-control" v-model="form.purchase_price" step="0.01" min="0">
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">الوصف</label>
            <textarea class="form-control" v-model="form.description" rows="3" placeholder="وصف اختياري..."></textarea>
          </div>

          <div class="mb-3" v-if="isEdit">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="isActive" v-model="form.is_active">
              <label class="form-check-label" for="isActive">نشط</label>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <router-link :to="{ name: 'manufacturing.raw-materials' }" class="btn btn-secondary">إلغاء</router-link>
            <button type="submit" class="btn btn-primary" :disabled="saving">
              <span v-if="saving" class="spinner-border spinner-border-sm me-1"></span>
              {{ isEdit ? 'تحديث' : 'إنشاء' }} مادة خام
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'RawMaterialForm',
  data() {
    return {
      isEdit: false,
      saving: false,
      form: {
        name: '',
        unit_id: '',
        category_id: '',
        supplier_id: '',
        sku: '',
        barcode: '',
        min_stock_level: 0,
        purchase_price: 0,
        description: '',
        is_active: true,
      },
      units: [],
      categories: [],
      suppliers: [],
    };
  },
  methods: {
    async fetchData() {
      try {
        // Fetch units
        const unitsRes = await axios.get('/dashboard/api/manufacturing/units');
        this.units = unitsRes.data.data;

        // Fetch categories
        const catsRes = await axios.get('/dashboard/api/categories');
        this.categories = catsRes.data.data || catsRes.data;

        // Fetch suppliers
        const supRes = await axios.get('/dashboard/api/suppliers/dropdown');
        this.suppliers = supRes.data.data || supRes.data;
      } catch (error) {
        console.error('Error loading form data:', error);
      }
    },

    async fetchMaterial(id) {
      try {
        const response = await axios.get(`/dashboard/api/manufacturing/raw-materials/${id}`);
        const material = response.data.data;
        this.form = {
          name: material.name,
          unit_id: material.unit_id,
          category_id: material.category_id || '',
          supplier_id: material.supplier_id || '',
          sku: material.sku || '',
          barcode: material.barcode || '',
          min_stock_level: material.min_stock_level,
          purchase_price: material.purchase_price,
          description: material.description || '',
          is_active: material.is_active,
        };
      } catch (error) {
        toastr.error('فشل تحميل المادة الخام');
        this.$router.push({ name: 'manufacturing.raw-materials' });
      }
    },

    async submitForm() {
      this.saving = true;
      try {
        if (this.isEdit) {
          await axios.put(`/dashboard/api/manufacturing/raw-materials/${this.$route.params.id}`, this.form);
          toastr.success('تم تحديث المادة الخام بنجاح');
        } else {
          await axios.post('/dashboard/api/manufacturing/raw-materials', this.form);
          toastr.success('تم إنشاء المادة الخام بنجاح');
        }
        this.$router.push({ name: 'manufacturing.raw-materials' });
      } catch (error) {
        toastr.error(error.response?.data?.message || 'فشل حفظ المادة الخام');
      } finally {
        this.saving = false;
      }
    },
  },
  mounted() {
    this.fetchData();
    if (this.$route.params.id) {
      this.isEdit = true;
      this.fetchMaterial(this.$route.params.id);
    }
  },
};
</script>
