<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>تفاصيل الفاتورة #{{ invoice.invoice_number }}</h4>
                    <div>
                        <button @click="$router.go(-1)" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> رجوع
                        </button>
                        <button @click="printInvoice" class="btn btn-success">
                            <i class="fas fa-print"></i> طباعة
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <template v-if="isLoading">
                        <div class="text-center p-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </template>
                    <template v-else-if="invoice.id">
                        <!-- Invoice Info -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">معلومات العميل</h5>
                                        <hr>
                                        <p><strong>الاسم:</strong> {{ invoice.customer ? invoice.customer.customer_name : 'N/A' }}</p>
                                        <p><strong>رقم الهاتف 1:</strong> {{ invoice.customer ? invoice.customer.phone1 : 'N/A' }}</p>
                                        <p v-if="invoice.customer && invoice.customer.phone2"><strong>رقم الهاتف 2:</strong> {{ invoice.customer.phone2 }}</p>
                                        <p v-if="invoice.customer && invoice.customer.state"><strong>المحافظة:</strong> {{ invoice.customer.state }}</p>
                                        <p v-if="invoice.customer && invoice.customer.city"><strong>المدينة:</strong> {{ invoice.customer.city }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">معلومات الفاتورة</h5>
                                        <hr>
                                        <p><strong>رقم الفاتورة:</strong> {{ invoice.invoice_number }}</p>
                                        <p><strong>التاريخ:</strong> {{ moment(invoice.created_at).format("DD MMM YYYY, h:mm a") }}</p>
                                        <p><strong>نشأ بواسطة:</strong> {{ invoice.created_by ? invoice.created_by.name : 'N/A' }}</p>
                                        <p><strong>نوع الدفع:</strong>
                                            <span v-if="invoice.payment_type == 'full_payment'" class="badge badge-info">دفع كامل</span>
                                            <span v-else-if="invoice.payment_type == 'installment'" class="badge badge-warning">تقسيط ({{ invoice.installment_months }} شهر)</span>
                                        </p>
                                        <p><strong>حالة الدفع:</strong>
                                            <span v-if="invoice.is_fully_paid" class="badge badge-success">مدفوع بالكامل</span>
                                            <span v-else-if="invoice.payment_status == 'partial'" class="badge badge-warning">مدفوع جزئياً</span>
                                            <span v-else class="badge badge-danger">غير مدفوع</span>
                                        </p>
                                        <p v-if="invoice.notes"><strong>ملاحظات:</strong> {{ invoice.notes }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Products Table -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-primary">المنتجات</h5>
                                <hr>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
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
                                            <tr v-for="(item, idx) in invoice.items" :key="idx">
                                                <td>{{ idx + 1 }}</td>
                                                <td>{{ item.product_name }}</td>
                                                <td>{{ item.variation_name || 'N/A' }}</td>
                                                <td>{{ item.quantity }}</td>
                                                <td>{{ item.custom_price }} IQD</td>
                                                <td>{{ item.line_total }} IQD</td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="bg-light">
                                            <tr>
                                                <td colspan="5" class="text-end"><strong>المجموع الفرعي:</strong></td>
                                                <td><strong>{{ invoice.subtotal }} IQD</strong></td>
                                            </tr>
                                            <tr v-if="invoice.discount_amount > 0">
                                                <td colspan="5" class="text-end"><strong>الخصم:</strong></td>
                                                <td><strong class="text-danger">-{{ invoice.discount_amount }} IQD</strong></td>
                                            </tr>
                                            <tr v-if="invoice.extra_charge > 0">
                                                <td colspan="5" class="text-end"><strong>رسوم إضافية:</strong></td>
                                                <td><strong>{{ invoice.extra_charge }} IQD</strong></td>
                                            </tr>
                                            <tr class="table-primary">
                                                <td colspan="5" class="text-end"><strong>المجموع الكلي:</strong></td>
                                                <td><strong>{{ invoice.total_amount }} IQD</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Summary -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h6>المبلغ المدفوع</h6>
                                        <h3>{{ invoice.paid_amount }} IQD</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-warning text-white">
                                    <div class="card-body text-center">
                                        <h6>المبلغ المتبقي</h6>
                                        <h3>{{ invoice.remaining_amount }} IQD</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h6>المبلغ الإجمالي</h6>
                                        <h3>{{ invoice.total_amount }} IQD</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Installments Timeline -->
                        <div class="card" v-if="invoice.payment_type == 'installment' && installments.length > 0">
                            <div class="card-body">
                                <h5 class="card-title text-primary">جدول الأقساط</h5>
                                <hr>
                                <div class="timeline">
                                    <div
                                        v-for="(installment, idx) in installments"
                                        :key="installment.id"
                                        class="timeline-item"
                                        :class="getInstallmentClass(installment)"
                                        @click="openPaymentModal(installment)"
                                        style="cursor: pointer;"
                                    >
                                        <div class="timeline-marker" :class="getMarkerClass(installment)">
                                            <i :class="getMarkerIcon(installment)"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">
                                                        القسط {{ installment.installment_number }}
                                                        <span :class="getStatusBadgeClass(installment)">
                                                            {{ getStatusText(installment.status) }}
                                                        </span>
                                                    </h6>
                                                    <p class="text-muted mb-1">
                                                        <i class="fas fa-calendar"></i>
                                                        تاريخ الاستحقاق: {{ moment(installment.due_date).format("DD MMM YYYY") }}
                                                    </p>
                                                    <p class="mb-0" v-if="installment.paid_date">
                                                        <i class="fas fa-check-circle text-success"></i>
                                                        تاريخ الدفع: {{ moment(installment.paid_date).format("DD MMM YYYY") }}
                                                    </p>
                                                </div>
                                                <div class="text-end">
                                                    <h5 class="mb-1">{{ installment.amount }} IQD</h5>
                                                    <small class="text-muted">
                                                        مدفوع: <strong class="text-success">{{ installment.paid_amount }} IQD</strong>
                                                    </small>
                                                    <br>
                                                    <small class="text-muted">
                                                        متبقي: <strong class="text-danger">{{ installment.amount - installment.paid_amount }} IQD</strong>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Payment Modal -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="paymentModalLabel">تسجيل دفعة - القسط {{ selectedInstallment.installment_number }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <strong>مبلغ القسط:</strong> {{ selectedInstallment.amount }} IQD<br>
                            <strong>المبلغ المدفوع سابقاً:</strong> {{ selectedInstallment.paid_amount }} IQD<br>
                            <strong>المبلغ المتبقي:</strong> {{ selectedInstallment.amount - selectedInstallment.paid_amount }} IQD
                        </div>
                        <div class="form-group">
                            <label for="paymentAmount" class="form-label">المبلغ المدفوع</label>
                            <input
                                type="number"
                                class="form-control"
                                id="paymentAmount"
                                v-model.number="paymentAmount"
                                min="0"
                                step="0.01"
                                placeholder="أدخل المبلغ المدفوع"
                            >
                        </div>
                        <div class="alert alert-warning mt-3" v-if="paymentAmount > (selectedInstallment.amount - selectedInstallment.paid_amount)">
                            <i class="fas fa-info-circle"></i>
                            المبلغ أكبر من المتبقي. سيتم تطبيق الفائض على الأقساط التالية.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="button" class="btn btn-success" @click="processPayment" :disabled="isProcessing || !paymentAmount || paymentAmount <= 0">
                            <span v-if="isProcessing">
                                <span class="spinner-border spinner-border-sm" role="status"></span>
                                جاري المعالجة...
                            </span>
                            <span v-else>
                                <i class="fas fa-check"></i> تأكيد الدفع
                            </span>
                        </button>
                    </div>
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
            invoice: {},
            installments: [],
            isLoading: true,
            isProcessing: false,
            moment: moment,
            selectedInstallment: {},
            paymentAmount: 0,
        }
    },
    mounted() {
        this.getInvoiceDetails();
    },
    methods: {
        async getInvoiceDetails() {
            this.isLoading = true;
            const invoiceId = this.$route.params.id;

            try {
                const response = await axios.get(`/dashboard/api/invoices/${invoiceId}`);
                this.invoice = response.data.invoice;
                this.installments = response.data.installments || [];
                this.isLoading = false;
            } catch (error) {
                this.isLoading = false;
                console.error(error);
                swal.fire("خطأ", "فشل في تحميل بيانات الفاتورة", "error");
            }
        },

        getInstallmentClass(installment) {
            if (installment.status === 'paid') return 'timeline-item-paid';
            if (this.isUpcoming(installment)) return 'timeline-item-upcoming';
            return 'timeline-item-pending';
        },

        getMarkerClass(installment) {
            if (installment.status === 'paid') return 'bg-success';
            if (this.isUpcoming(installment)) return 'bg-warning';
            return 'bg-secondary';
        },

        getMarkerIcon(installment) {
            if (installment.status === 'paid') return 'fas fa-check';
            if (this.isUpcoming(installment)) return 'fas fa-clock';
            return 'fas fa-circle';
        },

        getStatusBadgeClass(installment) {
            if (installment.status === 'paid') return 'badge badge-success';
            if (installment.status === 'partial') return 'badge badge-warning';
            if (this.isUpcoming(installment)) return 'badge badge-info';
            return 'badge badge-secondary';
        },

        getStatusText(status) {
            const statusMap = {
                'paid': 'مدفوع',
                'partial': 'مدفوع جزئياً',
                'unpaid': 'غير مدفوع'
            };
            return statusMap[status] || 'غير مدفوع';
        },

        isUpcoming(installment) {
            if (installment.status === 'paid') return false;
            const today = moment();
            const dueDate = moment(installment.due_date);
            const daysDiff = dueDate.diff(today, 'days');
            return daysDiff >= 0 && daysDiff <= 30;
        },

        openPaymentModal(installment) {
            if (installment.status === 'paid') {
                swal.fire("تنبيه", "هذا القسط مدفوع بالكامل", "info");
                return;
            }

            this.selectedInstallment = installment;
            this.paymentAmount = installment.amount - installment.paid_amount;
            $('#paymentModal').modal('show');
        },

        async processPayment() {
            if (!this.paymentAmount || this.paymentAmount <= 0) {
                swal.fire("خطأ", "الرجاء إدخال مبلغ صحيح", "error");
                return;
            }

            this.isProcessing = true;

            try {
                const response = await axios.post(`/dashboard/api/installments/${this.selectedInstallment.id}/pay`, {
                    amount: this.paymentAmount
                });

                this.isProcessing = false;

                if (response.data.status === 'ok') {
                    swal.fire("نجح", response.data.msg, "success");
                    $('#paymentModal').modal('hide');
                    this.paymentAmount = 0;
                    this.selectedInstallment = {};
                    await this.getInvoiceDetails(); // Refresh data
                } else {
                    swal.fire("خطأ", response.data.msg, "error");
                }
            } catch (error) {
                this.isProcessing = false;
                console.error(error);
                swal.fire("خطأ", "فشل في معالجة الدفع", "error");
            }
        },

        printInvoice() {
            window.open(`/dashboard/print-new-invoice/${this.invoice.id}`, '_blank');
        }
    }
}
</script>

