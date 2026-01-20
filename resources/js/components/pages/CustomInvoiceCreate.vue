<template>
  <div class="custom-invoice-create">
    <!-- Step 1: Template Selection -->
    <div v-if="!selectedTemplate" class="template-selection">
      <div class="page-header mb-4">
        <h2>Create Custom Invoice</h2>
        <p class="text-muted">Select a template to create your invoice</p>
      </div>

      <div v-if="loadingTemplates" class="text-center py-5">
        <div class="spinner-border" role="status"></div>
        <p class="mt-2">Loading templates...</p>
      </div>

      <div v-else class="row">
        <div v-for="template in templates" :key="template.id" class="col-md-4 mb-4">
          <div class="template-card" @click="selectTemplate(template)">
            <div class="template-icon">
              <i class="fas fa-file-invoice"></i>
            </div>
            <h5>{{ template.name }}</h5>
            <p class="text-muted small">{{ template.description || 'No description' }}</p>
            <span v-if="template.is_default" class="badge badge-primary">Default</span>
            <button class="btn btn-sm btn-primary mt-3">
              <i class="fas fa-check"></i> Select Template
            </button>
          </div>
        </div>

        <div class="col-md-4 mb-4">
          <div class="template-card standard" @click="selectStandardInvoice">
            <div class="template-icon">
              <i class="fas fa-file-alt"></i>
            </div>
            <h5>Standard Invoice</h5>
            <p class="text-muted small">Use default invoice without template</p>
            <button class="btn btn-sm btn-secondary mt-3">
              <i class="fas fa-arrow-right"></i> Use Standard
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Step 2: Invoice Creation Form -->
    <div v-else class="invoice-form-container">
      <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h2>Create Invoice - {{ selectedTemplate.name }}</h2>
            <p class="text-muted mb-0">Fill in the invoice details based on selected template</p>
          </div>
          <div>
            <button @click="changeTemplate" class="btn btn-secondary me-2">
              <i class="fas fa-exchange-alt"></i> Change Template
            </button>
            <button @click="generateInvoice" class="btn btn-success" :disabled="processing">
              <i class="fas fa-check"></i> {{ processing ? 'Generating...' : 'Generate Invoice' }}
            </button>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-8">
          <!-- Customer Section -->
          <div class="card mb-4">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0"><i class="fas fa-user"></i> Customer Information</h5>
            </div>
            <div class="card-body">
              <div class="form-group mb-3">
                <label>Search Customer</label>
                <input
                  v-model="customerSearch"
                  @input="searchCustomers"
                  type="text"
                  class="form-control"
                  placeholder="Search by name or phone"
                >
                <ul v-if="customerResults.length > 0" class="list-group mt-2">
                  <li
                    v-for="customer in customerResults"
                    :key="customer.id"
                    @click="selectCustomer(customer)"
                    class="list-group-item list-group-item-action"
                    style="cursor: pointer;"
                  >
                    {{ customer.name }} - {{ customer.phone1 }}
                  </li>
                </ul>
              </div>

              <div v-if="form.customer_id" class="alert alert-info">
                <strong>Selected Customer:</strong> {{ selectedCustomerName }}
                <button @click="clearCustomer" class="btn btn-sm btn-link text-danger">
                  <i class="fas fa-times"></i> Clear
                </button>
              </div>
            </div>
          </div>

          <!-- Products Section -->
          <div class="card mb-4">
            <div class="card-header bg-success text-white">
              <h5 class="mb-0"><i class="fas fa-box"></i> Products / Items</h5>
            </div>
            <div class="card-body">
              <div class="form-group mb-3">
                <label>Search Product</label>
                <input
                  v-model="productSearch"
                  @input="searchProducts"
                  type="text"
                  class="form-control"
                  placeholder="Search products"
                >
                <ul v-if="productResults.length > 0" class="list-group mt-2">
                  <li
                    v-for="product in productResults"
                    :key="product.id"
                    @click="selectProduct(product)"
                    class="list-group-item list-group-item-action"
                    style="cursor: pointer;"
                  >
                    {{ product.name }} - {{ formatCurrency(product.price) }}
                  </li>
                </ul>
              </div>

              <div v-if="form.items.length > 0" class="table-responsive">
                <table class="table table-bordered">
                  <thead class="bg-light">
                    <tr>
                      <th v-for="col in enabledColumns" :key="col.key">{{ col.label }}</th>
                      <th width="80">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in form.items" :key="index">
                      <td v-if="isColumnEnabled('index')">{{ index + 1 }}</td>
                      <td v-if="isColumnEnabled('product_name')">{{ item.product_name }}</td>
                      <td v-if="isColumnEnabled('variation')">{{ item.variation_name || '-' }}</td>
                      <td v-if="isColumnEnabled('quantity')">
                        <input v-model.number="item.quantity" type="number" class="form-control form-control-sm" min="1" @input="calculateTotal">
                      </td>
                      <td v-if="isColumnEnabled('price')">
                        <input v-model.number="item.custom_price" type="number" class="form-control form-control-sm" step="0.01" @input="calculateTotal">
                      </td>
                      <td v-if="isColumnEnabled('total')">{{ formatCurrency(item.line_total) }}</td>
                      <td>
                        <button @click="removeItem(index)" class="btn btn-sm btn-danger">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div v-else class="alert alert-warning">
                No items added. Search and add products above.
              </div>
            </div>
          </div>

          <!-- Price Summary Section -->
          <div class="card mb-4">
            <div class="card-header bg-info text-white">
              <h5 class="mb-0"><i class="fas fa-calculator"></i> Price Summary</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6 offset-md-6">
                  <div v-if="isSummaryFieldEnabled('subtotal')" class="d-flex justify-content-between mb-2">
                    <span>{{ getSummaryLabel('subtotal') }}:</span>
                    <strong>{{ formatCurrency(calculations.subtotal) }}</strong>
                  </div>

                  <div v-if="isSummaryFieldEnabled('discount')" class="mb-2">
                    <div class="d-flex justify-content-between mb-1">
                      <span>{{ getSummaryLabel('discount') }}:</span>
                    </div>
                    <div class="input-group input-group-sm">
                      <select v-model="form.discount_type" class="form-select">
                        <option value="fixed">Fixed</option>
                        <option value="percentage">Percentage</option>
                      </select>
                      <input v-model.number="form.discount_amount" type="number" class="form-control" min="0" @input="calculateTotal">
                    </div>
                  </div>

                  <div v-if="isSummaryFieldEnabled('tax')" class="mb-2">
                    <div class="d-flex justify-content-between">
                      <span>{{ getSummaryLabel('tax') }} ({{ getTaxRate() }}%):</span>
                      <strong>{{ formatCurrency(calculations.tax) }}</strong>
                    </div>
                  </div>

                  <div v-if="isSummaryFieldEnabled('extra_charge')" class="mb-2">
                    <div class="d-flex justify-content-between mb-1">
                      <span>{{ getSummaryLabel('extra_charge') }}:</span>
                    </div>
                    <input v-model.number="form.extra_charge" type="number" class="form-control form-control-sm" min="0" @input="calculateTotal">
                  </div>

                  <div class="d-flex justify-content-between mb-2 pt-2 border-top">
                    <strong>{{ getSummaryLabel('total') }}:</strong>
                    <strong class="text-primary">{{ formatCurrency(calculations.total) }}</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Payment & Notes -->
          <div class="card mb-4">
            <div class="card-header">
              <h5 class="mb-0"><i class="fas fa-money-bill"></i> Payment & Notes</h5>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-md-6">
                  <label>Payment Type</label>
                  <select v-model="form.payment_type" class="form-control">
                    <option value="full_payment">Full Payment</option>
                    <option value="installment">Installment</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label>Paid Amount</label>
                  <input v-model.number="form.paid_amount" type="number" class="form-control" min="0" step="0.01">
                </div>
              </div>

              <div class="form-group">
                <label>Notes</label>
                <textarea v-model="form.notes" class="form-control" rows="3" placeholder="Additional notes..."></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- Preview Sidebar -->
        <div class="col-md-4">
          <div class="card sticky-top" style="top: 20px;">
            <div class="card-header bg-secondary text-white">
              <h5 class="mb-0"><i class="fas fa-eye"></i> Invoice Preview</h5>
            </div>
            <div class="card-body" style="max-height: 80vh; overflow-y: auto; font-size: 12px;">
              <div class="invoice-mini-preview">
                <!-- Header preview -->
                <div v-if="templateConfig" class="text-center mb-3 pb-2 border-bottom">
                  <i v-if="templateConfig.header.show_logo" class="fas fa-image text-muted"></i>
                  <h6 v-if="templateConfig.header.show_company_name">Company Name</h6>
                  <small v-if="templateConfig.header.show_phone" class="d-block">Phone</small>
                  <h5 class="mt-2">{{ templateConfig.header.title }}</h5>
                </div>

                <div class="mb-2">
                  <strong>Customer:</strong> {{ selectedCustomerName || 'Not selected' }}
                </div>

                <div class="mb-2">
                  <strong>Items:</strong> {{ form.items.length }}
                </div>

                <div class="border-top pt-2">
                  <div class="d-flex justify-content-between"><span>Subtotal:</span><span>{{ formatCurrency(calculations.subtotal) }}</span></div>
                  <div v-if="calculations.discount > 0" class="d-flex justify-content-between"><span>Discount:</span><span>-{{ formatCurrency(calculations.discount) }}</span></div>
                  <div v-if="calculations.tax > 0" class="d-flex justify-content-between"><span>Tax:</span><span>{{ formatCurrency(calculations.tax) }}</span></div>
                  <div class="d-flex justify-content-between border-top pt-2 mt-2"><strong>Total:</strong><strong>{{ formatCurrency(calculations.total) }}</strong></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CustomInvoiceCreate',
  data() {
    return {
      loadingTemplates: false,
      processing: false,
      templates: [],
      selectedTemplate: null,
      customerSearch: '',
      customerResults: [],
      productSearch: '',
      productResults: [],
      selectedCustomerName: '',
      form: {
        customer_id: null,
        invoice_template_id: null,
        items: [],
        discount_type: 'fixed',
        discount_amount: 0,
        extra_charge: 0,
        paid_amount: 0,
        payment_type: 'full_payment',
        notes: ''
      }
    };
  },
  computed: {
    templateConfig() {
      return this.selectedTemplate?.template_config || null;
    },
    enabledColumns() {
      return this.templateConfig?.table.columns.filter(col => col.enabled) || [];
    },
    calculations() {
      const subtotal = this.form.items.reduce((sum, item) => sum + (item.line_total || 0), 0);

      let discount = 0;
      if (this.form.discount_type === 'percentage') {
        discount = (subtotal * this.form.discount_amount) / 100;
      } else {
        discount = this.form.discount_amount;
      }

      let tax = 0;
      if (this.isSummaryFieldEnabled('tax')) {
        const taxRate = this.getTaxRate();
        tax = ((subtotal - discount) * taxRate) / 100;
      }

      const total = subtotal - discount + tax + (this.form.extra_charge || 0);

      return { subtotal, discount, tax, total };
    }
  },
  mounted() {
    this.loadTemplates();
  },
  methods: {
    async loadTemplates() {
      this.loadingTemplates = true;
      try {
        const response = await axios.get('/dashboard/api/invoices/templates/list');
        if (response.data.status === 'ok') {
          this.templates = response.data.templates;
        }
      } catch (error) {
        this.$toastr.error('Failed to load templates');
        console.error(error);
      } finally {
        this.loadingTemplates = false;
      }
    },

    selectTemplate(template) {
      this.selectedTemplate = template;
      this.form.invoice_template_id = template.id;
    },

    selectStandardInvoice() {
      this.$router.push({ name: 'create-invoice' });
    },

    changeTemplate() {
      this.selectedTemplate = null;
      this.form.invoice_template_id = null;
    },

    async searchCustomers() {
      if (this.customerSearch.length < 2) {
        this.customerResults = [];
        return;
      }

      try {
        const response = await axios.get(`/dashboard/api/customers/search?q=${this.customerSearch}`);
        if (response.data.status === 'ok') {
          this.customerResults = response.data.customers;
        }
      } catch (error) {
        console.error('Failed to search customers:', error);
      }
    },

    selectCustomer(customer) {
      this.form.customer_id = customer.id;
      this.selectedCustomerName = customer.name;
      this.customerResults = [];
      this.customerSearch = '';
    },

    clearCustomer() {
      this.form.customer_id = null;
      this.selectedCustomerName = '';
    },

    async searchProducts() {
      if (this.productSearch.length < 2) {
        this.productResults = [];
        return;
      }

      try {
        const response = await axios.get(`/dashboard/api/products/search?q=${this.productSearch}`);
        if (response.data.status === 'ok') {
          this.productResults = response.data.products;
        }
      } catch (error) {
        console.error('Failed to search products:', error);
      }
    },

    selectProduct(product) {
      this.form.items.push({
        product_id: product.id,
        product_name: product.name,
        variation_name: product.variation || '',
        quantity: 1,
        original_price: product.price,
        custom_price: product.price,
        line_total: product.price
      });

      this.productResults = [];
      this.productSearch = '';
      this.calculateTotal();
    },

    removeItem(index) {
      this.form.items.splice(index, 1);
      this.calculateTotal();
    },

    calculateTotal() {
      this.form.items.forEach(item => {
        item.line_total = item.quantity * item.custom_price;
      });
    },

    isColumnEnabled(key) {
      return this.templateConfig?.table.columns.find(c => c.key === key)?.enabled || false;
    },

    isSummaryFieldEnabled(key) {
      return this.templateConfig?.summary.fields.find(f => f.key === key)?.enabled || false;
    },

    getSummaryLabel(key) {
      return this.templateConfig?.summary.fields.find(f => f.key === key)?.label || key;
    },

    getTaxRate() {
      const taxField = this.templateConfig?.summary.fields.find(f => f.key === 'tax');
      return taxField?.rate || 0;
    },

    formatCurrency(amount) {
      return new Intl.NumberFormat('en-IQ', {
        style: 'currency',
        currency: 'IQD',
        minimumFractionDigits: 0
      }).format(amount || 0);
    },

    async generateInvoice() {
      // Validation
      if (!this.form.customer_id) {
        this.$toastr.error('Please select a customer');
        return;
      }

      if (this.form.items.length === 0) {
        this.$toastr.error('Please add at least one item');
        return;
      }

      this.processing = true;
      try {
        const invoiceData = {
          ...this.form,
          subtotal: this.calculations.subtotal,
          total_amount: this.calculations.total
        };

        const response = await axios.post('/dashboard/api/invoices/store', invoiceData);

        if (response.data.status === 'ok') {
          this.$toastr.success('Invoice created successfully');
          // Redirect to custom print page
          this.$router.push({
            name: 'custom-invoice-print',
            params: { id: response.data.invoice.id }
          });
        } else {
          this.$toastr.error(response.data.msg || 'Failed to create invoice');
        }
      } catch (error) {
        this.$toastr.error('An error occurred while creating the invoice');
        console.error(error);
      } finally {
        this.processing = false;
      }
    }
  }
};
</script>

<style scoped>
.custom-invoice-create {
  padding: 20px;
}

.page-header {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.template-card {
  background: white;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  padding: 30px 20px;
  text-align: center;
  cursor: pointer;
  transition: all 0.3s;
  height: 100%;
}

.template-card:hover {
  border-color: #007bff;
  box-shadow: 0 4px 12px rgba(0,123,255,0.15);
  transform: translateY(-2px);
}

.template-card.standard {
  border-style: dashed;
}

.template-icon {
  font-size: 48px;
  color: #007bff;
  margin-bottom: 15px;
}

.invoice-form-container {
  background: #f8f9fa;
}

.sticky-top {
  position: sticky;
}

.list-group-item-action:hover {
  background-color: #f0f0f0;
}

.invoice-mini-preview {
  font-size: 11px;
}
</style>
