<template>
  <div class="contract-template-form">
    <div class="page-header">
      <h2>{{ isEdit ? 'تعديل قالب العقد' : 'إنشاء قالب عقد جديد' }}</h2>
      <router-link :to="{name: 'contract-templates'}" class="btn btn-secondary">
        <i class="fas fa-arrow-right"></i> العودة
      </router-link>
    </div>

    <div class="form-container">
      <div class="form-section">
        <h3>معلومات القالب</h3>

        <div class="form-group">
          <label>اسم القالب *</label>
          <input
            v-model="form.name"
            type="text"
            class="form-control"
            placeholder="مثال: عقد تأجير محل تجاري"
            required
          />
        </div>

        <div class="form-group">
          <label>وصف العقد (نص منسق) *</label>
          <textarea
            ref="tinymceEditor"
            v-model="form.description"
            class="form-control tinymce-editor"
          ></textarea>
          <small class="form-text">استخدم المحرر لإضافة التنسيق والتعديل على نص العقد</small>
        </div>

        <div class="form-group">
          <label>نص التذييل</label>
          <textarea
            v-model="form.footer_text"
            rows="4"
            class="form-control"
            placeholder="نص ثابت يظهر في نهاية كل عقد (مثل: شروط وأحكام، بيانات التوقيع، إلخ)"
          ></textarea>
          <small class="form-text">هذا النص سيظهر في نهاية جميع العقود المنشأة من هذا القالب</small>
        </div>

        <div class="form-group">
          <label>
            <input type="checkbox" v-model="form.is_default" />
            تعيين كقالب افتراضي
          </label>
        </div>
      </div>

      <div class="form-section">
        <div class="section-header-row">
          <h3>الحقول المخصصة</h3>
          <button @click="addField" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i> إضافة حقل
          </button>
        </div>

        <div v-if="form.custom_fields.length === 0" class="empty-state">
          <i class="fas fa-inbox"></i>
          <p>لا توجد حقول مخصصة. اضغط "إضافة حقل" لإنشاء حقول جديدة.</p>
        </div>

        <div v-for="(field, index) in form.custom_fields" :key="index" class="field-builder">
          <div class="field-number">{{ index + 1 }}</div>

          <div class="field-content">
            <div class="field-row">
              <div class="form-group flex-1">
                <label>اسم الحقل *</label>
                <input
                  v-model="field.field_label"
                  @input="autoGenerateKey(field, index)"
                  type="text"
                  class="form-control"
                  placeholder="مثال: اسم الطرف الأول"
                  required
                />
              </div>

              <div class="form-group flex-1">
                <label>مفتاح الحقل</label>
                <input
                  v-model="field.field_key"
                  type="text"
                  class="form-control"
                  readonly
                  disabled
                />
              </div>

              <div class="form-group">
                <label>نوع الحقل *</label>
                <select v-model="field.field_type" class="form-control">
                  <option value="text">نص قصير</option>
                  <option value="textarea">نص طويل</option>
                  <option value="number">رقم</option>
                  <option value="date">تاريخ</option>
                  <option value="select">قائمة منسدلة</option>
                </select>
              </div>
            </div>

            <div v-if="field.field_type === 'select'" class="form-group">
              <label>خيارات القائمة المنسدلة (افصل بفاصلة)</label>
              <input
                v-model="field.select_options_input"
                @input="updateSelectOptions(field)"
                type="text"
                class="form-control"
                placeholder="خيار 1, خيار 2, خيار 3"
              />
            </div>

            <div class="field-actions">
              <label class="checkbox-label">
                <input type="checkbox" v-model="field.is_required" />
                حقل مطلوب
              </label>

              <div class="action-buttons">
                <button
                  @click="moveFieldUp(index)"
                  :disabled="index === 0"
                  class="btn btn-sm btn-light"
                  title="تحريك لأعلى"
                >
                  <i class="fas fa-arrow-up"></i>
                </button>
                <button
                  @click="moveFieldDown(index)"
                  :disabled="index === form.custom_fields.length - 1"
                  class="btn btn-sm btn-light"
                  title="تحريك لأسفل"
                >
                  <i class="fas fa-arrow-down"></i>
                </button>
                <button
                  @click="removeField(index)"
                  class="btn btn-sm btn-danger"
                  title="حذف الحقل"
                >
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="form-actions">
        <button @click="saveTemplate" class="btn btn-primary btn-lg" :disabled="saving">
          <i class="fas fa-save"></i>
          {{ saving ? 'جاري الحفظ...' : 'حفظ القالب' }}
        </button>
        <router-link :to="{name: 'contract-templates'}" class="btn btn-secondary btn-lg">
          <i class="fas fa-times"></i> إلغاء
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isEdit: false,
      templateId: null,
      saving: false,
      tinymceInstance: null,
      form: {
        name: '',
        description: '',
        footer_text: '',
        is_default: false,
        custom_fields: []
      }
    };
  },

  mounted() {
    // Check if editing
    if (this.$route.params.id) {
      this.isEdit = true;
      this.templateId = this.$route.params.id;
      this.loadTemplate();
    } else {
      this.initTinyMCE();
    }
  },

  beforeDestroy() {
    if (this.tinymceInstance) {
      tinymce.remove(this.tinymceInstance);
    }
  },

  methods: {
    initTinyMCE() {
      this.$nextTick(() => {
        tinymce.init({
          target: this.$refs.tinymceEditor,
          height: 400,
          menubar: false,
          language: 'ar',
          directionality: 'rtl',
          plugins: [
            'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview',
            'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'table', 'help', 'wordcount'
          ],
          toolbar: 'undo redo | formatselect | bold italic underline | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | removeformat | help',
          content_style: 'body { font-family:Arial,sans-serif; font-size:14px; direction:rtl; text-align:right; }',
          setup: (editor) => {
            this.tinymceInstance = editor;
            editor.on('change', () => {
              this.form.description = editor.getContent();
            });
          }
        });
      });
    },

    async loadTemplate() {
      try {
        const response = await axios.get(`/dashboard/api/contract-templates/${this.templateId}`);
        this.form = {
          name: response.data.name,
          description: response.data.description || '',
          footer_text: response.data.footer_text || '',
          is_default: response.data.is_default,
          custom_fields: response.data.custom_fields.map(field => ({
            ...field,
            select_options_input: field.select_options ? field.select_options.join(', ') : ''
          }))
        };

        this.$nextTick(() => {
          this.initTinyMCE();
        });
      } catch (error) {
        toastr.error('فشل تحميل القالب');
        console.error(error);
      }
    },

    autoGenerateKey(field, index) {
      // Convert Arabic and English labels to snake_case
      field.field_key = field.field_label
        .toLowerCase()
        .replace(/\s+/g, '_')
        .replace(/[^\w\u0621-\u064A]/g, '_')
        .replace(/_{2,}/g, '_')
        .replace(/^_+|_+$/g, '');
    },

    addField() {
      this.form.custom_fields.push({
        field_key: '',
        field_label: '',
        field_type: 'text',
        select_options: [],
        select_options_input: '',
        is_required: false,
        display_order: this.form.custom_fields.length
      });
    },

    removeField(index) {
      if (confirm('هل أنت متأكد من حذف هذا الحقل؟')) {
        this.form.custom_fields.splice(index, 1);
        this.updateDisplayOrder();
      }
    },

    moveFieldUp(index) {
      if (index > 0) {
        const field = this.form.custom_fields.splice(index, 1)[0];
        this.form.custom_fields.splice(index - 1, 0, field);
        this.updateDisplayOrder();
      }
    },

    moveFieldDown(index) {
      if (index < this.form.custom_fields.length - 1) {
        const field = this.form.custom_fields.splice(index, 1)[0];
        this.form.custom_fields.splice(index + 1, 0, field);
        this.updateDisplayOrder();
      }
    },

    updateDisplayOrder() {
      this.form.custom_fields.forEach((field, index) => {
        field.display_order = index;
      });
    },

    updateSelectOptions(field) {
      if (field.select_options_input) {
        field.select_options = field.select_options_input
          .split(',')
          .map(opt => opt.trim())
          .filter(opt => opt);
      } else {
        field.select_options = [];
      }
    },

    validateForm() {
      if (!this.form.name) {
        toastr.error('يرجى إدخال اسم القالب');
        return false;
      }

      if (!this.form.description) {
        toastr.error('يرجى إدخال وصف العقد');
        return false;
      }

      for (let i = 0; i < this.form.custom_fields.length; i++) {
        const field = this.form.custom_fields[i];

        if (!field.field_label) {
          toastr.error(`يرجى إدخال اسم الحقل رقم ${i + 1}`);
          return false;
        }

        if (!field.field_key) {
          toastr.error(`مفتاح الحقل رقم ${i + 1} غير صحيح`);
          return false;
        }

        if (field.field_type === 'select' && (!field.select_options || field.select_options.length === 0)) {
          toastr.error(`يرجى إدخال خيارات للحقل "${field.field_label}"`);
          return false;
        }
      }

      return true;
    },

    async saveTemplate() {
      if (!this.validateForm()) {
        return;
      }

      // Update description from TinyMCE
      if (this.tinymceInstance) {
        this.form.description = this.tinymceInstance.getContent();
      }

      this.saving = true;

      try {
        const payload = {
          ...this.form,
          custom_fields: this.form.custom_fields.map(field => ({
            field_key: field.field_key,
            field_label: field.field_label,
            field_type: field.field_type,
            select_options: field.select_options || [],
            is_required: field.is_required,
            display_order: field.display_order
          }))
        };

        if (this.isEdit) {
          await axios.put(`/dashboard/api/contract-templates/${this.templateId}`, payload);
          toastr.success('تم تحديث القالب بنجاح');
        } else {
          await axios.post('/dashboard/api/contract-templates', payload);
          toastr.success('تم إنشاء القالب بنجاح');
        }

        this.$router.push({ name: 'contract-templates' });
      } catch (error) {
        toastr.error('فشل حفظ القالب');
        console.error(error);
      } finally {
        this.saving = false;
      }
    }
  }
};
</script>

