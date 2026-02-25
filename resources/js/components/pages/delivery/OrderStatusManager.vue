<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4><i class="fas fa-truck me-2"></i> حالات الطلب</h4>
                    <button class="btn btn-success" @click="openAddModal">
                        <i class="fas fa-plus me-1"></i> إضافة حالة
                    </button>
                </div>
                <div class="card-body">
                    <template v-if="isLoading">
                        <div class="text-center p-5">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                    </template>
                    <template v-else>
                        <div v-if="statuses.length === 0" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            لا توجد حالات مضافة بعد. أضف أول حالة لتفعيل وحدة التوصيل.
                        </div>
                        <div v-else class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>الترتيب</th>
                                        <th>اسم الحالة</th>
                                        <th>اللون</th>
                                        <th>الافتراضي</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="status in statuses" :key="status.id">
                                        <td class="text-muted">{{ status.sort_order }}</td>
                                        <td>
                                            <span class="badge" :style="{ backgroundColor: status.color, color: '#fff' }">
                                                {{ status.name }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="d-flex align-items-center gap-2">
                                                <span :style="{ width:'20px', height:'20px', backgroundColor: status.color, display:'inline-block', borderRadius:'4px', border:'1px solid #dee2e6' }"></span>
                                                <code>{{ status.color }}</code>
                                            </span>
                                        </td>
                                        <td>
                                            <span v-if="status.is_default" class="badge bg-success">
                                                <i class="fas fa-check"></i> افتراضي
                                            </span>
                                            <span v-else class="text-muted">—</span>
                                        </td>
                                        <td>
                                            <span v-if="status.is_active" class="badge bg-success">مفعّل</span>
                                            <span v-else class="badge bg-secondary">معطّل</span>
                                        </td>
                                        <td>
                                            <button @click="openEditModal(status)" class="btn btn-sm btn-primary me-1" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button @click="toggleActive(status)" class="btn btn-sm me-1"
                                                :class="status.is_active ? 'btn-warning' : 'btn-success'"
                                                :title="status.is_active ? 'تعطيل' : 'تفعيل'">
                                                <i :class="status.is_active ? 'fas fa-toggle-off' : 'fas fa-toggle-on'"></i>
                                            </button>
                                            <button @click="deleteStatus(status)" class="btn btn-sm btn-danger" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Add/Edit Modal -->
        <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ editingStatus ? 'تعديل الحالة' : 'إضافة حالة جديدة' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">اسم الحالة <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" v-model="form.name"
                                placeholder="مثال: جاري التوصيل، تم التسليم، مُعاد..." maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">اللون</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" class="form-control form-control-color" v-model="form.color" style="width:60px;">
                                <input type="text" class="form-control" v-model="form.color"
                                    placeholder="#6c757d" maxlength="20">
                            </div>
                            <small class="text-muted">لون الشارة في قائمة الفواتير</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ترتيب العرض</label>
                            <input type="number" class="form-control" v-model="form.sort_order" min="0" placeholder="0">
                            <small class="text-muted">الأرقام الأصغر تظهر أولاً</small>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" v-model="form.is_active" id="statusActive">
                                <label class="form-check-label" for="statusActive">مفعّل</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" v-model="form.is_default" id="statusDefault">
                                <label class="form-check-label" for="statusDefault">
                                    <strong>حالة افتراضية</strong>
                                    <small class="text-muted d-block">ستظهر هذه الحالة محددة تلقائياً عند إنشاء فاتورة جديدة</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="button" class="btn btn-success" @click="saveStatus" :disabled="saving">
                            <span v-if="saving"><i class="fas fa-spinner fa-spin me-1"></i>جاري الحفظ...</span>
                            <span v-else><i class="fas fa-save me-1"></i>حفظ</span>
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
            statuses: [],
            isLoading: true,
            saving: false,
            editingStatus: null,
            form: {
                name: '',
                color: '#6c757d',
                sort_order: 0,
                is_active: true,
                is_default: false,
            },
        };
    },

    methods: {
        async loadStatuses() {
            this.isLoading = true;
            try {
                const resp = await axios.get('/dashboard/api/delivery/order-statuses');
                this.statuses = resp.data.statuses;
            } catch (err) {
                console.error(err);
                swal.fire('خطأ', 'فشل تحميل الحالات', 'error');
            } finally {
                this.isLoading = false;
            }
        },

        openAddModal() {
            this.editingStatus = null;
            this.form = { name: '', color: '#6c757d', sort_order: 0, is_active: true, is_default: false };
            $('#statusModal').modal('show');
        },

        openEditModal(status) {
            this.editingStatus = status;
            this.form = {
                name: status.name,
                color: status.color,
                sort_order: status.sort_order,
                is_active: status.is_active,
                is_default: status.is_default,
            };
            $('#statusModal').modal('show');
        },

        async saveStatus() {
            if (!this.form.name.trim()) {
                swal.fire('تنبيه', 'اسم الحالة مطلوب', 'warning');
                return;
            }

            this.saving = true;
            try {
                let resp;
                if (this.editingStatus) {
                    resp = await axios.put(`/dashboard/api/delivery/order-statuses/${this.editingStatus.id}`, this.form);
                    const index = this.statuses.findIndex(s => s.id === this.editingStatus.id);
                    if (index !== -1) this.statuses.splice(index, 1, resp.data.order_status);
                } else {
                    resp = await axios.post('/dashboard/api/delivery/order-statuses', this.form);
                    this.statuses.push(resp.data.order_status);
                }

                swal.fire('تم', resp.data.msg, 'success');
                $('#statusModal').modal('hide');
            } catch (err) {
                const msg = err.response?.data?.message || err.response?.data?.msg || 'حدث خطأ';
                swal.fire('خطأ', msg, 'error');
            } finally {
                this.saving = false;
            }
        },

        async toggleActive(status) {
            try {
                const resp = await axios.post(`/dashboard/api/delivery/order-statuses/${status.id}/toggle`);
                const index = this.statuses.findIndex(s => s.id === status.id);
                if (index !== -1) this.statuses.splice(index, 1, resp.data.order_status);
                toastr.success(resp.data.msg);
            } catch (err) {
                swal.fire('خطأ', 'فشل تغيير حالة التفعيل', 'error');
            }
        },

        async deleteStatus(status) {
            const result = await swal.fire({
                title: 'هل أنت متأكد؟',
                text: `سيتم حذف حالة "${status.name}" نهائياً`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، احذف',
                cancelButtonText: 'إلغاء',
                confirmButtonColor: '#d33',
            });

            if (!result.isConfirmed) return;

            try {
                await axios.delete(`/dashboard/api/delivery/order-statuses/${status.id}`);
                this.statuses = this.statuses.filter(s => s.id !== status.id);
                toastr.success('تم حذف الحالة بنجاح');
            } catch (err) {
                const msg = err.response?.data?.msg || 'فشل حذف الحالة';
                swal.fire('خطأ', msg, 'error');
            }
        },
    },

    mounted() {
        this.loadStatuses();
    },
};
</script>
