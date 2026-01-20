<template>
  <div class="contract-create">
    <div class="page-header">
      <h2>إنشاء عقد جديد</h2>
    </div>

    <!-- Template Selection -->
    <div v-if="!selectedTemplate" class="template-selection">
      <h3>اختر قالب العقد</h3>
      <div v-if="loadingTemplates" class="loading-state">
        <i class="fas fa-spinner fa-spin"></i>
        <p>جاري التحميل...</p>
      </div>
      <div v-else class="template-cards">
        <div
          v-for="template in templates"
          :key="template.id"
          @click="selectTemplate(template)"
          class="template-card"
        >
          <div class="template-card-header">
            <h4>{{ template.name }}</h4>
            <span v-if="template.is_default" class="badge badge-primary">افتراضي</span>
          </div>
          <div class="template-card-body" v-html="truncateHtml(template.description, 150)"></div>
          <div class="template-card-footer">
            <span><i class="fas fa-list"></i> {{ template.custom_fields.length }} حقل مخصص</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Contract Form -->
    <div v-if="selectedTemplate" class="contract-form">
      <div class="form-container">
        <div class="selected-template-info">
          <div>
            <strong>القالب المختار:</strong> {{ selectedTemplate.name }}
          </div>
          <button @click="changeTemplate" class="btn btn-sm btn-secondary">
            <i class="fas fa-exchange-alt"></i> تغيير القالب
          </button>
        </div>

        <div class="form-section">
          <h3>معلومات العقد</h3>

          <div class="form-group">
            <label>عنوان العقد *</label>
            <input
              v-model="form.title"
              type="text"
              class="form-control"
              placeholder="مثال: عقد تأجير محل تجاري - شارع الملك فيصل"
              required
            />
          </div>

          <div class="form-group">
            <label>نص العقد (من القالب)</label>
            <div class="description-preview" v-html="selectedTemplate.description"></div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>تاريخ البدء</label>
                <input v-model="form.start_date" type="date" class="form-control" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>تاريخ الانتهاء</label>
                <input v-model="form.end_date" type="date" class="form-control" />
              </div>
            </div>
          </div>
        </div>

        <div v-if="selectedTemplate.custom_fields.length > 0" class="form-section">
          <h3>تفاصيل العقد</h3>

          <div
            v-for="field in selectedTemplate.custom_fields"
            :key="field.id"
            class="form-group"
          >
            <label>
              {{ field.field_label }}
              <span v-if="field.is_required" class="required">*</span>
            </label>

            <input
              v-if="field.field_type === 'text'"
              v-model="form.custom_fields[field.field_key]"
              type="text"
              class="form-control"
              :required="field.is_required"
            />

            <input
              v-if="field.field_type === 'number'"
              v-model="form.custom_fields[field.field_key]"
              type="number"
              class="form-control"
              :required="field.is_required"
            />

            <input
              v-if="field.field_type === 'date'"
              v-model="form.custom_fields[field.field_key]"
              type="date"
              class="form-control"
              :required="field.is_required"
            />

            <textarea
              v-if="field.field_type === 'textarea'"
              v-model="form.custom_fields[field.field_key]"
              class="form-control"
              :required="field.is_required"
              rows="3"
            ></textarea>

            <select
              v-if="field.field_type === 'select'"
              v-model="form.custom_fields[field.field_key]"
              class="form-control"
              :required="field.is_required"
            >
              <option value="">-- اختر --</option>
              <option
                v-for="option in field.select_options"
                :key="option"
                :value="option"
              >
                {{ option }}
              </option>
            </select>
          </div>
        </div>

        <div v-if="selectedTemplate.footer_text" class="form-section">
          <h3>نص التذييل</h3>
          <div class="footer-preview">{{ selectedTemplate.footer_text }}</div>
        </div>

        <div class="form-actions">
          <button @click="saveAndPrint" class="btn btn-primary btn-lg" :disabled="saving">
            <i class="fas fa-save"></i>
            {{ saving ? 'جاري الحفظ...' : 'حفظ وطباعة' }}
          </button>
          <button @click="saveDraft" class="btn btn-secondary btn-lg" :disabled="saving">
            <i class="fas fa-file"></i>
            حفظ كمسودة
          </button>
          <router-link :to="{name: 'contracts.list'}" class="btn btn-light btn-lg">
            <i class="fas fa-times"></i> إلغاء
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      templates: [],
      selectedTemplate: null,
      loadingTemplates: false,
      saving: false,
      form: {
        contract_template_id: null,
        title: '',
        description: '',
        custom_fields: {},
        footer_text: '',
        status: 'draft',
        start_date: null,
        end_date: null
      }
    };
  },

  mounted() {
    this.loadTemplates();

    if (this.$route.params.template_id) {
      this.loadTemplate(this.$route.params.template_id);
    }
  },

  methods: {
    async loadTemplates() {
      this.loadingTemplates = true;
      try {
        const response = await axios.get('/dashboard/api/contract-templates');
        this.templates = response.data.filter(t => t.is_active);
      } catch (error) {
        toastr.error('فشل تحميل القوالب');
        console.error(error);
      } finally {
        this.loadingTemplates = false;
      }
    },

    async loadTemplate(templateId) {
      try {
        const response = await axios.get(`/dashboard/api/contract-templates/${templateId}`);
        this.selectTemplate(response.data);
      } catch (error) {
        toastr.error('فشل تحميل القالب');
        console.error(error);
      }
    },

    selectTemplate(template) {
      this.selectedTemplate = template;
      this.form.contract_template_id = template.id;
      this.form.title = template.name;
      this.form.description = template.description;
      this.form.footer_text = template.footer_text;
      this.form.custom_fields = {};
    },

    changeTemplate() {
      this.selectedTemplate = null;
      this.form.custom_fields = {};
    },

    truncateHtml(html, maxLength) {
      if (!html) return '';
      const text = html.replace(/<[^>]*>/g, '');
      if (text.length <= maxLength) return text;
      return text.substring(0, maxLength) + '...';
    },

    validateForm() {
      if (!this.form.title) {
        toastr.error('يرجى إدخال عنوان العقد');
        return false;
      }

      for (const field of this.selectedTemplate.custom_fields) {
        if (field.is_required && !this.form.custom_fields[field.field_key]) {
          toastr.error(`الحقل "${field.field_label}" مطلوب`);
          return false;
        }
      }

      return true;
    },

    async saveAndPrint() {
      if (!this.validateForm()) return;

      this.saving = true;
      this.form.status = 'active';

      try {
        const response = await axios.post('/dashboard/api/contracts', this.form);
        swal.fire({
          title: 'نجح!',
          text: 'تم إنشاء العقد بنجاح',
          icon: 'success',
          confirmButtonText: 'حسناً'
        }).then(() => {
          window.location.href = `/dashboard/contracts/${response.data.id}/print`;
        });
      } catch (error) {
        console.error('Error:', error);
        console.error('Response:', error.response);

        let errorMessage = 'فشل حفظ العقد';

        if (error.response && error.response.data) {
          if (error.response.data.errors) {
            // Show first validation error
            const firstError = Object.values(error.response.data.errors)[0];
            errorMessage = firstError[0];
          } else if (error.response.data.message) {
            errorMessage = error.response.data.message;
          }
        }

        toastr.error(errorMessage);
        this.saving = false;
      }
    },

    async saveDraft() {
      if (!this.form.title) {
        toastr.error('يرجى إدخال عنوان العقد على الأقل');
        return;
      }

      this.saving = true;
      this.form.status = 'draft';

      try {
        await axios.post('/dashboard/api/contracts', this.form);
        swal.fire({
          title: 'نجح!',
          text: 'تم حفظ المسودة بنجاح',
          icon: 'success',
          confirmButtonText: 'حسناً'
        }).then(() => {
          window.location.reload();
        });
      } catch (error) {
        console.error('Error:', error);
        console.error('Response:', error.response);

        let errorMessage = 'فشل حفظ المسودة';

        if (error.response && error.response.data) {
          if (error.response.data.errors) {
            // Show first validation error
            const firstError = Object.values(error.response.data.errors)[0];
            errorMessage = firstError[0];
          } else if (error.response.data.message) {
            errorMessage = error.response.data.message;
          }
        }

        toastr.error(errorMessage);
        this.saving = false;
      }
    }
  }
};
</script>

