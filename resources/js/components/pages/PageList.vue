<template>
  <div class="row justify-content-center">

    <div class="col-md-12 mb-4" v-if="addMode">
        <div class="card">
            <div class="card-header">
                <h4>أضافة صفحة <i class="fab fa-facebook"></i></h4>
            </div>
            <div class="card-body">
                <form @submit.prevent="addPage" class="row">
                    <div class="col-md-4 mb-4">
                        <div class="form-outline">
                            <input type="text" class="form-control-lg form-control" :class="{'is-invalid' : form.errors.has('name')}"
                                placeholder="أسم الصفحة..." v-model="form.name"/>
                            <label class="form-label">أسم الصفحة</label>
                            <HasError :form="form" field="name"/>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="form-outline">
                            <input type="text" class="form-control-lg form-control" :class="{'is-invalid' : form.errors.has('url')}"
                                placeholder="Web url..." v-model="form.url"/>
                            <label class="form-label">الرابط</label>
                            <HasError :form="form" field="url"/>
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">
                        <div class="form-outline">
                            <Button type="submit" :form="form" class="btn btn-success">اضافة</Button>
                            <button type="button" @click="addMode=false" class="btn btn-danger">أللغاء</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-4" v-if="updateMode">
        <div class="card">
            <div class="card-header">
                <h4>تحديث <i class="fab fa-facebook"></i></h4>
            </div>
            <div class="card-body">
                <form @submit.prevent="updatePage" class="row">
                    <div class="col-md-4 mb-4">
                        <div class="form-outline">
                            <input type="text" class="form-control-lg form-control" :class="{'is-invalid' : updateForm.errors.has('name')}"
                                placeholder=" أسم صفحة..." v-model="updateForm.name"/>
                            <label class="form-label">أسم صفحة</label>
                            <HasError :form="updateForm" field="name"/>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="form-outline">
                            <input type="text" class="form-control-lg form-control" :class="{'is-invalid' : updateForm.errors.has('url')}"
                                placeholder="web address..." v-model="updateForm.url"/>
                            <label class="form-label">الرابط</label>
                            <HasError :form="updateForm" field="url"/>
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">
                        <div class="form-outline">
                            <Button type="submit" :form="updateForm" class="btn btn-success">تحديث</Button>
                            <button type="button" @click="updateMode=false" class="btn btn-danger">غلق</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h6>قائمة بيجات</h6>
                <button @click="toggleAddMode" class="btn btn-sm btn-primary">أضافة بيج <i class="fas fa-plus"></i></button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المعرف</th>
                                <th>أسم الصفحة</th>
                                <th>الرابط</th>
                                <th>ألأجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(page,i) in pages">
                                <td>{{ i+1 }}</td>
                                <td>{{ page.id }}</td>
                                <td>{{ page.name }}</td>
                                <td>{{ page.url }}</td>
                                <td>
                                    <button @click="deletePage(page.id,i)" class="btn btn-sm btn-danger">حذف</button>
                                    <button @click="toggleUpdateMode(i)" class="btn btn-sm btn-warning">تعديل</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    <pagination :limit="8" :data="paginateData" @pagination-change-page="getPageList"></pagination>
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
            pages: [],
            form: new Form({
                name: "",
                url: "",
            }),
            addMode: false,
            updateMode: false,
            updateForm: new Form({
                pageId: null,
                name: "",
                url: "",
                index: "",
            }),
        }
    },
    methods: {
        initMDB() {
            var parent = this.$el;
            var child = parent.querySelectorAll(".form-outline");
            child.forEach(function(el) { new mdb.Input(el); });
        },
        async deletePage(id,index) {
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
                    axios.post("/dashboard/api/delete-page",{
                        pageId: id,
                    }).then(resp=>{
                        return resp.data;
                    }).then(data=>{
                        if(data.status == "ok") {
                            swal.fire("Deleted",data.msg,"success");
                            this.pages.splice(index,1);
                        }
                    }).catch(err=>{
                        console.error(err.response.data);
                    })
                }
            })
        },
        async getPageList(page = 1) {
            await axios.get("/dashboard/api/list-page-crud").then(resp=>{
                return resp.data;
            }).then(data=>{
                this.paginateData = data;
                this.pages = data.data;
            }).catch(err=>{
                console.error(err.response.data);
            })
        },
        toggleAddMode() {
            var _self = this;
            this.addMode = true;
            this.updateMode =false;
            setTimeout(function(){
                _self.initMDB();
            })
        },
        toggleUpdateMode(index) {
            var _self = this;
            var pageData = this.pages[index];
            this.updateForm.pageId = pageData.id;
            this.updateForm.name = pageData.name;
            this.updateForm.url = pageData.url;
            this.updateForm.index = index;

            this.updateMode = true;
            this.addMode = false;
            setTimeout(function(){
                _self.initMDB();
            })
        },
        async addPage() {
            await this.form.post("/dashboard/api/store-page").then(resp=>{
                return resp.data;
            }).then(data=>{
                if(data.status == "ok") {
                    swal.fire("Success",data.msg,"success");
                    this.pages.unshift(data.data);
                    this.form.reset();
                    this.addMode = false;
                }
            }).catch(err=>{
                console.error(err.response.data);
            })
        },
        async updatePage() {
            await this.updateForm.post("/dashboard/api/update-page").then(resp=>{
                return resp.data;
            }).then(data=>{
                if(data.status == "ok") {
                    this.pages[this.updateForm.index].name = data.data.name;
                    this.pages[this.updateForm.index].url = data.data.url;
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
        this.$nextTick(()=>{
            this.initMDB();
        })
        this.getPageList();
    },
}
</script>

<style>

</style>