<template>
  <div class="row justify-content-center">
    <!-- زر إضافة مورد -->
    <div class="col-12 mb-3 d-flex justify-content-end">
      <button v-if="!showForm" @click="showAddForm" class="btn btn-primary">
        <i class="fas fa-plus"></i> إضافة مورد جديد
      </button>
    </div>

    <!-- Supplier Form Card -->
    <div class="col-md-12 mb-4" v-if="showForm">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="mb-0">
            {{ editMode ? 'تحديث مورد' : 'إضافة مورد جديد' }}
            <i class="fas fa-truck"></i>
          </h4>
          <button
            @click="cancelEdit"
            class="btn btn-danger btn-sm"
          >إغلاق</button>
        </div>
        <div class="card-body">
          <form @submit.prevent="editMode ? updateSupplier() : addSupplier()">
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">أسم المورد</label>
                <input
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                  placeholder="أسم المورد ..."
                  v-model="form.name"
                />
                <HasError :form="form" field="name" />
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">اسم الشركة</label>
                <input
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('company_name') }"
                  placeholder="اسم الشركة ..."
                  v-model="form.company_name"
                />
                <HasError :form="form" field="company_name" />
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">الشخص المسؤول</label>
                <input
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('contact_person') }"
                  placeholder="الشخص المسؤول ..."
                  v-model="form.contact_person"
                />
                <HasError :form="form" field="contact_person" />
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">البريد الإلكتروني</label>
                <input
                  type="email"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                  placeholder="البريد الإلكتروني ..."
                  v-model="form.email"
                />
                <HasError :form="form" field="email" />
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">رقم الهاتف</label>
                <input
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('phone') }"
                  placeholder="رقم الهاتف ..."
                  v-model="form.phone"
                />
                <HasError :form="form" field="phone" />
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">العنوان</label>
                <input
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('address') }"
                  placeholder="العنوان ..."
                  v-model="form.address"
                />
                <HasError :form="form" field="address" />
              </div>
              <div class="col-md-12 mb-3">
                <label class="form-label">ملاحظات</label>
                <textarea
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('notes') }"
                  placeholder="ملاحظات ..."
                  v-model="form.notes"
                  rows="2"
                ></textarea>
                <HasError :form="form" field="notes" />
              </div>
              <div class="col-md-12">
                <button type="submit" class="btn btn-success">
                  {{ editMode ? 'تحديث' : 'إضافة' }}
                </button>
                <button
                  type="button"
                  @click="cancelEdit"
                  class="btn btn-secondary ms-2"
                >إلغاء</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Supplier List Table Card -->
    <div class="col-md-12 col-lg-12">
      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="mb-0">قائمة الموردين</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered align-middle">
              <thead>
                <tr>
                  <th>#</th>
                  <th>المعرف</th>
                  <th>اسم المورد</th>
                  <th>اسم الشركة</th>
                  <th>الشخص المسؤول</th>
                  <th>البريد الإلكتروني</th>
                  <th>رقم الهاتف</th>
                  <th>العنوان</th>
                  <th>ملاحظات</th>
                  <th>الإجراء</th>
                  <th>Total Debts</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(supplier, i) in suppliers" :key="supplier.id">
                  <td>{{ i + 1 }}</td>
                  <td>{{ supplier.id }}</td>
                  <td>{{ supplier.name }}</td>
                  <td>{{ supplier.company_name }}</td>
                  <td>{{ supplier.contact_person }}</td>
                  <td>{{ supplier.email }}</td>
                  <td>{{ supplier.phone }}</td>
                  <td>{{ supplier.address }}</td>
                  <td>{{ supplier.notes }}</td>
                  <td>{{ supplier.total_debts }} IQD</td>
                  <td>
                    <button @click="editSupplier(i)" class="btn btn-sm btn-warning me-1">تعديل</button>
                    <button @click="deleteSupplier(supplier.id, i)" class="btn btn-sm btn-danger">حذف</button>
                    <router-link class="btn btn-sm btn-primary" :to="{name: 'supplier.purchase', params: {id: supplier.id}}">Purchase</router-link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="d-flex justify-content-center">
            <pagination :limit="8" :data="paginateData" @pagination-change-page="getSupplierList"></pagination>
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
      suppliers: [],
      showForm: false,
      form: new Form({
        supplierId: null,      // For edit purpose
        name: "",
        company_name: "",
        contact_person: "",
        email: "",
        phone: "",
        address: "",
        notes: ""
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
    // List Suppliers
    async getSupplierList(page = 1) {
      await axios.get(`/dashboard/api/supplier-list?page=${page}`).then(resp=>{
        return resp.data;
      }).then(data=>{
        this.paginateData = data;
        this.suppliers = data.data;
      }).catch(err=>{
        console.error(err.response.data);
      })
    },
    // Add Supplier
    async addSupplier() {
      await this.form.post("/dashboard/api/supplier-store").then(resp=>{
        return resp.data;
      }).then(data=>{
        if(data.status === "ok") {
          swal.fire("تمت الإضافة", data.msg, "success");
          this.suppliers.unshift(data.data);
          this.form.reset();
          this.showForm = false;
        }
      }).catch(err=>{
        console.error(err.response.data);
      })
    },
    // Edit Supplier (fill form)
    editSupplier(index) {
      let s = this.suppliers[index];
      this.form.supplierId = s.id;
      this.form.name = s.name;
      this.form.company_name = s.company_name;
      this.form.contact_person = s.contact_person;
      this.form.email = s.email;
      this.form.phone = s.phone;
      this.form.address = s.address;
      this.form.notes = s.notes;
      this.editMode = true;
      this.editIndex = index;
      this.showForm = true;
    },
    // Update Supplier
    async updateSupplier() {
      await this.form.post("/dashboard/api/supplier-update").then(resp=>{
        return resp.data;
      }).then(data=>{
        if(data.status === "ok") {
          swal.fire("تم التحديث", data.msg, "success");
          this.suppliers[this.editIndex] = data.data;
          this.cancelEdit();
        }
      }).catch(err=>{
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
    // Delete Supplier
    async deleteSupplier(id, index) {
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
          axios.post("/dashboard/api/supplier-delete",{
            supplierId: id,
          }).then(resp=>{
            return resp.data;
          }).then(data=>{
            if(data.status === "ok") {
              swal.fire("تم الحذف", data.msg, "success");
              this.suppliers.splice(index,1);
            }
          }).catch(err=>{
            console.error(err.response.data);
          })
        }
      })
    }
  },
  mounted() {
    this.getSupplierList();
  }
}
</script>
