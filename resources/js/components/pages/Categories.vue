<template>
  <div class="row justify-content-center">
    <div class="col-md-10 col-lg-10">

      <div v-if="showForm" class="card shadow-sm mb-4">
        <div class="card-header">
          <h5 class="mb-0">
            {{ editMode ? 'تعديل التصنيف' : 'إضافة تصنيف جديد' }}
          </h5>
        </div>
        <div class="card-body">
          <form @submit.prevent="editMode ? updateCategory() : createCategory()">
            <div class="mb-3">
              <label class="form-label" for="catName">اسم التصنيف</label>
              <input
                type="text"
                class="form-control"
                id="catName"
                v-model="form.name"
                :class="{'is-invalid' : form.errors.has('name')}"
                required
                autocomplete="off"
              >
              <HasError :form="form" field="name" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="catDesc">الوصف</label>
              <textarea
                class="form-control"
                id="catDesc"
                rows="2"
                v-model="form.description"
                :class="{'is-invalid' : form.errors.has('description')}"
              ></textarea>
              <HasError :form="form" field="description" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="catParent">التصنيف الأساسي (اختياري)</label>
              <select
                class="form-control"
                id="catParent"
                v-model="form.parent_id"
                :class="{'is-invalid' : form.errors.has('parent_id')}"
              >
                <option :value="null">لا يوجد - تصنيف رئيسي</option>
                <option v-for="cat in parentCategories" :key="cat.id" :value="cat.id">
                  {{ cat.name }}
                </option>
              </select>
              <HasError :form="form" field="parent_id" />
            </div>
            <div class="mb-3">
              <label class="form-label" for="catSort">ترتيب العرض</label>
              <input
                type="number"
                class="form-control"
                id="catSort"
                v-model="form.sort_order"
                :class="{'is-invalid' : form.errors.has('sort_order')}"
                min="0"
              >
              <HasError :form="form" field="sort_order" />
            </div>
            <div class="mb-3 form-check">
              <input
                type="checkbox"
                class="form-check-input"
                id="catActive"
                v-model="form.is_active"
              >
              <label class="form-check-label" for="catActive">فعال</label>
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
          <h5 class="mb-0">قائمة التصنيفات</h5>
          <button class="btn btn-primary btn-sm" v-if="!showForm" @click="showCreateForm">
            إضافة تصنيف <i class="fas fa-plus"></i>
          </button>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped mb-0">
            <thead>
              <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>التصنيف الأساسي</th>
                <th>الوصف</th>
                <th>الترتيب</th>
                <th>الحالة</th>
                <th width="150">الإجراءات</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(cat, i) in categories" :key="cat.id">
                <td>{{ i + 1 }}</td>
                <td>
                  <span v-if="cat.parent_id" class="text-muted">└─</span>
                  {{ cat.name }}
                </td>
                <td>{{ cat.parent ? cat.parent.name : '-' }}</td>
                <td>{{ cat.description || '-' }}</td>
                <td>{{ cat.sort_order }}</td>
                <td>
                  <span class="badge" :class="cat.is_active ? 'bg-success' : 'bg-secondary'">
                    {{ cat.is_active ? 'فعال' : 'غير فعال' }}
                  </span>
                </td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-warning btn-sm" @click="showEditForm(cat, i)">تعديل</button>
                    <button class="btn btn-danger btn-sm" @click="deleteCategory(cat.id, i)">حذف</button>
                  </div>
                </td>
              </tr>
              <tr v-if="categories.length === 0">
                <td colspan="7" class="text-center text-muted">لم يتم العثور على تصنيفات.</td>
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
      categories: [],
      form: new Form({
        id: null,
        name: "",
        description: "",
        parent_id: null,
        sort_order: 0,
        is_active: true,
      }),
      showForm: false,
      editMode: false,
      editIndex: null,
    }
  },
  computed: {
    parentCategories() {
      // For edit mode, exclude the current category and its children
      if (this.editMode && this.form.id) {
        return this.categories.filter(cat => cat.id !== this.form.id && cat.parent_id !== this.form.id);
      }
      return this.categories;
    }
  },
  methods: {
    // Fetch all categories
    async fetchCategories() {
      try {
        const response = await axios.get('/dashboard/api/categories');
        this.categories = response.data;
      } catch (error) {
        swal.fire("خطأ", "فشل تحميل التصنيفات.", "error");
      }
    },
    showCreateForm() {
      this.showForm = true;
      this.editMode = false;
      this.form.reset();
      this.form.clear();
      this.form.is_active = true;
      this.form.sort_order = 0;
      this.form.parent_id = null;
    },
    showEditForm(cat, index) {
      this.showForm = true;
      this.editMode = true;
      this.editIndex = index;
      this.form.reset();
      this.form.clear();
      this.form.id = cat.id;
      this.form.name = cat.name;
      this.form.description = cat.description;
      this.form.parent_id = cat.parent_id;
      this.form.sort_order = cat.sort_order;
      this.form.is_active = cat.is_active;
    },
    hideForm() {
      this.showForm = false;
      this.editMode = false;
      this.editIndex = null;
      this.form.reset();
      this.form.clear();
    },
    // Create
    async createCategory() {
      await this.form.post('/dashboard/api/category-store')
        .then(response => {
          this.categories.unshift(response.data.data);
          swal.fire("نجح", "تم إنشاء التصنيف!", "success");
          this.hideForm();
        })
        .catch(() => {});
    },
    // Update
    async updateCategory() {
      await this.form.post('/dashboard/api/category-update')
        .then(response => {
          this.categories[this.editIndex] = response.data.data;
          swal.fire("نجح", "تم تحديث التصنيف!", "success");
          this.hideForm();
        })
        .catch(() => {});
    },
    // Delete
    deleteCategory(id, index) {
      swal.fire({
        title: "هل أنت متأكد؟",
        text: "سيتم حذف التصنيف نهائياً.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#aaa",
        cancelButtonText: "إلغاء",
        confirmButtonText: "حذف"
      }).then((result) => {
        if (result.isConfirmed) {
          axios.post('/dashboard/api/category-delete', { id })
            .then(() => {
              this.categories.splice(index, 1);
              swal.fire("تم الحذف!", "تم حذف التصنيف.", "success");
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
    this.fetchCategories();
  }
}
</script>
