<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Invoice Templates</h4>
            <router-link :to="{ name: 'invoice-template-builder' }" class="btn btn-primary">
              <i class="fas fa-plus"></i> Create New Template
            </router-link>
          </div>
          <div class="card-body">
            <div v-if="loading" class="text-center py-5">
              <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </div>

            <div v-else-if="templates.length === 0" class="text-center py-5">
              <p class="text-muted">No templates found. Create your first template!</p>
            </div>

            <div v-else class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead class="thead-light">
                  <tr>
                    <th>Template Name</th>
                    <th>Description</th>
                    <th>Header Fields</th>
                    <th>Item Fields</th>
                    <th>Default</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="template in templates" :key="template.id">
                    <td>
                      <strong>{{ template.name }}</strong>
                    </td>
                    <td>{{ template.description || '-' }}</td>
                    <td class="text-center">
                      <span class="badge badge-info">
                        {{ template.header_fields ? template.header_fields.length : 0 }}
                      </span>
                    </td>
                    <td class="text-center">
                      <span class="badge badge-info">
                        {{ template.item_fields ? template.item_fields.length : 0 }}
                      </span>
                    </td>
                    <td class="text-center">
                      <span v-if="template.is_default" class="badge badge-success">
                        <i class="fas fa-check"></i> Default
                      </span>
                      <span v-else class="text-muted">-</span>
                    </td>
                    <td class="text-center">
                      <span v-if="template.is_active" class="badge badge-success">Active</span>
                      <span v-else class="badge badge-secondary">Inactive</span>
                    </td>
                    <td>
                      <div class="btn-group btn-group-sm" role="group">
                        <router-link
                          :to="{ name: 'invoice-template-builder', params: { id: template.id } }"
                          class="btn btn-sm btn-primary"
                          title="Edit"
                        >
                          <i class="fas fa-edit"></i>
                        </router-link>
                        <button
                          @click="toggleActive(template)"
                          class="btn btn-sm btn-warning"
                          :title="template.is_active ? 'Deactivate' : 'Activate'"
                        >
                          <i :class="template.is_active ? 'fas fa-pause' : 'fas fa-play'"></i>
                        </button>
                        <button
                          @click="confirmDelete(template)"
                          class="btn btn-sm btn-danger"
                          title="Delete"
                        >
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'InvoiceTemplateManager',
  data() {
    return {
      templates: [],
      loading: false
    };
  },
  mounted() {
    this.loadTemplates();
  },
  methods: {
    async loadTemplates() {
      this.loading = true;
      try {
        const response = await axios.get('/dashboard/api/invoice-templates');
        if (response.data.status === 'ok') {
          this.templates = response.data.templates;
        }
      } catch (error) {
        console.error('Failed to load templates:', error);
        this.$toastr.error('Failed to load templates');
      } finally {
        this.loading = false;
      }
    },

    async toggleActive(template) {
      try {
        const response = await axios.post(`/dashboard/api/invoice-templates/${template.id}/toggle-active`);
        if (response.data.status === 'ok') {
          template.is_active = response.data.is_active;
          this.$toastr.success('Template status updated');
        }
      } catch (error) {
        console.error('Failed to toggle template status:', error);
        this.$toastr.error('Failed to update template status');
      }
    },

    confirmDelete(template) {
      this.$swal({
        title: 'Delete Template?',
        text: `Are you sure you want to delete "${template.name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then(async (result) => {
        if (result.isConfirmed) {
          await this.deleteTemplate(template);
        }
      });
    },

    async deleteTemplate(template) {
      try {
        const response = await axios.delete(`/dashboard/api/invoice-templates/${template.id}`);

        if (response.data.status === 'warning') {
          // Template is in use
          this.$swal({
            title: 'Template In Use',
            html: response.data.msg,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Delete Anyway',
            cancelButtonText: 'Cancel'
          }).then(async (result) => {
            if (result.isConfirmed) {
              // Force delete
              await this.forceDelete(template);
            }
          });
        } else if (response.data.status === 'ok') {
          this.templates = this.templates.filter(t => t.id !== template.id);
          this.$toastr.success('Template deleted successfully');
        }
      } catch (error) {
        console.error('Failed to delete template:', error);
        this.$toastr.error('Failed to delete template');
      }
    },

    async forceDelete(template) {
      // Soft delete - template will be kept in database but marked as deleted
      this.templates = this.templates.filter(t => t.id !== template.id);
      this.$toastr.success('Template deleted successfully');
    }
  }
};
</script>

<style scoped>
.card {
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  border: none;
}

.card-header {
  background-color: #fff;
  border-bottom: 2px solid #e2e8f0;
  padding: 1.5rem;
}

.card-header h4 {
  color: #2d3748;
  font-weight: 600;
}

.table {
  margin-bottom: 0;
}

.table thead th {
  background-color: #f7fafc;
  color: #4a5568;
  font-weight: 600;
  border-bottom: 2px solid #e2e8f0;
  padding: 12px;
}

.table tbody td {
  padding: 12px;
  vertical-align: middle;
}

.btn-group .btn {
  margin: 0 2px;
}

.badge {
  padding: 0.5em 0.75em;
  font-size: 0.875rem;
}

.spinner-border {
  width: 3rem;
  height: 3rem;
}
</style>
