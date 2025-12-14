<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
              <strong>الشركاء</strong> <i class="fas fa-handshake"></i>
            </h5>
            <button class="btn btn-primary btn-sm" @click="showAddModal">
              <i class="fas fa-plus"></i> إضافة شريك
            </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>الاسم</th>
                    <th>نسبة الربح %</th>
                    <th>الحالة</th>
                    <th>الإجمالي المدفوع</th>
                    <th>الإجمالي المستحق</th>
                    <th>الإجراءات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="partner in partners" :key="partner.id">
                    <td>{{ partner.name }}</td>
                    <td>{{ partner.profit_percent }}%</td>
                    <td>
                      <span class="badge" :class="partner.is_active ? 'bg-success' : 'bg-danger'">
                        {{ partner.is_active ? 'نشط' : 'غير نشط' }}
                      </span>
                    </td>
                    <td>{{ formatCurrency(partner.total_paid || 0) }}</td>
                    <td>{{ formatCurrency(partner.total_pending || 0) }}</td>
                    <td>
                      <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" @click="viewPartner(partner)">
                          <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-outline-info" @click="viewSettlements(partner)">
                          <i class="fas fa-money-bill-wave"></i>
                        </button>
                        <button class="btn btn-outline-warning" @click="editPartner(partner)">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-danger" @click="deletePartner(partner)" v-if="partner.monthly_settlements_count === 0">
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

    <!-- Add/Edit Partner Modal -->
    <div class="modal fade" id="partnerModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ editingPartner ? 'تعديل الشريك' : 'إضافة شريك جديد' }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="savePartner">
              <div class="mb-3">
                <label class="form-label">الاسم</label>
                <input type="text" class="form-control" v-model="form.name" :class="{'is-invalid' : form.errors.has('name')}" required>
                <HasError :form="form" field="name" />
              </div>
              <div class="mb-3">
                <label class="form-label">نسبة الربح (%)</label>
                <input type="number" class="form-control" v-model="form.profit_percent" :class="{'is-invalid' : form.errors.has('profit_percent')}" required min="0" max="100" step="0.01">
                <HasError :form="form" field="profit_percent" />
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" v-model="form.is_active" id="isActive">
                  <label class="form-check-label" for="isActive">
                    نشط
                  </label>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">ملاحظات</label>
                <textarea class="form-control" v-model="form.notes" rows="3"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
            <button type="button" class="btn btn-primary" @click="savePartner" :disabled="form.busy">
              {{ editingPartner ? 'تحديث' : 'حفظ' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      partners: [],
      editingPartner: null,
      form: new Form({
        id: null,
        name: "",
        profit_percent: "",
        is_active: true,
        notes: "",
      })
    }
  },
  methods: {
    async fetchPartners() {
      try {
        const response = await axios.get('/dashboard/api/partners');
        this.partners = response.data.data;
      } catch (error) {
        swal.fire("خطأ", "فشل تحميل الشركاء", "error");
      }
    },
    showAddModal() {
      this.editingPartner = null;
      this.form.reset();
      this.form.is_active = true;
      new mdb.Modal(document.getElementById('partnerModal')).show();
    },
    editPartner(partner) {
      this.editingPartner = partner;
      this.form.fill(partner);
      new mdb.Modal(document.getElementById('partnerModal')).show();
    },
    async savePartner() {
      const url = this.editingPartner
        ? `/dashboard/api/partner-update`
        : `/dashboard/api/partner-store`;

      this.form.post(url)
        .then(response => {
          swal.fire("نجاح", this.editingPartner ? "تم تحديث الشريك!" : "تم إضافة الشريك!", "success");
          mdb.Modal.getInstance(document.getElementById('partnerModal')).hide();
          this.fetchPartners();
        })
        .catch(err => {
          // errors handled by vform
        });
    },
    async deletePartner(partner) {
      const result = await swal.fire({
        title: 'هل أنت متأكد؟',
        text: "لن تتمكن من استعادة هذا الشريك!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'إلغاء',
        confirmButtonText: 'نعم، احذفه!'
      });

      if (result.isConfirmed) {
        try {
          await axios.post(`/dashboard/api/partner-delete`, { id: partner.id });
          swal.fire("تم الحذف!", "تم حذف الشريك.", "success");
          this.fetchPartners();
        } catch (error) {
          swal.fire("خطأ", "فشل حذف الشريك.", "error");
        }
      }
    },
    viewPartner(partner) {
      // Navigate to partner details view
      this.$router.push({ name: 'partner.details', params: { id: partner.id } });
    },
    viewSettlements(partner) {
      // Navigate to partner settlements view
      this.$router.push({ name: 'partner.settlements', params: { id: partner.id } });
    },
    formatCurrency(amount) {
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
      }).format(amount);
    }
  },
  mounted() {
    this.fetchPartners();
  }
}
</script>
