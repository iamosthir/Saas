<template>
  <div class="contract-list">
    <div class="page-header">
      <h2><i class="fas fa-file-signature"></i> العقود</h2>
      <router-link :to="{name: 'contract-create'}" class="btn btn-primary">
        <i class="fas fa-plus"></i> عقد جديد
      </router-link>
    </div>

    <!-- Filters -->
    <div class="filters-container">
      <div class="filter-group">
        <label>البحث</label>
        <input
          v-model="filters.search"
          type="text"
          class="form-control"
          placeholder="ابحث برقم العقد أو العنوان..."
          @input="applyFilters"
        />
      </div>

      <div class="filter-group">
        <label>الحالة</label>
        <select v-model="filters.status" @change="applyFilters" class="form-control">
          <option value="">الكل</option>
          <option value="draft">مسودة</option>
          <option value="active">نشط</option>
          <option value="completed">مكتمل</option>
          <option value="cancelled">ملغي</option>
        </select>
      </div>

      <div class="filter-group">
        <label>من تاريخ</label>
        <input
          v-model="filters.start_date"
          type="date"
          class="form-control"
          @change="applyFilters"
        />
      </div>

      <div class="filter-group">
        <label>إلى تاريخ</label>
        <input
          v-model="filters.end_date"
          type="date"
          class="form-control"
          @change="applyFilters"
        />
      </div>

      <div class="filter-group">
        <button @click="clearFilters" class="btn btn-secondary">
          <i class="fas fa-times"></i> مسح الفلاتر
        </button>
      </div>
    </div>

    <!-- Contracts Container -->
    <div class="contracts-container">
      <div v-if="loading" class="loading-state">
        <i class="fas fa-spinner fa-spin"></i>
        <p>جاري التحميل...</p>
      </div>

      <div v-else-if="filteredContracts.length === 0" class="empty-state">
        <i class="fas fa-inbox"></i>
        <h3>لا توجد عقود</h3>
        <p v-if="hasActiveFilters">لم يتم العثور على عقود مطابقة للفلاتر</p>
        <p v-else>ابدأ بإنشاء عقد جديد</p>
        <router-link :to="{name: 'contract-create'}" class="btn btn-primary">
          <i class="fas fa-plus"></i> إنشاء عقد
        </router-link>
      </div>

      <div v-else class="contracts-table-wrapper">
        <table class="contracts-table">
          <thead>
            <tr>
              <th>رقم العقد</th>
              <th>العنوان</th>
              <th>القالب</th>
              <th>الحالة</th>
              <th>تاريخ البدء</th>
              <th>تاريخ الانتهاء</th>
              <th>الإجراءات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="contract in filteredContracts" :key="contract.id">
              <td>
                <span class="contract-number">{{ contract.contract_number }}</span>
              </td>
              <td>
                <div class="contract-title-cell">
                  {{ contract.title }}
                </div>
              </td>
              <td>
                <span v-if="contract.template" class="template-badge">
                  {{ contract.template.name }}
                </span>
                <span v-else class="template-badge template-badge-empty">-</span>
              </td>
              <td>
                <span
                  class="status-badge"
                  :class="'status-' + contract.status"
                >
                  {{ getStatusLabel(contract.status) }}
                </span>
              </td>
              <td>
                <span v-if="contract.start_date">{{ formatDate(contract.start_date) }}</span>
                <span v-else class="text-muted">-</span>
              </td>
              <td>
                <span v-if="contract.end_date">{{ formatDate(contract.end_date) }}</span>
                <span v-else class="text-muted">-</span>
              </td>
              <td>
                <div class="action-buttons">
                  <button
                    @click="viewContract(contract.id)"
                    class="btn btn-sm btn-info"
                    title="عرض وطباعة"
                  >
                    <i class="fas fa-eye"></i>
                  </button>
                  <button
                    v-if="contract.status === 'draft'"
                    @click="editContract(contract.id)"
                    class="btn btn-sm btn-primary"
                    title="تعديل"
                  >
                    <i class="fas fa-edit"></i>
                  </button>
                  <button
                    @click="showStatusMenu(contract)"
                    class="btn btn-sm btn-warning"
                    title="تغيير الحالة"
                  >
                    <i class="fas fa-exchange-alt"></i>
                  </button>
                  <button
                    @click="deleteContract(contract)"
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

    <!-- Status Change Modal (using SweetAlert) -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      contracts: [],
      filteredContracts: [],
      loading: false,
      filters: {
        search: '',
        status: '',
        start_date: '',
        end_date: ''
      }
    };
  },

  computed: {
    hasActiveFilters() {
      return (
        this.filters.search ||
        this.filters.status ||
        this.filters.start_date ||
        this.filters.end_date
      );
    }
  },

  mounted() {
    this.loadContracts();
  },

  methods: {
    async loadContracts() {
      this.loading = true;
      try {
        const response = await axios.get('/dashboard/api/contracts');
        this.contracts = response.data;
        this.applyFilters();
      } catch (error) {
        toastr.error('فشل تحميل العقود');
        console.error(error);
      } finally {
        this.loading = false;
      }
    },

    applyFilters() {
      let filtered = [...this.contracts];

      // Search filter
      if (this.filters.search) {
        const search = this.filters.search.toLowerCase();
        filtered = filtered.filter(
          (contract) =>
            contract.contract_number.toLowerCase().includes(search) ||
            contract.title.toLowerCase().includes(search)
        );
      }

      // Status filter
      if (this.filters.status) {
        filtered = filtered.filter(
          (contract) => contract.status === this.filters.status
        );
      }

      // Start date filter
      if (this.filters.start_date) {
        filtered = filtered.filter(
          (contract) =>
            contract.start_date &&
            new Date(contract.start_date) >= new Date(this.filters.start_date)
        );
      }

      // End date filter
      if (this.filters.end_date) {
        filtered = filtered.filter(
          (contract) =>
            contract.end_date &&
            new Date(contract.end_date) <= new Date(this.filters.end_date)
        );
      }

      this.filteredContracts = filtered;
    },

    clearFilters() {
      this.filters = {
        search: '',
        status: '',
        start_date: '',
        end_date: ''
      };
      this.applyFilters();
    },

    formatDate(date) {
      if (!date) return '-';
      return new Date(date).toLocaleDateString('ar-SA', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      });
    },

    getStatusLabel(status) {
      const labels = {
        draft: 'مسودة',
        active: 'نشط',
        completed: 'مكتمل',
        cancelled: 'ملغي'
      };
      return labels[status] || status;
    },

    viewContract(contractId) {
      this.$router.push({
        name: 'contract-print',
        params: { id: contractId }
      });
    },

    editContract(contractId) {
      // Navigate to edit page (you can create ContractEdit.vue or reuse ContractCreate.vue)
      toastr.info('صفحة التعديل قيد التطوير');
      // this.$router.push({ name: 'contract-edit', params: { id: contractId } });
    },

    showStatusMenu(contract) {
      const statusOptions = {
        draft: 'مسودة',
        active: 'نشط',
        completed: 'مكتمل',
        cancelled: 'ملغي'
      };

      const inputOptions = {};
      for (const [key, value] of Object.entries(statusOptions)) {
        if (key !== contract.status) {
          inputOptions[key] = value;
        }
      }

      swal.fire({
        title: 'تغيير حالة العقد',
        text: `العقد: ${contract.title}`,
        input: 'select',
        inputOptions: inputOptions,
        inputPlaceholder: 'اختر الحالة الجديدة',
        showCancelButton: true,
        confirmButtonText: 'تغيير',
        cancelButtonText: 'إلغاء',
        confirmButtonColor: '#667eea',
        cancelButtonColor: '#6c757d'
      }).then(async (result) => {
        if (result.isConfirmed && result.value) {
          await this.updateStatus(contract, result.value);
        }
      });
    },

    async updateStatus(contract, newStatus) {
      try {
        const response = await axios.patch(
          `/dashboard/api/contracts/${contract.id}/status`,
          { status: newStatus }
        );

        contract.status = response.data.status;
        if (response.data.signed_at) {
          contract.signed_at = response.data.signed_at;
        }

        toastr.success('تم تحديث حالة العقد بنجاح');
      } catch (error) {
        toastr.error('فشل تحديث حالة العقد');
        console.error(error);
      }
    },

    deleteContract(contract) {
      swal.fire({
        title: 'هل أنت متأكد؟',
        text: `سيتم حذف العقد "${contract.title}" (${contract.contract_number})`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'نعم، احذف',
        cancelButtonText: 'إلغاء'
      }).then(async (result) => {
        if (result.isConfirmed) {
          try {
            await axios.delete(`/dashboard/api/contracts/${contract.id}`);
            toastr.success('تم حذف العقد بنجاح');
            this.loadContracts();
          } catch (error) {
            toastr.error('فشل حذف العقد');
            console.error(error);
          }
        }
      });
    }
  }
};
</script>

