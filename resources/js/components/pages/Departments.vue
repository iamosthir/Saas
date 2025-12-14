<template>
  <div class="row justify-content-center">
    <div class="col-md-10 col-lg-10">

      <div v-if="showForm" class="card shadow-sm mb-4">
        <div class="card-header">
          <h5 class="mb-0">
            {{ editMode ? 'تعديل القسم' : 'إضافة قسم جديد' }}
          </h5>
        </div>
        <div class="card-body">
          <form @submit.prevent="editMode ? updateDepartment() : createDepartment()">
            <div class="mb-3">
              <label class="form-label" for="depName">اسم القسم</label>
              <input
                type="text"
                class="form-control"
                id="depName"
                v-model="form.name"
                :class="{'is-invalid' : form.errors.has('name')}"
                required
                autocomplete="off"
              >
              <HasError :form="form" field="name" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="depDesc">الوصف</label>
              <textarea
                class="form-control"
                id="depDesc"
                rows="2"
                v-model="form.description"
                :class="{'is-invalid' : form.errors.has('description')}"
              ></textarea>
              <HasError :form="form" field="description" />
            </div>
            <div class="text-end">
              <button type="button" class="btn btn-secondary me-2" @click="hideForm">إلغاء</button>
              <button type="submit" class="btn btn-success px-4" :disabled="form.busy">
                {{ editMode ? 'تحديث' : 'إنشاء' }}
              </button>
            </div>
          </form>
        </div>
      </div>

      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">قائمة الأقسام</h5>
          <button class="btn btn-primary btn-sm" v-if="!showForm" @click="showCreateForm">
            إضافة قسم <i class="fas fa-plus"></i>
          </button>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped mb-0">
            <thead>
              <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>الوصف</th>
                <th width="120">الإجراءات</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(dep, i) in departments" :key="dep.id">
                <td>{{ i + 1 }}</td>
                <td>{{ dep.name }}</td>
                <td>{{ dep.description }}</td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-warning btn-sm" @click="showEditForm(dep, i)">تعديل</button>
                    <button class="btn btn-danger btn-sm" @click="deleteDepartment(dep.id, i)">حذف</button>
                  </div>
                </td>

              </tr>
              <tr v-if="departments.length === 0">
                <td colspan="4" class="text-center text-muted">لم يتم العثور على أقسام.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      departments: [],
      form: new Form({
        id: null,
        name: "",
        description: "",
      }),
      showForm: false,
      editMode: false,
      editIndex: null,
    }
  },
  methods: {
    // Fetch all departments
    async fetchDepartments() {
      try {
        const response = await axios.get('/dashboard/api/departments');
        this.departments = response.data;
      } catch (error) {
        swal.fire("Error", "Failed to load departments.", "error");
      }
    },
    showCreateForm() {
      this.showForm = true;
      this.editMode = false;
      this.form.reset();
      this.form.clear();
    },
    showEditForm(dep, index) {
      this.showForm = true;
      this.editMode = true;
      this.editIndex = index;
      this.form.reset();
      this.form.clear();
      this.form.id = dep.id;
      this.form.name = dep.name;
      this.form.description = dep.description;
    },
    hideForm() {
      this.showForm = false;
      this.editMode = false;
      this.editIndex = null;
      this.form.reset();
      this.form.clear();
    },
    // Create
    async createDepartment() {
      await this.form.post('/dashboard/api/department-store')
        .then(response => {
          this.departments.unshift(response.data.data); // assuming response.data.data is the created dept
          swal.fire("Success", "Department created!", "success");
          this.hideForm();
        })
        .catch(() => {});
    },
    // Update
    async updateDepartment() {
      await this.form.post('/dashboard/api/department-update')
        .then(response => {
          // update in place
          this.departments[this.editIndex] = response.data.data; // assuming response.data.data is updated dept
          swal.fire("Success", "Department updated!", "success");
          this.hideForm();
        })
        .catch(() => {});
    },
    // Delete
    deleteDepartment(id, index) {
      swal.fire({
        title: "Are you sure?",
        text: "This will delete the department.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#aaa",
        confirmButtonText: "Delete"
      }).then((result) => {
        if (result.isConfirmed) {
          axios.post('/dashboard/api/department-delete', { id })
            .then(() => {
              this.departments.splice(index, 1);
              swal.fire("Deleted!", "Department deleted.", "success");
            })
            .catch(() => {
              swal.fire("Error", "Could not delete.", "error");
            });
        }
      });
    }
  },
  mounted() {
    this.fetchDepartments();
  }
}
</script>
