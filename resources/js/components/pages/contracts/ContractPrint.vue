<template>
  <div class="contract-print-wrapper">
    <!-- No Print Header Actions -->
    <div class="no-print header-actions">
      <button @click="printContract" class="btn btn-primary">
        <i class="fas fa-print"></i> طباعة العقد
      </button>
      <button @click="$router.go(-1)" class="btn btn-secondary">
        <i class="fas fa-arrow-right"></i> رجوع
      </button>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="loading-state">
      <i class="fas fa-spinner fa-spin"></i>
      <p>جاري التحميل...</p>
    </div>

    <!-- Contract Document -->
    <div v-else-if="contract" class="contract-page">
      <!-- Header with car images -->
      <div class="page-header">
        <div class="header-car header-car-left">
          <img src="/images/car-left.png" alt="Car" onerror="this.style.display='none'">
        </div>

        <div class="header-content">
          <div class="bismillah">بسم الله الرحمن الرحيم</div>
          <h1 class="main-title">{{ contract.title }}</h1>
          <div class="contract-number">رقم العقد: {{ contract.contract_number }}</div>
        </div>

        <div class="header-car header-car-right">
          <img src="/images/car-right.png" alt="Car" onerror="this.style.display='none'">
        </div>
      </div>

      <!-- Contract Body -->
      <div class="contract-body">
        <!-- Parties Information -->
        <div class="parties-section">
          <!-- First Party -->
          <div class="party-box">
            <h3 class="party-title">الطرف الأول ({{ getFieldLabel('first_party_type') || 'البائع' }})</h3>
            <table class="info-table">
              <tr v-for="field in getPartyFields('first_party')" :key="field.field_key">
                <th>{{ field.field_label }}</th>
                <td>{{ contract.custom_fields[field.field_key] || '.............................' }}</td>
              </tr>
            </table>
          </div>

          <!-- Second Party -->
          <div class="party-box">
            <h3 class="party-title">الطرف الثاني ({{ getFieldLabel('second_party_type') || 'المشتري' }})</h3>
            <table class="info-table">
              <tr v-for="field in getPartyFields('second_party')" :key="field.field_key">
                <th>{{ field.field_label }}</th>
                <td>{{ contract.custom_fields[field.field_key] || '.............................' }}</td>
              </tr>
            </table>
          </div>
        </div>

        <!-- Contract Description/Terms -->
        <div class="contract-terms">
          <h3 class="section-heading">نص العقد</h3>
          <div class="terms-content" v-html="contract.description"></div>
        </div>

        <!-- Additional Custom Fields (excluding party fields) -->
        <div v-if="hasOtherCustomFields" class="additional-fields">
          <h3 class="section-heading">تفاصيل إضافية</h3>
          <table class="details-table">
            <tr v-for="field in getOtherFields()" :key="field.field_key">
              <th>{{ field.field_label }}</th>
              <td>{{ formatFieldValue(field, contract.custom_fields[field.field_key]) }}</td>
            </tr>
          </table>
        </div>

        <!-- Footer Text -->
        <div v-if="contract.footer_text" class="footer-note">
          {{ contract.footer_text }}
        </div>

        <!-- Agreement Clause -->
        <div class="agreement-clause">
          <p>عقدت هذه الاتفاقية بين الطرفين حسب ما يلي:</p>
          <p v-if="contract.start_date || contract.end_date" class="contract-dates-info">
            <span v-if="contract.start_date">تاريخ البدء: {{ formatDate(contract.start_date) }}</span>
            <span v-if="contract.end_date">تاريخ الانتهاء: {{ formatDate(contract.end_date) }}</span>
          </p>
        </div>

        <!-- Signatures -->
        <div class="signatures">
          <div class="signature-box">
            <div class="signature-label">توقيع الطرف الأول</div>
            <div class="signature-line"></div>
            <div class="signature-info">
              <div>الاسم: ...................................</div>
              <div>التاريخ: {{ new Date().toLocaleDateString('ar-SA') }}</div>
            </div>
          </div>

          <div class="signature-box">
            <div class="signature-label">توقيع الطرف الثاني</div>
            <div class="signature-line"></div>
            <div class="signature-info">
              <div>الاسم: ...................................</div>
              <div>التاريخ: {{ new Date().toLocaleDateString('ar-SA') }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Error State -->
    <div v-else class="error-state">
      <i class="fas fa-exclamation-triangle"></i>
      <h3>خطأ في تحميل العقد</h3>
      <p>لم يتم العثور على العقد المطلوب</p>
      <button @click="$router.push({name: 'contracts.list'})" class="btn btn-primary">
        العودة إلى قائمة العقود
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      contract: null,
      template: null,
      loading: false
    };
  },

  computed: {
    hasOtherCustomFields() {
      if (!this.template?.custom_fields || !this.contract?.custom_fields) return false;
      return this.getOtherFields().length > 0;
    }
  },

  mounted() {
    this.loadContract();
  },

  methods: {
    async loadContract() {
      this.loading = true;
      try {
        const response = await axios.get(
          `/dashboard/api/contracts/${this.$route.params.id}`
        );
        this.contract = response.data;
        this.template = response.data.template;
      } catch (error) {
        swal.fire('خطأ', 'فشل تحميل العقد', 'error');
        console.error(error);
      } finally {
        this.loading = false;
      }
    },

    getPartyFields(partyType) {
      if (!this.template?.custom_fields) return [];
      return this.template.custom_fields.filter(field =>
        field.field_key.startsWith(partyType + '_')
      );
    },

    getOtherFields() {
      if (!this.template?.custom_fields) return [];
      return this.template.custom_fields.filter(field =>
        !field.field_key.startsWith('first_party_') &&
        !field.field_key.startsWith('second_party_')
      );
    },

    getFieldLabel(fieldKey) {
      if (!this.template?.custom_fields) return '';
      const field = this.template.custom_fields.find(f => f.field_key === fieldKey);
      return field ? field.field_label : '';
    },

    formatFieldValue(field, value) {
      if (!value && value !== 0) return '...........................';

      switch (field.field_type) {
        case 'date':
          return this.formatDate(value);
        case 'number':
          return value.toLocaleString('ar-SA');
        default:
          return value;
      }
    },

    formatDate(date) {
      if (!date) return '';
      return new Date(date).toLocaleDateString('ar-SA', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    },

    printContract() {
      window.print();
    }
  }
};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.contract-print-wrapper {
  min-height: 100vh;
  background: #f5f5f5;
  padding: 20px;
}

