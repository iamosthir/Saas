<template>
  <div class="row justify-content-center">
    <div class="col-md-7 col-lg-4">
        <div class="card">
            <div class="card-header">
                <p>أعدادات</p>
            </div>
            <div class="card-body">
                <form @submit.prevent="updateStock" class="row">
                    
                    <div class="col-md-12 mb-4">
                        <div class="form-outline">
                            <input type="number" id="formName" class="form-control-lg form-control" :class="{'is-invalid' : form.errors.has('phone')}"
                            placeholder="Add stock of product..." v-model="form.phone"/>
                            <label class="form-label" for="formName">أضافة رقم هاتف</label>
                            <HasError :form="form" field="name"/>
                        </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <Button :form="form" class="btn btn-success">حفظ</Button>
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
                phone: "",
            }),
        }
    },
    methods: {
        initMDB() {
            var parent = this.$el;
            var child = parent.querySelectorAll(".form-outline");
            child.forEach(function(el) { new mdb.Input(el); });
        },
        updateStock() {
            this.form.post("/dashboard/api/changephone").then(resp=>{
                return resp.data;
            }).then(data=>{
                if(data.status == "ok") {
                    swal.fire("Success",data.msg,"success");
                    this.$root.settingData.product_stock = data.phone;
                }
                else {
                    swal.fire("Operation failed",data.msg,"error");
                }
            }).catch(err=>{
                console.error(err.response.data);
            })
        }
    },
    mounted() {
        this.$nextTick(()=>{
            this.initMDB();
        })
    },
    computed: {
        productStock() {
            return this.$root.settingData.product_stock;
        }
    }
}
</script>

<style>

</style>