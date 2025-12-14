<template>
  <div class="row justify-content-center">
    <div class="col-md-12 mb-3">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="text-md-end text-center flex-shrink-0 ms-md-4 mt-3 mt-md-0">
                <span class="fw-bold fs-5">
                  إجمالي المصروفات لهذا الشهر:
                  <span class="text-success">{{ totalExpenseThisMonth.toLocaleString() }}</span>
                </span>
              </div>
            </div>
          </div>
          <form class="row flex-grow-1 mt-3" @submit.prevent="getExpenseReport(1)">
            <div class="col-md-4 mb-2 mb-md-0">
              <label class="form-label">من تاريخ</label>
              <input type="date" class="form-control" v-model="filter.from_date">
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
              <label class="form-label">إلى تاريخ</label>
              <input type="date" class="form-control" v-model="filter.to_date">
            </div>
            <div class="col-md-4">
              <button class="btn btn-primary mt-4" type="submit">
                تصفية
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>

    <div class="col-md-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h6 class="mb-0">تقرير المصروفات</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>المعرف</th>
                  <th>الاسم</th>
                  <th>المبلغ</th>
                  <th>التاريخ</th>
                  <th>القسم</th>
                  <th>المرجع</th>
                  <th>ملاحظات</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(expense, i) in expenses" :key="expense.id">
                  <td>{{ ((paginateData.current_page-1)*paginateData.per_page) + i + 1 }}</td>
                  <td>{{ expense.id }}</td>
                  <td>{{ expense.name }}</td>
                  <td>{{ expense.amount }}</td>
                  <td>{{ expense.date }}</td>
                  <td>{{ expense.department_name ?? '-' }}</td>
                  <td>{{ expense.reference }}</td>
                  <td>{{ expense.notes }}</td>
                </tr>
                <tr v-if="expenses.length === 0">
                  <td colspan="8" class="text-center text-muted">لا توجد مصروفات.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="d-flex justify-content-center">
            <pagination :limit="8" :data="paginateData" @pagination-change-page="getExpenseReport"></pagination>
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
      filter: {
        from_date: "",
        to_date: ""
      },
      paginateData: {},
      expenses: [],
      totalExpenseThisMonth: 0
    }
  },
  methods: {
    async getExpenseReport(page = 1) {
      let params = {
        page,
        ...this.filter
      };
      await axios.get('/dashboard/api/expenses', { params }).then(resp => {
        const data = resp.data;
        this.paginateData = data;
        this.expenses = data.data || [];
        this.totalExpenseThisMonth = data.total_expense_month || 0;
      }).catch(err => {
        this.paginateData = {};
        this.expenses = [];
        this.totalExpenseThisMonth = 0;
      });
    }
  },
  mounted() {
    this.getExpenseReport();
  }
}
</script>