/* No Print Actions */
.no-print.header-actions {
  display: flex;
  gap: 15px;
  justify-content: center;
  margin-bottom: 20px;
  padding: 15px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.btn {
  padding: 10px 25px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 15px;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: all 0.3s;
}

.btn-primary {
  background: #667eea;
  color: white;
}

.btn-primary:hover {
  background: #5568d3;
  transform: translateY(-2px);
}

.btn-secondary {
  background: #6c757d;
  color: white;
}

.btn-secondary:hover {
  background: #5a6268;
}

/* Loading & Error States */
.loading-state,
.error-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 20px;
  background: white;
  border-radius: 10px;
  text-align: center;
}

.loading-state i {
  font-size: 48px;
  color: #667eea;
  margin-bottom: 20px;
}

.error-state i {
  font-size: 64px;
  color: #e74c3c;
  margin-bottom: 20px;
}

/* Contract Page */
.contract-page {
  max-width: 900px;
  margin: 0 auto;
  background: white;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
  direction: rtl;
  font-family: 'Arial', 'Tahoma', sans-serif;
}

/* Header */
.page-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  padding: 30px 40px 20px;
  border-bottom: 3px double #000;
  position: relative;
}

.header-car {
  width: 120px;
  flex-shrink: 0;
}

.header-car img {
  width: 100%;
  height: auto;
}

.header-content {
  flex: 1;
  text-align: center;
  padding: 0 20px;
}

.bismillah {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 15px;
  font-family: 'Traditional Arabic', serif;
}

