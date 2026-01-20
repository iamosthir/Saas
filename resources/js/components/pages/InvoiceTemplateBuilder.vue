<template>
  <div class="invoice-template-builder">
    <!-- Page Header -->
    <div class="page-header mb-4">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h2 class="mb-1">{{ isEditMode ? 'Edit Template' : 'Create New Template' }}</h2>
          <p class="text-muted">Configure your custom invoice template layout and fields</p>
        </div>
        <div>
          <button @click="goBack" class="btn btn-secondary me-2">
            <i class="fas fa-arrow-left"></i> Back
          </button>
          <button @click="saveTemplate" class="btn btn-primary" :disabled="saving">
            <i class="fas fa-save"></i> {{ saving ? 'Saving...' : 'Save Template' }}
          </button>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Configuration Panel -->
      <div class="col-lg-7">
        <div class="card mb-4">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-cog"></i> Template Configuration</h5>
          </div>
          <div class="card-body">
            <!-- Basic Info Section -->
            <div class="config-section mb-4">
              <h6 class="section-title">Basic Information</h6>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label>Template Name <span class="text-danger">*</span></label>
                    <input v-model="form.name" type="text" class="form-control" placeholder="e.g., Transportation Invoice">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label>
                      <input v-model="form.is_default" type="checkbox" class="form-check-input me-2">
                      Set as Default Template
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group mb-3">
                <label>Description</label>
                <textarea v-model="form.description" class="form-control" rows="2" placeholder="Brief description of this template"></textarea>
              </div>
            </div>

            <!-- Header Configuration -->
            <div class="config-section mb-4">
              <h6 class="section-title">Header Configuration</h6>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label>Invoice Title</label>
                    <input v-model="form.template_config.header.title" type="text" class="form-control" placeholder="INVOICE">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label>Subtitle (optional)</label>
                    <input v-model="form.template_config.header.subtitle" type="text" class="form-control" placeholder="Tax Invoice">
                  </div>
                </div>
              </div>
              <div class="header-fields">
                <label class="d-block mb-2">Company Information Fields:</label>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-check mb-2">
                      <input v-model="form.template_config.header.show_logo" type="checkbox" class="form-check-input" id="showLogo">
                      <label class="form-check-label" for="showLogo">Show Logo</label>
                    </div>
                    <div class="form-check mb-2">
                      <input v-model="form.template_config.header.show_company_name" type="checkbox" class="form-check-input" id="showCompanyName">
                      <label class="form-check-label" for="showCompanyName">Show Company Name</label>
                    </div>
                    <div class="form-check mb-2">
                      <input v-model="form.template_config.header.show_phone" type="checkbox" class="form-check-input" id="showPhone">
                      <label class="form-check-label" for="showPhone">Show Phone</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-check mb-2">
                      <input v-model="form.template_config.header.show_email" type="checkbox" class="form-check-input" id="showEmail">
                      <label class="form-check-label" for="showEmail">Show Email</label>
                    </div>
                    <div class="form-check mb-2">
                      <input v-model="form.template_config.header.show_address" type="checkbox" class="form-check-input" id="showAddress">
                      <label class="form-check-label" for="showAddress">Show Address</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Table Column Configuration -->
            <div class="config-section mb-4">
              <h6 class="section-title">Table Column Configuration</h6>
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th width="60">Show</th>
                      <th>Column Label</th>
                      <th width="100">Width</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(col, index) in form.template_config.table.columns" :key="index">
                      <td>
                        <input v-model="col.enabled" type="checkbox" class="form-check-input">
                      </td>
                      <td>
                        <input v-model="col.label" type="text" class="form-control form-control-sm">
                      </td>
                      <td>
                        <input v-model="col.width" type="text" class="form-control form-control-sm" placeholder="20%">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Price Summary Configuration -->
            <div class="config-section mb-4">
              <h6 class="section-title">Price Summary Configuration</h6>
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th width="60">Show</th>
                      <th>Field Label</th>
                      <th width="150">Additional Info</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(field, index) in form.template_config.summary.fields" :key="index">
                      <td>
                        <input v-model="field.enabled" type="checkbox" class="form-check-input" :disabled="field.key === 'total'">
                      </td>
                      <td>
                        <input v-model="field.label" type="text" class="form-control form-control-sm">
                      </td>
                      <td>
                        <input v-if="field.key === 'tax'" v-model.number="field.rate" type="number" class="form-control form-control-sm" placeholder="Tax %" step="0.01" min="0">
                        <span v-else class="text-muted small">—</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Footer Configuration -->
            <div class="config-section">
              <h6 class="section-title">Footer Configuration</h6>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-check mb-3">
                    <input v-model="form.template_config.footer.show_customer_signature" type="checkbox" class="form-check-input" id="showCustomerSig">
                    <label class="form-check-label" for="showCustomerSig">Show Customer Signature</label>
                  </div>
                  <div v-if="form.template_config.footer.show_customer_signature" class="form-group mb-3">
                    <label class="small">Customer Signature Label</label>
                    <input v-model="form.template_config.footer.customer_signature_label" type="text" class="form-control form-control-sm">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-check mb-3">
                    <input v-model="form.template_config.footer.show_authorized_signature" type="checkbox" class="form-check-input" id="showAuthSig">
                    <label class="form-check-label" for="showAuthSig">Show Authorized Signature</label>
                  </div>
                  <div v-if="form.template_config.footer.show_authorized_signature" class="form-group mb-3">
                    <label class="small">Authorized Signature Label</label>
                    <input v-model="form.template_config.footer.authorized_signature_label" type="text" class="form-control form-control-sm">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Footer Note</label>
                <textarea v-model="form.template_config.footer.footer_note" class="form-control" rows="2" placeholder="Thank you for your business"></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Preview Panel -->
      <div class="col-lg-5">
        <div class="card sticky-top" style="top: 20px;">
          <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-eye"></i> Live Preview</h5>
          </div>
          <div class="card-body p-3" style="max-height: 80vh; overflow-y: auto;">
            <div class="invoice-preview">
              <!-- Header Preview -->
              <div class="preview-header text-center mb-3 pb-2 border-bottom">
                <div v-if="form.template_config.header.show_logo" class="mb-2">
                  <i class="fas fa-image text-muted" style="font-size: 40px;"></i>
                  <small class="d-block text-muted">Company Logo</small>
                </div>
                <h5 v-if="form.template_config.header.show_company_name" class="mb-1">Company Name</h5>
                <small v-if="form.template_config.header.show_phone" class="d-block">Phone: +1234567890</small>
                <small v-if="form.template_config.header.show_email" class="d-block">Email: info@company.com</small>
                <small v-if="form.template_config.header.show_address" class="d-block">Address Line 1, City</small>
                <h4 class="mt-3 mb-1">{{ form.template_config.header.title || 'INVOICE' }}</h4>
                <p v-if="form.template_config.header.subtitle" class="text-muted small mb-0">{{ form.template_config.header.subtitle }}</p>
              </div>

              <!-- Invoice Info -->
              <div class="preview-info mb-3">
                <div class="row small">
                  <div class="col-6"><strong>Invoice #:</strong> INV-0001</div>
                  <div class="col-6 text-end"><strong>Date:</strong> 2026-01-13</div>
                </div>
              </div>

              <!-- Customer Info -->
              <div class="preview-customer mb-3 p-2 bg-light rounded">
                <strong class="small">Bill To:</strong>
                <div class="small">Customer Name</div>
                <div class="small text-muted">Customer Address</div>
              </div>

              <!-- Items Table -->
              <div class="preview-table mb-3">
                <table class="table table-sm table-bordered" style="font-size: 11px;">
                  <thead class="bg-light">
                    <tr>
                      <th v-for="col in enabledColumns" :key="col.key" :style="{width: col.width}">{{ col.label }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td v-for="col in enabledColumns" :key="col.key">
                        <span v-if="col.key === 'index'">1</span>
                        <span v-else-if="col.key === 'product_name'">Sample Product</span>
                        <span v-else-if="col.key === 'variation'">Option 1</span>
                        <span v-else-if="col.key === 'quantity'">2</span>
                        <span v-else-if="col.key === 'price'">$50.00</span>
                        <span v-else-if="col.key === 'total'">$100.00</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- Price Summary -->
              <div class="preview-summary">
                <div class="row justify-content-end">
                  <div class="col-6">
                    <div v-for="field in enabledSummaryFields" :key="field.key" class="d-flex justify-content-between mb-1 small">
                      <span>{{ field.label }}:</span>
                      <strong v-if="field.key === 'total'">$110.00</strong>
                      <span v-else-if="field.key === 'discount'">- $5.00</span>
                      <span v-else-if="field.key === 'tax'">$10.00</span>
                      <span v-else>$5.00</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Footer -->
              <div class="preview-footer mt-4 pt-3 border-top">
                <div class="row text-center small">
                  <div v-if="form.template_config.footer.show_customer_signature" class="col-6 mb-3">
                    <div style="border-top: 1px solid #ccc; padding-top: 5px; margin-top: 40px;">
                      {{ form.template_config.footer.customer_signature_label }}
                    </div>
                  </div>
                  <div v-if="form.template_config.footer.show_authorized_signature" class="col-6 mb-3">
                    <div style="border-top: 1px solid #ccc; padding-top: 5px; margin-top: 40px;">
                      {{ form.template_config.footer.authorized_signature_label }}
                    </div>
                  </div>
                </div>
                <p v-if="form.template_config.footer.footer_note" class="text-center text-muted small mb-0">
                  {{ form.template_config.footer.footer_note }}
                </p>
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
  name: 'InvoiceTemplateBuilder',
  data() {
    return {
      isEditMode: false,
      templateId: null,
      saving: false,
      form: {
        name: '',
        description: '',
        is_default: false,
        template_config: {
          header: {
            show_logo: true,
            show_company_name: true,
            show_phone: true,
            show_email: true,
            show_address: true,
            title: 'INVOICE',
            subtitle: ''
          },
          table: {
            columns: [
              { key: 'index', label: '#', width: '5%', enabled: true },
              { key: 'product_name', label: 'Item Name', width: '35%', enabled: true },
              { key: 'variation', label: 'Variation', width: '15%', enabled: true },
              { key: 'quantity', label: 'Quantity', width: '10%', enabled: true },
              { key: 'price', label: 'Unit Price', width: '15%', enabled: true },
              { key: 'total', label: 'Total', width: '20%', enabled: true }
            ]
          },
          summary: {
            fields: [
              { key: 'subtotal', label: 'Subtotal', enabled: true },
              { key: 'discount', label: 'Discount', enabled: true },
              { key: 'tax', label: 'Tax', enabled: false, rate: 0 },
              { key: 'shipping', label: 'Shipping', enabled: false },
              { key: 'extra_charge', label: 'Extra Charges', enabled: true },
              { key: 'total', label: 'Total', enabled: true }
            ]
          },
          footer: {
            show_customer_signature: true,
            customer_signature_label: 'Customer Signature',
            show_authorized_signature: true,
            authorized_signature_label: 'Authorized Signature',
            footer_note: 'Thank you for your business'
          }
        }
      }
    };
  },
  computed: {
    enabledColumns() {
      return this.form.template_config.table.columns.filter(col => col.enabled);
    },
    enabledSummaryFields() {
      return this.form.template_config.summary.fields.filter(field => field.enabled);
    }
  },
  mounted() {
    // Check if editing existing template
    if (this.$route.params.id) {
      this.isEditMode = true;
      this.templateId = this.$route.params.id;
      this.loadTemplate();
    }
  },
  methods: {
    async loadTemplate() {
      try {
        const response = await axios.get(`/dashboard/api/invoice-templates/${this.templateId}`);
        if (response.data.status === 'ok') {
          const template = response.data.template;
          this.form.name = template.name;
          this.form.description = template.description || '';
          this.form.is_default = template.is_default;
          if (template.template_config) {
            this.form.template_config = template.template_config;
          }
        }
      } catch (error) {
        this.$toastr.error('Failed to load template');
        console.error(error);
      }
    },
    async saveTemplate() {
      // Validation
      if (!this.form.name.trim()) {
        this.$toastr.error('Template name is required');
        return;
      }

      this.saving = true;
      try {
        let response;
        if (this.isEditMode) {
          response = await axios.put(`/dashboard/api/invoice-templates/${this.templateId}`, this.form);
        } else {
          response = await axios.post('/dashboard/api/invoice-templates', this.form);
        }

        if (response.data.status === 'ok') {
          this.$toastr.success(this.isEditMode ? 'Template updated successfully' : 'Template created successfully');
          this.$router.push({ name: 'invoice-templates' });
        } else {
          this.$toastr.error(response.data.msg || 'Failed to save template');
        }
      } catch (error) {
        this.$toastr.error('An error occurred while saving the template');
        console.error(error);
      } finally {
        this.saving = false;
      }
    },
    goBack() {
      this.$router.push({ name: 'invoice-templates' });
    }
  }
};
</script>

<style scoped>
.invoice-template-builder {
  padding: 20px;
}

.page-header {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.config-section {
  padding: 15px;
  border: 1px solid #e0e0e0;
  border-radius: 6px;
  background: #f9f9f9;
}

.section-title {
  font-weight: 600;
  color: #333;
  margin-bottom: 15px;
  padding-bottom: 8px;
  border-bottom: 2px solid #007bff;
}

.invoice-preview {
  background: white;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 12px;
}

.preview-header {
  background: #f8f9fa;
  padding: 15px;
  margin: -15px -15px 15px -15px;
}

.sticky-top {
  position: sticky;
}

.form-check-input:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
