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
import InvoiceTemplateManager from "../components/pages/InvoiceTemplateManager.vue";
import InvoiceTemplateForm from "../components/pages/InvoiceTemplateForm.vue";
import InvoiceTemplateBuilder from "../components/pages/InvoiceTemplateBuilder.vue";
import CustomInvoiceCreate from "../components/pages/CustomInvoiceCreate.vue";
import CustomInvoicePrint from "../components/pages/CustomInvoicePrint.vue";
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

// Contract Management
import ContractTemplateManager from "../components/pages/contracts/ContractTemplateManager.vue";
import ContractTemplateForm from "../components/pages/contracts/ContractTemplateForm.vue";
import ContractCreate from "../components/pages/contracts/ContractCreate.vue";
import ContractPrint from "../components/pages/contracts/ContractPrint.vue";
import ContractList from "../components/pages/contracts/ContractList.vue";

// POS System
const PosMain = () => import("../components/pages/pos/PosMain.vue");
const PosSettings = () => import("../components/pages/pos/PosSettings.vue");
const PosSalesHistory = () => import("../components/pages/pos/PosSalesHistory.vue");

// Manufacturing System
const ManufacturingDashboard = () => import("../components/pages/manufacturing/ManufacturingDashboard.vue");
const RawMaterialList = () => import("../components/pages/manufacturing/RawMaterialList.vue");
const RawMaterialForm = () => import("../components/pages/manufacturing/RawMaterialForm.vue");
const RecipeList = () => import("../components/pages/manufacturing/RecipeList.vue");
const RecipeForm = () => import("../components/pages/manufacturing/RecipeForm.vue");
const ProductionList = () => import("../components/pages/manufacturing/ProductionList.vue");
const ProductionCreate = () => import("../components/pages/manufacturing/ProductionCreate.vue");

