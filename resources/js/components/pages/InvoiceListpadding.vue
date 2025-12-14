<template>
  <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4> قائمة الطلبات</h4>
                <div>
                    <p>مجموع الطلبات: <strong>{{ paginateData.total }}</strong>
                         &nbsp;|&nbsp; عدد المنتجات :  <strong>{{ totalQuantity }}</strong>
                         &nbsp;|&nbsp; السعر الكلي: <strong>IQD {{ totalPrice }}</strong></p>
                </div>
            </div>
            <div class="card-body">
                <form class="row mb-4" @submit.prevent="getOrderList">
                    <div class="col-md-3 mt-2">
                        <div class="form-outline">
                            <input type="search" class="form-control" placeholder="Invoice ID" id="invId" v-model="form.invoiceId">
                            <label class="form-label" for="invId">معرف الوصل او رقم الوصل</label>
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <multiselect v-model="selectedProduct"
                        :options="products"
                        placeholder="أختيار المنتج.."
                        label="name"
                        track-by="id"
                        select-label=""
                        ></multiselect>
                    </div>

                    <div class="col-md-3 mt-2">
                        <multiselect v-model="selectedPage"
                        :options="pages"
                        placeholder="أختيار البيج"
                        label="name"
                        track-by="id"
                        select-label=""></multiselect>
                    </div>

                    <div class="col-md-3 mt-2">
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

                    <div class="col-md-2 mt-2">
                        <date-picker placeholder="من تاريخ" class="w-100" type="date" valueType="format" v-model="form.from_date"></date-picker>
                    </div>
                    <div class="col-md-2 mt-2">
                        <date-picker placeholder="الى تاريخ" class="w-100" type="date" valueType="format" v-model="form.to_date"></date-picker>
                    </div>

                    <div class="col-md-2 mt-2">
                        <input class="form-control" placeholder="رقم الهاتف" type="number" v-model="form.phone">
                    </div>

                    <div class="col-12 mt-2">
                        <button type="submit" class="btn btn-success">بحث <i class="fas fa-search"></i></button>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="listTable">
                        <thead class="bg-info text-white">
                            <tr class="text-center">
                                <th>
                                    <div class="form-check">
                                        <input @change="toggleCheckBox" v-model="mainCheck" class="form-check-input" type="checkbox" value="" id="selectAll" name="remember"/>
                                        <label class="form-check-label" for="selectAll">#</label>
                                    </div>
                                </th>
                                <!-- <th> معرف الوصل</th> -->
                                <th> رقم الوصل</th>
                                <th>تاريخ</th>
                                <th>اسم زبون</th>
                                <th>العنوان</th>
                                <th>نشأ بواسطة</th>
                                <th>العدد</th>
                                <th>السعر الكلي</th>
                                <th>الحالة</th>
                                <th>الواتس اب</th>
                                 <th>الأجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="isLoading">
                                <tr v-for="n in 10" :key="n">
                                     <td colspan="9"><skeleton width="100%" height="30px" /></td>
                                </tr>
                            </template>
                            <template v-else>

                                <template v-if="orders.length > 0">

                                    <tr v-for="(order,i) in orders" :key="i" class="text-center">
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" :disabled="order.is_printed=='yes'?true:false"
                                                 :value="order.id" name="print-order" v-model="orderSelect"/>
                                            </div>
                                            <div class="form-check">
                                                <input style="background-color: rgb(0 0 0);" class="form-check-input" type="checkbox"
                                                 :value="order.id" name="x-order" v-model="orderSelect2"/>
                                            </div>

                                        </td>
                                        <td>
                                            <span class="badge badge-pill badge-primary">{{ order.id }}</span>
                                        </td>
                                        <!-- <td>
                                            <span class="badge badge-pill badge-primary">{{ order.order_number }}</span>
                                        </td> -->
                                        <td><span dir="ltr" class="text-left"><strong>{{ moment(order.created_at).format("DD MMM YYYY, h:m a") }}</strong></span></td>
                                        <td><strong class="text-muted"><a target="_blank" :href="order.customer_link">{{ order.customer_name }}</a></strong></td>
                                        <td>{{ order.address }}<br>{{ order.state }}, {{ order.city }}</td>
                                        <td><strong class="text-muted">{{ order.admin_name }}</strong></td>
                                        <td><strong class="text-muted">{{ order.qnt }}</strong></td>
                                        <td><strong class="text-success">{{ order.price }} IQD</strong></td>
                                        <td>
                                            <span v-if="order.status=='pending'" class="badge badge-warning">Pending <i class="fas fa-history"></i></span>
                                            <span v-else-if="order.status=='canceled'" class="badge badge-danger">Canceled <i class="fas fa-times-circle"></i></span>
                                            <span v-else-if="order.status=='completed'" class="badge badge-success">Completed <i class="fas fa-check-circle"></i></span>
                                            <span v-else-if="order.status=='delayed'" class="badge badge-secondary">Delayed <i class="fas fa-clock"></i></span>
                                        </td>
                                        <td>
                                            <a  :href="'https://api.whatsapp.com/send/?phone=+964'+order.phone1+'&text=مرحبا&type=phone_number&app_absent=0'" class="btn btn-sm btn-link"><i class="fas fa-phone"></i></a>
                                        <!-- <a class="text-success" :href="'https://api.whatsapp.com/send/?phone=+964'+order.phone1+'&text=مرحبا&type=phone_number&app_absent=0'">  واتس اب</a> -->

                                        </td>

                                        <td>
                                            <button title="PRINT" @click="printSingle(order.id)" class="btn btn-sm btn-link"><i class="fas fa-print"></i></button>
                                            <router-link title="Edit" :to="{name: 'invoice.edit', params: {id: order.id}}"
                                            class="btn btn-sm btn-link text-warning"><i class="fas fa-edit"></i></router-link>


                                            <div style="    width: 306px;">

                                            <label for="checkbox"><input :name="'radio'+order.id" :checked="order.status=='pending'?true:false"
                                            type="radio" id="checkbox" @change="updateOrderStatus(order.id,i,'pending')"> جاري شحن</label>
                                            <label for="checkbox2"><input :name="'radio'+order.id" :checked="order.status=='completed'?true:false"
                                            type="radio" id="checkbox2" @change="updateOrderStatus(order.id,i,'completed')"> واصل تم</label>
                                            <label for="checkbox3"><input :name="'radio'+order.id" :checked="order.status=='canceled'?true:false"
                                            type="radio" id="checkbox3" @change="updateOrderStatus(order.id,i,'canceled')"> راجع</label>
                                            <label for="checkbox4"><input :name="'radio'+order.id" :checked="order.status=='delayed'?true:false"
                                            type="radio" id="checkbox4" @change="updateOrderStatus(order.id,i,'delayed')"> استبدال</label>

                                        </div>

                                        </td>
                                    </tr>

                                </template>

                                <template v-else>
                                    <tr>
                                        <td colspan="9" class="text-danger text-center">لا توجد طلبات</td>
                                    </tr>
                                </template>
                            </template>
                        </tbody>
                    </table>

                </div>

                <div class="d-flex justify-content-center">
                    <pagination :limit="8" :data="paginateData" @pagination-change-page="getOrderList"></pagination>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
    components: {
        DatePicker,
    },
    data() {
        return {
            orders: [],
            isLoading: true,
            form: {
                invoiceId: "",
                from_date: "",
                to_date: "",
                page: 1,
                status: "",
                phone: "",
                page_name: "",
                state: "",
                productId: "",
            },
            moment: moment,
            orderSelect: [],
            orderSelect2: [],
            orderSelectdel: [],
            paginateData: {},
            mainCheck: false,
            role: role,
            totalQuantity: 0,
            totalPrice: 0,

            pages: [],
            selectedPage: "",

            products: [],
            selectedProduct: "",
        }
    },
    methods: {
        async getOrderList(page = 1) {
            this.form.page = page;
            this.isLoading = true;
            this.mainCheck = false;
            await axios.get("/dashboard/api/get-invoice-list-padding", {
                params: this.form
            }).then(resp=>{
                return resp.data;
            }).then(data=>{
                this.isLoading = false;
                this.orders = data.orders.data;
                this.paginateData = data.orders;
                this.totalQuantity = data.total_qnt;
                this.totalPrice = data.total_price;
            }).catch(err=>{
                this.isLoading = false;
                console.error(err.response.data);
            })
        },
        initMDB() {
            var parent = this.$el;
            var child = parent.querySelectorAll(".form-outline");
            child.forEach(function(el) { new mdb.Input(el); });
        },
        toggleCheckBox() {
            var _self = this;

            $("input[name='print-order']").each(function(){
                if(_self.mainCheck == true) {
                    if(!$(this).is(":checked")){
                        $(this).trigger("click");
                    }
                }
                else {
                    $(this).trigger("click");
                }
            })
        },
        printSingle(id) {
            let url = `/dashboard/print-invoice/["${id}"]/copy/1`;
            window.open(url,"_blank");
        },
        updateOrderStatus(orderId,index,status) {
            axios.post("/dashboard/api/update-order-status",{
                orderId: orderId,
                status: status,
            }).then(resp=>{
                return resp.data;
            }).then(data=>{
                if(data.status == "ok") {
                    swal.fire("Success",data.msg,"success");
                    this.orders[index].status = data.update;
                }
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
        async getProductList() {
            await axios.get("/dashboard/api/product-list").then(resp=>{
                return resp.data;
            }).then(data=>{
                this.products = data;
            }).catch(err=>{
                console.error(err.response.data);
            })
        },
    },
    mounted() {

        this.getOrderList();
        this.getPageList();
        this.getProductList();
    },
    watch: {
        'orderSelect' : function(newVal) {
            var rootData = this.$root._data;
            rootData.printQuee = newVal;
        },
        'orderSelect2' : function(newVal) {
            var rootData = this.$root._data;
            rootData.editinvoiceQuee = newVal;
           // console.log(newVal);
        },
        'selectedPage' : function(newPage) {
            this.form.page_name = newPage.name;
        },
        'selectedProduct' : async function(newVal) {
            this.form.productId = newVal.id;
        },
    },
    computed: {
        // totalQuantity() {
        //     let qnt = 0;
        //     this.orders.forEach((item)=>{
        //         qnt += item.qnt;
        //     });
        //     return qnt;
        // },
        // totalPrice() {
        //     let price = 0;
        //     this.orders.forEach((item)=>{
        //         price += item.price;
        //     })
        //     return price;
        // }
    }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
