<template>
  <div class="row justify-content-center">

    <div class="col-md-12 mb-4" v-if="addMode">
        <div class="card">
            <div class="card-header">
                <h4>أضافة <i class="fas fa-truck"></i></h4>
            </div>
            <div class="card-body">
                <form @submit.prevent="addShipping" class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">أسم شركة</label>
                        <input type="text" class="form-control" :class="{'is-invalid' : form.errors.has('name')}"
                            placeholder="أسم شركة الشحن" v-model="form.name"/>
                        <HasError :form="form" field="name"/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">العنوان</label>
                        <input type="text" class="form-control" :class="{'is-invalid' : form.errors.has('address')}"
                            placeholder="العنوان" v-model="form.address"/>
                        <HasError :form="form" field="address"/>
                    </div>

                    <div class="col-md-12 mb-3">
                        <Button type="submit" :form="form" class="btn btn-success">أضافة</Button>
                        <button type="button" @click="addMode=false" class="btn btn-danger ms-2">أللغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-4" v-if="updateMode">
        <div class="card">
            <div class="card-header">
                <h4>تحديث <i class="fas fa-truck"></i></h4>
            </div>
            <div class="card-body">
                <form @submit.prevent="updateShipping" class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">أسم شركة</label>
                        <input type="text" class="form-control" :class="{'is-invalid' : updateForm.errors.has('name')}"
                            placeholder="أسم شركة الشحن" v-model="updateForm.name"/>
                        <HasError :form="updateForm" field="name"/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">العنوان</label>
                        <input type="text" class="form-control" :class="{'is-invalid' : updateForm.errors.has('address')}"
                            placeholder="العنوان" v-model="updateForm.address"/>
                        <HasError :form="updateForm" field="address"/>
                    </div>

                    <div class="col-md-12 mb-3">
                        <Button type="submit" :form="updateForm" class="btn btn-success">تحديث</Button>
                        <button type="button" @click="updateMode=false" class="btn btn-danger ms-2">غلق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h6>شركات الشحن</h6>
                <button @click="toggleAddMode" class="btn btn-sm btn-primary">اضافة شركة شحن <i class="fas fa-plus"></i></button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المعرف</th>
                                <th>أسم شركة</th>
                                <th>العنوان</th>
                                <th>الأجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(ship,i) in shippings">
                                <td>{{ i+1 }}</td>
                                <td>{{ ship.id }}</td>
                                <td>{{ ship.name }}</td>
                                <td>{{ ship.address }}</td>
                                <td>
                                    <button @click="deleteShipping(ship.id,i)" class="btn btn-sm btn-danger">حذف</button>
                                    <button @click="toggleUpdateMode(i)" class="btn btn-sm btn-warning">تعديل</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    <pagination :limit="8" :data="paginateData" @pagination-change-page="getShippingList"></pagination>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>

export default {
    data() {
        return {
            paginateData: {},
            shippings: [],
            form: new Form({
                name: "",
                address: "",
            }),
            addMode: false,
            updateMode: false,
            updateForm: new Form({
                shipId: null,
                name: "",
                address: "",
                index: "",
            }),
        }
    },
    methods: {
        async deleteShipping(id,index) {
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
                    axios.post("/dashboard/api/delete-shipping",{
                        shipId: id,
                    }).then(resp=>{
                        return resp.data;
                    }).then(data=>{
                        if(data.status == "ok") {
                            swal.fire("Deleted",data.msg,"success");
                            this.shippings.splice(index,1);
                        }
                    }).catch(err=>{
                        console.error(err.response.data);
                    })
                }
            })
        },
        async getShippingList(page = 1) {
            await axios.get("/dashboard/api/list-shipping-crud").then(resp=>{
                return resp.data;
            }).then(data=>{
                this.paginateData = data;
                this.shippings = data.data;
            }).catch(err=>{
                console.error(err.response.data);
            })
        },
        toggleAddMode() {
            this.addMode = true;
            this.updateMode = false;
        },
        toggleUpdateMode(index) {
            var shipData = this.shippings[index];
            this.updateForm.shipId = shipData.id;
            this.updateForm.name = shipData.name;
            this.updateForm.address = shipData.address;
            this.updateForm.index = index;

            this.updateMode = true;
            this.addMode = false;
        },
        async addShipping() {
            await this.form.post("/dashboard/api/store-shipping").then(resp=>{
                return resp.data;
            }).then(data=>{
                if(data.status == "ok") {
                    swal.fire("Success",data.msg,"success");
                    this.shippings.push(data.data);
                    this.form.reset();
                    this.addMode = false;
                }
            }).catch(err=>{
                console.error(err.response.data);
            })
        },
        async updateShipping() {
            await this.updateForm.post("/dashboard/api/update-shipping").then(resp=>{
                return resp.data;
            }).then(data=>{
                if(data.status == "ok") {
                    this.shippings[this.updateForm.index].name = data.data.name;
                    this.shippings[this.updateForm.index].address = data.data.address;
                    swal.fire("Success",data.msg,"success");
                    
                }
            }).catch(err=>{
                console.error(err.response.data);
            })
        }
    },
    watch: {
        'updateMode'(status) {
            if(status == false) {
                this.updateForm.reset();
            }
        }
    },
    mounted() {
        this.getShippingList();
    },
}
</script>

<style>

</style>