<template>
    <div class="row justify-content-center">
      <div class="col-md-9 col-lg-7">
          <div class="card">
              <div class="card-body">
                  <h5 class="card-title text-center"><strong>تحديث الطلب <i class="fas fa-file-invoice"></i></strong></h5>
                  <form class="mt-5" method="POST" @submit.prevent="updateInvoice">
                    <div class="row">
                          <div class="col-md-5 mb-4">
                              <div class="form-outline">
                                  <multiselect v-model="selectedProduct" 
                                  :options="products" 
                                  placeholder="أختيار المنتج.." 
                                  label="name" 
                                  track-by="id"
                                  select-label=""
                                  ></multiselect>
                              </div>
                              <HasError :form="productForm" field="product_id"/>
                          </div>
  
                          <div class="col-md-5 mb-4">
                              <select class="form-select" v-model="productForm.variant_id">
                                  <option value="" hidden selected>أختيار المتغير</option>
                                  <option value="" v-for="(vars,i) in productVars" :key="i" :value="vars.id">{{ vars.var_name }} - {{ vars.price }} IQD ({{ vars.quantity }} in Stock)</option>
                              </select>
                              <HasError :form="productForm" field="variant_id"/>
                          </div>
  
                          <div class="col-md-2 mb-4">
                              <div class="form-outline input-group input-group-lg">
                                  <button @click="productForm.qnt++" type="button" class="btn btn-success border-red-0">+</button>
                                  <input type="number" class="form-control form-control-lg" value="1" style="text-align:center;" v-model="productForm.qnt">
                                  <button @click="productForm.qnt--" type="button" class="btn btn-primary border-red-0">-</button>
                              </div>
                              <HasError :form="productForm" field="qnt"/>
                          </div>
  
                          <div class="col-md-12 mb-4">
                              <button @click="addProductList" type="button" class="btn btn-sm btn-warning">Add</button>
                          </div>
  
                          <div class="col-md-12 mb-4">
                              <table class="table table-bordered">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>أسم المنتج</th>
                                          <th>المتغير</th>
                                          <th>العدد</th>
                                          <th>السعر</th>
                                          <th>السعر الكلي</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <template v-if="addedProductList.length > 0 || newAddedProductList.length > 0">
                                          <tr v-for="(pr,i) in addedProductList">
                                              <td>{{ i+1 }}</td>
                                              <td>{{ pr.product_name }}</td>
                                              <td>{{ pr.variant }}</td>
                                              <td>{{ pr.qnt }}</td>
                                              <td>{{ pr.net_price }}IQD</td>
                                              <td>{{ pr.total_price }}IQD</td>
                                              <td>
                                                  <button type="button" @click="removeProduct(i,pr.id)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                              </td>
                                          </tr>

                                          <tr v-for="(newPr,i) in newAddedProductList">
                                              <td>{{ i+1 }}</td>
                                              <td>{{ newPr.product_name }}</td>
                                              <td>{{ newPr.variant }}</td>
                                              <td>{{ newPr.qnt }}</td>
                                              <td>{{ newPr.net_price }}IQD</td>
                                              <td>{{ newPr.total_price }}IQD</td>
                                              <td>
                                                  <button type="button" @click="removeNewProduct(i)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                              </td>
                                          </tr>
                                      </template>
  
                                      <template v-else>
                                          <tr>
                                              <td class="text-center text-muted" colspan="7">لم يتم اضافة منتجات</td>
                                          </tr>
                                      </template>
  
                                      <tr v-if="addedProductList.length > 0 || newAddedProductList.length > 0">
                                          <td colspan="5"><strong>Sub total : </strong></td>
                                          <td colspan="1"><strong id="editPriceCell" class="edit-price" contenteditable="true" 
                                            @focusout="editPriceCell">{{ getSubTotal }}</strong><span>IQD</span></td>
                                      </tr>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <hr>
                      <div class="row">
  
                          <div class="col-md-12 mb-4">
                              <div class="form-outline">
                                  <input type="text" id="formName" class="form-control-lg form-control active" :class="{'is-invalid' : form.errors.has('name')}"
                                  placeholder="Customer name..." v-model="form.name"/>
                                  <label class="form-label" for="formName">أسم الزبون</label>
                                  <HasError :form="form" field="name"/>
                              </div>
                          </div>
  
                          <div class="col-md-12 mb-4">
                              <div class="form-outline">
                                  <input type="url" id="formLink" class="form-control-lg form-control active" :class="{'is-invalid' : form.errors.has('customer_link')}"
                                  placeholder="Customer profile link..." v-model="form.customer_link"/>
                                  <label class="form-label" for="formLink">رابط صفحة الزبون <small>(فيس بوك/انستا)</small></label>
                                  <HasError :form="form" field="customer_link"/>
                              </div>
                          </div>
  
                          <div class="col-md-6 mb-4">
                              <div class="form-outline">
                                  <input type="text" id="formPhone1" class="form-control-lg form-control active" :class="{'is-invalid' : form.errors.has('phone1')}"
                                  placeholder="Primary phone number..." v-model="form.phone1"/>
                                  <label class="form-label" for="formPhone1">رقم الهاتف الرئيسي</label>
                                  <HasError :form="form" field="phone1"/>
                              </div>
                          </div>
  
                          <div class="col-md-6 mb-4">
                              <div class="form-outline">
                                  <input type="text" id="formPhone2" class="form-control-lg form-control active" :class="{'is-invalid' : form.errors.has('phone2')}"
                                  placeholder="Secondary phone number..." v-model="form.phone2"/>
                                  <label class="form-label" for="formPhone2">رقم الثاني</label>
                                  <HasError :form="form" field="phone2"/>
                              </div>
                          </div>
  
                                          
                          <div class="col-md-6 mb-4">
                            <select class="form-select" v-model="form.state">
                                <option value="" hidden selected>أختيار المحافظة</option>
                                <option value="بغداد">بغداد</option>
                                <option value="البصرة">بصرة</option>
                                <option value="بابل">بابل</option>
                                <option value="النجف">النجف</option>
                                <option value="المثنى">سماوة</option>
                                <option value="ميسان">عمارة</option>
                                <option value="كركوك">كركوك</option>
                                <option value="كربلاء">كربلاء</option>
                                <option value="ديالى">ديالى</option>
                                <option value="الانبار">انبار</option>
                                <option value="دهوك">دهوك</option>
                                <option value="اربيل">اربيل</option>
                                <option value="نينوى">الموصل</option>
                                <option value="القادسية">ديوانية</option>
                                <option value="صلاح الدين">صلاح الدين</option>
                                <option value="السليمانية">السليمانية</option>
                                <option value="ذي قار">ناصرية</option>
                                <option value="واسط">واسط</option>
                            </select>
                        </div>
  
                        <div class="col-md-6 mb-4">
                              <div class="form-outline">
                                  <multiselect v-model="selectedCity" 
                                  :options="cities" 
                                  placeholder="Select city" 
                                  label="name" 
                                  track-by="id"
                                  select-label=""
                                  ></multiselect>
                              </div>
                              <HasError :form="form" field="city"/>
                        </div>
  
                        <div class="col-md-12 mb-4">
                              <div class="form-outline">
                                  <textarea class="form-control" id="textAreaExample" rows="4" v-model="form.address"></textarea>
                                  <label class="form-label" for="textAreaExample">العنوان</label>
                                  <HasError :form="form" field="address"/>
                              </div>
                        </div>

  
                          <div class="col-md-12 mb-4">
                              <div class="form-outline">
                                  <textarea class="form-control" id="textAreaExample" rows="4" v-model="form.note"></textarea>
                                  <label class="form-label" for="textAreaExample">ملاحظة</label>
                                  <HasError :form="form" field="note"/>
                              </div>
                          </div>
  
                                     
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <multiselect v-model="selectedPage" 
                                    :options="pages" 
                                    placeholder="Select page name" 
                                    label="name" 
                                    track-by="id"
                                    select-label=""
                                    ></multiselect>
                                </div>
                                <HasError :form="form" field="page_name"/>
                            </div>

                            <div class="col-md-6 mb-4">
                              
  
                              <div class="form-outline">
                                  <multiselect v-model="selectedShipping" 
                                  :options="shippings" 
                                  placeholder="Select shiping" 
                                  label="name" 
                                  track-by="id"
                                  select-label=""
                                  ></multiselect>
                              </div>
                              <HasError :form="form" field="shiping"/>
  
                          </div>


                          <div class="col-md-6 mb-4">
                              <select class="form-select form-control-lg" v-model="form.status" :class="{'is-invalid' : form.errors.has('status')}">
                                  <option value="pending">جاري الشحن</option>
                                  <option value="delayed">مؤجل</option>
                                  <option value="completed">واصل تم</option>
                                  <option value="canceled">راجع</option>
                              </select>
                          </div>
  
                          <div class="col-md-12 mb-4 text-center">
                              <Button :form="form" class="btn btn-success">تحديث الطلب <i class="fas fa-check-circle"></i></Button>
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
                  invoiceId: "",
                  name: "",
                  customer_link: "",
                  phone1: "",
                  phone2: "",
                  state: "",
                  city:"",
                  city_id: '',
                  product_type: "",
                  qnt: 1,
                  price: 0,
                  shiping: "",
                  shipping_id: "",
                  note: "",
                  page_name: "",
                  page_id: "",
                  products: [],
                  address: "",
                  order_price: "",
              }),
              products: [],
              productForm: new Form({
                  product_id: "",
                  variant_id: "",
                  qnt: 1,
              }),
              selectedProduct: "",
              selectedCity: "",
              selectedPage: "",
              selectedShipping: "",
              productVars: [],
              addedProductList: [],
              newAddedProductList: [],
              cities: [],
              pages: [],
              shippings: [],
          }
      },
      methods: {
        async getInvoiceData() {
            await axios.get("/dashboard/api/get-invoice-data",{
                params: {
                    invoiceNumber: this.$route.params.id
                }
            }).then(resp=>{
                return resp.data;
            }).then(data=>{
                if(data.status == "ok") {
                    this.form.invoiceId = data.data.id;
                    this.form.name = data.data.customer_name;
                    this.form.customer_link = data.data.customer_link;
                    this.form.phone1 = data.data.phone1;
                    this.form.phone2 = data.data.phone2;
                    this.form.state = data.data.state;
                    this.form.city = data.data.city;
                    this.form.city_id = data.data.city_id;
                    this.form.order_price = data.data.price;
                    this.form.note = data.data.note;
                    this.form.page_name = data.data.page_name;
                    this.form.page_id = data.data.page_id;
                    this.form.status = data.data.status;
                    this.form.shiping = data.data.shiping;
                    this.form.shipping_id = data.data.shipping_id;
                    this.form.address = data.data.address;
                    this.addedProductList = data.product_data;
                    this.selectedCity = data.data.city;
                    this.selectedPage = data.data.page;
                    this.selectedShipping = data.data.shipping;
                }
                else {
                    this.$router.push({
                        name: 'invoice-list'
                    })
                }
            }).catch(err=>{
                this.$router.push({
                    name: 'invoice-list'
                })
                console.error(err.response.data);
            })
        },
          updateInvoice() {

            if(this.addedProductList.length < 1) {
                if(this.newAddedProductList < 1) {
                    swal.fire("Warning","Please add product first","warning");
                    return;
                }
            }
            this.form.products = this.newAddedProductList;

            this.form.post("/dashboard/api/update-invoice").then(resp=>{
                return resp.data;
            }).then(data=>{
                console.log(data);
                if(data.status == "ok") {
                    swal.fire("Success",data.msg,"success");
                    this.$root.settingData.product_stock = data.stock;
                }
                else {
                    swal.fire("Failed","Failed to update this order. You may not have proper permission","error");
                }
            }).catch(err=>{
                console.error(err.response.data);
            })
          },
          initMDB() {
              var parent = this.$el;
              var child = parent.querySelectorAll(".form-outline");
              child.forEach(function(el) { new mdb.Input(el); });
          },
          async getProductList() {
              await axios.get("/dashboard/api/product-list").then(resp=>{
                  return resp.data;
              }).then(data=>{
                  this.products = data;
              }).catch(err=>{
                  console.error(err.response.data);
              })
          },
          async addProductList() {
              await this.productForm.post("/dashboard/api/product-data-process").then(resp=>{
                  return resp.data;
              }).then(data=>{
                  if(data.status == "ok"){
                      this.newAddedProductList.push(data.result);
                      this.form.order_price += data.result.total_price;
                      document.getElementById("editPriceCell").innerText = this.form.order_price;
                  }
                  else {
                      swal.fire("Failed",data.msg,"error");
                  }
                  
              }).catch(err=>{
                  console.error(err.response.data);
              })
          },
          async getCityList() {
              await axios.get("/dashboard/api/get-city-list").then(resp=>{
                  return resp.data;
              }).then(data=>{
                  this.cities = data;
              }).catch(err=>{
                  console.error(err.response.data);
              })
          },
          async getPageList() {
              await axios.get("/dashboard/api/get-page-list").then(resp=>{
                  return resp.data;
              }).then(data=>{
                  this.pages = data;
              }).catch(err=>{
                  console.error(err.response.data);
              })
          },
          async getShippingList() {
              await axios.get("/dashboard/api/get-shipping-list").then(resp=>{
                  return resp.data;
              }).then(data=>{
                  this.shippings = data;
              }).catch(err=>{
                  console.error(err.response.data);
              })
          },
          removeProduct(index,id) {
            axios.post("/dashboard/api/remove-order-product",{
                id: id,
            }).then(resp=>{
                return resp.data;
            }).then(data=>{
                if(data.status == "ok") {
                    var product = this.addedProductList[index];
                    this.addedProductList.splice(index,1);
                    this.form.order_price -= product.total_price;
                    document.getElementById("editPriceCell").innerText = this.form.order_price;
                }
            }).catch(err=>{
                console.error(err.response.data);
            });
          },
          removeNewProduct(index) {
            var pr = this.newAddedProductList[index];
            this.newAddedProductList.splice(index,1);
            this.form.order_price -= pr.total_price;
            document.getElementById("editPriceCell").innerText = this.form.order_price;
          },
          editPriceCell(e) {
            e.target.innerText = e.target.innerText.replace(/[^0-9]/g, '');
            if(e.target.innerText != "") {
                this.form.order_price = parseInt(e.target.innerText);
            }
            else {
                this.form.order_price = this.getSubTotal;
                e.target.innerText = this.getSubTotal;
            }
          }
      },
      computed: {
        getSubTotal() {
            let price = 0;
            this.addedProductList.forEach((item,i)=>{
                price += item.total_price;
            })
            this.newAddedProductList.forEach((item,i)=>{
                price += item.total_price;
            })
            return price;
        },
      },
      watch: {
          'form.qnt' : function(val) {
              if(val < 1)
              {
                  this.form.qnt = 1;
              }
          },
          'selectedProduct' : async function(newVal) {
              this.productForm.product_id = newVal.id;
              this.productVars = [];
              this.productForm.variant_id = "";
              axios.get("/dashboard/api/get-product-variations",{
                  params: {
                      productId: newVal.id,
                  }
              }).then(resp=>{
                  return resp.data;
              }).then(data=>{
                  this.productVars = data;
              }).catch(err=>{
                  console.error(err.response.data);
              })
          },
          'selectedCity' : function(newCity) {
              this.form.city = newCity.name;
              this.form.city_id = newCity.id;
          },
          'selectedPage' : function(newPage) {
              this.form.page_name = newPage.name;
              this.form.page_id = newPage.id;
          },
          'selectedShipping' : function(newShip) {
              this.form.shiping = newShip.name;
              this.form.shipping_id = newShip.id;
          }
      },
      mounted() {
          this.$nextTick(function () {
              this.initMDB();
          })
          this.getInvoiceData();
          this.getProductList();
          this.getCityList();
          this.getPageList();
          this.getShippingList();
      }
  }
  </script>
  <style src="vue-multiselect/dist/vue-multiselect.min.css"></style>