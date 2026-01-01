import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const prefix = "/dashboard/";

// Import
import Dashboard from "../components/pages/Dashboard.vue";
import CreateInvoice from "../components/pages/CreateInvoice.vue";
import InvoiceList from "../components/pages/InvoiceList.vue";
import InvoiceDetails from "../components/pages/InvoiceDetails.vue";
import InvoiceListcancel from "../components/pages/InvoiceListcancel.vue";
import InvoiceListcomplate from "../components/pages/InvoiceListcomplate.vue";
import InvoiceListpadding from "../components/pages/InvoiceListpadding.vue";
import InvoiceListbarcode from "../components/pages/InvoiceListbarcode.vue";
import EditInvoice from "../components/pages/EditInvoice.vue";
import NoPermission from "../components/pages/NoPermission.vue";
import CreateUser from "../components/pages/user/Create.vue";
import ListUser from "../components/pages/user/List.vue";
import EditUser from "../components/pages/user/Edit.vue";
import MyProfile from "../components/pages/user/MyProfile.vue";
import MerchantProfile from "../components/pages/merchant/MerchantProfile.vue";
import ProductStock from "../components/pages/ProductStock.vue";


import AddProduct from "../components/pages/AddProduct.vue";
import ProductList from "../components/pages/ProductList.vue";
import EditProduct from "../components/pages/EditProduct.vue";

import ShippingList from "../components/pages/ShippingList.vue";
import PageList from "../components/pages/PageList.vue";

import SupplierList from "../components/pages/SupplierList.vue";
import SupplierPurchase from "../components/pages/SupplierPurchase.vue";

import Expense from "../components/pages/Expense.vue";
import Departments from "../components/pages/Departments.vue";

import ExpenseReport from "../components/pages/ExpenseReport.vue";

import SalesReport from "../components/pages/SalesReport.vue";
import PurchaseReport from "../components/pages/PurchaseReport.vue";
import ProfitLossReport from "../components/pages/ProfitLossReport.vue";

import CustomerList from "../components/pages/CustomerList.vue";
import CustomerSale from "../components/pages/CustomerSale.vue";
import WholeSale from "../components/pages/WholeSale.vue";

import Categories from "../components/pages/Categories.vue";
import Attributes from "../components/pages/Attributes.vue";

// Treasury & Financial Management
import Treasury from "../components/pages/Treasury.vue";
import CustomerPayments from "../components/pages/CustomerPayments.vue";
import QuickInvoice from "../components/pages/QuickInvoice.vue";

