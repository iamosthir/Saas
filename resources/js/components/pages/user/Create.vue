<template>
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4>أنشاء مستخدم جديد</h4>
                <router-link class="btn btn-secondary" :to="{name: 'user.list'}">قائمة المستخدمين <i class="fas fa-list"></i> </router-link>
            </div>
            <div class="card-body">
                <form @submit.prevent="addUser">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="form-outline">
                                <input type="text" id="formName" class="form-control-lg form-control" :class="{'is-invalid' : form.errors.has('name')}"
                                placeholder="User name..." v-model="form.name"/>
                                <label class="form-label" for="formName">أسم الموضف</label>
                                <HasError :form="form" field="name"/>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="form-outline">
                                <input type="phone" id="formphone" class="form-control-lg form-control" :class="{'is-invalid' : form.errors.has('phone')}"
                                placeholder="User phone..." v-model="form.phone"/>
                                <label class="form-label" for="formphone">رقم الهاتف</label>
                                <HasError :form="form" field="phone"/>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="form-outline">
                                <input type="text" id="formPasword" class="form-control-lg form-control" :class="{'is-invalid' : form.errors.has('password')}"
                                placeholder="Set password..." v-model="form.password"/>
                                <label class="form-label" for="formPasword">كلمة المرور</label>
                                <HasError :form="form" field="password"/>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="">دور المستخدم</label>
                            <select class="form-select" v-model="form.role" :class="{'is-invalid' : form.errors.has('role')}">
                                <option value="" hidden selected></option>
                                <option value="staff">موضف</option>
                                <option value="super">مدير</option>
                            </select>
                            <HasError :form="form" field="page_name"/>
                        </div>

                        <div class="col-md-12 mb-4">
                            <Button :form="form" type="submit" class="btn btn-success">أنشاء</Button>
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
                password: "",
                role: "staff"
            })
        }
    },
    methods: {
        initMDB() {
            var parent = this.$el;
            var child = parent.querySelectorAll(".form-outline");
            child.forEach(function(el) { new mdb.Input(el); });
        },
        addUser() {
            this.form.post("/dashboard/api/add-user").then(resp=>{
                return resp.data;
            }).then(data=>{
                if(data.status == "ok") {
                    swal.fire("Success",data.msg,"success");
                    this.form.reset();
                }
                else {
                    swal.fire("Operation failed",data.msg,"error");
                }
            }).catch(err=>{
                console.error(err.response.data);
            })
        }
    },
    mounted() {
        this.$nextTick(()=>{
            this.initMDB();
        })
    }
}
</script>

<style>

</style>