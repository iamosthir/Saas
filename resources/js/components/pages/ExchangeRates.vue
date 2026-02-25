<template>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-exchange-alt me-2"></i> أسعار الصرف</h5>
                    </div>
                    <div class="card-body">
                        <div v-if="loading" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                        <div v-else>
                            <div class="mb-4">
                                <label class="form-label fw-bold">1 USD = ? IQD</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text">1 USD =</span>
                                    <input
                                        type="number"
                                        class="form-control"
                                        v-model="rate"
                                        min="0"
                                        step="0.01"
                                        placeholder="أدخل سعر الصرف"
                                    />
                                    <span class="input-group-text">IQD</span>
                                </div>
                                <div class="form-text">أدخل سعر صرف الدولار مقابل الدينار العراقي</div>
                            </div>

                            <div v-if="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ successMessage }}
                                <button type="button" class="btn-close" @click="successMessage = ''"></button>
                            </div>

                            <div v-if="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ errorMessage }}
                                <button type="button" class="btn-close" @click="errorMessage = ''"></button>
                            </div>

                            <button
                                class="btn btn-primary w-100"
                                @click="saveRate"
                                :disabled="saving"
                            >
                                <span v-if="saving">
                                    <span class="spinner-border spinner-border-sm me-1"></span> جاري الحفظ...
                                </span>
                                <span v-else>
                                    <i class="fas fa-save me-1"></i> حفظ سعر الصرف
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ExchangeRates",
    data() {
        return {
            rate: 0,
            loading: true,
            saving: false,
            successMessage: "",
            errorMessage: "",
        };
    },
    mounted() {
        this.fetchRates();
    },
    methods: {
        fetchRates() {
            this.loading = true;
            axios
                .get("/dashboard/api/exchange-rates")
                .then((response) => {
                    const rates = response.data;
                    const usdToIqd = rates.find(
                        (r) => r.base_currency === "USD" && r.target_currency === "IQD"
                    );
                    if (usdToIqd) {
                        this.rate = usdToIqd.rate;
                    }
                })
                .catch(() => {
                    this.errorMessage = "فشل في تحميل أسعار الصرف";
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        saveRate() {
            if (!this.rate || this.rate <= 0) {
                this.errorMessage = "يجب أن يكون سعر الصرف أكبر من صفر";
                return;
            }

            this.saving = true;
            this.successMessage = "";
            this.errorMessage = "";

            axios
                .post("/dashboard/api/exchange-rates", {
                    base_currency: "USD",
                    target_currency: "IQD",
                    rate: this.rate,
                })
                .then(() => {
                    this.successMessage = "تم تحديث سعر الصرف بنجاح";
                })
                .catch((error) => {
                    this.errorMessage =
                        error.response?.data?.message || "فشل في تحديث سعر الصرف";
                })
                .finally(() => {
                    this.saving = false;
                });
        },
    },
};
</script>
