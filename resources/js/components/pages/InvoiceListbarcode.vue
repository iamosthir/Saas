<template>
  <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4> قائمة الطلبات</h4>
                <div>
                    <p>مجموع الطلبات: <strong>{{ orders.length }}</strong>
                         &nbsp;|&nbsp; عدد المنتجات :  <strong>{{ totalQuantity }}</strong>
                         &nbsp;|&nbsp; السعر الكلي: <strong>{{ formatAmount(totalPrice) }} IQD</strong></p>
                </div>
            </div>
            <div class="card-body">
                <form class="row mb-4" @submit.prevent="getOrderById">
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="invId">بحث عن طريق الباركود</label>
                        <input
                            type="search"
                            class="form-control"
                            placeholder="أدخل رقم الفاتورة"
                            id="invId"
                            v-model="searchId"
                            ref="barcodeInput"
                        >
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label d-block">&nbsp;</label>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus me-1"></i>إضافة
                        </button>
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
                                <th>   العنوان</th>
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
                                            <!-- <div class="form-check">
                                                <input class="form-check-input" type="checkbox" :disabled="order.is_printed=='yes'?true:false"
                                                 :value="order.id" name="print-order" v-model="orderSelect"/>
                                            </div> -->
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
                                        <td><strong class="text-success">{{ formatAmount(order.price) }} IQD</strong></td>
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

                <!-- <div class="d-flex justify-content-center">
                    <pagination :data="paginateData" @pagination-change-page="getOrderList"></pagination>
                </div> -->
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
            isLoading: false,
            form: {
                invoiceId: "",
                from_date: "",
                to_date: "",
                page: 1,
                status: "",
                phone: "",
            },
            moment: moment,
            orderSelect: [],
            orderSelect2: [],
            orderSelectdel: [],
            paginateData: {},
            mainCheck: false,
            role: role,
            searchId: "",
        }
    },
    methods: {
        formatAmount(amount) {
            const num = parseFloat(amount);
            if (isNaN(num)) return '0';
            const hasDecimals = num % 1 !== 0;
            if (hasDecimals) {
                return num.toLocaleString('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 2
                });
            } else {
                return num.toLocaleString('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            }
        },
        async getOrderById() {
            if (!this.searchId || this.searchId.trim() === '') {
                swal.fire("خطأ", "الرجاء إدخال رقم الفاتورة", "warning");
                return;
            }

            axios.get('/dashboard/api/search-order-by-id',{
                params: {
                    orderId: this.searchId
                }
            }).then(resp=>{
                return resp.data;
            }).then(data=>{
                if(data.status == "ok") {
                    let canPush = true;

                    this.orders.forEach((item,i)=>{
                        if(item.id == data.data.id)
                        {
                            canPush = false;
                        }
                    });

                    if(canPush) {
                        this.orders.push(data.data);
                        swal.fire("تم", "تم إضافة الفاتورة بنجاح", "success");
                    } else {
                        swal.fire("تنبيه", "هذه الفاتورة موجودة بالفعل في القائمة", "info");
                    }

                    this.searchId = "";
                    // Refocus on input for next scan
                    this.$nextTick(() => {
                        if (this.$refs.barcodeInput) {
                            this.$refs.barcodeInput.focus();
                        }
                    });
                }
                else {
                    swal.fire("غير موجود", data.msg || "لم يتم العثور على الفاتورة", "error");
                    // Keep focus on input for retry
                    this.$nextTick(() => {
                        if (this.$refs.barcodeInput) {
                            this.$refs.barcodeInput.select();
                        }
                    });
                }
            }).catch(err=>{
                console.error(err.response.data);
                swal.fire("خطأ", "حدث خطأ أثناء البحث عن الفاتورة", "error");
            });
        },
        toggleCheckBox() {
            var _self = this;

            $("input[name='x-order']").each(function(){
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
        }
    },
    mounted() {
        // Auto-focus on barcode input for easier scanning
        this.$nextTick(() => {
            if (this.$refs.barcodeInput) {
                this.$refs.barcodeInput.focus();
            }
        });
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
        }
    },
    computed: {
        totalQuantity() {
            let qnt = 0;
            this.orders.forEach((item)=>{
                qnt += item.qnt;
            });
            return qnt;
        },
        totalPrice() {
            let price = 0;
            this.orders.forEach((item)=>{
                price += item.price;
            })
            return price;
        }
    }
}
</script>

<style>

</style>
