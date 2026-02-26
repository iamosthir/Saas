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
                <label class="form-label">المورد <span class="text-danger">*</span></label>
                <div class="d-flex align-items-start gap-2">
                  <div class="flex-grow-1">
                    <multiselect
                      v-model="selectedSupplier"
                      :options="suppliers"
                      placeholder="ابحث عن مورد..."
                      label="name"
                      track-by="id"
                      :searchable="true"
                      :allow-empty="false"
                      select-label=""
                      selected-label=""
                      deselect-label="">
                      <template slot="option" slot-scope="props">
                        <div>
                          <strong>{{ props.option.name }}</strong>
                          <span v-if="props.option.phone" class="text-muted ms-2">{{ props.option.phone }}</span>
                        </div>
                      </template>
                      <template slot="noResult">لا توجد نتائج</template>
                    </multiselect>
                  </div>
                  <button type="button" class="btn btn-outline-primary btn-sm mt-1" @click="openSupplierModal" title="إضافة مورد جديد">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
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
    <!-- Quick-Create Supplier Modal -->
    <div class="modal fade" id="supplierModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">إضافة مورد جديد</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">اسم المورد <span class="text-danger">*</span></label>
              <input type="text" class="form-control" v-model="supplierForm.name" required>
            </div>
            <div class="mb-3">
              <label class="form-label">الهاتف</label>
              <input type="text" class="form-control" v-model="supplierForm.phone" placeholder="اختياري">
            </div>
            <div class="mb-3">
              <label class="form-label">العنوان / ملاحظات</label>
              <textarea class="form-control" v-model="supplierForm.address" rows="2" placeholder="اختياري"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
            <button type="button" class="btn btn-primary" @click="saveSupplier" :disabled="savingSupplier || !supplierForm.name.trim()">
              <span v-if="savingSupplier" class="spinner-border spinner-border-sm me-1"></span>
              حفظ المورد
            </button>
          </div>
        </div>
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
      savingSupplier: false,
      selectedSupplier: null,
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
      supplierForm: {
        name: '',
        phone: '',
        address: '',
      },
      units: [],
      categories: [],
      suppliers: [],
    };
  },
  watch: {
    selectedSupplier(val) {
      this.form.supplier_id = val ? val.id : '';
    },
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
        if (material.supplier_id) {
          this.selectedSupplier = this.suppliers.find(s => s.id === material.supplier_id) || null;
        }
      } catch (error) {
        toastr.error('فشل تحميل المادة الخام');
        this.$router.push({ name: 'manufacturing.raw-materials' });
      }
    },

    openSupplierModal() {
      this.supplierForm = { name: '', phone: '', address: '' };
      $('#supplierModal').modal('show');
    },

    async saveSupplier() {
      this.savingSupplier = true;
      try {
        const res = await axios.post('/dashboard/api/suppliers/store', this.supplierForm);
        const newSupplier = res.data.data;
        this.suppliers.push(newSupplier);
        this.selectedSupplier = newSupplier;
        $('#supplierModal').modal('hide');
        toastr.success('تم إضافة المورد بنجاح');
      } catch (error) {
        toastr.error(error.response?.data?.message || 'فشل إضافة المورد');
      } finally {
        this.savingSupplier = false;
      }
    },

    async submitForm() {
      if (!this.form.supplier_id) {
        toastr.error('يجب اختيار مورد');
        return;
      }
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
  async mounted() {
    await this.fetchData();
    if (this.$route.params.id) {
      this.isEdit = true;
      this.fetchMaterial(this.$route.params.id);
    }
  },
};
</script>