// Partner Management
import PartnerList from "../components/pages/PartnerList.vue";
import PartnerSettlements from "../components/pages/PartnerSettlements.vue";
import PartnerProfitBreakdown from "../components/pages/PartnerProfitBreakdown.vue";
//

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: prefix + "home",
            name: "dashboard",
            component: Dashboard,
            meta: {
                title: "Home - Dashboard",
                pageTitle: "لوحة التحكم",
                pageIcon: "fas fa-tachometer-alt",
                pageSubtitle: "مرحباً بك في نظام إدارة الأعمال المتكامل",
                permission: ["all"]
            }
        },
        {
            path: prefix + "create-invoice",
            name: "create-invoice",
            component: CreateInvoice,
            meta: {
                title: "Create new inovoice",
                permission: ["all"]
            }
        },
        {
            path: prefix + "invoice-list",
            name: "invoice-list",
            component: InvoiceList,
            meta: {
                title: "Invoice List",
                permission: ["all"]
            }
        },
        {
            path: prefix + "invoice/:id",
            name: "invoice.details",
            component: InvoiceDetails,
            meta: {
                title: "Invoice Details",
                permission: ["all"]
            }
        },
        {
            path: prefix + "invoice-list-cancel",
            name: "invoice-list-cancel",
            component: InvoiceListcancel,
            meta: {
                title: "Invoice List",
                permission: ["all"]
            }
        },
        {
            path: prefix + "invoice-list-complate",
            name: "invoice-list-complate",
            component: InvoiceListcomplate,
            meta: {
                title: "Invoice List",
                permission: ["all"]
            }
        },
        {
            path: prefix + "invoice-list-padding",
            name: "invoice-list-padding",
            component: InvoiceListpadding,
            meta: {
                title: "Invoice List",
                permission: ["all"]
            }
        },
        {
            path: prefix + "invoice-list-barcode",
            name: "invoice-list-barcode",
            component: InvoiceListbarcode,
            meta: {
                title: "Invoice List",
                permission: ["all"]
            }
        },
        {
            path: prefix + "edit/invoice/:id",
            name: "invoice.edit",
            component: EditInvoice,
            meta: {
                title: "Edit Invoice",
                permission: ["super","staff"],
            }
        },
        {
            path: prefix + "add-new-user",
            name: "user.add",
            component: CreateUser,
            meta: {
                title: "Create new user",
                permission: ["super"]
            }
        },

        {
            path: prefix + "user-and-staff-list",
            name: "user.list",
            component: ListUser,
            meta: {
                title: "User List",
                permission: ["super"]
            }
        },

        {
            path: prefix + "edit-user/:userid",
            name: "user.edit",
            component: EditUser,
            meta: {
                title: "Edit user",
                permission: ["super"]
            }
        },
        {
            path: prefix + "my-profile",
            name: "my-profile",
            component: MyProfile,
            meta: {
                title: "My Profile",
                permission: ["all"]
            }
        },
        {
            path: prefix + "merchant-profile",
            name: "merchant-profile",
            component: MerchantProfile,
            meta: {
                title: "Merchant Profile",
                permission: ["super"]
            }
        },


        {
            path: prefix + "access-denied",
            name: "no-permission",
            component: NoPermission,
            meta: {
                title: "Access Denied",
                permission: ["all"]
            }
        },
        {
            path: prefix + "product-stock",
            name: "product-stock",
            component: ProductStock,
            meta: {
                title: "Product Stock",
                permission: ["super",'staff']
            }
        },
        {
            path: prefix + "products",
            name: "products.add",
            component: AddProduct,
            meta: {
                title: "Add Product",
                permission: ["super",'staff']
            }
        },
        {
            path: prefix+"product-list",
            name: "product.list",
            component: ProductList,
            meta: {
                title: "Product List",
                permission: ['super','staff']
            }
        },
        {
            path: prefix+"edit-product/:productId",
            name: "product.edit",
            component: EditProduct,
            meta: {
                title: "Edit Product",
                permission: ['super'],
            }
        },
        {
            path: prefix + "shipping-list",
            name: "shipping.list",
            component: ShippingList,
            meta: {
                title: "Shipping List",
                permission: ['super'],
            }
        },
        {
            path: prefix + "page-list",
            name: "page.list",
            component: PageList,
            meta: {
                title: "Page List",
                permission: ['super'],
            }
        },
        {
            path: prefix + "customers-list",
            name: "customers.list",
            component: CustomerList,
            meta: {
                title: "Customer List",
                permission: ['super'],
            }
        },
        {
            path: prefix + "customers-sale/:customerid",
            name: "customer.create-sale",
            component: CustomerSale,
            meta: {
                title: "Customer Sale",
                permission: ['super'],
            }
        },
        {
            path: prefix + "supplier-list",
            name: "supplier.list",
            component: SupplierList,
            meta: {
                title: "Supplier List",
                permission: ['super'],
            }
        },
        {
            path: prefix + "supplier-purchase/:id",
            name: "supplier.purchase",
            component: SupplierPurchase,
            meta: {
                title: "Supplier Purchase",
                permission: ['super'],
            }
        },
        {
            path: prefix + "expense",
            name: "expense",
            component: Expense,
            meta: {
                title: "Expense",
                permission: ['super'],
            }
        },
        {
            path: prefix + "departments",
            name: "departments",
            component: Departments,
            meta: {
                title: "Departments",
                permission: ['super'],
            }
        },
        {
            path: prefix + "expenses/report",
            name: "expenses.report",
            component: ExpenseReport,
            meta: {
                title: "Expense Report",
                permission: ['super'],
            }
        },
        {
            path: prefix + "sales/report",
            name: "sales.report",
            component: SalesReport,
            meta: {
                title: "Sales Report",
                permission: ['super'],
            }
        },
        {
            path: prefix + "purchases/report",
            name: "purchases.report",
            component: PurchaseReport,
            meta: {
                title: "Purchase Report",
                permission: ['super'],
            }
        },
        {
            path: prefix + "profit-loss/report",
            name: "profitloss.report",
            component: ProfitLossReport,
            meta: {
                title: "Profit & Loss Report",
                permission: ['super'],
            }
        },
        {
            path: prefix+ "whole-sale",
            name: "whole-sale",
            component: WholeSale,
            meta: {
                title: "Whole Sale",
                permission: ['super'],
            }
        },
        {
            path: prefix + "categories",
            name: "categories",
            component: Categories,
            meta: {
                title: "Categories",
                pageTitle: "التصنيفات",
                pageIcon: "fas fa-tags",
                pageSubtitle: "إدارة تصنيفات المنتجات",
                permission: ['super'],
            }
        },
        {
            path: prefix + "attributes",
            name: "attributes",
            component: Attributes,
            meta: {
                title: "Attributes",
                pageTitle: "الخصائص",
                pageIcon: "fas fa-sliders-h",
                pageSubtitle: "إدارة خصائص المنتجات",
                permission: ['super'],
            }
        },
        // Treasury & Financial Management Routes
        {
            path: prefix + "treasury",
            name: "treasury",
            component: Treasury,
            meta: {
                title: "Treasury Management",
                pageTitle: "إدارة الخزينة",
                pageIcon: "fas fa-cash-register",
                pageSubtitle: "متابعة الإيرادات والمصروفات والرصيد",
                permission: ['all'],
            }
        },
        {
            path: prefix + "quick-invoice",
            name: "quick-invoice",
            component: QuickInvoice,
            meta: {
                title: "Quick Invoice",
                pageTitle: "فاتورة سريعة",
                pageIcon: "fas fa-bolt",
                pageSubtitle: "عرض ملخص العميل قبل إنشاء الفاتورة",
                permission: ['all'],
            }
        },
        {
            path: prefix + "customer-payments",
            name: "customer-payments",
            component: CustomerPayments,
            meta: {
                title: "Customer Bulk Payments",
                pageTitle: "تسديد دفعات الجملة",
                pageIcon: "fas fa-money-bill-wave",
                pageSubtitle: "تسديد عدة فواتير للعميل دفعة واحدة",
                permission: ['all'],
            }
        },
        // Partner Management Routes
        {
            path: prefix + "partners",
            name: "partner.list",
            component: PartnerList,
            meta: {
                title: "Partners",
                pageTitle: "الشركاء",
                pageIcon: "fas fa-handshake",
                pageSubtitle: "إدارة الشركاء وتقسيم الأرباح",
                permission: ['super'],
            }
        },
        {
            path: prefix + "partner-settlements",
            name: "partner.settlements",
            component: PartnerSettlements,
            meta: {
                title: "Partner Settlements",
                pageTitle: "تسويات الشركاء",
                pageIcon: "fas fa-money-bill-wave",
                pageSubtitle: "إدارة تسويات الشركاء",
                permission: ['super'],
            }
        },
        {
            path: prefix + "partner-profit-breakdown/:year/:month",
            name: "partner.profit-breakdown",
            component: PartnerProfitBreakdown,
            meta: {
                title: "Profit Breakdown",
                pageTitle: "تحليل الأرباح",
                pageIcon: "fas fa-chart-pie",
                pageSubtitle: "تحليل مفصل للأرباح",
                permission: ['super'],
            }
        }
    ]
})

export default router;
