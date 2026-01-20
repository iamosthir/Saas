<template>
  <div class="custom-invoice-print">
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border" role="status"></div>
      <p class="mt-2">Loading invoice...</p>
    </div>

    <div v-else-if="invoice" class="print-container">
      <!-- Print Actions -->
      <div class="print-actions no-print">
        <button @click="printInvoice" class="btn btn-primary">
          <i class="fas fa-print"></i> Print Invoice
        </button>
        <button @click="goBack" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Back
        </button>
      </div>

      <!-- Invoice Print Layout -->
      <div class="invoice-document">
        <!-- Header Section -->
        <div v-if="templateConfig" class="invoice-header">
          <div class="row align-items-center">
            <div class="col-6">
              <img v-if="templateConfig.header.show_logo && merchant.logo" :src="merchant.logo" alt="Logo" class="company-logo">
              <h3 v-if="templateConfig.header.show_company_name" class="company-name">{{ merchant.name || 'Company Name' }}</h3>
              <div v-if="templateConfig.header.show_phone" class="company-info">
                <i class="fas fa-phone"></i> {{ merchant.phone_primary || 'N/A' }}
              </div>
              <div v-if="templateConfig.header.show_email" class="company-info">
                <i class="fas fa-envelope"></i> {{ merchant.email || 'N/A' }}
              </div>
              <div v-if="templateConfig.header.show_address" class="company-info">
                <i class="fas fa-map-marker-alt"></i> {{ merchant.address1 || 'N/A' }}
              </div>
            </div>
            <div class="col-6 text-end">
              <h2 class="invoice-title">{{ templateConfig.header.title || 'INVOICE' }}</h2>
              <p v-if="templateConfig.header.subtitle" class="invoice-subtitle">{{ templateConfig.header.subtitle }}</p>
            </div>
          </div>
        </div>

        <!-- Invoice Info Bar -->
        <div class="invoice-info-bar">
          <div class="row">
            <div class="col-6">
              <strong>Invoice Number:</strong> {{ invoice.invoice_number }}
            </div>
            <div class="col-6 text-end">
              <strong>Date:</strong> {{ formatDate(invoice.created_at) }}
            </div>
          </div>
        </div>

        <!-- Customer Information -->
        <div class="customer-section">
          <h5>Bill To:</h5>
          <div><strong>{{ invoice.customer.name }}</strong></div>
          <div v-if="invoice.customer.phone1"><i class="fas fa-phone"></i> {{ invoice.customer.phone1 }}</div>
          <div v-if="invoice.customer.address"><i class="fas fa-map-marker-alt"></i> {{ invoice.customer.address }}</div>
        </div>

        <!-- Custom Header Fields -->
        <div v-if="invoice.custom_fields && Object.keys(invoice.custom_fields).length > 0" class="custom-fields-section">
          <div class="row">
            <div v-for="field in invoice.template.header_fields" :key="field.id" class="col-md-4 mb-2">
              <strong>{{ field.field_label }}:</strong>
              <span>{{ formatFieldValue(invoice.custom_fields[field.field_key], field.field_type) }}</span>
            </div>
          </div>
        </div>

        <!-- Items Table -->
        <div class="items-table-section">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th v-for="col in enabledColumns" :key="col.key" :style="{width: col.width}">
                  {{ col.label }}
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in invoice.items" :key="item.id">
                <td v-if="isColumnEnabled('index')">{{ index + 1 }}</td>
                <td v-if="isColumnEnabled('product_name')">{{ item.product_name }}</td>
                <td v-if="isColumnEnabled('variation')">{{ item.variation_name || '-' }}</td>
                <td v-if="isColumnEnabled('quantity')" class="text-center">{{ item.quantity }}</td>
                <td v-if="isColumnEnabled('price')" class="text-end">{{ formatCurrency(item.custom_price) }}</td>
                <td v-if="isColumnEnabled('total')" class="text-end">{{ formatCurrency(item.line_total) }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Price Summary -->
        <div class="price-summary-section">
          <div class="row justify-content-end">
            <div class="col-md-5">
              <table class="table table-sm summary-table">
                <tbody>
                  <tr v-if="isSummaryFieldEnabled('subtotal')">
                    <td><strong>{{ getSummaryLabel('subtotal') }}</strong></td>
                    <td class="text-end">{{ formatCurrency(invoice.subtotal) }}</td>
                  </tr>
                  <tr v-if="isSummaryFieldEnabled('discount') && invoice.discount_amount > 0">
                    <td><strong>{{ getSummaryLabel('discount') }}</strong></td>
                    <td class="text-end text-danger">- {{ formatCurrency(invoice.discount_amount) }}</td>
                  </tr>
                  <tr v-if="isSummaryFieldEnabled('tax')">
                    <td><strong>{{ getSummaryLabel('tax') }} ({{ getTaxRate() }}%)</strong></td>
                    <td class="text-end">{{ formatCurrency(calculateTax()) }}</td>
                  </tr>
                  <tr v-if="isSummaryFieldEnabled('extra_charge') && invoice.extra_charge > 0">
                    <td><strong>{{ getSummaryLabel('extra_charge') }}</strong></td>
                    <td class="text-end">{{ formatCurrency(invoice.extra_charge) }}</td>
                  </tr>
                  <tr class="total-row">
                    <td><strong>{{ getSummaryLabel('total') }}</strong></td>
                    <td class="text-end"><strong>{{ formatCurrency(invoice.total_amount) }}</strong></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Payment Information -->
        <div v-if="invoice.paid_amount > 0" class="payment-info-section">
          <div class="row">
            <div class="col-md-4">
              <strong>Paid Amount:</strong> {{ formatCurrency(invoice.paid_amount) }}
            </div>
            <div class="col-md-4">
              <strong>Remaining:</strong> {{ formatCurrency(invoice.remaining_amount) }}
            </div>
            <div class="col-md-4">
              <strong>Status:</strong>
              <span :class="getStatusClass(invoice.payment_status)">
                {{ invoice.payment_status.toUpperCase() }}
              </span>
            </div>
          </div>
        </div>

        <!-- Notes -->
        <div v-if="invoice.notes" class="notes-section">
          <strong>Notes:</strong>
          <p>{{ invoice.notes }}</p>
        </div>

        <!-- Footer Section -->
        <div v-if="templateConfig" class="invoice-footer">
          <div class="row text-center">
            <div v-if="templateConfig.footer.show_customer_signature" class="col-6">
              <div class="signature-line"></div>
              <p class="signature-label">{{ templateConfig.footer.customer_signature_label }}</p>
            </div>
            <div v-if="templateConfig.footer.show_authorized_signature" class="col-6">
              <div class="signature-line"></div>
              <p class="signature-label">{{ templateConfig.footer.authorized_signature_label }}</p>
            </div>
          </div>
          <div v-if="templateConfig.footer.footer_note" class="footer-note">
            {{ templateConfig.footer.footer_note }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CustomInvoicePrint',
  data() {
    return {
      loading: false,
      invoice: null,
      merchant: {}
    };
  },
  computed: {
    templateConfig() {
      return this.invoice?.template?.template_config || null;
    },
    enabledColumns() {
      if (!this.templateConfig) return [];
      return this.templateConfig.table.columns.filter(col => col.enabled);
    }
  },
  mounted() {
    this.loadInvoice();
  },
  methods: {
    async loadInvoice() {
      this.loading = true;
      try {
        const invoiceId = this.$route.params.id;
        const response = await axios.get(`/dashboard/api/invoices/${invoiceId}`);

        if (response.data.status === 'ok') {
          this.invoice = response.data.invoice;
          this.merchant = response.data.merchant || {};
        } else {
          this.$toastr.error('Failed to load invoice');
        }
      } catch (error) {
        this.$toastr.error('An error occurred while loading the invoice');
        console.error(error);
      } finally {
        this.loading = false;
      }
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

    calculateTax() {
      const taxRate = this.getTaxRate();
      const taxableAmount = this.invoice.subtotal - (this.invoice.discount_amount || 0);
      return (taxableAmount * taxRate) / 100;
    },

    formatCurrency(amount) {
      return new Intl.NumberFormat('en-IQ', {
        style: 'currency',
        currency: 'IQD',
        minimumFractionDigits: 0
      }).format(amount || 0);
    },

    formatDate(date) {
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    },

    formatFieldValue(value, type) {
      if (!value) return '-';
      if (type === 'date') return this.formatDate(value);
      if (type === 'number') return Number(value).toLocaleString();
      return value;
    },

    getStatusClass(status) {
      const classes = {
        paid: 'badge bg-success',
        partial: 'badge bg-warning',
        unpaid: 'badge bg-danger'
      };
      return classes[status] || 'badge bg-secondary';
    },

    printInvoice() {
      window.print();
    },

    goBack() {
      this.$router.go(-1);
    }
  }
};
</script>

<style scoped>
.custom-invoice-print {
  padding: 20px;
  background: #f5f5f5;
}

.print-actions {
  margin-bottom: 20px;
  text-align: center;
}

.print-actions .btn {
  margin: 0 10px;
}

.invoice-document {
  background: white;
  padding: 40px;
  max-width: 900px;
  margin: 0 auto;
  box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.invoice-header {
  padding-bottom: 20px;
  border-bottom: 3px solid #333;
  margin-bottom: 20px;
}

.company-logo {
  max-height: 60px;
  margin-bottom: 10px;
}

.company-name {
  font-size: 24px;
  font-weight: bold;
  color: #333;
  margin-bottom: 5px;
}

.company-info {
  font-size: 13px;
  color: #666;
  margin-bottom: 3px;
}

.invoice-title {
  font-size: 36px;
  font-weight: bold;
  color: #007bff;
  margin: 0;
}

.invoice-subtitle {
  font-size: 14px;
  color: #666;
  margin: 0;
}

.invoice-info-bar {
  background: #f8f9fa;
  padding: 15px;
  border-radius: 5px;
  margin-bottom: 20px;
}

.customer-section {
  background: #f0f8ff;
  padding: 15px;
  border-radius: 5px;
  margin-bottom: 20px;
  border-left: 4px solid #007bff;
}

.customer-section h5 {
  color: #007bff;
  margin-bottom: 10px;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.custom-fields-section {
  background: #fffbf0;
  padding: 15px;
  border-radius: 5px;
  margin-bottom: 20px;
  border-left: 4px solid #ffc107;
}

.items-table-section {
  margin-bottom: 20px;
}

.items-table-section table {
  margin-bottom: 0;
}

.items-table-section thead {
  background: #343a40;
  color: white;
}

.items-table-section thead th {
  font-weight: 600;
  padding: 12px;
  border: none;
}

.items-table-section tbody td {
  padding: 10px 12px;
  vertical-align: middle;
}

.price-summary-section {
  margin-bottom: 20px;
}

.summary-table {
  border: 1px solid #dee2e6;
}

.summary-table td {
  padding: 8px 12px;
}

.summary-table .total-row {
  background: #f8f9fa;
  font-size: 16px;
  border-top: 2px solid #333;
}

.payment-info-section {
  background: #e8f5e9;
  padding: 15px;
  border-radius: 5px;
  margin-bottom: 20px;
  border-left: 4px solid #28a745;
}

.notes-section {
  background: #fff9e6;
  padding: 15px;
  border-radius: 5px;
  margin-bottom: 20px;
  border-left: 4px solid #ffc107;
}

.invoice-footer {
  margin-top: 40px;
  padding-top: 30px;
  border-top: 2px solid #dee2e6;
}

.signature-line {
  border-top: 2px solid #333;
  margin: 60px auto 10px;
  width: 60%;
}

.signature-label {
  font-size: 14px;
  color: #666;
  margin: 0;
}

.footer-note {
  text-align: center;
  margin-top: 30px;
  font-size: 14px;
  color: #666;
  font-style: italic;
}

/* Print Styles */
@media print {
  .no-print {
    display: none !important;
  }

  .custom-invoice-print {
    padding: 0;
    background: white;
  }

  .invoice-document {
    box-shadow: none;
    padding: 20px;
    max-width: 100%;
  }

  .invoice-header {
    page-break-after: avoid;
  }

  .items-table-section {
    page-break-inside: avoid;
  }

  .invoice-footer {
    page-break-before: avoid;
  }
}
</style>
