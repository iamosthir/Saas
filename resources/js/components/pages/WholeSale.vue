<template>
  <div class="row justify-content-center">
    <div class="col-md-9 col-lg-7">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-center">
            <strong>عملية بيع جملة <i class="fas fa-cash-register"></i></strong>
          </h5>
          <form class="mt-5" method="POST" @submit.prevent="submitWholesaleSale">
            <div class="row">

              <!-- Customer Selection -->
              <div class="col-md-12 mb-4">
                <label class="form-label">اختر الزبون</label>
                <multiselect
                  v-model="selectedCustomer"
                  :options="customers"
                  placeholder="اختر زبون ..."
                  label="customer_name"
                  track-by="id"
                  :searchable="true"
                  :clear-on-select="false"
                  :allow-empty="false"
                />
              </div>

              <!-- Product Selection -->
              <div class="col-md-5 mb-4">
                <label class="form-label">أختيار المنتج</label>
                <multiselect v-model="selectedProduct"
                  :options="products"
                  placeholder="أختيار المنتج.."
                  label="name"
                  track-by="id"
                  select-label="">
                </multiselect>
              </div>

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

              <div class="col-md-2 mb-4">
                <label class="form-label">العدد</label>
                <div class="input-group input-group-lg">
                  <button @click="productForm.qnt++" type="button" class="btn btn-success border-red-0">+</button>
                  <input type="number" class="form-control form-control-lg text-center" v-model="productForm.qnt">
                  <button @click="productForm.qnt = productForm.qnt > 1 ? productForm.qnt-1 : 1" type="button" class="btn btn-primary border-red-0">-</button>
                </div>
              </div>

              <div class="col-md-12 mb-4">
                <button @click="addProductList" type="button" class="btn btn-sm btn-warning">Add</button>
              </div>

              <div class="col-md-12 mb-4">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>أسم المنتج</th>
                      <th>المتغير</th>
                      <th>العدد</th>
                      <th>السعر</th>
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
                        <td colspan="5" class="text-end"><b>Total</b></td>
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
                <textarea class="form-control" rows="3" v-model="form.note"></textarea>
              </div>
              <div class="col-md-12 mb-4 text-center">
                <Button :form="form" class="btn btn-success">
                  إنشاء الفاتورة <i class="fas fa-check-circle"></i>
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
        customer_id: "",
        note: "",
        products: [],
        payment_status: "",
        order_status: "",
      }),
      customers: [],
      products: [],
      productVars: [],
      selectedCustomer: "",
      selectedProduct: "",
      productForm: {
        product_id: "",
        variant_id: "",
        qnt: 1,
      },
      addedProductList: [],
    }
  },
  methods: {
    async getCustomerList() {
      await axios.get("/dashboard/api/customer-list")
        .then(resp => { this.customers = resp.data.data || resp.data; })
        .catch(() => { this.customers = []; });
    },
    async getProductList() {
      await axios.get("/dashboard/api/product-list")
        .then(resp => { this.products = resp.data; })
        .catch(() => { this.products = []; });
    },
    async getProductVars(productId) {
      if (!productId) {
        this.productVars = [];
        return;
      }
      await axios.get("/dashboard/api/get-product-variations", { params: { productId } })
        .then(resp => { this.productVars = resp.data; })
        .catch(() => { this.productVars = []; });
    },
    addProductList() {
      if (!this.selectedProduct || !this.productForm.variant_id || !this.productForm.qnt || this.productForm.qnt < 1) {
        swal.fire("Warning", "Please select product, variant and quantity.", "warning");
        return;
      }
      let product = this.selectedProduct;
      let variant = this.productVars.find(v => v.id === this.productForm.variant_id) || {};
      let price = Number(variant.price || 0);
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
    submitWholesaleSale() {
      if (!this.selectedCustomer) {
        swal.fire("تنبيه", "يرجى اختيار الزبون أولاً", "warning");
        return;
      }
      if (this.addedProductList.length < 1) {
        swal.fire("تنبيه", "يرجى إضافة المنتجات أولاً", "warning");
        return;
      }
      this.form.customer_id = this.selectedCustomer.id;
      this.form.products = this.addedProductList.map(pr => ({
        product_id: pr.product_id,
        product_name: pr.product_name,
        variant_id: pr.variant_id,
        variant_name: pr.variant_name,
        qnt: pr.qnt,
        price: pr.price,
        total_price: pr.total_price
      }));
      this.form.post("/dashboard/api/create-customer-invoice")
        .then(resp => resp.data)
        .then(data => {
          if (data.status == "ok") {
            swal.fire("تم", data.msg, "success");
            this.form.reset();
            this.addedProductList = [];
            this.selectedCustomer = "";
            setTimeout(() => {
              window.location.reload();
            }, 2000);
          } else {
            swal.fire("فشل", "فشل في إنشاء الفاتورة", "error");
          }
        }).catch(err => {
          console.error(err.response.data);
        });
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
    this.getCustomerList();
    this.getProductList();
  }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
