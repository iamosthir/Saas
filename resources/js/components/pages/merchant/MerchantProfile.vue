<template>
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
          <div class="card">
              <div class="card-header d-flex justify-content-between">
                  <h4>الملف التجاري</h4>
                  <router-link class="btn btn-secondary" :to="{name: 'dashboard'}">الرئيسية <i class="fas fa-home"></i></router-link>
              </div>
              <div class="card-body">
                  <form @submit.prevent="updateMerchant">
                      <div class="row">
                          <!-- Merchant Name -->
                          <div class="col-md-12 mb-4">
                              <div class="form-outline">
                                  <input
                                      type="text"
                                      id="formMerchantName"
                                      class="form-control-lg form-control"
                                      :class="{
                                        'is-invalid' : form.errors.has('name'),
                                        'active' : form.name!='',
                                      }"
                                      placeholder="أسم الشركة..."
                                      v-model="form.name"
                                  />
                                  <label class="form-label" for="formMerchantName">أسم الشركة</label>
                                  <HasError :form="form" field="name"/>
                              </div>
                          </div>

                          <!-- Phone -->
                          <div class="col-md-12 mb-4">
                              <div class="form-outline">
                                  <input
                                      type="text"
                                      id="formPhone"
                                      class="form-control-lg form-control"
                                      :class="{
                                        'is-invalid' : form.errors.has('phone'),
                                        'active' : form.phone!='',
                                      }"
                                      placeholder="رقم الهاتف..."
                                      v-model="form.phone"
                                  />
                                  <label class="form-label" for="formPhone">رقم الهاتف</label>
                                  <HasError :form="form" field="phone"/>
                              </div>
                          </div>

                          <!-- Address -->
                          <div class="col-md-12 mb-4">
                              <div class="form-outline">
                                  <textarea
                                      id="formAddress"
                                      class="form-control"
                                      rows="3"
                                      :class="{
                                        'is-invalid' : form.errors.has('address'),
                                        'active' : form.address!='',
                                      }"
                                      placeholder="العنوان..."
                                      v-model="form.address"
                                  ></textarea>
                                  <label class="form-label" for="formAddress">العنوان</label>
                                  <HasError :form="form" field="address"/>
                              </div>
                          </div>

                          <!-- Current Logo Preview -->
                          <div class="col-md-12 mb-4" v-if="currentLogo">
                              <label class="form-label d-block">الشعار الحالي</label>
                              <div class="position-relative d-inline-block">
                                  <img :src="currentLogo" alt="Logo" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                  <button
                                      type="button"
                                      @click="removeLogo"
                                      class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"
                                      title="حذف الشعار"
                                  >
                                      <i class="fas fa-trash"></i>
                                  </button>
                              </div>
                          </div>

                          <!-- Logo Upload -->
                          <div class="col-md-12 mb-4">
                              <label class="form-label" for="formLogo">
                                  {{ currentLogo ? 'تغيير الشعار' : 'رفع الشعار' }}
                              </label>
                              <input
                                  type="file"
                                  id="formLogo"
                                  class="form-control"
                                  accept="image/*"
                                  @change="handleLogoUpload"
                                  ref="logoInput"
                              />
                              <small class="text-muted d-block mt-1">
                                  الصيغ المقبولة: JPG, PNG, GIF (حد أقصى 2 ميجابايت)
                              </small>

                              <!-- Preview new logo before upload -->
                              <div v-if="logoPreview" class="mt-3">
                                  <label class="form-label d-block">معاينة الشعار الجديد</label>
                                  <img :src="logoPreview" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                              </div>
                          </div>

                          <!-- Submit Button -->
                          <div class="col-md-12 mb-4">
                              <Button :form="form" type="submit" class="btn btn-success btn-lg w-100">
                                  <i class="fas fa-save"></i> تحديث الملف التجاري
                              </Button>
                          </div>

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
                phone: "",
                address: "",
                logo: null,
            }),
            currentLogo: null,
            logoPreview: null,
        }
    },
    mounted() {
        this.getMerchantProfile();
        this.initMDB();
    },
    methods: {
        initMDB() {
            this.$nextTick(() => {
                var parent = this.$el;
                var child = parent.querySelectorAll(".form-outline");
                child.forEach(function(el) {
                    new mdb.Input(el);
                });
            });
        },

        async getMerchantProfile() {
            try {
                const response = await axios.get("/dashboard/api/get-merchant-profile");
                const data = response.data;

                if(data.status == "ok") {
                    this.form.name = data.data.name || "";
                    this.form.phone = data.data.phone || "";
                    this.form.address = data.data.address || "";
                    this.currentLogo = data.data.logo || null;

                    // Re-initialize MDB inputs after data is loaded
                    this.$nextTick(() => {
                        this.initMDB();
                    });
                } else {
                    swal.fire("خطأ", data.msg, "error");
                }
            } catch(err) {
                console.error(err);
                if(err.response && err.response.status === 403) {
                    swal.fire("غير مصرح", "ليس لديك صلاحية للوصول إلى هذه الصفحة", "error");
                    this.$router.push({name: 'dashboard'});
                } else {
                    swal.fire("خطأ", "حدث خطأ أثناء تحميل البيانات", "error");
                }
            }
        },

        handleLogoUpload(event) {
            const file = event.target.files[0];
            if(file) {
                // Validate file size (2MB max)
                if(file.size > 2048 * 1024) {
                    swal.fire("خطأ", "حجم الملف يجب أن لا يتجاوز 2 ميجابايت", "error");
                    this.$refs.logoInput.value = "";
                    return;
                }

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if(!allowedTypes.includes(file.type)) {
                    swal.fire("خطأ", "نوع الملف غير مقبول. يرجى اختيار صورة (JPG, PNG, GIF)", "error");
                    this.$refs.logoInput.value = "";
                    return;
                }

                this.form.logo = file;

                // Create preview
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.logoPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        async updateMerchant() {
            try {
                // Create FormData for file upload
                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('phone', this.form.phone || '');
                formData.append('address', this.form.address || '');

                if(this.form.logo) {
                    formData.append('logo', this.form.logo);
                }

                const response = await axios.post("/dashboard/api/update-merchant-profile", formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                const data = response.data;

                if(data.status == "ok") {
                    swal.fire("نجح", data.msg, "success");

                    // Update current logo and clear preview
                    if(data.data.logo) {
                        this.currentLogo = data.data.logo;
                    }
                    this.logoPreview = null;
                    this.form.logo = null;

                    // Clear file input
                    if(this.$refs.logoInput) {
                        this.$refs.logoInput.value = "";
                    }

                    // Reload page to update logo in header
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    swal.fire("فشلت العملية", data.msg, "error");
                }
            } catch(err) {
                console.error(err);
                if(err.response && err.response.status === 403) {
                    swal.fire("غير مصرح", "ليس لديك صلاحية لتحديث هذه البيانات", "error");
                } else if(err.response && err.response.data && err.response.data.errors) {
                    // Handle validation errors
                    this.form.errors.set(err.response.data.errors);
                } else {
                    swal.fire("خطأ", "حدث خطأ أثناء التحديث", "error");
                }
            }
        },

        async removeLogo() {
            const result = await swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف الشعار نهائياً",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذف',
                cancelButtonText: 'إلغاء'
            });

            if (result.isConfirmed) {
                try {
                    const response = await axios.post("/dashboard/api/remove-merchant-logo");
                    const data = response.data;

                    if(data.status == "ok") {
                        swal.fire("تم الحذف", data.msg, "success");
                        this.currentLogo = null;

                        // Reload page to update logo in header
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        swal.fire("فشلت العملية", data.msg, "error");
                    }
                } catch(err) {
                    console.error(err);
                    swal.fire("خطأ", "حدث خطأ أثناء حذف الشعار", "error");
                }
            }
        }
    }
}
</script>

<style scoped>
.card {
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px 10px 0 0 !important;
    padding: 1.5rem;
}

.card-header h4 {
    margin: 0;
    color: white;
}

.img-thumbnail {
    border-radius: 8px;
}
</style>