<style scoped>
.contract-template-form {
  padding: 20px;
  max-width: 1200px;
  margin: 0 auto;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
  padding-bottom: 15px;
  border-bottom: 2px solid #e0e0e0;
}

.page-header h2 {
  margin: 0;
  color: #2c3e50;
}

.form-container {
  background: white;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  padding: 30px;
}

.form-section {
  margin-bottom: 40px;
}

.form-section h3 {
  color: #667eea;
  margin-bottom: 20px;
  font-size: 1.3rem;
}

.section-header-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.section-header-row h3 {
  margin: 0;
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

.form-control {
  width: 100%;
  padding: 10px 15px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 14px;
  transition: border-color 0.3s;
}

.form-control:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-text {
  display: block;
  margin-top: 5px;
  font-size: 12px;
  color: #6c757d;
}

.empty-state {
  text-align: center;
  padding: 40px;
  color: #95a5a6;
}

.empty-state i {
  font-size: 48px;
  margin-bottom: 15px;
}

.field-builder {
  display: flex;
  gap: 15px;
  margin-bottom: 20px;
  padding: 20px;
  background: #f8f9fa;
  border-radius: 8px;
  border-right: 4px solid #667eea;
}

.field-number {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 35px;
  height: 35px;
  background: #667eea;
  color: white;
  border-radius: 50%;
  font-weight: bold;
  flex-shrink: 0;
}

.field-content {
  flex: 1;
}

.field-row {
  display: flex;
  gap: 15px;
  margin-bottom: 15px;
}

.flex-1 {
  flex: 1;
}

.field-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 10px;
  border-top: 1px solid #dee2e6;
}

.checkbox-label {
  display: flex;
  align-items: center;
  gap: 8px;
  margin: 0;
  font-weight: normal;
}

.action-buttons {
  display: flex;
  gap: 5px;
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

.btn-primary:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-secondary {
  background: #6c757d;
  color: white;
}

.btn-secondary:hover {
  background: #5a6268;
}

.btn-success {
  background: #28a745;
  color: white;
}

.btn-success:hover {
  background: #218838;
}

.btn-danger {
  background: #dc3545;
  color: white;
}

.btn-danger:hover {
  background: #c82333;
}

.btn-light {
  background: #f8f9fa;
  color: #495057;
  border: 1px solid #dee2e6;
}

.btn-light:hover:not(:disabled) {
  background: #e2e6ea;
}

.btn-light:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
