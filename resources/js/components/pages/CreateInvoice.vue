<template>
    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-12">
          <div class="modern-card card">
              <div class="card-body">
                  <h5 class="modern-card-title text-center">Create New Invoice <i class="fas fa-file-invoice"></i></h5>
                  <form class="mt-5" method="POST" @submit.prevent="createInvoice">

                      <!-- Customer Section -->
                      <div class="row">
                          <div class="col-md-12 mb-4">
                              <h6 style="font-weight: 700; color: #2d3748;">Customer Information</h6>
                          </div>

                          <!-- Customer Selection Buttons -->
                          <div class="col-md-12 mb-4">
                              <div class="d-flex gap-3">
                                  <button type="button"
                                      class="modern-btn"
                                      :class="useExistingCustomer ? 'modern-btn-primary' : 'modern-btn-outline'"
                                      @click="toggleCustomerMode(true)">
                                      <i class="fas fa-search"></i> Select Existing Customer
                                  </button>
                                  <button type="button"
                                      class="modern-btn"
                                      :class="!useExistingCustomer && showCustomerForm ? 'modern-btn-primary' : 'modern-btn-outline'"
                                      @click="toggleCustomerMode(false)">
                                      <i class="fas fa-user-plus"></i> New Customer
                                  </button>
                              </div>
                          </div>

                          <!-- Existing Customer Select -->
                          <div class="col-md-12 mb-4" v-if="useExistingCustomer">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">Search Customer</label>
                                  <multiselect v-model="selectedCustomer"
                                      :options="customers"
                                      placeholder="Search by name or phone..."
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

                          <!-- Customer Details Form - Only show when button clicked -->
                          <div class="col-md-6 mb-4" v-if="showCustomerForm">
                              <div class="modern-form-group">
                                  <label class="modern-form-label" for="customerName">Customer Name</label>
                                  <input type="text" id="customerName" class="modern-form-control"
                                      v-model="form.customer_name" placeholder="Enter customer name..."
                                      :readonly="useExistingCustomer && selectedCustomer"/>
                                  <HasError :form="form" field="customer_name"/>
                              </div>
                          </div>

                          <div class="col-md-6 mb-4" v-if="showCustomerForm">
                              <div class="modern-form-group">
                                  <label class="modern-form-label" for="customerEmail">Email (Optional)</label>
                                  <input type="email" id="customerEmail" class="modern-form-control"
                                      v-model="form.customer_email" placeholder="customer@email.com"
                                      :readonly="useExistingCustomer && selectedCustomer"/>
                                  <HasError :form="form" field="customer_email"/>
                              </div>
                          </div>

                          <div class="col-md-6 mb-4" v-if="showCustomerForm">
                              <div class="modern-form-group">
                                  <label class="modern-form-label" for="customerPhone1">Primary Phone</label>
                                  <input type="text" id="customerPhone1" class="modern-form-control"
                                      v-model="form.customer_phone1" placeholder="07XXXXXXXXX"
                                      :readonly="useExistingCustomer && selectedCustomer"/>
                                  <HasError :form="form" field="customer_phone1"/>
                              </div>
                          </div>

                          <div class="col-md-6 mb-4" v-if="showCustomerForm">
                              <div class="modern-form-group">
                                  <label class="modern-form-label" for="customerPhone2">Secondary Phone (Optional)</label>
                                  <input type="text" id="customerPhone2" class="modern-form-control"
                                      v-model="form.customer_phone2" placeholder="07XXXXXXXXX"
                                      :readonly="useExistingCustomer && selectedCustomer"/>
                                  <HasError :form="form" field="customer_phone2"/>
                              </div>
                          </div>

                          <div class="col-md-6 mb-4" v-if="showCustomerForm">
                              <div class="modern-form-group">
                                  <label class="modern-form-label" for="customerState">State</label>
                                  <input type="text" id="customerState" class="modern-form-control"
                                      v-model="form.customer_state" placeholder="Enter state..."
                                      :readonly="useExistingCustomer && selectedCustomer"/>
                              </div>
                          </div>

                          <div class="col-md-6 mb-4" v-if="showCustomerForm">
                              <div class="modern-form-group">
                                  <label class="modern-form-label" for="customerCity">City</label>
                                  <input type="text" id="customerCity" class="modern-form-control"
                                      v-model="form.customer_city" placeholder="Enter city..."
                                      :readonly="useExistingCustomer && selectedCustomer"/>
                              </div>
                          </div>

                          <div class="col-md-12 mb-4" v-if="showCustomerForm">
                              <div class="modern-form-group">
                                  <label class="modern-form-label" for="customerAddress">Address</label>
                                  <textarea class="modern-textarea" id="customerAddress" rows="2"
                                      v-model="form.customer_address" placeholder="Enter full address..."
                                      :readonly="useExistingCustomer && selectedCustomer"></textarea>
                              </div>
                          </div>
                      </div>

                      <hr>

                      <!-- Products Section -->
                      <div class="row">
                          <div class="col-md-12 mb-4">
                              <h6 style="font-weight: 700; color: #2d3748;">Products</h6>
                          </div>

                          <div class="col-md-4 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">Select Product</label>
                                  <multiselect v-model="selectedProduct"
                                      :options="products"
                                      placeholder="Choose product..."
                                      label="name"
                                      track-by="id"
                                      select-label="">
                                  </multiselect>
                              </div>
                          </div>

                          <div class="col-md-3 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">Variation (Optional)</label>
                                  <select class="modern-select" v-model="currentItem.product_variation_id">
                                      <option value="">No Variation</option>
                                      <option v-for="variation in productVariations"
                                          :key="variation.id"
                                          :value="variation.id">
                                          {{ variation.var_name }} - {{ variation.price }} IQD (Stock: {{ variation.quantity }})
                                      </option>
                                  </select>
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">Custom Price</label>
                                  <input type="number" class="modern-form-control"
                                      v-model="currentItem.custom_price"
                                      placeholder="0.00"
                                      step="0.01"
                                      min="0">
                              </div>
                          </div>

                          <div class="col-md-2 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">Quantity</label>
                                  <div class="modern-input-group">
                                      <button @click="currentItem.quantity--" type="button" class="modern-btn modern-btn-primary">-</button>
                                      <input type="number" class="modern-form-control" v-model="currentItem.quantity" style="text-align:center;" min="1">
                                      <button @click="currentItem.quantity++" type="button" class="modern-btn modern-btn-success">+</button>
                                  </div>
                              </div>
                          </div>

                          <div class="col-md-1 mb-4 d-flex align-items-end">
                              <button @click="addProductToInvoice" type="button" class="modern-btn modern-btn-warning w-100">Add</button>
                          </div>

                          <!-- Products Table -->
                          <div class="col-md-12 mb-4">
                              <table class="modern-table table-bordered">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Product</th>
                                          <th>Variation</th>
                                          <th>Quantity</th>
                                          <th>Price</th>
                                          <th>Line Total</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <template v-if="invoiceItems.length > 0">
                                          <tr v-for="(item, index) in invoiceItems" :key="index">
                                              <td>{{ index + 1 }}</td>
                                              <td>{{ item.product_name }}</td>
                                              <td>{{ item.variation_name || 'N/A' }}</td>
                                              <td>{{ item.quantity }}</td>
                                              <td>{{ item.custom_price }} IQD</td>
                                              <td>{{ (item.custom_price * item.quantity).toFixed(2) }} IQD</td>
                                              <td>
                                                  <button @click="removeProduct(index)" class="btn btn-danger btn-sm">
                                                      <i class="fas fa-trash"></i>
                                                  </button>
                                              </td>
                                          </tr>
                                      </template>
                                      <template v-else>
                                          <tr>
                                              <td class="text-center text-muted" colspan="7">No products added</td>
                                          </tr>
                                      </template>

                                      <!-- Subtotal Row -->
                                      <tr v-if="invoiceItems.length > 0" class="table-info">
                                          <td colspan="5" class="text-end"><strong>Subtotal:</strong></td>
                                          <td colspan="2"><strong>{{ subtotal.toFixed(2) }} IQD</strong></td>
                                      </tr>
                                  </tbody>
                              </table>
                          </div>
                      </div>

                      <hr>

                      <!-- Pricing Section -->
                      <div class="row" v-if="invoiceItems.length > 0">
                          <div class="col-md-12 mb-4">
                              <h6 style="font-weight: 700; color: #2d3748;">Pricing & Payment</h6>
                          </div>

                          <!-- Discount -->
                          <div class="col-md-6 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">Discount Type</label>
                                  <select class="modern-select" v-model="form.discount_type">
                                      <option value="fixed">Fixed Amount</option>
                                      <option value="percentage">Percentage (%)</option>
                                  </select>
                              </div>
                          </div>

                          <div class="col-md-6 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">Discount Amount</label>
                                  <input type="number" class="modern-form-control"
                                      v-model="form.discount_amount"
                                      :placeholder="form.discount_type === 'percentage' ? '0-100' : '0.00'"
                                      step="0.01"
                                      min="0">
                              </div>
                          </div>

                          <!-- Extra Charge -->
                          <div class="col-md-6 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">Extra Charge</label>
                                  <input type="number" class="modern-form-control"
                                      v-model="form.extra_charge"
                                      placeholder="0.00"
                                      step="0.01"
                                      min="0">
                              </div>
                          </div>

                          <!-- Total Display -->
                          <div class="col-md-6 mb-4">
                              <div class="alert alert-success">
                                  <strong>Total Amount: {{ totalAmount.toFixed(2) }} IQD</strong>
                              </div>
                          </div>

                          <!-- Payment Type -->
                          <div class="col-md-12 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">Payment Type</label>
                                  <div class="d-flex gap-3">
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="paymentType"
                                              id="fullPayment" value="full_payment" v-model="form.payment_type">
                                          <label class="form-check-label" for="fullPayment">
                                              Full Payment
                                          </label>
                                      </div>
                                      <div class="form-check">
                                          <input class="form-check-input" type="radio" name="paymentType"
                                              id="installment" value="installment" v-model="form.payment_type">
                                          <label class="form-check-label" for="installment">
                                              Installment
                                          </label>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <!-- Full Payment Fields -->
                          <div class="col-md-6 mb-4" v-if="form.payment_type === 'full_payment'">
                              <div class="modern-form-group">
                                  <label class="modern-form-label">Paid Amount</label>
                                  <input type="number" class="modern-form-control"
                                      v-model="form.paid_amount"
                                      :placeholder="totalAmount.toFixed(2)"
                                      step="0.01"
                                      min="0">
                                  <small class="text-muted">Leave empty to auto-fill with total amount</small>
                              </div>
                          </div>

                          <!-- Installment Fields -->
                          <template v-if="form.payment_type === 'installment'">
                              <div class="col-md-6 mb-4">
                                  <div class="modern-form-group">
                                      <label class="modern-form-label">Number of Months</label>
                                      <input type="number" class="modern-form-control"
                                          v-model="form.installment_months"
                                          placeholder="Enter months..."
                                          min="1"
                                          @input="calculateInstallments">
                                      <HasError :form="form" field="installment_months"/>
                                  </div>
                              </div>

                              <div class="col-md-6 mb-4">
                                  <div class="modern-form-group">
                                      <label class="modern-form-label">Initial Payment (Optional)</label>
                                      <input type="number" class="modern-form-control"
                                          v-model="form.paid_amount"
                                          placeholder="0.00"
                                          step="0.01"
                                          min="0">
                                  </div>
                              </div>

                              <!-- Installment Preview -->
                              <div class="col-md-12 mb-4" v-if="form.installment_months > 0">
                                  <div class="alert alert-info">
                                      <h6>Installment Plan Preview:</h6>
                                      <p class="mb-1"><strong>Monthly Payment:</strong> {{ monthlyInstallment.toFixed(2) }} IQD</p>
                                      <p class="mb-1"><strong>Number of Installments:</strong> {{ form.installment_months }}</p>
                                      <p class="mb-0"><strong>Total:</strong> {{ totalAmount.toFixed(2) }} IQD</p>
                                  </div>
                              </div>
                          </template>

                          <!-- Notes -->
                          <div class="col-md-12 mb-4">
                              <div class="modern-form-group">
                                  <label class="modern-form-label" for="notes">Notes (Optional)</label>
                                  <textarea class="modern-textarea" id="notes" rows="3"
                                      v-model="form.notes" placeholder="Add any additional notes..."></textarea>
                              </div>
                          </div>

                          <!-- Submit Button -->
                          <div class="col-md-12 mb-4 text-center">
                              <Button :form="form" class="btn btn-success btn-lg">
                                  Create Invoice <i class="fas fa-check-circle"></i>
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
                customer_email: "",
                customer_address: "",
                customer_state: "",
                customer_city: "",
                payment_type: "full_payment",
                installment_months: null,
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

        monthlyInstallment() {
            if (this.form.installment_months > 0) {
                return this.totalAmount / this.form.installment_months;
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
                this.form.customer_email = "";
                this.form.customer_address = "";
                this.form.customer_state = customer.state || "";
                this.form.customer_city = customer.city || "";
            }
        },

        'selectedProduct': function(product) {
            if (product) {
                this.currentItem.product_id = product.id;
                this.loadProductVariations(product.id);

                // Set default price
                this.currentItem.custom_price = product.sell_price || product.default_price || 0;
            }
        },

        'currentItem.product_variation_id': function(variationId) {
            if (variationId) {
                const variation = this.productVariations.find(v => v.id == variationId);
                if (variation) {
                    this.currentItem.custom_price = variation.price;
                }
            } else if (this.selectedProduct) {
                this.currentItem.custom_price = this.selectedProduct.sell_price || this.selectedProduct.default_price || 0;
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
                this.form.customer_email = "";
                this.form.customer_address = "";
                this.form.customer_state = "";
                this.form.customer_city = "";
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
