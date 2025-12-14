<template>
  <div class="row justify-content-center">
    <div class="col-md-12 mb-3">
      <div class="card">
        <div class="card-body">
          <form class="row" @submit.prevent="getReport(1)">
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
                بحث
              </button>
            </div>
          </form>
          <div class="text-md-end text-center flex-shrink-0 ms-md-4 mt-3 mt-md-0">
            <span class="fw-bold fs-5">
              صافي الربح لهذا الشهر:
              <span :class="netProfitThisMonth >= 0 ? 'text-success' : 'text-danger'">
                {{ netProfitThisMonth.toLocaleString() }}
              </span>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h6 class="mb-0">تقرير الأرباح والخسائر</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
              <thead>
                <tr>
                  <th>النوع</th>
                  <th>المبلغ</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>مجموع المبيعات</td>
                  <td>{{ summary.sales.toLocaleString() }}</td>
                </tr>
                <tr>
                  <td>مجموع المشتريات</td>
                  <td>{{ summary.purchases.toLocaleString() }}</td>
                </tr>
                <tr>
                  <td>مجموع المصاريف</td>
                  <td>{{ summary.expenses.toLocaleString() }}</td>
                </tr>
                <tr class="table-success">
                  <td><b>صافي الربح</b></td>
                  <td>
                    <b>{{ netProfitThisMonth.toLocaleString() }}</b>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- اختياري: تقدر تضيف جدول أو قائمة تفاصيل تحت هنا -->
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
      summary: {
        sales: 0,
        purchases: 0,
        expenses: 0
      }
    }
  },
  computed: {
    netProfitThisMonth() {
      return (this.summary.sales - this.summary.purchases - this.summary.expenses);
    }
  },
  methods: {
    async getReport(page = 1) {
      let params = { page, ...this.filter };
      await axios.get('/dashboard/api/profit-loss', { params }).then(resp => {
        const data = resp.data;
        this.summary.sales = data.sales || 0;
        this.summary.purchases = data.purchases || 0;
        this.summary.expenses = data.expenses || 0;
      }).catch(() => {
        this.summary.sales = 0;
        this.summary.purchases = 0;
        this.summary.expenses = 0;
      });
    }
  },
  mounted() {
    this.getReport();
  }
}
</script>
