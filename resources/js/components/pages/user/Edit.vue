<template>
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
          <div class="card">
              <div class="card-header d-flex justify-content-between">
                  <h4>تحديث المستخدم</h4>
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
                                  <input type="phone" id="formphone" class="form-control-lg form-control" :class="{
                                    'is-invalid' : form.errors.has('phone'),
                                    'active' : form.phone!='',
                                    }"
                                  placeholder="User phone..." v-model="form.phone"/>
                                  <label class="form-label" for="formphone">رقم الهاتف</label>
                                  <HasError :form="form" field="phone"/>
                              </div>
                          </div>
                          <div class="col-md-12 mb-4">
                              <div class="form-outline">
                                  <input type="text" id="formPasword" class="form-control-lg form-control" :class="{
                                    'is-invalid' : form.errors.has('password'),
                                    'active' : form.password!='',
                                    }"
                                  placeholder="Set password..." v-model="form.password"/>
                                  <label class="form-label" for="formPasword">كلمة السر</label>
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
import { error } from 'jquery';
  export default {
      data() {
          return {
              form: new Form({
                  name: "",
                  phone: "",
                  password: "",
                  role: "staff",
                  userid: this.$route.params.userid,
              })
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
            await axios.get("/dashboard/api/get-user-details",{
                params : {
                    userId: this.$route.params.userid
                }
            }).then(resp=>{
                return resp.data;
            }).then(data=>{
                if(data.status == "ok") {
                    this.form.name = data.user.name;
                    this.form.phone = data.user.phone;
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