<style scoped>
.contract-list {
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

/* Filters */
.filters-container {
  background: white;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
  margin-bottom: 20px;
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
  align-items: flex-end;
}

.filter-group {
  flex: 1;
  min-width: 200px;
}

.filter-group label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
  color: #2c3e50;
  font-size: 14px;
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

/* Contracts Container */
.contracts-container {
  background: white;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

/* Table */
.contracts-table-wrapper {
  overflow-x: auto;
}

.contracts-table {
  width: 100%;
  border-collapse: collapse;
}

.contracts-table thead {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.contracts-table th {
  padding: 15px;
  text-align: right;
  font-weight: 600;
  white-space: nowrap;
}

.contracts-table td {
  padding: 15px;
  border-bottom: 1px solid #e0e0e0;
}

.contracts-table tbody tr:hover {
  background: #f8f9fa;
}

/* Contract cells */
.contract-number {
  font-family: monospace;
  font-weight: 600;
  color: #667eea;
  font-size: 0.95rem;
}

.contract-title-cell {
  font-weight: 600;
  color: #2c3e50;
  max-width: 300px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.template-badge {
  display: inline-block;
  padding: 5px 12px;
  border-radius: 12px;
  font-size: 13px;
  background: #e8eaf6;
  color: #667eea;
  font-weight: 600;
}

.template-badge-empty {
  background: #f5f5f5;
  color: #95a5a6;
}

.status-badge {
  display: inline-block;
  padding: 6px 12px;
  border-radius: 15px;
  font-size: 13px;
  font-weight: 600;
  white-space: nowrap;
}

.status-draft {
  background: #fff3cd;
  color: #856404;
}

.status-active {
  background: #d4edda;
  color: #155724;
}

.status-completed {
  background: #d1ecf1;
  color: #0c5460;
}

.status-cancelled {
  background: #f8d7da;
  color: #721c24;
}

.text-muted {
  color: #95a5a6;
}

/* Actions */
.action-buttons {
  display: flex;
  gap: 5px;
  justify-content: center;
}

/* Buttons */
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

.btn-secondary {
  background: #6c757d;
  color: white;
}

.btn-secondary:hover {
  background: #5a6268;
}

.btn-info {
  background: #17a2b8;
  color: white;
}

.btn-info:hover {
  background: #138496;
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

/* Responsive */
@media (max-width: 768px) {
  .filters-container {
    flex-direction: column;
  }

  .filter-group {
    width: 100%;
  }

  .contracts-table {
    font-size: 13px;
  }

  .contracts-table th,
  .contracts-table td {
    padding: 10px;
  }

  .action-buttons {
    flex-direction: column;
  }
}
</style>
