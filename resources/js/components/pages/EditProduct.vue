<template>
  <div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h6>تعديل المنتج</h6>
          <router-link :to="{name: 'product.list'}" class="btn btn-sm btn-primary">قائمة المنتجات <i class="fas fa-list"></i></router-link>
        </div>
        <div class="card-body">
          <form @submit.prevent="updateProduct">
            <div class="row">
              <div class="col-md-6 mb-4">
                <div class="form-outline">
                  <input type="text" id="formName" class="form-control-lg form-control" :class="{'is-invalid' : form.errors.has('name')}"
                  placeholder="اسم المنتج..." v-model="form.name"/>
                  <label class="form-label" for="formName">اسم المنتج</label>
                  <HasError :form="form" field="name"/>
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <div class="form-outline">
                  <input type="text" id="formName" class="form-control-lg form-control" :class="{'is-invalid' : form.errors.has('model_name')}"
                  placeholder="اسم الموديل..." v-model="form.model_name"/>
                  <label class="form-label" for="formName">اسم الموديل</label>
                  <HasError :form="form" field="model_name"/>
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <label class="form-label" for="customFile">صورة المنتج</label>
                <p class="text-warning" v-if="prImg != null"><strong>{{ prImg }}</strong></p>
                <input type="file" class="form-control" id="customFile" accept="image/*" @change="fileInput"/>
              </div>
            </div>
            <div class="row mt-5">
              <div class="col-md-12 mb-5">
                <h6>تغييرات المنتج</h6>
                <hr>
              </div>
              <div class="col-md-8">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>اسم التغيير</th>
                      <th>السعر</th>
                      <th>المخزون</th>
                      <th>الإجراء</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(variation,j) in variations">
                      <td>{{ variation.var_name }}</td>
                      <td>{{ variation.price }} دينار عراقي</td>
                      <td>{{ variation.quantity }}</td>
                      <td>
                        <button type="button" @click="deleteVariant(variation.id,j)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-md-8">

                <div class="row mb-4" v-for="(variation,i) in form.variant" :key="i">
                  <div class="col-md-4">
                    <div class="form-outline">
                      <input type="text" id="formName" class="form-control-lg form-control" placeholder="اسم التغيير..." v-model="variation.variant_name"/>
                      <label class="form-label" for="formName">اسم التغيير</label>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-outline">
                      <input type="number" id="formName" class="form-control-lg form-control"
                      placeholder="سعر التغيير..." v-model="variation.price"/>
                      <label class="form-label" for="formName">السعر</label>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-outline">
                      <input type="number" id="formName" class="form-control-lg form-control"
                      placeholder="كمية المخزون..." v-model="variation.qnt"/>
                      <label class="form-label" for="formName">كمية المخزون</label>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12 mb-4">
                    <button type="button" @click="addVariant" class="btn btn-sm btn-warning"><i class="fas fa-plus"></i></button>
                    <button type="button" @click="removeVariant" v-if="form.variant.length > 1" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mb-4">
                <Button :form="form" class="btn btn-success">تحديث المنتج</Button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            form: new Form({
                productId: this.$route.params.productId,
                name: "",
                model_name: "",
                image: null,
                variant: [
                    {
                        variant_name: "",
                        price: "",
                        qnt: 1,
                    }
                ],
                variant_data: "",
            }),
            prImg: null,
            variations: [],
        }
    },
    methods: {
        initMDB() {
            var parent = this.$el;
            var child = parent.querySelectorAll(".form-outline");
            child.forEach(function(el) { new mdb.Input(el); });
        },
        addVariant() {
            var _self = this;
            this.form.variant.push(
                {
                    variant_name: "",
                    price: "",
                    qnt: 1
                }
            );
            setTimeout(function(){
                _self.initMDB();
            });
        },
        removeVariant() {
            this.form.variant.pop()
        },
        async updateProduct() {
            this.form.variant_data = JSON.stringify(this.form.variant);
            await this.form.post("/dashboard/api/update-product").then(resp=>{
                return resp.data;
            }).then(data=>{
                if(data.status == "ok") {
                    if(data.new_vars.length > 0)
                    {
                        data.new_vars.forEach((item,i)=>{
                            this.variations.push(item);
                        })
                    }
                    swal.fire("Success",data.msg,"success");
                }
                else {
                    swal.fire("Failed",data.msg,"error");
                }
            }).catch(err=>{
                console.error(err.response.data);
            })
        },
        fileInput(e) {
            let file = e.target.files[0];
            if(file) {
                this.form.image = file;
            }
            else {
                this.form.image = null;
            }
        },
        async getProductDetails() {
            var _self = this;
            await axios.get("/dashboard/api/get-product-details",{
                params: {
                    productId: this.$route.params.productId,
                }
            }).then(resp=>{
                return resp.data;
            }).then(data=>{
                if(data.status == "ok") {
                    this.form.name = data.product.name;
                    this.form.model_name = data.product.model_name;
                    this.prImg = data.product.image;
                    this.variations = data.product.variation;
                    setTimeout(function(){
                        _self.initMDB();
                    })
                }
                else {
                    this.$router.push({
                        name: 'product.list',
                    })
                }
            }).catch(err=>{
                console.error(err.response.data);
                this.$router.push({
                    name: 'product.list',
                })
            })
        },
        async deleteVariant(id,index) {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post("/dashboard/api/delete-variant",{
                        variantId: id,
                    }).then(resp=>{
                        return resp.data;
                    }).then(data=>{
                        if(data.status == "ok") {
                            swal.fire("Deleted",data.msg,"success");
                            this.variations.splice(index,1);
                        }
                    }).catch(err=>{
                        console.error(err.response.data);
                    })
                }
            })
        }
    },
    mounted() {
        this.$nextTick(()=>{
            this.initMDB();
        })
        this.getProductDetails();
    },
}
</script>

<style>

</style>