<template>
  <div class="row justify-content-center">
    <div class="col-md-9 col-lg-7">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between">
                <h4>قائمة المستخدمين</h4>
                <router-link :to="{name: 'user.add'}" class="btn btn-primary">أضافة مستخدم جديد <i class="fas fa-user-plus"></i> </router-link>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>أسم مستخدم</th>
                                <th>البريد الألكتروني</th>
                                <th>الصلاحية</th>
                                <th>عدد طلبات</th>
                                <th>الأجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="isLoading">
                                <tr v-for="n in 5" :key="n">
                                    <td colspan="4"><skeleton width="100%" height="25px" /></td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr v-for="(user,i) in users" :key="i">
                                    <td><strong>{{ user.name }}</strong></td>
                                    <td><span class="badge badge-success">{{ user.email }}</span></td>
                                    <td><span class="badge badge-secondary">{{ user.role }}</span></td>
                                    <td><span class="badge badge-secondary">{{ user.orders_count }}</span></td>
                                    <td>
                                        <button @click="deleteUser(user.id,i)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        <router-link :to="{name: 'user.edit', params: {userid: user.id}}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></router-link>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
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
            role: role,
            users: [],
            isLoading: true,
        }
    },
    methods: {
        getUserList() {
            axios.get("/dashboard/api/get-user-list").then(resp=>{
                return resp.data;
            }).then(data=>{
                if(data.status == "ok") {
                    this.isLoading = false;
                    this.users = data.users;
                }
                else {
                    this.$router.push({
                        name: "no-permission"
                    });
                }
            }).catch(err=>{
                console.error(err.response.data);
            })
        },
        deleteUser(id,index) {

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
                    axios.post("/dashboard/api/delete-user",{
                        userId: id,
                    }).then(resp=>{
                        return resp.data;
                    }).then(data=>{
                        if(data.status == "ok") {
                            this.users.splice(index,1);
                            swal.fire("Success",data.msg,"success");
                        }
                    }).catch(err=>{
                        console.error(err.response.data);
                    })
                }
            })
            
        }
    },
    mounted() {
        this.getUserList();
    }
}
</script>

<style>

</style>