.main-title {
  font-size: 26px;
  font-weight: bold;
  margin: 15px 0;
  text-decoration: underline;
}

.contract-number {
  font-size: 16px;
  margin-top: 10px;
  font-weight: 600;
}

/* Contract Body */
.contract-body {
  padding: 30px 40px 40px;
}

/* Parties Section */
.parties-section {
  margin-bottom: 30px;
}

.party-box {
  margin-bottom: 25px;
  border: 2px solid #000;
  padding: 15px;
}

.party-title {
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 15px;
  padding-bottom: 10px;
  border-bottom: 2px solid #000;
  text-align: center;
}

.info-table {
  width: 100%;
  border-collapse: collapse;
}

.info-table tr {
  border-bottom: 1px dotted #999;
}

.info-table tr:last-child {
  border-bottom: none;
}

.info-table th {
  text-align: right;
  padding: 10px 15px;
  width: 30%;
  font-weight: 600;
  font-size: 15px;
}

.info-table td {
  padding: 10px 15px;
  font-size: 15px;
  border-right: 1px solid #ddd;
}

/* Contract Terms */
.section-heading {
  font-size: 18px;
  font-weight: bold;
  margin: 25px 0 15px;
  padding: 10px;
  background: #f8f8f8;
  border-right: 4px solid #000;
}

.contract-terms {
  margin: 25px 0;
}

.terms-content {
  padding: 20px;
  line-height: 2;
  font-size: 15px;
  text-align: justify;
  border: 1px solid #ddd;
  background: #fafafa;
}

.terms-content >>> p {
  margin-bottom: 15px;
}

.terms-content >>> ul,
.terms-content >>> ol {
  margin: 15px 0;
  padding-right: 30px;
}

.terms-content >>> li {
  margin-bottom: 10px;
}

/* Additional Fields */
.additional-fields {
  margin: 25px 0;
}

.details-table {
  width: 100%;
  border-collapse: collapse;
  border: 2px solid #000;
}

.details-table th {
  text-align: right;
  padding: 12px 15px;
  background: #f0f0f0;
  border: 1px solid #000;
  font-weight: 600;
  width: 35%;
}

.details-table td {
  padding: 12px 15px;
  border: 1px solid #000;
}

/* Footer Note */
.footer-note {
  margin: 25px 0;
  padding: 15px 20px;
  background: #fffbf0;
  border: 1px solid #daa520;
  border-right: 4px solid #daa520;
  line-height: 1.8;
  font-size: 14px;
}

/* Agreement Clause */
.agreement-clause {
  margin: 30px 0;
  padding: 20px;
  background: #f8f8f8;
  border: 2px solid #000;
  text-align: center;
}

.agreement-clause p {
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 10px;
}

.contract-dates-info {
  display: flex;
  justify-content: center;
  gap: 40px;
  margin-top: 15px;
  font-size: 14px;
}

/* Signatures */
.signatures {
  display: flex;
  justify-content: space-between;
  gap: 40px;
  margin-top: 50px;
  padding-top: 30px;
  border-top: 2px solid #000;
}

.signature-box {
  flex: 1;
  text-align: center;
}

.signature-label {
  font-size: 16px;
  font-weight: bold;
  margin-bottom: 50px;
}

.signature-line {
  border-bottom: 2px solid #000;
  margin: 0 20px 20px;
}

.signature-info {
  text-align: right;
  padding: 0 20px;
  font-size: 14px;
}

.signature-info div {
  margin: 8px 0;
}

/* Print Styles */
@media print {
  .no-print {
    display: none !important;
  }

  .contract-print-wrapper {
    padding: 0;
    background: white;
  }

  .contract-page {
    max-width: 100%;
    box-shadow: none;
  }

  .page-header {
    padding: 20px 30px 15px;
  }

  .contract-body {
    padding: 20px 30px 30px;
  }

  /* Ensure proper page breaks */
  .party-box,
  .contract-terms,
  .signatures {
    page-break-inside: avoid;
  }

  /* Print colors */
  .party-box,
  .details-table th,
  .agreement-clause {
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }
}
</style>
