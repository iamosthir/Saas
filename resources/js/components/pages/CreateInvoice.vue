<template>
    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-12">
          <div class="modern-card card">
              <div class="card-body">
                  <h5 class="modern-card-title text-center">إنشاء فاتورة جديدة <i class="fas fa-file-invoice"></i></h5>
                  <form class="mt-5" method="POST" @submit.prevent="createInvoice">

                      <!-- قسم العميل -->
                      <div class="row">
                          <div class="col-md-12 mb-4">
                              <h6 style="font-weight: 700; color: #2d3748;">معلومات العميل</h6>
                          </div>

                          <!-- أزرار اختيار العميل -->
                          <div class="col-md-12 mb-4">
                              <div class="d-flex gap-3">
                                  <button type="button"
                                      class="modern-btn"
                                      :class="useExistingCustomer ? 'modern-btn-primary' : 'modern-btn-outline'"
                                      @click="toggleCustomerMode(true)">
                                      <i class="fas fa-search"></i> اختيار عميل موجود
                                  </button>
                                  <button type="button"
                                      class="modern-btn"
                                      :class="!useExistingCustomer && showCustomerForm ? 'modern-btn-primary' : 'modern-btn-outline'"
                                      @click="toggleCustomerMode(false)">
                                      <i class="fas fa-user-plus"></i> عميل جديد
                                  </button>
                              </div>
                          </div>

                          <!-- اختيار عميل موجود -->
                          <div class="col-md-12 mb-4" v-if="useExistingCustomer">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">بحث عن عميل</label>
                                  <multiselect v-model="selectedCustomer"
                                      :options="customers"
                                      placeholder="ابحث بالاسم أو رقم الهاتف..."
                                      label="name"
                                      track-by="id"
                                      :searchable="true"
                                      :internal-search="false"
                                      @search-change="searchCustomers"
                                      select-label="">
                                      <template slot="option" slot-scope="props">
                                          <div>
                                              <strong>{{ props.option.name }}</strong> - {{ props.option.phone }}
                                          </div>
                                      </template>
                                  </multiselect>
                              </div>
                          </div>

                          <!-- نموذج تفاصيل العميل - يظهر فقط عند الضغط على الزر -->
                          <div class="col-md-6 mb-4" v-if="showCustomerForm">
                              <div class="modern-form-group">
                                  <label class="modern-form-label" for="customerName">اسم العميل</label>
                                  <input type="text" id="customerName" class="modern-form-control"
                                      v-model="form.customer_name" placeholder="أدخل اسم العميل..."
                                      :readonly="useExistingCustomer && selectedCustomer"/>
                                  <HasError :form="form" field="customer_name"/>
                              </div>
                          </div>


                          <div class="col-md-6 mb-4" v-if="showCustomerForm">
                              <div class="modern-form-group">
                                  <label class="modern-form-label" for="customerPhone1">الهاتف الأساسي</label>
                                  <input type="text" id="customerPhone1" class="modern-form-control"
                                      v-model="form.customer_phone1" placeholder="07XXXXXXXXX"
                                      :readonly="useExistingCustomer && selectedCustomer"/>
                                  <HasError :form="form" field="customer_phone1"/>
                              </div>
                          </div>

                          <div class="col-md-6 mb-4" v-if="showCustomerForm">
                              <div class="modern-form-group">
                                  <label class="modern-form-label" for="customerPhone2">هاتف ثانوي (اختياري)</label>
                                  <input type="text" id="customerPhone2" class="modern-form-control"
                                      v-model="form.customer_phone2" placeholder="07XXXXXXXXX"
                                      :readonly="useExistingCustomer && selectedCustomer"/>
                                  <HasError :form="form" field="customer_phone2"/>
                              </div>
                          </div>

                          <div class="col-md-6 mb-4" v-if="showCustomerForm">
                              <div class="modern-form-group">
                                  <label class="modern-form-label" for="sponsorName">اسم الكفيل/الراعي (اختياري)</label>
                                  <input type="text" id="sponsorName" class="modern-form-control"
                                      v-model="form.sponsor_name" placeholder="اسم الشخص الكفيل/الشريك..."
                                      :readonly="useExistingCustomer && selectedCustomer"/>
                                  <small class="text-muted">الشخص الذي أحال هذا العميل</small>
                              </div>
                          </div>

                          <div class="col-md-6 mb-4" v-if="showCustomerForm">
                              <div class="modern-form-group">
                                  <label class="modern-form-label" for="sponsorPhone">هاتف الكفيل/الراعي (اختياري)</label>
                                  <input type="text" id="sponsorPhone" class="modern-form-control"
                                      v-model="form.sponsor_phone" placeholder="07XXXXXXXXX"
                                      :readonly="useExistingCustomer && selectedCustomer"/>
                              </div>
                          </div>

                          <div class="col-md-12 mb-4" v-if="showCustomerForm">
                              <div class="modern-form-group">
                                  <label class="modern-form-label" for="customerAddress">العنوان</label>
                                  <textarea class="modern-textarea" id="customerAddress" rows="2"
                                      v-model="form.customer_address" placeholder="أدخل العنوان الكامل..."
                                      :readonly="useExistingCustomer && selectedCustomer"></textarea>
                              </div>
                          </div>
                      </div>

                      <hr>

                      <!-- قسم المنتجات -->
                      <div class="row">
                          <div class="col-md-12 mb-4">
                              <h6 style="font-weight: 700; color: #2d3748;">المنتجات</h6>
                          </div>

                          <div class="col-md-4 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">اختر المنتج</label>
                                  <multiselect v-model="selectedProduct"
                                      :options="products"
                                      placeholder="اختر المنتج..."
                                      label="name"
                                      track-by="id"
                                      select-label="">
                                  </multiselect>
                              </div>
                          </div>

                          <div class="col-md-3 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">النوع/الخيار (اختياري)</label>
                                  <select class="modern-select" v-model="currentItem.product_variation_id">
                                      <option value="">بدون خيار</option>
                                      <option v-for="variation in productVariations"
                                          :key="variation.id"
                                          :value="variation.id">
                                          {{ variation.var_name }} - {{ variation.price }} د.ع (المخزون: {{ variation.quantity }})
                                      </option>
                                  </select>
                              </div>
                          </div>

                          <div class="col-md-3 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">سعر مخصص</label>
                                  <input type="number" class="modern-form-control"
                                      v-model="currentItem.custom_price"
                                      placeholder="0.00"
                                      step="0.01"
                                      min="0">
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">الكمية</label>
                                  <div class="modern-input-group">
                                      <button @click="currentItem.quantity--" type="button" class="modern-btn modern-btn-primary">-</button>
                                      <input type="number" class="modern-form-control" v-model="currentItem.quantity" style="text-align:center;" min="1">
                                      <button @click="currentItem.quantity++" type="button" class="modern-btn modern-btn-success">+</button>
                                  </div>
                              </div>
                          </div>

                          <div class="col-md-12 mb-4 d-flex align-items-end">
                              <button @click="addProductToInvoice" type="button" class="modern-btn modern-btn-warning">إضافة</button>
                          </div>

                          <!-- جدول المنتجات -->
                          <div class="col-md-12 mb-4">
                              <table class="modern-table table-bordered">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>المنتج</th>
                                          <th>الخيار</th>
                                          <th>الكمية</th>
                                          <th>السعر</th>
                                          <th>إجمالي السطر</th>
                                          <th>إجراء</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <template v-if="invoiceItems.length > 0">
                                          <tr v-for="(item, index) in invoiceItems" :key="index">
                                              <td>{{ index + 1 }}</td>
                                              <td>{{ item.product_name }}</td>
                                              <td>{{ item.variation_name || 'غير متوفر' }}</td>
                                              <td>{{ item.quantity }}</td>
                                              <td>{{ item.custom_price }} د.ع</td>
                                              <td>{{ (item.custom_price * item.quantity).toFixed(2) }} د.ع</td>
                                              <td>
                                                  <button @click="removeProduct(index)" class="btn btn-danger btn-sm">
                                                      <i class="fas fa-trash"></i>
                                                  </button>
                                              </td>
                                          </tr>
                                      </template>
                                      <template v-else>
                                          <tr>
                                              <td class="text-center text-muted" colspan="7">لا توجد منتجات مضافة</td>
                                          </tr>
                                      </template>

                                      <!-- صف المجموع الفرعي -->
                                      <tr v-if="invoiceItems.length > 0" class="table-info">
                                          <td colspan="5" class="text-end"><strong>المجموع الفرعي:</strong></td>
                                          <td colspan="2"><strong>{{ subtotal.toFixed(2) }} د.ع</strong></td>
                                      </tr>
                                  </tbody>
                              </table>
                          </div>
                      </div>

                      <hr>

                      <!-- قسم التسعير والدفع -->
                      <div class="row" v-if="invoiceItems.length > 0">
                          <div class="col-md-12 mb-4">
                              <h6 style="font-weight: 700; color: #2d3748;">التسعير والدفع</h6>
                          </div>

                          <!-- الخصم -->
                          <div class="col-md-6 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">نوع الخصم</label>
                                  <select class="modern-select" v-model="form.discount_type">
                                      <option value="fixed">مبلغ ثابت</option>
                                      <option value="percentage">نسبة مئوية (%)</option>
                                  </select>
                              </div>
                          </div>

                          <div class="col-md-6 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">قيمة الخصم</label>
                                  <input type="number" class="modern-form-control"
                                      v-model="form.discount_amount"
                                      :placeholder="form.discount_type === 'percentage' ? '0-100' : '0.00'"
                                      step="0.01"
                                      min="0">
                              </div>
                          </div>

                          <!-- رسوم إضافية -->
                          <div class="col-md-6 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">رسوم إضافية</label>
                                  <input type="number" class="modern-form-control"
                                      v-model="form.extra_charge"
                                      placeholder="0.00"
                                      step="0.01"
                                      min="0">
                              </div>
                          </div>

                          <!-- عرض المجموع -->
                          <div class="col-md-6 mb-4">
                              <div class="alert alert-success">
                                  <strong>المبلغ الإجمالي: {{ totalAmount.toFixed(2) }} د.ع</strong>
                              </div>
                          </div>

                          <!-- نوع الدفع -->
                          <div class="col-md-12 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">نوع الدفع</label>
                                  <div class="d-flex gap-3">
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="paymentType"
                                              id="fullPayment" value="full_payment" v-model="form.payment_type">
                                          <label class="form-check-label" for="fullPayment">
                                              دفع كامل
                                          </label>
                                      </div>
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="paymentType"
                                              id="installment" value="installment" v-model="form.payment_type">
                                          <label class="form-check-label" for="installment">
                                              أقساط
                                          </label>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <!-- حقول الدفع الكامل -->
                          <div class="col-md-6 mb-4" v-if="form.payment_type === 'full_payment'">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">المبلغ المدفوع</label>
                                  <input type="number" class="modern-form-control"
                                      v-model="form.paid_amount"
                                      :placeholder="totalAmount.toFixed(2)"
                                      step="0.01"
                                      min="0">
                                  <small class="text-muted">اتركه فارغًا ليتم تعبئته تلقائيًا بمبلغ الإجمالي</small>
                              </div>
                          </div>

                          <!-- حقول الأقساط -->
                          <template v-if="form.payment_type === 'installment'">
                              <div class="col-md-6 mb-4">
                                  <div class="modern-form-group">
                                      <label class="modern-form-label">عدد الأشهر</label>
                                      <input type="number" class="modern-form-control"
                                          v-model="form.installment_months"
                                          placeholder="أدخل عدد الأشهر..."
                                          min="1"
                                          @input="calculateInstallments">
                                      <HasError :form="form" field="installment_months"/>
                                  </div>
                              </div>

                              <div class="col-md-6 mb-4">
                                  <div class="modern-form-group">
                                      <label class="modern-form-label">عربون/دفعة مقدمة؟</label>
                                      <div class="form-check">
                                          <input type="checkbox" v-model="form.has_deposit" class="form-check-input" id="hasDeposit">
                                          <label class="form-check-label" for="hasDeposit">
                                              نعم، العميل سيدفع عربون
                                          </label>
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-6 mb-4" v-if="form.has_deposit">
                                  <div class="modern-form-group">
                                      <label class="modern-form-label">مبلغ العربون</label>
                                      <input type="number" class="modern-form-control"
                                          v-model="form.deposit_amount"
                                          placeholder="0.00"
                                          step="0.01"
                                          min="0"
                                          :max="totalAmount">
                                      <small class="text-muted">المبلغ المُمَوَّل: {{ amountToFinance.toFixed(2) }} د.ع</small>
                                      <HasError :form="form" field="deposit_amount"/>
                                  </div>
                              </div>

                              <div class="col-md-6 mb-4">
                                  <div class="modern-form-group">
                                      <label class="modern-form-label">دفعة أولية إضافية غير العربون (اختياري)</label>
                                      <input type="number" class="modern-form-control"
                                          v-model="form.paid_amount"
                                          placeholder="0.00"
                                          step="0.01"
                                          min="0">
                                      <small class="text-muted">دفعة إضافية لتغطية القسط/الأقساط الأولى</small>
                                  </div>
                              </div>

                              <!-- معاينة خطة الأقساط -->
                              <div class="col-md-12 mb-4" v-if="form.installment_months > 0">
                                  <div class="alert alert-info">
                                      <h6>معاينة خطة الأقساط:</h6>
                                      <p class="mb-1"><strong>المبلغ الإجمالي:</strong> {{ totalAmount.toFixed(2) }} د.ع</p>
                                      <p class="mb-1" v-if="form.has_deposit"><strong>العربون:</strong> {{ (parseFloat(form.deposit_amount) || 0).toFixed(2) }} د.ع</p>
                                      <p class="mb-1"><strong>المبلغ المُمَوَّل:</strong> {{ amountToFinance.toFixed(2) }} د.ع</p>
                                      <p class="mb-1"><strong>القسط الشهري:</strong> {{ monthlyInstallment.toFixed(2) }} د.ع</p>
                                      <p class="mb-0"><strong>عدد الأقساط:</strong> {{ form.installment_months }}</p>
                                  </div>
                              </div>
                          </template>

                          <!-- ملاحظات -->
                          <div class="col-md-12 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label" for="notes">ملاحظات (اختياري)</label>
                                  <textarea class="modern-textarea" id="notes" rows="3"
                                      v-model="form.notes" placeholder="أضف أي ملاحظات إضافية..."></textarea>
                              </div>
                          </div>

                          <!-- زر الإرسال -->
                          <div class="col-md-12 mb-4 text-center">
                              <Button :form="form" class="btn btn-success btn-lg">
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
                customer_name: "",
                customer_phone1: "",
                customer_phone2: "",
                customer_address: "",
                sponsor_name: "",
                sponsor_phone: "",
                payment_type: "full_payment",
                installment_months: null,
                has_deposit: false,
                deposit_amount: 0,
                paid_amount: null,
                discount_type: "fixed",
                discount_amount: 0,
                extra_charge: 0,
                notes: "",
                items: [],
            }),

            useExistingCustomer: false,
            showCustomerForm: false,
            selectedCustomer: null,
            customers: [],
            customerSearchTimeout: null,

            products: [],
            selectedProduct: null,
            productVariations: [],

            currentItem: {
                product_id: null,
                product_variation_id: null,
                quantity: 1,
                custom_price: 0,
            },

            invoiceItems: [],
        }
    },

    computed: {
        subtotal() {
            return this.invoiceItems.reduce((sum, item) => {
                return sum + (item.custom_price * item.quantity);
            }, 0);
        },

        discountValue() {
            if (this.form.discount_type === 'percentage') {
                return (this.subtotal * parseFloat(this.form.discount_amount || 0)) / 100;
            }
            return parseFloat(this.form.discount_amount || 0);
        },

        totalAmount() {
            return this.subtotal - this.discountValue + parseFloat(this.form.extra_charge || 0);
        },

        amountToFinance() {
            const deposit = this.form.has_deposit ? (parseFloat(this.form.deposit_amount) || 0) : 0;
            return this.totalAmount - deposit;
        },

        monthlyInstallment() {
            if (this.form.installment_months > 0) {
                return this.amountToFinance / this.form.installment_months;
            }
            return 0;
        }
    },

    watch: {
        'selectedCustomer': function(customer) {
            if (customer) {
                this.form.customer_name = customer.name;
                this.form.customer_phone1 = customer.phone || customer.phone1 || "";
                this.form.customer_phone2 = customer.phone2 || "";
                this.form.customer_address = "";
                this.form.sponsor_name = customer.sponsor_name || "";
                this.form.sponsor_phone = customer.sponsor_phone || "";
            }
        },

        'selectedProduct': function(product) {
            if (product) {
                this.currentItem.product_id = product.id;
                this.loadProductVariations(product.id);

                // Set price based on payment type (dual pricing)
                this.currentItem.custom_price = this.getPriceForProduct(product);
            }
        },

        'currentItem.product_variation_id': function(variationId) {
            if (variationId) {
                const variation = this.productVariations.find(v => v.id == variationId);
                if (variation) {
                    this.currentItem.custom_price = this.getPriceForVariation(variation);
                }
            } else if (this.selectedProduct) {
                this.currentItem.custom_price = this.getPriceForProduct(this.selectedProduct);
            }
        },

        'form.payment_type': function(paymentType) {
            // Update current item price when payment type changes
            if (this.currentItem.product_variation_id && this.productVariations.length > 0) {
                const variation = this.productVariations.find(v => v.id == this.currentItem.product_variation_id);
                if (variation) {
                    this.currentItem.custom_price = this.getPriceForVariation(variation);
                }
            } else if (this.selectedProduct) {
                this.currentItem.custom_price = this.getPriceForProduct(this.selectedProduct);
            }
        },

        'currentItem.quantity': function(val) {
            if (val < 1) {
                this.currentItem.quantity = 1;
            }
        },

        'useExistingCustomer': function(val) {
            if (!val) {
                this.selectedCustomer = null;
                this.form.customer_name = "";
                this.form.customer_phone1 = "";
                this.form.customer_phone2 = "";
                this.form.customer_address = "";
                this.form.sponsor_name = "";
                this.form.sponsor_phone = "";
            }
        }
    },

    methods: {
        async createInvoice() {
            if (this.invoiceItems.length < 1) {
                swal.fire("Warning", "Please add at least one product", "warning");
                return;
            }

            this.form.items = this.invoiceItems;

            await this.form.post("/dashboard/api/invoices").then(resp => {
                return resp.data;
            }).then(data => {
                if (data.status == "ok") {
                    swal.fire("Success", data.msg, "success");
                    this.resetForm();
                } else {
                    swal.fire("Failed", data.msg || "Failed to create invoice", "error");
                }
            }).catch(err => {
                console.error(err.response?.data);
                swal.fire("Error", err.response?.data?.message || "An error occurred", "error");
            });
        },

        async loadProductList() {
            await axios.get("/dashboard/api/product-list").then(resp => {
                return resp.data;
            }).then(data => {
                this.products = data;
            }).catch(err => {
                console.error(err.response?.data);
            });
        },

        async loadProductVariations(productId) {
            this.productVariations = [];
            this.currentItem.product_variation_id = null;

            await axios.get("/dashboard/api/get-product-variations", {
                params: { productId }
            }).then(resp => {
                return resp.data;
            }).then(data => {
                this.productVariations = data;
            }).catch(err => {
                console.error(err.response?.data);
            });
        },

        searchCustomers(search) {
            clearTimeout(this.customerSearchTimeout);

            this.customerSearchTimeout = setTimeout(async () => {
                if (search.length >= 2) {
                    await axios.get("/dashboard/api/customers", {
                        params: { search }
                    }).then(resp => {
                        this.customers = resp.data;
                    }).catch(err => {
                        console.error(err.response?.data);
                    });
                }
            }, 500);
        },

        addProductToInvoice() {
            if (!this.selectedProduct) {
                swal.fire("Warning", "Please select a product", "warning");
                return;
            }

            if (this.currentItem.custom_price <= 0) {
                swal.fire("Warning", "Please enter a valid price", "warning");
                return;
            }

            const variation = this.productVariations.find(v => v.id == this.currentItem.product_variation_id);

            this.invoiceItems.push({
                product_id: this.currentItem.product_id,
                product_variation_id: this.currentItem.product_variation_id || null,
                product_name: this.selectedProduct.name,
                variation_name: variation ? variation.var_name : null,
                quantity: this.currentItem.quantity,
                custom_price: parseFloat(this.currentItem.custom_price),
            });

            // Reset current item
            this.selectedProduct = null;
            this.productVariations = [];
            this.currentItem = {
                product_id: null,
                product_variation_id: null,
                quantity: 1,
                custom_price: 0,
            };
        },

        removeProduct(index) {
            this.invoiceItems.splice(index, 1);
        },

        calculateInstallments() {
            // This method is called when installment months change
            // The computed property monthlyInstallment handles the calculation
        },

        toggleCustomerMode(useExisting) {
            this.useExistingCustomer = useExisting;
            this.showCustomerForm = true;

            if (!useExisting) {
                // Clear existing customer selection when switching to new customer
                this.selectedCustomer = null;
            }
        },

        resetForm() {
            this.form.reset();
            this.invoiceItems = [];
            this.selectedProduct = null;
            this.selectedCustomer = null;
            this.useExistingCustomer = false;
            this.showCustomerForm = false;
            this.currentItem = {
                product_id: null,
                product_variation_id: null,
                quantity: 1,
                custom_price: 0,
            };
        },

        getPriceForProduct(product) {
            if (this.form.payment_type === 'full_payment') {
                return parseFloat(product.sell_price || product.default_price || 0);
            } else {
                return parseFloat(product.installment_price || product.sell_price || product.default_price || 0);
            }
        },

        getPriceForVariation(variation) {
            if (this.form.payment_type === 'full_payment') {
                return parseFloat(variation.price || 0);
            } else {
                return parseFloat(variation.installment_price || variation.price || 0);
            }
        }
    },

    mounted() {
        this.loadProductList();
    }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
.gap-3 {
    gap: 1rem;
}
</style>
