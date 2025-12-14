<template>
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-sm mt-5">
        <div class="card-header text-center">
          <h4 class="mb-0">
            <strong>إضافة مصروف جديد</strong> <i class="fas fa-receipt"></i>
          </h4>

        </div>
        <div class="card-body">
          <div class="mb-4">
            <router-link class="btn btn-sm btn-primary" :to="{name: 'expenses.report'}">تقرير المصروفات</router-link>
          </div>
          <form @submit.prevent="addExpense">
            <div class="mb-3">
              <label class="form-label" for="expenseName">اسم المصروف</label>
              <input type="text" class="form-control" id="expenseName" v-model="form.name" :class="{'is-invalid' : form.errors.has('name')}" required>
              <HasError :form="form" field="name" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="expenseAmount">المبلغ</label>
              <input type="number" class="form-control" id="expenseAmount" v-model="form.amount" :class="{'is-invalid' : form.errors.has('amount')}" required min="0" step="0.01">
              <HasError :form="form" field="amount" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="expenseDate">التاريخ</label>
              <input type="date" class="form-control" id="expenseDate" v-model="form.date" :class="{'is-invalid' : form.errors.has('date')}" required>
              <HasError :form="form" field="date" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="department">القسم</label>
              <select class="form-select" id="department" v-model="form.department" :class="{'is-invalid' : form.errors.has('department')}" required>
                <option value="" disabled>اختار القسم</option>
                <option v-for="dep in departments" :key="dep.id" :value="dep.id">{{ dep.name }}</option>
              </select>
              <HasError :form="form" field="department" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="expenseReference">المرجع/رقم الفاتورة (اختياري)</label>
              <input type="text" class="form-control" id="expenseReference" v-model="form.reference" :class="{'is-invalid' : form.errors.has('reference')}">
              <HasError :form="form" field="reference" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="expenseNotes">ملاحظات / الوصف</label>
              <textarea class="form-control" id="expenseNotes" rows="3" v-model="form.notes" :class="{'is-invalid' : form.errors.has('notes')}"></textarea>
              <HasError :form="form" field="notes" />
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-success px-5" :disabled="form.busy">
                إضافة مصروف <i class="fas fa-plus-circle"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: new Form({
        name: "",
        amount: "",
        date: "",
        department: "",
        reference: "",
        notes: "",
      }),
      departments: []
    }
  },
  methods: {
    async addExpense() {
      this.form.post('/dashboard/api/expense-store')
        .then(response => {
          swal.fire("Success", "Expense has been added!", "success");
          this.form.reset();
        })
        .catch(err => {
          // errors handled by vform
        });
    },
    async fetchDepartments() {
      try {
        const response = await axios.get('/dashboard/api/departments');
        this.departments = response.data;
      } catch (error) {
        swal.fire("Error", "Failed to load departments.", "error");
        this.departments = [];
      }
    }
  },
  mounted() {
    this.fetchDepartments();
  }
}
</script>
