<template>
  <div class="row justify-content-center">
    <div class="col-md-12 col-lg-11">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><i class="fas fa-plus-circle"></i> إضافة منتج جديد</h5>
          <router-link :to="{name: 'product.list'}" class="btn btn-sm btn-primary">
            <i class="fas fa-list"></i> قائمة المنتجات
          </router-link>
        </div>
        <div class="card-body">
          <form @submit.prevent="addProduct">

            <!-- Product Info Section -->
            <div class="section-container mb-4">
              <h6 class="section-title"><i class="fas fa-info-circle"></i> معلومات المنتج</h6>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">اسم المنتج <span class="text-danger">*</span></label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.name"
                    :class="{'is-invalid': form.errors.has('name')}"
                    placeholder="أدخل اسم المنتج"
                    required
                  >
                  <HasError :form="form" field="name" />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">الموديل</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.model_name"
                    placeholder="أدخل رقم الموديل"
                  >
                </div>
                <div class="col-md-12 mb-3">
                  <label class="form-label">الوصف</label>
                  <textarea
                    class="form-control"
                    v-model="form.description"
                    rows="3"
                    placeholder="وصف تفصيلي للمنتج"
                  ></textarea>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">التصنيف</label>
                  <select class="form-control" v-model="form.category_id" @change="loadSubCategories">
                    <option :value="null">اختر التصنيف الرئيسي</option>
                    <option v-for="cat in mainCategories" :key="cat.id" :value="cat.id">
                      {{ cat.name }}
                    </option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">التصنيف الفرعي</label>
                  <select class="form-control" v-model="form.sub_category_id" :disabled="!subCategories.length">
                    <option :value="null">اختر التصنيف الفرعي</option>
                    <option v-for="cat in subCategories" :key="cat.id" :value="cat.id">
                      {{ cat.name }}
                    </option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">صورة المنتج الرئيسية</label>
                  <input
                    type="file"
                    class="form-control"
                    accept="image/*"
                    @change="handleImageUpload($event, 'image')"
                  >
                  <small class="text-muted">الحجم الموصى به: 800x800 بكسل</small>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">صورة مصغرة</label>
                  <input
                    type="file"
                    class="form-control"
                    accept="image/*"
                    @change="handleImageUpload($event, 'thumbnail')"
                  >
                  <small class="text-muted">الحجم الموصى به: 300x300 بكسل</small>
                </div>
              </div>
            </div>

            <!-- Price Info Section -->
            <div class="section-container mb-4">
              <h6 class="section-title"><i class="fas fa-dollar-sign"></i> معلومات السعر</h6>
              <div class="row">
                <div class="col-md-3 mb-3">
                  <label class="form-label">سعر الشراء <span class="text-danger">*</span></label>
                  <input
                    type="number"
                    class="form-control"
                    v-model="form.purchase_price"
                    :class="{'is-invalid': form.errors.has('purchase_price')}"
                    placeholder="0.00"
                    step="0.01"
                    min="0"
                    required
                  >
                  <HasError :form="form" field="purchase_price" />
                </div>
                <div class="col-md-3 mb-3">
                  <label class="form-label">سعر البيع <span class="text-danger">*</span></label>
                  <input
                    type="number"
                    class="form-control"
                    v-model="form.sell_price"
                    :class="{'is-invalid': form.errors.has('sell_price')}"
                    placeholder="0.00"
                    step="0.01"
                    min="0"
                    required
                  >
                  <HasError :form="form" field="sell_price" />
                </div>
                <div class="col-md-3 mb-3">
                  <label class="form-label">نوع الخصم</label>
                  <select class="form-control" v-model="form.discount_type">
                    <option :value="null">بدون خصم</option>
                    <option value="fixed">خصم ثابت</option>
                    <option value="percentage">نسبة مئوية</option>
                  </select>
                </div>
                <div class="col-md-3 mb-3">
                  <label class="form-label">قيمة الخصم</label>
                  <input
                    type="number"
                    class="form-control"
                    v-model="form.discount_amount"
                    placeholder="0.00"
                    step="0.01"
                    min="0"
                    :disabled="!form.discount_type"
                  >
                  <small class="text-muted" v-if="form.discount_type === 'percentage'">النسبة المئوية</small>
                  <small class="text-muted" v-if="form.discount_type === 'fixed'">المبلغ الثابت</small>
                </div>
              </div>
            </div>

            <!-- Attributes/Variations Section -->
            <div class="section-container mb-4">
              <h6 class="section-title"><i class="fas fa-sliders-h"></i> الخصائص والمتغيرات</h6>

              <div class="mb-3">
                <label class="form-label">اختر الخصائص</label>
                <multiselect
                  v-model="selectedAttributes"
                  :options="attributes"
                  :multiple="true"
                  :close-on-select="false"
                  :clear-on-select="false"
                  :preserve-search="true"
                  placeholder="اختر الخصائص (مثل: اللون، الحجم، الذاكرة...)"
                  label="name"
                  track-by="id"
                  @input="generateVariationTemplate"
                >
                  <template slot="selection" slot-scope="{ values, isOpen }">
                    <span class="multiselect__single" v-if="values.length && !isOpen">
                      {{ values.length }} خاصية محددة
                    </span>
                  </template>
                </multiselect>
                <small class="text-muted">يمكنك اختيار عدة خصائص لإنشاء متغيرات المنتج</small>
              </div>

              <div v-if="selectedAttributes.length > 0" class="variations-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h6 class="mb-0">جدول المتغيرات</h6>
                  <button type="button" class="btn btn-sm btn-success" @click="addVariation">
                    <i class="fas fa-plus"></i> إضافة متغير
                  </button>
                </div>

                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead class="table-light">
                      <tr>
                        <th v-for="attr in selectedAttributes" :key="attr.id" style="min-width: 120px">
                          {{ attr.name }}
                        </th>
                        <th style="min-width: 120px">سعر الشراء</th>
                        <th style="min-width: 120px">سعر البيع</th>
                        <th style="min-width: 100px">الكمية</th>
                        <th style="min-width: 150px">اسم المتغير</th>
                        <th style="width: 80px">حذف</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(variation, index) in form.variations" :key="index">
                        <td v-for="attr in selectedAttributes" :key="attr.id">
                          <input
                            type="text"
                            class="form-control form-control-sm"
                            v-model="variation.attributes[attr.name]"
                            @input="generateVariationName(index)"
                            :placeholder="attr.name"
                          >
                        </td>
                        <td>
                          <input
                            type="number"
                            class="form-control form-control-sm"
                            v-model="variation.purchase_price"
                            placeholder="0.00"
                            step="0.01"
                            min="0"
                          >
                        </td>
                        <td>
                          <input
                            type="number"
                            class="form-control form-control-sm"
                            v-model="variation.sell_price"
                            placeholder="0.00"
                            step="0.01"
                            min="0"
                          >
                        </td>
                        <td>
                          <input
                            type="number"
                            class="form-control form-control-sm"
                            v-model="variation.quantity"
                            placeholder="0"
                            min="0"
                            @input="calculateTotalStock"
                          >
                        </td>
                        <td>
                          <input
                            type="text"
                            class="form-control form-control-sm bg-light"
                            v-model="variation.var_name"
                            readonly
                            placeholder="سيتم التوليد تلقائياً"
                          >
                        </td>
                        <td class="text-center">
                          <button
                            type="button"
                            class="btn btn-sm btn-danger"
                            @click="removeVariation(index)"
                            :disabled="form.variations.length === 1"
                          >
                            <i class="fas fa-trash"></i>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                    <tfoot class="table-light">
                      <tr>
                        <td :colspan="selectedAttributes.length + 2" class="text-end fw-bold">إجمالي المخزون:</td>
                        <td class="fw-bold text-primary">{{ totalStock }}</td>
                        <td colspan="2"></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>

              <div v-else class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                الرجاء اختيار الخصائص أولاً لإنشاء متغيرات المنتج
              </div>
            </div>

            <!-- Submit Button -->
            <div class="text-end">
              <button type="button" class="btn btn-secondary me-2" @click="resetForm">
                <i class="fas fa-redo"></i> إعادة تعيين
              </button>
              <Button :form="form" class="btn btn-success btn-lg px-5">
                <i class="fas fa-save"></i> حفظ المنتج
              </Button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: new Form({
        name: "",
        model_name: "",
        description: "",
        category_id: null,
        sub_category_id: null,
        image: null,
        thumbnail: null,
        purchase_price: "",
        sell_price: "",
        discount_type: null,
        discount_amount: 0,
        variations: [],
        variant_data: "",
      }),
      categories: [],
      attributes: [],
      selectedAttributes: [],
      totalStock: 0,
    }
  },
  computed: {
    mainCategories() {
      return this.categories.filter(cat => !cat.parent_id);
    },
    subCategories() {
      if (!this.form.category_id) return [];
      return this.categories.filter(cat => cat.parent_id === this.form.category_id);
    }
  },
  methods: {
    async fetchCategories() {
      try {
        const response = await axios.get('/dashboard/api/categories');
        this.categories = response.data;
      } catch (error) {
        console.error('Error fetching categories:', error);
      }
    },
    async fetchAttributes() {
      try {
        const response = await axios.get('/dashboard/api/attributes');
        this.attributes = response.data.filter(attr => attr.is_active);
      } catch (error) {
        console.error('Error fetching attributes:', error);
      }
    },
    loadSubCategories() {
      // Reset sub category when main category changes
      this.form.sub_category_id = null;
    },
    handleImageUpload(event, type) {
      const file = event.target.files[0];
      if (file) {
        this.form[type] = file;
      } else {
        this.form[type] = null;
      }
    },
    generateVariationTemplate() {
      // When attributes are selected, create initial variation structure
      if (this.selectedAttributes.length > 0 && this.form.variations.length === 0) {
        this.addVariation();
      }
    },
    addVariation() {
      const newVariation = {
        attributes: {},
        purchase_price: this.form.purchase_price || "",
        sell_price: this.form.sell_price || "",
        quantity: 1,
        var_name: ""
      };

      // Initialize attribute values
      this.selectedAttributes.forEach(attr => {
        newVariation.attributes[attr.name] = "";
      });

      this.form.variations.push(newVariation);
    },
    removeVariation(index) {
      if (this.form.variations.length > 1) {
        this.form.variations.splice(index, 1);
        this.calculateTotalStock();
      }
    },
    generateVariationName(index) {
      const variation = this.form.variations[index];
      const values = [];

      this.selectedAttributes.forEach(attr => {
        const value = variation.attributes[attr.name];
        if (value && value.trim() !== "") {
          values.push(value.trim());
        }
      });

      variation.var_name = values.join('-');
    },
    calculateTotalStock() {
      this.totalStock = this.form.variations.reduce((sum, variation) => {
        return sum + (parseInt(variation.quantity) || 0);
      }, 0);
    },
    async addProduct() {
      // Validate variations
      if (!this.selectedAttributes.length) {
        swal.fire("خطأ", "الرجاء اختيار الخصائص وإضافة المتغيرات", "error");
        return;
      }

      if (!this.form.variations.length) {
        swal.fire("خطأ", "الرجاء إضافة متغير واحد على الأقل", "error");
        return;
      }

      // Validate each variation
      for (let i = 0; i < this.form.variations.length; i++) {
        const variation = this.form.variations[i];

        if (!variation.var_name) {
          swal.fire("خطأ", `الرجاء إدخال قيم الخصائص للمتغير ${i + 1}`, "error");
          return;
        }

        if (!variation.purchase_price || !variation.sell_price || !variation.quantity) {
          swal.fire("خطأ", `الرجاء إدخال السعر والكمية للمتغير ${i + 1}`, "error");
          return;
        }
      }

      // Prepare variations data
      const variationsData = this.form.variations.map(v => ({
        var_name: v.var_name,
        attribute_values: v.attributes,
        purchase_price: parseFloat(v.purchase_price) || 0,
        sell_price: parseFloat(v.sell_price) || 0,
        quantity: parseInt(v.quantity) || 0
      }));

      this.form.variant_data = JSON.stringify(variationsData);

      // Use sub_category_id if selected, otherwise use category_id
      if (this.form.sub_category_id) {
        this.form.category_id = this.form.sub_category_id;
      }

      try {
        const response = await this.form.post("/dashboard/api/store-product");
        if (response.data.status === "ok") {
          swal.fire("نجح", response.data.msg, "success");
          this.resetForm();
        } else {
          swal.fire("فشل", response.data.msg, "error");
        }
      } catch (err) {
        console.error(err);
        swal.fire("خطأ", "حدث خطأ أثناء إضافة المنتج", "error");
      }
    },
    resetForm() {
      this.form.reset();
      this.form.clear();
      this.selectedAttributes = [];
      this.form.variations = [];
      this.totalStock = 0;
      this.form.discount_type = null;
      this.form.category_id = null;
      this.form.sub_category_id = null;
    }
  },
  mounted() {
    this.fetchCategories();
    this.fetchAttributes();
  }
}
</script>

<style scoped>
.section-container {
  background: #f8f9fa;
  border-radius: 10px;
  padding: 1.5rem;
  border: 1px solid #e0e0e0;
}

.section-title {
  color: #667eea;
  font-weight: 600;
  margin-bottom: 1rem;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid #667eea;
}

.variations-container {
  background: white;
  padding: 1rem;
  border-radius: 8px;
  border: 1px solid #dee2e6;
}

.table th {
  background: #667eea;
  color: white;
  font-weight: 600;
  text-align: center;
  vertical-align: middle;
}

.table td {
  vertical-align: middle;
}

.form-label {
  font-weight: 500;
  color: #495057;
  margin-bottom: 0.5rem;
}

.text-danger {
  color: #dc3545;
}

.table-responsive {
  max-height: 500px;
  overflow-y: auto;
}

.multiselect {
  min-height: 40px;
}

.bg-light {
  background-color: #f8f9fa !important;
}
</style>