<style scoped>
.timeline {
    position: relative;
    padding: 30px 0 10px 0;
    max-width: 100%;
    margin: 0 auto;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 50px;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, #dee2e6 0%, #dee2e6 100%);
    border-radius: 3px;
}

.timeline-item {
    position: relative;
    padding-left: 90px;
    padding-right: 20px;
    margin-bottom: 25px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.timeline-item:hover {
    transform: translateX(8px);
}

.timeline-item:hover .timeline-marker {
    transform: scale(1.15);
    box-shadow: 0 6px 20px rgba(0,0,0,0.25);
}

.timeline-item:hover .timeline-content {
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.timeline-item-paid .timeline-content {
    border-left: 4px solid #28a745;
    background: linear-gradient(to right, #f0fff4 0%, #ffffff 100%);
}

.timeline-item-upcoming .timeline-content {
    border-left: 4px solid #ffc107;
    background: linear-gradient(to right, #fffbf0 0%, #ffffff 100%);
}

.timeline-item-pending .timeline-content {
    border-left: 4px solid #6c757d;
    background: linear-gradient(to right, #f8f9fa 0%, #ffffff 100%);
}

.timeline-marker {
    position: absolute;
    left: 30px;
    top: 50%;
    transform: translateY(-50%);
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    border: 3px solid white;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 2;
}

.bg-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.bg-warning {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
}

.bg-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #adb5bd 100%);
}

.timeline-content {
    background: #ffffff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.timeline-content h6 {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
}

.timeline-content .badge {
    font-size: 11px;
    padding: 4px 10px;
    font-weight: 600;
    border-radius: 20px;
}

.timeline-content p {
    font-size: 14px;
    color: #6c757d;
}

.timeline-content small {
    font-size: 13px;
}

.timeline-content h5 {
    font-weight: 700;
    color: #2c3e50;
}

/* Badge colors */
.badge-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.badge-warning {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    color: white;
}

.badge-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
}

.badge-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #adb5bd 100%);
    color: white;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .timeline::before {
        left: 35px;
    }

    .timeline-item {
        padding-left: 70px;
        padding-right: 10px;
    }

    .timeline-marker {
        left: 15px;
        width: 40px;
        height: 40px;
        font-size: 16px;
    }

    .timeline-content {
        padding: 15px;
    }
}

@media print {
    .btn, .timeline-item {
        cursor: default !important;
        pointer-events: none;
    }

    .timeline-item:hover {
        transform: none;
    }
}
</style>
