<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="mb-0">{{ isEditMode ? 'Edit Template' : 'Create New Template' }}</h4>
          </div>
          <div class="card-body">
            <form @submit.prevent="saveTemplate">
              <!-- Basic Information -->
              <div class="section-header">
                <h5>Basic Information</h5>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Template Name <span class="text-danger">*</span></label>
                    <input
                      v-model="form.name"
                      type="text"
                      class="form-control"
                      placeholder="e.g., Transportation, Wholesale, Construction"
                      required
                    />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Description</label>
                    <input
                      v-model="form.description"
                      type="text"
                      class="form-control"
                      placeholder="Brief description of this template"
                    />
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input
                    v-model="form.is_default"
                    type="checkbox"
                    class="custom-control-input"
                    id="isDefault"
                  />
                  <label class="custom-control-label" for="isDefault">
                    Set as Default Template
                  </label>
                  <small class="form-text text-muted">
                    Default template will be auto-selected when creating new invoices
                  </small>
                </div>
              </div>

              <hr class="my-4" />

              <!-- Invoice Header Fields -->
              <div class="section-header">
                <h5>Invoice Header Fields</h5>
                <p class="text-muted">Custom fields that apply to the entire invoice (e.g., Vehicle Number, Driver Name)</p>
              </div>

              <div v-if="form.header_fields.length === 0" class="alert alert-info">
                No header fields added yet. Click "Add Header Field" to start.
              </div>

              <div v-for="(field, index) in form.header_fields" :key="'header-' + index" class="field-builder mb-3">
                <div class="field-builder-header">
                  <strong>Header Field {{ index + 1 }}</strong>
                  <button
                    type="button"
                    @click="removeHeaderField(index)"
                    class="btn btn-sm btn-danger"
                  >
                    <i class="fas fa-trash"></i> Remove
                  </button>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Field Label <span class="text-danger">*</span></label>
                      <input
                        v-model="field.field_label"
                        @input="autoGenerateKey(field, 'header', index)"
                        type="text"
                        class="form-control"
                        placeholder="e.g., Vehicle Number"
                        required
                      />
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Field Key <span class="text-danger">*</span></label>
                      <input
                        v-model="field.field_key"
                        type="text"
                        class="form-control"
                        placeholder="e.g., vehicle_number"
                        required
                      />
                      <small class="form-text text-muted">Auto-generated, but you can edit</small>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Field Type <span class="text-danger">*</span></label>
                      <select v-model="field.field_type" class="form-control" required>
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="date">Date</option>
                        <option value="select">Select (Dropdown)</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Required?</label>
                      <div class="custom-control custom-checkbox mt-2">
                        <input
                          v-model="field.is_required"
                          type="checkbox"
                          class="custom-control-input"
                          :id="'header-required-' + index"
                        />
                        <label class="custom-control-label" :for="'header-required-' + index">
                          Required
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Select Options (only show if field_type is 'select') -->
                <div v-if="field.field_type === 'select'" class="select-options-builder">
                  <label>Dropdown Options <span class="text-danger">*</span></label>
                  <div v-for="(option, optIndex) in field.select_options" :key="optIndex" class="input-group mb-2">
                    <input
                      v-model="field.select_options[optIndex]"
                      type="text"
                      class="form-control"
                      placeholder="Option value"
                      required
                    />
                    <div class="input-group-append">
                      <button
                        type="button"
                        @click="removeOption(field.select_options, optIndex)"
                        class="btn btn-outline-danger"
                      >
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <button
                    type="button"
                    @click="addOption(field.select_options)"
                    class="btn btn-sm btn-secondary"
                  >
                    <i class="fas fa-plus"></i> Add Option
                  </button>
                </div>
              </div>

              <button
                type="button"
                @click="addHeaderField"
                class="btn btn-outline-primary mb-4"
              >
                <i class="fas fa-plus"></i> Add Header Field
              </button>

              <hr class="my-4" />

              <!-- Line Item Fields -->
              <div class="section-header">
                <h5>Line Item Fields</h5>
                <p class="text-muted">Custom fields for each product/item in the invoice (e.g., Batch Number, Weight)</p>
              </div>

              <div v-if="form.item_fields.length === 0" class="alert alert-info">
                No item fields added yet. Click "Add Item Field" to start.
              </div>

              <div v-for="(field, index) in form.item_fields" :key="'item-' + index" class="field-builder mb-3">
                <div class="field-builder-header">
                  <strong>Item Field {{ index + 1 }}</strong>
                  <button
                    type="button"
                    @click="removeItemField(index)"
                    class="btn btn-sm btn-danger"
                  >
                    <i class="fas fa-trash"></i> Remove
                  </button>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Field Label <span class="text-danger">*</span></label>
                      <input
                        v-model="field.field_label"
                        @input="autoGenerateKey(field, 'item', index)"
                        type="text"
                        class="form-control"
                        placeholder="e.g., Batch Number"
                        required
                      />
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Field Key <span class="text-danger">*</span></label>
                      <input
                        v-model="field.field_key"
                        type="text"
                        class="form-control"
                        placeholder="e.g., batch_number"
                        required
                      />
                      <small class="form-text text-muted">Auto-generated, but you can edit</small>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Field Type <span class="text-danger">*</span></label>
                      <select v-model="field.field_type" class="form-control" required>
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="date">Date</option>
                        <option value="select">Select (Dropdown)</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Required?</label>
                      <div class="custom-control custom-checkbox mt-2">
                        <input
                          v-model="field.is_required"
                          type="checkbox"
                          class="custom-control-input"
                          :id="'item-required-' + index"
                        />
                        <label class="custom-control-label" :for="'item-required-' + index">
                          Required
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Select Options (only show if field_type is 'select') -->
                <div v-if="field.field_type === 'select'" class="select-options-builder">
                  <label>Dropdown Options <span class="text-danger">*</span></label>
                  <div v-for="(option, optIndex) in field.select_options" :key="optIndex" class="input-group mb-2">
                    <input
                      v-model="field.select_options[optIndex]"
                      type="text"
                      class="form-control"
                      placeholder="Option value"
                      required
                    />
                    <div class="input-group-append">
                      <button
                        type="button"
                        @click="removeOption(field.select_options, optIndex)"
                        class="btn btn-outline-danger"
                      >
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <button
                    type="button"
                    @click="addOption(field.select_options)"
                    class="btn btn-sm btn-secondary"
                  >
                    <i class="fas fa-plus"></i> Add Option
                  </button>
                </div>
              </div>

              <button
                type="button"
                @click="addItemField"
                class="btn btn-outline-primary mb-4"
              >
                <i class="fas fa-plus"></i> Add Item Field
              </button>

              <hr class="my-4" />

              <!-- Actions -->
              <div class="form-actions">
                <button type="submit" class="btn btn-success btn-lg" :disabled="saving">
                  <i class="fas fa-save"></i>
                  {{ saving ? 'Saving...' : (isEditMode ? 'Update Template' : 'Create Template') }}
                </button>
                <router-link :to="{ name: 'invoice-templates' }" class="btn btn-secondary btn-lg ml-2">
                  <i class="fas fa-times"></i> Cancel
                </router-link>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'InvoiceTemplateForm',
  data() {
    return {
      isEditMode: false,
      templateId: null,
      saving: false,
      form: {
        name: '',
        description: '',
        is_default: false,
        header_fields: [],
        item_fields: []
      }
    };
  },
  mounted() {
    this.checkEditMode();
  },
  methods: {
    checkEditMode() {
      this.templateId = this.$route.params.id;
      this.isEditMode = !!this.templateId;

      if (this.isEditMode) {
        this.loadTemplate();
      }
    },

    async loadTemplate() {
      try {
        const response = await axios.get(`/dashboard/api/invoice-templates/${this.templateId}`);
        if (response.data.status === 'ok') {
          const template = response.data.template;
          this.form = {
            name: template.name,
            description: template.description || '',
            is_default: template.is_default,
            header_fields: template.header_fields || [],
            item_fields: template.item_fields || []
          };
        }
      } catch (error) {
        console.error('Failed to load template:', error);
        this.$toastr.error('Failed to load template');
        this.$router.push({ name: 'invoice-templates' });
      }
    },

    addHeaderField() {
      this.form.header_fields.push({
        field_key: '',
        field_label: '',
        field_type: 'text',
        select_options: [],
        is_required: false
      });
    },

    removeHeaderField(index) {
      this.form.header_fields.splice(index, 1);
    },

    addItemField() {
      this.form.item_fields.push({
        field_key: '',
        field_label: '',
        field_type: 'text',
        select_options: [],
        is_required: false
      });
    },

    removeItemField(index) {
      this.form.item_fields.splice(index, 1);
    },

    addOption(optionsArray) {
      optionsArray.push('');
    },

    removeOption(optionsArray, index) {
      optionsArray.splice(index, 1);
    },

    autoGenerateKey(field, type, index) {
      // Only auto-generate if field_key is empty or matches the previous auto-generated value
      if (!field.field_key || field._lastGeneratedKey === field.field_key) {
        const key = field.field_label
          .toLowerCase()
          .replace(/[^a-z0-9]+/g, '_')
          .replace(/^_+|_+$/g, '');
        field.field_key = key;
        field._lastGeneratedKey = key;
      }
    },

    validateForm() {
      if (!this.form.name) {
        this.$toastr.error('Template name is required');
        return false;
      }

      // Validate header fields
      for (const field of this.form.header_fields) {
        if (!field.field_label || !field.field_key || !field.field_type) {
          this.$toastr.error('All header field details are required');
          return false;
        }
        if (field.field_type === 'select' && (!field.select_options || field.select_options.length === 0)) {
          this.$toastr.error(`Select field "${field.field_label}" must have at least one option`);
          return false;
        }
      }

      // Validate item fields
      for (const field of this.form.item_fields) {
        if (!field.field_label || !field.field_key || !field.field_type) {
          this.$toastr.error('All item field details are required');
          return false;
        }
        if (field.field_type === 'select' && (!field.select_options || field.select_options.length === 0)) {
          this.$toastr.error(`Select field "${field.field_label}" must have at least one option`);
          return false;
        }
      }

      return true;
    },

    async saveTemplate() {
      if (!this.validateForm()) {
        return;
      }

      this.saving = true;

      try {
        const url = this.isEditMode
          ? `/dashboard/api/invoice-templates/${this.templateId}`
          : '/dashboard/api/invoice-templates';

        const method = this.isEditMode ? 'put' : 'post';

        const response = await axios[method](url, this.form);

        if (response.data.status === 'ok') {
          this.$toastr.success(response.data.msg);
          this.$router.push({ name: 'invoice-templates' });
        }
      } catch (error) {
        console.error('Failed to save template:', error);
        const errorMsg = error.response?.data?.msg || 'Failed to save template';
        this.$toastr.error(errorMsg);
      } finally {
        this.saving = false;
      }
    }
  }
};
</script>

<style scoped>
.section-header {
  margin-bottom: 1.5rem;
}

.section-header h5 {
  color: #2d3748;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.field-builder {
  background-color: #f7fafc;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  padding: 1.5rem;
}

.field-builder-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
  padding-bottom: 0.75rem;
  border-bottom: 2px solid #e2e8f0;
}

.field-builder-header strong {
  color: #2d3748;
  font-size: 1.1rem;
}

.select-options-builder {
  margin-top: 1rem;
  padding: 1rem;
  background-color: #fff;
  border-radius: 4px;
  border: 1px solid #e2e8f0;
}

.form-actions {
  display: flex;
  gap: 1rem;
  margin-top: 2rem;
  padding-top: 2rem;
  border-top: 2px solid #e2e8f0;
}

.text-danger {
  color: #e53e3e;
}

.alert {
  border-radius: 6px;
}

.custom-control-label {
  font-weight: 500;
}
</style>