// Employee Management
const EmployeeList = () => import("../components/pages/employees/EmployeeList.vue");
const SalaryList = () => import("../components/pages/employees/SalaryList.vue");
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
            path: prefix + "invoice-templates",
            name: "invoice-templates",
            component: InvoiceTemplateManager,
            meta: {
                title: "Invoice Templates",
                pageTitle: "قوالب الفواتير",
                pageIcon: "fas fa-file-alt",
                pageSubtitle: "إدارة قوالب الفواتير المخصصة",
                permission: ["all"]
            }
        },
        {
            path: prefix + "invoice-templates/create",
            name: "invoice-template-create",
            component: InvoiceTemplateForm,
            meta: {
                title: "Create Invoice Template",
                pageTitle: "إنشاء قالب جديد",
                pageIcon: "fas fa-plus-circle",
                pageSubtitle: "إنشاء قالب فاتورة مخصص",
                permission: ["all"]
            }
        },
        {
            path: prefix + "invoice-templates/:id/edit",
            name: "invoice-template-edit",
            component: InvoiceTemplateForm,
            meta: {
                title: "Edit Invoice Template",
                pageTitle: "تعديل القالب",
                pageIcon: "fas fa-edit",
                pageSubtitle: "تعديل قالب الفاتورة",
                permission: ["all"]
            }
        },
        {
            path: prefix + "invoice-templates/builder/:id?",
            name: "invoice-template-builder",
            component: InvoiceTemplateBuilder,
            meta: {
                title: "Invoice Template Builder",
                pageTitle: "بناء قالب الفاتورة",
                pageIcon: "fas fa-tools",
                pageSubtitle: "تصميم وتخصيص قالب الفاتورة",
                permission: ["all"]
            }
        },
        {
            path: prefix + "invoices/custom/create",
            name: "custom-invoice-create",
            component: CustomInvoiceCreate,
            meta: {
                title: "Create Custom Invoice",
                pageTitle: "إنشاء فاتورة مخصصة",
                pageIcon: "fas fa-file-invoice",
                pageSubtitle: "إنشاء فاتورة باستخدام القوالب",
                permission: ["all"]
            }
        },
        {
            path: prefix + "invoices/custom/:id/print",
            name: "custom-invoice-print",
            component: CustomInvoicePrint,
            meta: {
                title: "Print Custom Invoice",
                pageTitle: "طباعة الفاتورة",
                pageIcon: "fas fa-print",
                pageSubtitle: "عرض وطباعة الفاتورة المخصصة",
                permission: ["all"]
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
        },
        // POS System Routes
        {
            path: prefix + "pos",
            name: "pos",
            component: PosMain,
            meta: {
                title: "Point of Sale",
                pageTitle: "نقطة البيع",
                pageIcon: "fas fa-cash-register",
                pageSubtitle: "نظام نقطة البيع السريع",
                permission: ['all'],
            }
        },
        {
            path: prefix + "pos/settings",
            name: "pos.settings",
            component: PosSettings,
            meta: {
                title: "POS Settings",
                pageTitle: "إعدادات نقطة البيع",
                pageIcon: "fas fa-cog",
                pageSubtitle: "إعدادات وتهيئة نظام نقطة البيع",
                permission: ['super'],
            }
        },
        {
            path: prefix + "pos/history",
            name: "pos.history",
            component: PosSalesHistory,
            meta: {
                title: "POS Sales History",
                pageTitle: "سجل المبيعات",
                pageIcon: "fas fa-history",
                pageSubtitle: "عرض سجل مبيعات نقطة البيع",
                permission: ['all'],
            }
        },
        // Contract Management Routes
        {
            path: prefix + "contracts",
            name: "contracts.list",
            component: ContractList,
            meta: {
                title: "Contracts",
                pageTitle: "العقود",
                pageIcon: "fas fa-file-contract",
                pageSubtitle: "إدارة العقود",
                permission: ["all"]
            }
        },
        {
            path: prefix + "contracts/create",
            name: "contract-create",
            component: ContractCreate,
            meta: {
                title: "Create Contract",
                pageTitle: "إنشاء عقد جديد",
                pageIcon: "fas fa-plus-circle",
                pageSubtitle: "إنشاء عقد من قالب",
                permission: ["all"]
            }
        },
        {
            path: prefix + "contracts/create/:template_id",
            name: "contract-create-from-template",
            component: ContractCreate,
            meta: {
                title: "Create Contract",
                pageTitle: "إنشاء عقد",
                pageIcon: "fas fa-plus-circle",
                permission: ["all"]
            }
        },
        // {
        //     path: prefix + "contracts/:id/print",
        //     name: "contract-print",
        //     component: ContractPrint,
        //     meta: {
        //         title: "Print Contract",
        //         pageTitle: "طباعة العقد",
        //         pageIcon: "fas fa-print",
        //         permission: ["all"]
        //     }
        // },
        {
            path: prefix + "contract-templates",
            name: "contract-templates",
            component: ContractTemplateManager,
            meta: {
                title: "Contract Templates",
                pageTitle: "قوالب العقود",
                pageIcon: "fas fa-file-alt",
                pageSubtitle: "إدارة قوالب العقود",
                permission: ["all"]
            }
        },
        {
            path: prefix + "contract-templates/create",
            name: "contract-template-create",
            component: ContractTemplateForm,
            meta: {
                title: "Create Template",
                pageTitle: "إنشاء قالب عقد",
                pageIcon: "fas fa-plus-circle",
                permission: ["all"]
            }
        },
        {
            path: prefix + "contract-templates/:id/edit",
            name: "contract-template-edit",
            component: ContractTemplateForm,
            meta: {
                title: "Edit Template",
                pageTitle: "تعديل قالب العقد",
                pageIcon: "fas fa-edit",
                permission: ["all"]
            }
        },
        // Manufacturing System Routes
        {
            path: prefix + "manufacturing",
            name: "manufacturing.dashboard",
            component: ManufacturingDashboard,
            meta: {
                title: "Manufacturing",
                pageTitle: "التصنيع",
                pageIcon: "fas fa-industry",
                pageSubtitle: "نظام إدارة التصنيع والإنتاج",
                permission: ["all"]
            }
        },
        {
            path: prefix + "manufacturing/raw-materials",
            name: "manufacturing.raw-materials",
            component: RawMaterialList,
            meta: {
                title: "Raw Materials",
                pageTitle: "المواد الخام",
                pageIcon: "fas fa-cubes",
                pageSubtitle: "إدارة المواد الخام والمخزون",
                permission: ["all"]
            }
        },
        {
            path: prefix + "manufacturing/raw-materials/create",
            name: "manufacturing.raw-materials.create",
            component: RawMaterialForm,
            meta: {
                title: "Add Raw Material",
                pageTitle: "إضافة مادة خام",
                pageIcon: "fas fa-plus-circle",
                pageSubtitle: "إضافة مادة خام جديدة",
                permission: ["all"]
            }
        },
        {
            path: prefix + "manufacturing/raw-materials/:id/edit",
            name: "manufacturing.raw-materials.edit",
            component: RawMaterialForm,
            meta: {
                title: "Edit Raw Material",
                pageTitle: "تعديل مادة خام",
                pageIcon: "fas fa-edit",
                pageSubtitle: "تعديل بيانات المادة الخام",
                permission: ["all"]
            }
        },
        {
            path: prefix + "manufacturing/recipes",
            name: "manufacturing.recipes",
            component: RecipeList,
            meta: {
                title: "Recipes",
                pageTitle: "الوصفات",
                pageIcon: "fas fa-clipboard-list",
                pageSubtitle: "إدارة وصفات الإنتاج",
                permission: ["all"]
            }
        },
        {
            path: prefix + "manufacturing/recipes/create",
            name: "manufacturing.recipes.create",
            component: RecipeForm,
            meta: {
                title: "Create Recipe",
                pageTitle: "إنشاء وصفة",
                pageIcon: "fas fa-plus-circle",
                pageSubtitle: "إنشاء وصفة إنتاج جديدة",
                permission: ["all"]
            }
        },
        {
            path: prefix + "manufacturing/recipes/:id/edit",
            name: "manufacturing.recipes.edit",
            component: RecipeForm,
            meta: {
                title: "Edit Recipe",
                pageTitle: "تعديل الوصفة",
                pageIcon: "fas fa-edit",
                pageSubtitle: "تعديل وصفة الإنتاج",
                permission: ["all"]
            }
        },
        {
            path: prefix + "manufacturing/production",
            name: "manufacturing.production",
            component: ProductionList,
            meta: {
                title: "Production Batches",
                pageTitle: "دفعات الإنتاج",
                pageIcon: "fas fa-cogs",
                pageSubtitle: "إدارة دفعات الإنتاج",
                permission: ["all"]
            }
        },
        {
            path: prefix + "manufacturing/production/create",
            name: "manufacturing.production.create",
            component: ProductionCreate,
            meta: {
                title: "Create Production Batch",
                pageTitle: "إنشاء دفعة إنتاج",
                pageIcon: "fas fa-plus-circle",
                pageSubtitle: "إنشاء دفعة إنتاج جديدة",
                permission: ["all"]
            }
        },
        // Employee Management Routes
        {
            path: prefix + "employees",
            name: "employees.list",
            component: EmployeeList,
            meta: {
                title: "Employees",
                pageTitle: "الموظفين",
                pageIcon: "fas fa-users",
                pageSubtitle: "إدارة الموظفين",
                permission: ["super"]
            }
        },
        {
            path: prefix + "employees/salaries",
            name: "employees.salaries",
            component: SalaryList,
            meta: {
                title: "Salary Management",
                pageTitle: "إدارة الرواتب",
                pageIcon: "fas fa-money-bill-wave",
                pageSubtitle: "جدول رواتب الموظفين",
                permission: ["super"]
            }
        }

    ]
})

export default router;
