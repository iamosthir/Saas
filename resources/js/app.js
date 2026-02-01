import './bootstrap';

import Vue from "vue";

import VueProgressBar from "vue-progressbar";

import Form from 'vform';

import {
    Button,
    HasError,
    AlertError,
    AlertErrors,
    AlertSuccess
} from 'vform/src/components/bootstrap5';

import moment from "moment";

import Swal from "sweetalert2";

import toastr from "toastr";
import 'toastr/build/toastr.min.css';

import DashboardRouter from "./routes/dashboard";

//
window.Form = Form;
//
window.moment = moment;
//
window.swal = Swal;
//
window.toastr = toastr;
//
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('skeleton', require('./components/helper/CustomSkeleton.vue').default);
Vue.component("pagination",require("laravel-vue-pagination"));
// Form
Vue.component(Button.name, Button)
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertErrors.name, AlertErrors)
Vue.component(AlertSuccess.name, AlertSuccess)
//

import Multiselect from 'vue-multiselect'

Vue.component('multiselect', Multiselect)

Vue.use(VueProgressBar, {
    color: 'rgb(15, 111, 255)',
    failedColor: 'red',
    thickness: '5px'
});

DashboardRouter.beforeEach((to, from, next) => {
    document.title = to.meta.title || "Dashboard";
    Vue.prototype.$Progress.start();

    // Set page title and icon for the banner
    if(dashboard) {
        dashboard.pageTitle = to.meta.pageTitle || to.meta.title || 'لوحة التحكم';
        dashboard.pageIcon = to.meta.pageIcon || 'fas fa-tachometer-alt';
        dashboard.pageSubtitle = to.meta.pageSubtitle || '';
    }

    // Check if permission is defined in route meta
    if(!to.meta || !to.meta.permission)
    {
        next();
        return;
    }

    if(to.meta.permission.includes("all"))
    {
        next();
    }
    else
    {
        if(to.meta.permission.includes(window.role))
        {
            next();
        }
        else
        {
            next({
                name: 'no-permission'
            })
        }
    }
});

DashboardRouter.afterEach(() => {
    Vue.prototype.$Progress.finish();
});

if(document.getElementById("dashboard"))
{
    const dashboard = new Vue({
        el: "#dashboard",
        router: DashboardRouter,
        data() {
            return {
                printQuee: [],
                editinvoiceQuee: [],
                printCopy: 1,
                status:"",
                showSidebar2: false,
                showSidebar: false,
                settingData: {},
                pageTitle: 'لوحة التحكم',
                pageIcon: 'fas fa-tachometer-alt',
                pageSubtitle: ''
            }
        },
        methods: {
            async sendviapi() {
                if (this.editinvoiceQuee.length > 0) {
                    var string = JSON.stringify(this.editinvoiceQuee);
                    try {
                        let response = await axios.get(`/dashboard/send-invoiceapi/${string}`);
                        let data = response.data;
                        if (data.error === false && data.message === "Success") {
                            swal.fire("Success", "Operation successful.", "success");
                        } else {
                            swal.fire("Error", "Operation failed: " + (data.message || "Unknown error"), "error");
                        }
                    } catch (err) {
                        console.error(err);
                        let errorMessage = "An error occurred";
                        if (err.response && err.response.data && err.response.data.msg) {
                            errorMessage = err.response.data.msg;
                        }
                        swal.fire("Error", errorMessage, "error");
                    }
                }
            },
            printInvoice() {
                 if(this.printQuee.length > 0) {
                    var string = JSON.stringify(this.printQuee);
                    window.location.href = `/dashboard/print-invoice/${string}/copy/${this.printCopy}`;
                }
            },
            printInvoiceimages() {
                if(this.editinvoiceQuee.length > 0) {
                    var string = JSON.stringify(this.editinvoiceQuee);
                    window.location.href = `/dashboard/print-invoice-images/${string}/copy/${this.printCopy}`;
                }
            },
            editInvoiceimages() {
                if(this.editinvoiceQuee.length > 0) {
                    var string = JSON.stringify(this.editinvoiceQuee);
                    window.location.href = `/dashboard/print-invoice-images/${string}/copy/${this.printCopy}`;
                }
            },
            editinvoice() {
                if(this.editinvoiceQuee.length > 0) {
                    var string = JSON.stringify(this.editinvoiceQuee);
                    console.log(string);
                    window.location.href = `/dashboard/print-invoice/${string}/copy/${this.printCopy}`;
                }
            },
            changestatus() {
                if(this.editinvoiceQuee.length > 0) {
                    var string = JSON.stringify(this.editinvoiceQuee);
                   // var statusstring =
                   // console.log(this.status);
                   window.location.href = `/dashboard/changeStatus/${string}/changeto/${this.status}`;
                }
            },
            async getSiteSetting() {
                await axios.get("/dashboard/api/get-setting-data").then(resp=>{
                    return resp.data;
                }).then(data=>{
                    this.settingData = data;
                }).catch(err=>{
                    console.error(err.response.data);
                })
            }
        },
        mounted() {
            this.getSiteSetting();

            // Hide the loading screen with fade-out animation
            const loadingScreen = document.getElementById('app-loading-screen');
            if (loadingScreen) {
                loadingScreen.classList.add('fade-out');
                setTimeout(() => {
                    loadingScreen.remove();
                }, 500); // Match the animation duration
            }
        }
    })
}
