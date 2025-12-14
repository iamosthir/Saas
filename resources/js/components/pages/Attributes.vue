<template>
  <div class="row justify-content-center">
    <div class="col-md-10 col-lg-10">

      <div v-if="showForm" class="card shadow-sm mb-4">
        <div class="card-header">
          <h5 class="mb-0">
            {{ editMode ? 'تعديل الخاصية' : 'إضافة خاصية جديدة' }}
          </h5>
        </div>
        <div class="card-body">
          <form @submit.prevent="editMode ? updateAttribute() : createAttribute()">
            <div class="mb-3">
              <label class="form-label" for="attrName">اسم الخاصية</label>
              <input
                type="text"
                class="form-control"
                id="attrName"
                v-model="form.name"
                :class="{'is-invalid' : form.errors.has('name')}"
                required
                autocomplete="off"
                placeholder="مثال: اللون، الحجم، المادة..."
              >
              <HasError :form="form" field="name" />
            </div>
            <div class="mb-3 form-check">
              <input
                type="checkbox"
                class="form-check-input"
                id="attrActive"
                v-model="form.is_active"
              >
              <label class="form-check-label" for="attrActive">فعال</label>
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
          <h5 class="mb-0">قائمة الخصائص</h5>
          <button class="btn btn-primary btn-sm" v-if="!showForm" @click="showCreateForm">
            إضافة خاصية <i class="fas fa-plus"></i>
          </button>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped mb-0">
            <thead>
              <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>الحالة</th>
                <th width="150">الإجراءات</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(attr, i) in attributes" :key="attr.id">
                <td>{{ i + 1 }}</td>
                <td>{{ attr.name }}</td>
                <td>
                  <span class="badge" :class="attr.is_active ? 'bg-success' : 'bg-secondary'">
                    {{ attr.is_active ? 'فعال' : 'غير فعال' }}
                  </span>
                </td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-warning btn-sm" @click="showEditForm(attr, i)">تعديل</button>
                    <button class="btn btn-danger btn-sm" @click="deleteAttribute(attr.id, i)">حذف</button>
                  </div>
                </td>
              </tr>
              <tr v-if="attributes.length === 0">
                <td colspan="4" class="text-center text-muted">لم يتم العثور على خصائص.</td>
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
      attributes: [],
      form: new Form({
        id: null,
        name: "",
        is_active: true,
      }),
      showForm: false,
      editMode: false,
      editIndex: null,
    }
  },
  methods: {
    // Fetch all attributes
    async fetchAttributes() {
      try {
        const response = await axios.get('/dashboard/api/attributes');
        this.attributes = response.data;
      } catch (error) {
        swal.fire("خطأ", "فشل تحميل الخصائص.", "error");
      }
    },
    showCreateForm() {
      this.showForm = true;
      this.editMode = false;
      this.form.reset();
      this.form.clear();
      this.form.is_active = true;
    },
    showEditForm(attr, index) {
      this.showForm = true;
      this.editMode = true;
      this.editIndex = index;
      this.form.reset();
      this.form.clear();
      this.form.id = attr.id;
      this.form.name = attr.name;
      this.form.is_active = attr.is_active;
    },
    hideForm() {
      this.showForm = false;
      this.editMode = false;
      this.editIndex = null;
      this.form.reset();
      this.form.clear();
    },
    // Create
    async createAttribute() {
      await this.form.post('/dashboard/api/attribute-store')
        .then(response => {
          this.attributes.unshift(response.data.data);
          swal.fire("نجح", "تم إنشاء الخاصية!", "success");
          this.hideForm();
        })
        .catch(() => {});
    },
    // Update
    async updateAttribute() {
      await this.form.post('/dashboard/api/attribute-update')
        .then(response => {
          this.attributes[this.editIndex] = response.data.data;
          swal.fire("نجح", "تم تحديث الخاصية!", "success");
          this.hideForm();
        })
        .catch(() => {});
    },
    // Delete
    deleteAttribute(id, index) {
      swal.fire({
        title: "هل أنت متأكد؟",
        text: "سيتم حذف الخاصية نهائياً.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#aaa",
        cancelButtonText: "إلغاء",
        confirmButtonText: "حذف"
      }).then((result) => {
        if (result.isConfirmed) {
          axios.post('/dashboard/api/attribute-delete', { id })
            .then(() => {
              this.attributes.splice(index, 1);
              swal.fire("تم الحذف!", "تم حذف الخاصية.", "success");
            })
            .catch((error) => {
              const message = error.response?.data?.msg || "لا يمكن الحذف.";
              swal.fire("خطأ", message, "error");
            });
        }
      });
    }
  },
  mounted() {
    this.fetchAttributes();
  }
}
</script>
