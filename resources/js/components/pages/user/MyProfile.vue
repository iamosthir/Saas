<template>
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
          <div class="card shadow-sm">
              <div class="card-header bg-primary text-white">
                  <div class="d-flex justify-content-between align-items-center">
                      <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>الملف الشخصي</h5>
                      <router-link class="btn btn-light btn-sm" :to="{name: 'user.list'}">
                          <i class="fas fa-list me-1"></i>قائمة المستخدمين
                      </router-link>
                  </div>
              </div>
              <div class="card-body">
                  <form @submit.prevent="updateUser">
                      <!-- User Information Section -->
                      <div class="mb-4">
                          <h6 class="text-muted mb-3 pb-2 border-bottom">
                              <i class="fas fa-info-circle me-2"></i>معلومات المستخدم
                          </h6>
                          <div class="row">
                              <div class="col-md-12 mb-3">
                                  <label class="form-label">الاسم الكامل</label>
                                  <input
                                      type="text"
                                      class="form-control"
                                      :class="{'is-invalid' : form.errors.has('name')}"
                                      placeholder="أدخل اسمك الكامل"
                                      v-model="form.name"
                                  />
                                  <HasError :form="form" field="name"/>
                              </div>
                              <div class="col-md-12 mb-3">
                                  <label class="form-label">البريد الإلكتروني</label>
                                  <input
                                      type="email"
                                      class="form-control"
                                      :class="{'is-invalid' : form.errors.has('email')}"
                                      placeholder="example@domain.com"
                                      v-model="form.email"
                                  />
                                  <HasError :form="form" field="email"/>
                              </div>
                          </div>
                      </div>

                      <!-- Password Section -->
                      <div class="mb-4">
                          <h6 class="text-muted mb-3 pb-2 border-bottom">
                              <i class="fas fa-lock me-2"></i>تغيير كلمة المرور
                          </h6>
                          <div class="row">
                              <div class="col-md-12 mb-3">
                                  <label class="form-label">كلمة المرور الجديدة</label>
                                  <input
                                      type="password"
                                      class="form-control"
                                      :class="{'is-invalid' : form.errors.has('password')}"
                                      placeholder="اترك فارغاً إذا لم ترغب بالتغيير"
                                      v-model="form.password"
                                  />
                                  <small class="text-muted">اترك هذا الحقل فارغاً إذا لم ترغب في تغيير كلمة المرور</small>
                                  <HasError :form="form" field="password"/>
                              </div>
                          </div>
                      </div>

                      <!-- Action Buttons -->
                      <div class="d-flex justify-content-end gap-2">
                          <router-link :to="{name: 'user.list'}" class="btn btn-secondary">
                              <i class="fas fa-times me-1"></i>إلغاء
                          </router-link>
                          <Button :form="form" type="submit" class="btn btn-success">
                              <i class="fas fa-save me-1"></i>حفظ التغييرات
                          </Button>
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
                email: "",
                password: "",
                userid: this.$route.params.userid,
            }),
        }
    },
    methods: {
        updateUser() {
            this.form.post("/dashboard/api/update-user").then(resp=>{
                return resp.data;
            }).then(data=>{
                if(data.status == "ok") {
                    swal.fire("نجح", data.msg, "success");
                    // Clear password field after successful update
                    this.form.password = "";
                }
                else {
                    swal.fire("فشلت العملية", data.msg, "error");
                }
            }).catch(err=>{
                console.error(err.response.data);
            })
        },
        async getUserDetails() {
            await axios.post("/dashboard/api/get-my-profile").then(resp=>{
                return resp.data;
            }).then(data=>{
                if(data.status == "ok") {
                    this.form.name = data.user.name;
                    this.form.email = data.user.email;
                    this.form.role = data.user.role;
                    this.form.userid = data.user.id;
                }
                else {
                    this.$router.push({
                        name: 'user.list'
                    });
                }
            }).catch(err=>{
                this.$router.push({
                    name: 'user.list'
                });
                console.error(err.response.data);
            })
        }
    },
    mounted() {
        this.getUserDetails();
    }
}
</script>

<style scoped>
.gap-2 {
    gap: 0.5rem;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
</style>
