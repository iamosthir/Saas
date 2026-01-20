<template>
  <div class="contract-template-manager">
    <div class="page-header">
      <h2><i class="fas fa-file-contract"></i> قوالب العقود</h2>
      <router-link :to="{name: 'contract-template-create'}" class="btn btn-primary">
        <i class="fas fa-plus"></i> قالب جديد
      </router-link>
    </div>

    <div class="templates-container">
      <div v-if="loading" class="loading-state">
        <i class="fas fa-spinner fa-spin"></i>
        <p>جاري التحميل...</p>
      </div>

      <div v-else-if="templates.length === 0" class="empty-state">
        <i class="fas fa-inbox"></i>
        <h3>لا توجد قوالب</h3>
        <p>ابدأ بإنشاء قالب عقد جديد</p>
        <router-link :to="{name: 'contract-template-create'}" class="btn btn-primary">
          <i class="fas fa-plus"></i> إنشاء قالب
        </router-link>
      </div>

      <div v-else class="templates-table-wrapper">
        <table class="templates-table">
          <thead>
            <tr>
              <th>اسم القالب</th>
              <th>الوصف</th>
              <th>الحقول المخصصة</th>
              <th>الحالة</th>
              <th>الإجراءات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="template in templates" :key="template.id">
              <td>
                <div class="template-name">
                  {{ template.name }}
                  <span v-if="template.is_default" class="badge badge-primary">افتراضي</span>
                </div>
              </td>
              <td>
                <div class="template-description" v-html="truncateHtml(template.description, 100)"></div>
              </td>
              <td class="text-center">
                <span class="badge badge-info">
                  {{ template.custom_fields ? template.custom_fields.length : 0 }} حقل
                </span>
              </td>
              <td>
                <span
                  class="status-badge"
                  :class="template.is_active ? 'status-active' : 'status-inactive'"
                >
                  {{ template.is_active ? 'نشط' : 'غير نشط' }}
                </span>
              </td>
              <td>
                <div class="action-buttons">
                  <button
                    @click="createContract(template.id)"
                    class="btn btn-sm btn-success"
                    title="إنشاء عقد"
                  >
                    <i class="fas fa-file-signature"></i>
                  </button>
                  <router-link
                    :to="{name: 'contract-template-edit', params: {id: template.id}}"
                    class="btn btn-sm btn-primary"
                    title="تعديل"
                  >
                    <i class="fas fa-edit"></i>
                  </router-link>
                  <button
                    @click="toggleActive(template)"
                    class="btn btn-sm btn-warning"
                    :title="template.is_active ? 'تعطيل' : 'تفعيل'"
                  >
                    <i :class="template.is_active ? 'fas fa-toggle-on' : 'fas fa-toggle-off'"></i>
                  </button>
                  <button
                    @click="deleteTemplate(template)"
                    class="btn btn-sm btn-danger"
                    title="حذف"
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
</template>

<script>
export default {
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
        const response = await axios.get('/dashboard/api/contract-templates');
        this.templates = response.data;
      } catch (error) {
        toastr.error('فشل تحميل القوالب');
        console.error(error);
      } finally {
        this.loading = false;
      }
    },

    truncateHtml(html, maxLength) {
      if (!html) return '';
      const text = html.replace(/<[^>]*>/g, '');
      if (text.length <= maxLength) return text;
      return text.substring(0, maxLength) + '...';
    },

    createContract(templateId) {
      this.$router.push({
        name: 'contract-create-from-template',
        params: { template_id: templateId }
      });
    },

    async toggleActive(template) {
      try {
        const response = await axios.post(
          `/dashboard/api/contract-templates/${template.id}/toggle-active`
        );
        template.is_active = response.data.is_active;
        toastr.success(
          template.is_active ? 'تم تفعيل القالب' : 'تم تعطيل القالب'
        );
      } catch (error) {
        toastr.error('فشل تغيير حالة القالب');
        console.error(error);
      }
    },

    deleteTemplate(template) {
      Swal.fire({
        title: 'هل أنت متأكد؟',
        text: `سيتم حذف القالب "${template.name}"`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'نعم، احذف',
        cancelButtonText: 'إلغاء'
      }).then(async (result) => {
        if (result.isConfirmed) {
          try {
            await axios.delete(`/dashboard/api/contract-templates/${template.id}`);
            toastr.success('تم حذف القالب بنجاح');
            this.loadTemplates();
          } catch (error) {
            if (error.response && error.response.status === 400) {
              toastr.error(error.response.data.error);
            } else {
              toastr.error('فشل حذف القالب');
            }
            console.error(error);
          }
        }
      });
    }
  }
};
</script>

<style scoped>
.contract-template-manager {
  padding: 20px;
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
  display: flex;
  align-items: center;
  gap: 10px;
}

.templates-container {
  background: white;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  padding: 20px;
  min-height: 400px;
}

.loading-state,
.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 20px;
  color: #95a5a6;
}

.loading-state i,
.empty-state i {
  font-size: 64px;
  margin-bottom: 20px;
}

.empty-state h3 {
  margin: 10px 0;
  color: #7f8c8d;
}

.empty-state p {
  margin-bottom: 20px;
}

.templates-table-wrapper {
  overflow-x: auto;
}

.templates-table {
  width: 100%;
  border-collapse: collapse;
}

.templates-table thead {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.templates-table th {
  padding: 15px;
  text-align: right;
  font-weight: 600;
}

.templates-table td {
  padding: 15px;
  border-bottom: 1px solid #e0e0e0;
}

.templates-table tbody tr:hover {
  background: #f8f9fa;
}

.template-name {
  display: flex;
  align-items: center;
  gap: 10px;
  font-weight: 600;
  color: #2c3e50;
}

.template-description {
  color: #6c757d;
  font-size: 14px;
  max-width: 300px;
}

.text-center {
  text-align: center;
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

.badge-info {
  background: #17a2b8;
  color: white;
}

.status-badge {
  display: inline-block;
  padding: 6px 12px;
  border-radius: 15px;
  font-size: 13px;
  font-weight: 600;
}

.status-active {
  background: #d4edda;
  color: #155724;
}

.status-inactive {
  background: #f8d7da;
  color: #721c24;
}

.action-buttons {
  display: flex;
  gap: 5px;
  justify-content: center;
}

.btn {
  padding: 8px 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 14px;
  transition: all 0.3s;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  text-decoration: none;
}

.btn-sm {
  padding: 5px 10px;
  font-size: 13px;
}

.btn-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.btn-success {
  background: #28a745;
  color: white;
}

.btn-success:hover {
  background: #218838;
}

.btn-warning {
  background: #ffc107;
  color: #212529;
}

.btn-warning:hover {
  background: #e0a800;
}

.btn-danger {
  background: #dc3545;
  color: white;
}

.btn-danger:hover {
  background: #c82333;
}
</style>
