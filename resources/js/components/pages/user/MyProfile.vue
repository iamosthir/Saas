<template>
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
          <div class="card">
              <div class="card-header d-flex justify-content-between">
                  <h4>تحديث حسابك شخصي</h4>
                  <router-link class="btn btn-secondary" :to="{name: 'user.list'}">قائمة المستخدمين <i class="fas fa-list"></i> </router-link>
              </div>
              <div class="card-body">
                  <form @submit.prevent="updateUser">
                      <div class="row">
                          <div class="col-md-12 mb-4">
                              <div class="form-outline">
                                  <input type="text" id="formName" class="form-control-lg form-control" :class="{
                                    'is-invalid' : form.errors.has('name'),
                                    'active' : form.name!='',
                                }"
                                  placeholder="User name..." v-model="form.name"/>
                                  <label class="form-label" for="formName">أسم الزبون</label>
                                  <HasError :form="form" field="name"/>
                              </div>
                          </div>
                          <div class="col-md-12 mb-4">
                              <div class="form-outline">
                                  <input type="email" id="formEmail" class="form-control-lg form-control" :class="{
                                    'is-invalid' : form.errors.has('email'),
                                    'active' : form.email!='',
                                    }"
                                  placeholder="User email..." v-model="form.email"/>
                                  <label class="form-label" for="formEmail">بريد إلكتروني</label>
                                  <HasError :form="form" field="email"/>
                              </div>
                          </div>
                          <div class="col-md-12 mb-4">
                              <div class="form-outline">
                                  <input type="text" id="formPasword" class="form-control-lg form-control" :class="{
                                    'is-invalid' : form.errors.has('password'),
                                    'active' : form.password!='',
                                    }"
                                  placeholder="Set password..." v-model="form.password"/>
                                  <label class="form-label" for="formPasword">أسم الزبون</label>
                                  <HasError :form="form" field="password"/>
                              </div>
                          </div>
  
                          <div class="col-md-12 mb-4">
                              <Button :form="form" type="submit" class="btn btn-success">تحديث</Button>
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
                  email: "",
                  password: "",
                  userid: this.$route.params.userid,
              }),
          }
      },
      methods: {
          initMDB() {
              var parent = this.$el;
              var child = parent.querySelectorAll(".form-outline");
              child.forEach(function(el) { new mdb.Input(el); });
          },
          updateUser() {
              this.form.post("/dashboard/api/update-user").then(resp=>{
                  return resp.data;
              }).then(data=>{
                  if(data.status == "ok") {
                      swal.fire("Success",data.msg,"success");
                  }
                  else {
                      swal.fire("Operation failed",data.msg,"error");
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

        this.$nextTick(()=>{
            this.initMDB();
        })
      }
  }
  </script>
  
  <style>
  
  </style>