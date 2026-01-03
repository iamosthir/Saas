<template>
    <div class="row">
      <div class="col-md-12">
          <div class="card">
              <div class="card-header d-flex justify-content-between">
                  <h4> قائمة الطلبات</h4>
                  <div>
                      <p>مجموع الطلبات: <strong>{{ paginateData.total }}</strong>
                           &nbsp;|&nbsp; عدد المنتجات :  <strong>{{ totalQuantity }}</strong>
                           &nbsp;|&nbsp; السعر الكلي: <strong>IQD {{ formatAmount(totalPrice) }}</strong></p>
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
                          <select class="form-select" v-model="form.status">
                              <option value="">الكل</option>
                              <option value="pending">جاري شحن</option>
                              <option value="completed">واصل تم</option>
                              <option value="canceled">راجع</option>
                              <option value="delayed">مؤجل</option>
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

                      <div class="col-md-2 mt-2">
                          <input class="form-control" placeholder="السعر" type="number" v-model="form.price">
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
                            <th>رقم الوصل</th>
                            <th>تاريخ</th>
                            <th>اسم زبون</th>
                            <th>المنتجات</th>
                            <th>السعر الكلي</th>
                            <th>نوع الدفع</th>
                            <th>حالة الدفع</th>
                            <th>الحالة</th>
                            <th>الأجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="isLoading">
                            <tr v-for="n in 10" :key="n">
                                <td colspan="10"><skeleton width="100%" height="30px" /></td>
                            </tr>
                        </template>
                        <template v-else>
                            <template v-if="orders.length > 0">
                                <tr v-for="(order, i) in orders" :key="i" class="text-center">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :disabled="order.is_printed == 'yes'" :value="order.id" name="print-order" v-model="orderSelect"/>
                                        </div>
                                        <div class="form-check">
                                            <input style="background-color: rgb(0 0 0);" class="form-check-input" type="checkbox" :value="order.id" name="x-order" v-model="orderSelect2"/>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="font-size: 29px;" v-if="order.is_printed == 'no'" class="text-danger">•</span>
                                        <span class="badge badge-pill badge-primary">{{ order.id }}</span>
                                    </td>
                                    <td><span dir="ltr" class="text-left"><strong>{{ moment(order.created_at).format("DD MMM YYYY, h:m a") }}</strong></span></td>
                                    <td><strong class="text-muted">{{ order.customer ? order.customer.customer_name : 'N/A' }}</strong></td>
                                    <td class="text-start">
                                        <template v-if="order.items && order.items.length > 0">
                                            <div v-for="(item, idx) in order.items" :key="idx" class="mb-1">
                                                <span class="badge bg-light text-dark">
                                                    {{ item.product_name }}
                                                    <span v-if="item.variation_name"> - {{ item.variation_name }}</span>
                                                    <strong class="text-primary"> x{{ item.quantity }}</strong>
                                                </span>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <span class="text-muted">لا توجد منتجات</span>
                                        </template>
                                    </td>
                                    <td><strong class="text-success">{{ formatAmount(order.total_amount) }} IQD</strong></td>
                                    <td>
                                        <span v-if="order.payment_type == 'full_payment'" class="badge badge-info">دفع كامل</span>
                                        <span v-else-if="order.payment_type == 'installment'" class="badge badge-warning">تقسيط</span>
                                        <span v-else class="badge badge-secondary">نقدي</span>
                                    </td>
                                    <td>
                                        <span v-if="order.is_fully_paid" class="badge badge-success">مدفوع <i class="fas fa-check-circle"></i></span>
                                        <span v-else-if="order.payment_status == 'partial'" class="badge badge-warning">مدفوع جزئياً <i class="fas fa-exclamation-circle"></i></span>
                                        <span v-else class="badge badge-danger">غير مدفوع <i class="fas fa-times-circle"></i></span>
                                    </td>
                                    <td>
                                        <span v-if="order.payment_status == 'unpaid'" class="badge badge-warning">غير مدفوع</span>
                                        <span v-else-if="order.payment_status == 'partial'" class="badge badge-info">مدفوع جزئياً</span>
                                        <span v-else-if="order.payment_status == 'paid'" class="badge badge-success">مدفوع بالكامل</span>
                                    </td>
                                    <td>
                                        <router-link :to="{name: 'invoice.details', params: {id: order.id}}" title="Details" class="btn btn-sm btn-primary me-1">
                                            <i class="fas fa-eye"></i> Details
                                        </router-link>
                                        <button title="Print Invoice" @click="printSingle(order.id)" class="btn btn-sm btn-success">
                                            <i class="fas fa-print"></i> Print
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="10" class="text-danger text-center">لا توجد طلبات</td>
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

      <!-- Invoice Details Modal -->
      <div class="modal fade" id="invoiceDetailsModal" tabindex="-1" aria-labelledby="invoiceDetailsModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header bg-primary text-white">
                      <h5 class="modal-title" id="invoiceDetailsModalLabel">تفاصيل الفاتورة #{{ selectedOrder.id }}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" v-if="selectedOrder.id">
                      <div class="row mb-3">
                          <div class="col-md-6">
                              <h6 class="text-muted">معلومات العميل</h6>
                              <p><strong>الاسم:</strong> {{ selectedOrder.customer ? selectedOrder.customer.customer_name : 'N/A' }}</p>
                              <p><strong>رقم الهاتف 1:</strong> {{ selectedOrder.customer ? selectedOrder.customer.phone1 : 'N/A' }}</p>
                              <p v-if="selectedOrder.customer && selectedOrder.customer.phone2"><strong>رقم الهاتف 2:</strong> {{ selectedOrder.customer.phone2 }}</p>
                              <p v-if="selectedOrder.customer && selectedOrder.customer.state"><strong>المحافظة:</strong> {{ selectedOrder.customer.state }}</p>
                              <p v-if="selectedOrder.customer && selectedOrder.customer.city"><strong>المدينة:</strong> {{ selectedOrder.customer.city }}</p>
                          </div>
                          <div class="col-md-6">
                              <h6 class="text-muted">معلومات الفاتورة</h6>
                              <p><strong>رقم الفاتورة:</strong> {{ selectedOrder.invoice_number }}</p>
                              <p><strong>التاريخ:</strong> {{ moment(selectedOrder.created_at).format("DD MMM YYYY, h:mm a") }}</p>
                              <p><strong>نشأ بواسطة:</strong> {{ selectedOrder.created_by ? selectedOrder.created_by.name : 'N/A' }}</p>
                              <p v-if="selectedOrder.notes"><strong>ملاحظات:</strong> {{ selectedOrder.notes }}</p>
                          </div>
                      </div>

                      <hr>

                      <div class="mb-3">
                          <h6 class="text-muted">المنتجات</h6>
                          <div class="table-responsive">
                              <table class="table table-bordered">
                                  <thead class="bg-light">
                                      <tr>
                                          <th>#</th>
                                          <th>اسم المنتج</th>
                                          <th>المتغير</th>
                                          <th>الكمية</th>
                                          <th>السعر</th>
                                          <th>الإجمالي</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <tr v-for="(item, idx) in selectedOrder.items" :key="idx">
                                          <td>{{ idx + 1 }}</td>
                                          <td>{{ item.product_name }}</td>
                                          <td>{{ item.variation_name || 'N/A' }}</td>
                                          <td>{{ item.quantity }}</td>
                                          <td>{{ formatAmount(item.custom_price) }} IQD</td>
                                          <td>{{ formatAmount(item.line_total) }} IQD</td>
                                      </tr>
                                  </tbody>
                                  <tfoot class="bg-light">
                                      <tr>
                                          <td colspan="5" class="text-end"><strong>المجموع الفرعي:</strong></td>
                                          <td><strong>{{ formatAmount(selectedOrder.subtotal) }} IQD</strong></td>
                                      </tr>
                                      <tr v-if="selectedOrder.discount_amount > 0">
                                          <td colspan="5" class="text-end"><strong>الخصم:</strong></td>
                                          <td><strong class="text-danger">-{{ formatAmount(selectedOrder.discount_amount) }} IQD</strong></td>
                                      </tr>
                                      <tr v-if="selectedOrder.extra_charge > 0">
                                          <td colspan="5" class="text-end"><strong>رسوم إضافية:</strong></td>
                                          <td><strong>{{ formatAmount(selectedOrder.extra_charge) }} IQD</strong></td>
                                      </tr>
                                      <tr class="table-primary">
                                          <td colspan="5" class="text-end"><strong>المجموع الكلي:</strong></td>
                                          <td><strong>{{ formatAmount(selectedOrder.total_amount) }} IQD</strong></td>
                                      </tr>
                                  </tfoot>
                              </table>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-6">
                              <p><strong>نوع الدفع:</strong>
                                  <span v-if="selectedOrder.payment_type == 'full_payment'" class="badge badge-info">دفع كامل</span>
                                  <span v-else-if="selectedOrder.payment_type == 'installment'" class="badge badge-warning">تقسيط ({{ selectedOrder.installment_months }} شهر)</span>
                              </p>
                              <p><strong>المبلغ المدفوع:</strong> {{ formatAmount(selectedOrder.paid_amount) }} IQD</p>
                              <p><strong>المبلغ المتبقي:</strong> {{ formatAmount(selectedOrder.remaining_amount) }} IQD</p>
                          </div>
                          <div class="col-md-6">
                              <p><strong>حالة الدفع:</strong>
                                  <span v-if="selectedOrder.is_fully_paid" class="badge badge-success">مدفوع بالكامل</span>
                                  <span v-else-if="selectedOrder.payment_status == 'partial'" class="badge badge-warning">مدفوع جزئياً</span>
                                  <span v-else class="badge badge-danger">غير مدفوع</span>
                              </p>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                      <button type="button" class="btn btn-success" @click="printSingle(selectedOrder.id)">
                          <i class="fas fa-print"></i> طباعة الفاتورة
                      </button>
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
                price: "",
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
            selectedOrder: {},
            selectedInvoice: {},
          }
      },
      methods: {
          formatAmount(amount) {
              // Convert to number if it's a string
              const num = parseFloat(amount);

              // Return empty string if not a valid number
              if (isNaN(num)) return '0';

              // Check if the number has decimals
              const hasDecimals = num % 1 !== 0;

              // Format with thousand separators
              if (hasDecimals) {
                  // Show max 2 decimal places
                  return num.toLocaleString('en-US', {
                      minimumFractionDigits: 0,
                      maximumFractionDigits: 2
                  });
              } else {
                  // No decimals, show as whole number
                  return num.toLocaleString('en-US', {
                      minimumFractionDigits: 0,
                      maximumFractionDigits: 0
                  });
              }
          },
          async getOrderList(page = 1) {
              this.form.page = page;
              this.isLoading = true;
              this.mainCheck = false;
              await axios.get("/dashboard/api/invoices", {
                  params: this.form
              }).then(resp=>{
                  return resp.data;
              }).then(data=>{
                  this.isLoading = false;
                  this.orders = data.invoices.data;
                  this.paginateData = data.invoices;
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
        viewDetails(order) {
            this.selectedOrder = order;
            $('#invoiceDetailsModal').modal('show');
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

  <style>

  </style>
