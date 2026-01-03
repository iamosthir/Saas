<template>
  <div class="row justify-content-center">
    <div class="col-md-9 col-lg-7">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-center">
            <strong>أنشاء طلب جديد <i class="fas fa-file-invoice"></i></strong>
          </h5>
          <form class="mt-5" method="POST" @submit.prevent="createSupplierInvoice">
            <div class="row">

              <!-- Product Selection -->
              <div class="col-md-4 mb-4">
                <label class="form-label">أختيار المنتج</label>
                <multiselect v-model="selectedProduct"
                  :options="products"
                  placeholder="أختيار المنتج.."
                  label="name"
                  track-by="id"
                  select-label="">
                </multiselect>
              </div>

              <!-- Variant Selection -->
              <div class="col-md-5 mb-4">
                <label class="form-label">القياس</label>
                <select class="form-select" v-model="productForm.variant_id">
                  <option value="" hidden selected>أختيار القياس</option>
                  <option
                    v-for="(vars, i) in productVars"
                    :key="i"
                    :value="vars.id"
                    :style="{ color: vars.quantity <= 5 ? 'red' : 'black' }">
                    {{ vars.var_name }} - {{ vars.price }} IQD ({{ vars.quantity }} in Stock)
                  </option>
                </select>
              </div>

              <!-- Quantity Input -->
              <div class="col-md-3 mb-4">
                <label class="form-label">العدد</label>
                <div class="input-group">
                  <button @click="productForm.qnt = productForm.qnt > 1 ? productForm.qnt-1 : 1" type="button" class="btn btn-primary">-</button>
                  <input type="number" class="form-control text-center" v-model="productForm.qnt">
                  <button @click="productForm.qnt++" type="button" class="btn btn-success">+</button>
                </div>
              </div>

              <div class="col-md-12 mb-4">
                <button @click="addProductList" type="button" class="btn btn-sm btn-warning">إضافة</button>
              </div>

              <!-- Product Table -->
              <div class="col-md-12 mb-4">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>أسم المنتج</th>
                      <th>المتغير</th>
                      <th>العدد</th>
                      <th>سعر الشراء</th>
                      <th>المجموع</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <template v-if="addedProductList.length > 0">
                      <tr v-for="(pr,i) in addedProductList" :key="i">
                        <td>{{ i+1 }}</td>
                        <td>{{ pr.product_name }}</td>
                        <td>{{ pr.variant_name }}</td>
                        <td>{{ pr.qnt }}</td>
                        <td>{{ pr.price }} IQD</td>
                        <td>{{ pr.total_price }}</td>
                        <td>
                          <button @click="removeProduct(i)" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="5" class="text-end"><b>الإجمالي</b></td>
                        <td colspan="2"><b>{{ invoiceTotal }} IQD</b></td>
                      </tr>
                    </template>
                    <template v-else>
                      <tr>
                        <td class="text-center text-muted" colspan="7">لم يتم اضافة منتجات</td>
                      </tr>
                    </template>
                  </tbody>
                </table>
              </div>
            </div>

            <hr>

            <!-- Payment and Note -->
            <div class="row">
              <div class="col-md-6 mb-4">
                <label class="form-label">حالة الدفع</label>
                <select class="form-select" v-model="form.payment_status">
                  <option value="" hidden selected>اختر حالة الدفع</option>
                  <option value="pending">قيد الانتظار</option>
                  <option value="paid">مدفوع</option>
                  <option value="partial">مدفوع جزئيا</option>
                </select>
              </div>
              <div class="col-md-6 mb-4">
                <label class="form-label">حالة الطلب</label>
                <select class="form-select" v-model="form.order_status">
                  <option value="" hidden selected>اختر حالة الطلب</option>
                  <option value="draft">مسودة</option>
                  <option value="confirmed">مؤكد</option>
                  <option value="cancelled">ملغى</option>
                </select>
              </div>
              <div class="col-md-12 mb-4">
                <label class="form-label">ملاحظة</label>
                <textarea class="form-control" id="noteArea" rows="4" v-model="form.note"></textarea>
              </div>
              <div class="col-md-12 mb-4 text-center">
                <Button :form="form" class="btn btn-success">
                  أنشاء الطلب <i class="fas fa-check-circle"></i>
                </Button>
              </div>
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
        supplier_id: "",
        note: "",
        products: [],
        payment_status: "",
        order_status: "",
      }),
      products: [],
      productVars: [],
      selectedProduct: "",
      productForm: {
        product_id: "",
        variant_id: "",
        qnt: 1,
      },
      addedProductList: [],
      supplier_id: null,
    }
  },
  methods: {
    async getProductList() {
      await axios.get("/dashboard/api/product-list?merchant_id=" + this.supplier_id)
        .then(resp => { this.products = resp.data })
        .catch(err => { console.error(err.response.data); });
    },
    async getProductVars(productId) {
      if (!productId) {
        this.productVars = [];
        return;
      }
      await axios.get("/dashboard/api/get-product-variations", { params: { productId } })
        .then(resp => { this.productVars = resp.data; })
        .catch(err => { this.productVars = []; });
    },
    addProductList() {
      if (!this.selectedProduct || !this.productForm.variant_id || !this.productForm.qnt || this.productForm.qnt < 1) {
        swal.fire("Warning", "يرجى اختيار المنتج والقياس والعدد.", "warning");
        return;
      }
      let product = this.selectedProduct;
      let variant = this.productVars.find(v => v.id === this.productForm.variant_id);
      if (!variant) {
        swal.fire("Error", "القياس غير متوفر!", "error");
        return;
      }
      let price = Number(variant.price);
      let qnt = Number(this.productForm.qnt);
      this.addedProductList.push({
        product_id: product.id,
        product_name: product.name,
        variant_id: this.productForm.variant_id,
        variant_name: variant.var_name || '',
        qnt: qnt,
        price: price,
        total_price: price * qnt
      });
      this.selectedProduct = "";
      this.productVars = [];
      this.productForm = { product_id: "", variant_id: "", qnt: 1 };
    },

    removeProduct(index) {
      this.addedProductList.splice(index, 1);
    },

    createSupplierInvoice() {
      if (this.addedProductList.length < 1) {
        swal.fire("Warning", "Please add product first", "warning");
        return;
      }
      this.form.supplier_id = this.supplier_id;
      this.form.products = this.addedProductList.map(pr => ({
        product_id: pr.product_id,
        product_name: pr.product_name,
        variant_id: pr.variant_id,
        variant_name: pr.variant_name,
        qnt: pr.qnt,
        price: pr.price,
        total_price: pr.total_price
      }));
      this.form.post("/dashboard/api/create-supplier-invoice")
        .then(resp => resp.data)
        .then(data => {
          if (data.status == "ok") {
            swal.fire("Success", data.msg, "success");
            this.form.reset();
            this.addedProductList = [];
            setTimeout(() => {
              window.location.reload();
            }, 2000);
          } else {
            swal.fire("Failed", "Failed to create this order. You may not have proper permission", "error");
          }
        }).catch(err => {
          console.error(err.response.data);
        })
    }
  },
  watch: {
    selectedProduct: function (newVal) {
      if (newVal && newVal.id) {
        this.productForm.product_id = newVal.id;
        this.productForm.variant_id = "";
        this.getProductVars(newVal.id);
      } else {
        this.productForm.product_id = "";
        this.productVars = [];
        this.productForm.variant_id = "";
      }
    }
  },
  computed: {
    invoiceTotal() {
      return this.addedProductList.reduce((sum, item) => sum + Number(item.total_price), 0);
    }
  },
  mounted() {
    this.supplier_id = this.$route.params.id;
    this.getProductList();
  }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