<style scoped>
.contract-create {
  padding: 20px;
  max-width: 1200px;
  margin: 0 auto;
}

.page-header {
  margin-bottom: 30px;
  padding-bottom: 15px;
  border-bottom: 2px solid #e0e0e0;
}

.page-header h2 {
  margin: 0;
  color: #2c3e50;
}

.template-selection h3 {
  color: #667eea;
  margin-bottom: 20px;
}

.loading-state {
  text-align: center;
  padding: 60px 20px;
  color: #95a5a6;
}

.loading-state i {
  font-size: 48px;
  margin-bottom: 15px;
}

.template-cards {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
  margin-bottom: 30px;
}

.template-card {
  background: white;
  border-radius: 10px;
  padding: 20px;
  cursor: pointer;
  transition: all 0.3s;
  border: 2px solid #e0e0e0;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.template-card:hover {
  transform: translateY(-5px);
  border-color: #667eea;
  box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
}

.template-card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

.template-card-header h4 {
  margin: 0;
  color: #2c3e50;
}

.template-card-body {
  color: #6c757d;
  font-size: 14px;
  margin-bottom: 15px;
  min-height: 60px;
}

.template-card-footer {
  padding-top: 15px;
  border-top: 1px solid #e0e0e0;
  font-size: 13px;
  color: #95a5a6;
}

.form-container {
  background: white;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  padding: 30px;
}

.selected-template-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  background: #e8eaf6;
  border-radius: 8px;
  margin-bottom: 30px;
}

.form-section {
  margin-bottom: 40px;
}

.form-section h3 {
  color: #667eea;
  margin-bottom: 20px;
  font-size: 1.3rem;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
  color: #2c3e50;
}

.required {
  color: #dc3545;
}

.form-control {
  width: 100%;
  padding: 10px 15px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 14px;
}

.form-control:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.row {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
}

.col-md-6 {
  flex: 1;
}

.description-preview {
  padding: 20px;
  background: #f8f9fa;
  border-radius: 8px;
  border-right: 4px solid #667eea;
  line-height: 1.8;
}

.footer-preview {
  padding: 15px;
  background: #fff3cd;
  border-radius: 8px;
  border-right: 4px solid #ffc107;
}

.form-actions {
  display: flex;
  gap: 15px;
  justify-content: center;
  padding-top: 30px;
  border-top: 2px solid #e0e0e0;
}

.btn {
  padding: 10px 25px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 14px;
  transition: all 0.3s;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  text-decoration: none;
}

.btn-sm {
  padding: 5px 12px;
  font-size: 13px;
}

.btn-lg {
  padding: 12px 30px;
  font-size: 16px;
}

.btn-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.btn-primary:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.btn-secondary {
  background: #6c757d;
  color: white;
}

.btn-secondary:hover:not(:disabled) {
  background: #5a6268;
}

.btn-light {
  background: #f8f9fa;
  color: #495057;
  border: 1px solid #dee2e6;
}

.btn-light:hover {
  background: #e2e6ea;
}

.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.badge {
  display: inline-block;
  padding: 5px 10px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: 600;
}

.badge-primary {
  background: #667eea;
  color: white;
}
</style>
