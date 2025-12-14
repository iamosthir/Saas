<template>
  <div class="row justify-content-center">
    <!-- زر إضافة زبون -->
    <div class="col-12 mb-3 d-flex justify-content-end">
      <button v-if="!showForm" @click="showAddForm" class="btn btn-primary">
        <i class="fas fa-plus"></i> إضافة زبون جديد
      </button>
    </div>

    <!-- Customer Form Card -->
    <div class="col-md-12 mb-4" v-if="showForm">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="mb-0">
            {{ editMode ? 'تحديث زبون' : 'إضافة زبون جديد' }}
            <i class="fas fa-user"></i>
          </h4>
          <button @click="cancelEdit" class="btn btn-danger btn-sm">إغلاق</button>
        </div>
        <div class="card-body">
          <form @submit.prevent="editMode ? updateCustomer() : addCustomer()">
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">أسم الزبون</label>
                <input
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('customer_name') }"
                  placeholder="أسم الزبون ..."
                  v-model="form.customer_name"
                />
                <HasError :form="form" field="customer_name" />
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">رابط حساب الزبون</label>
                <input
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('customer_link') }"
                  placeholder="رابط حساب الزبون ..."
                  v-model="form.customer_link"
                />
                <HasError :form="form" field="customer_link" />
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">رقم الهاتف الرئيسي</label>
                <input
                  type="tel"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('phone1') }"
                  placeholder="رقم الهاتف الرئيسي ..."
                  v-model="form.phone1"
                />
                <HasError :form="form" field="phone1" />
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">رقم الهاتف الثاني</label>
                <input
                  type="tel"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('phone2') }"
                  placeholder="رقم الهاتف الثاني ..."
                  v-model="form.phone2"
                />
                <HasError :form="form" field="phone2" />
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">المحافظة</label>
                <input
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('state') }"
                  placeholder="المحافظة ..."
                  v-model="form.state"
                />
                <HasError :form="form" field="state" />
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">المدينة</label>
                <input
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('city') }"
                  placeholder="المدينة ..."
                  v-model="form.city"
                />
                <HasError :form="form" field="city" />
              </div>
              <div class="col-md-12">
                <button type="submit" class="btn btn-success">
                  {{ editMode ? 'تحديث' : 'إضافة' }}
                </button>
                <button type="button" @click="cancelEdit" class="btn btn-secondary ms-2">
                  إلغاء
                </button>
                
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Customer List Table Card -->
    <div class="col-md-12 col-lg-12">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="mb-0">قائمة الزبائن</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered align-middle">
              <thead>
                <tr>
                  <th>#</th>
                  <th>المعرف</th>
                  <th>اسم الزبون</th>
                  <th>رابط الحساب</th>
                  <th>الهاتف الرئيسي</th>
                  <th>الهاتف الثاني</th>
                  <th>المحافظة</th>
                  <th>المدينة</th>
                  <th>Total Debts</th>
                  <th>الإجراء</th>
                  
                </tr>
              </thead>
              <tbody>
                <tr v-for="(customer, i) in customers" :key="customer.id">
                  <td>{{ i + 1 }}</td>
                  <td>{{ customer.id }}</td>
                  <td>{{ customer.customer_name }}</td>
                  <td>
                    <a :href="customer.customer_link" target="_blank">
                      {{ customer.customer_link }}
                    </a>
                  </td>
                  <td>{{ customer.phone1 }}</td>
                  <td>{{ customer.phone2 }}</td>
                  <td>{{ customer.state }}</td>
                  <td>{{ customer.city }}</td>
                  <td>{{ customer.total_debts }} IQD</td>
                  <td>
                    <button @click="editCustomer(i)" class="btn btn-sm btn-warning me-1">تعديل</button>
                    <button @click="deleteCustomer(customer.id, i)" class="btn btn-sm btn-danger">حذف</button>
                    <router-link class="btn btn-sm btn-outline-danger" :to="{name: 'customer.create-sale', params: {customerid: customer.id}}">Create Sale</router-link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="d-flex justify-content-center">
            <pagination :limit="8" :data="paginateData" @pagination-change-page="getCustomerList"></pagination>
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
      paginateData: {},
      customers: [],
      showForm: false,
      form: new Form({
        customerId: null, // For edit purpose
        customer_name: "",
        customer_link: "",
        phone1: "",
        phone2: "",
        state: "",
        city: ""
      }),
      editMode: false,
      editIndex: null
    }
  },
  methods: {
    showAddForm() {
      this.editMode = false;
      this.editIndex = null;
      this.form.reset();
      this.showForm = true;
    },
    // List Customers
    async getCustomerList(page = 1) {
      await axios.get(`/dashboard/api/customer-list?page=${page}`).then(resp => {
        return resp.data;
      }).then(data => {
        this.paginateData = data;
        this.customers = data.data;
      }).catch(err => {
        console.error(err.response.data);
      })
    },
    // Add Customer
    async addCustomer() {
      await this.form.post("/dashboard/api/customer-store").then(resp => {
        return resp.data;
      }).then(data => {
        if (data.status === "ok") {
          swal.fire("تمت الإضافة", data.msg, "success");
          this.customers.unshift(data.data);
          this.form.reset();
          this.showForm = false;
        }
      }).catch(err => {
        console.error(err.response.data);
      })
    },
    // Edit Customer (fill form)
    editCustomer(index) {
      let c = this.customers[index];
      this.form.customerId = c.id;
      this.form.customer_name = c.customer_name;
      this.form.customer_link = c.customer_link;
      this.form.phone1 = c.phone1;
      this.form.phone2 = c.phone2;
      this.form.state = c.state;
      this.form.city = c.city;
      this.editMode = true;
      this.editIndex = index;
      this.showForm = true;
    },
    // Update Customer
    async updateCustomer() {
      await this.form.post("/dashboard/api/customer-update").then(resp => {
        return resp.data;
      }).then(data => {
        if (data.status === "ok") {
          swal.fire("تم التحديث", data.msg, "success");
          this.customers[this.editIndex] = data.data;
          this.cancelEdit();
        }
      }).catch(err => {
        console.error(err.response.data);
      })
    },
    // Cancel edit/add mode and hide form
    cancelEdit() {
      this.editMode = false;
      this.editIndex = null;
      this.form.reset();
      this.showForm = false;
    },
    // Delete Customer
    async deleteCustomer(id, index) {
      swal.fire({
        title: 'هل أنت متأكد؟',
        text: "لن تتمكن من التراجع!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم، احذفه!'
      }).then((result) => {
        if (result.isConfirmed) {
          axios.post("/dashboard/api/customer-delete", {
            customerId: id,
          }).then(resp => {
            return resp.data;
          }).then(data => {
            if (data.status === "ok") {
              swal.fire("تم الحذف", data.msg, "success");
              this.customers.splice(index, 1);
            }
          }).catch(err => {
            console.error(err.response.data);
          })
        }
      })
    }
  },
  mounted() {
    this.getCustomerList();
  }
}
</script>
