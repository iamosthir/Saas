<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get("/tesss","OrderController@tesss");



Route::get("/tesssbackup","OrderController@tesssbackup");



// Route::get("/super",function(){
//     $role = Role::create(["name" => "Super Admin"]);
//     $user = User::find(1);
//     $user->assignRole($role);
// });
Route::get("/resetorder","OrderController@reset");

Route::get("/", "LandingController@index")->name("home");

Route::get("/login", "Auth\LoginController@loginPage")->name("login");
Route::post("/login", "Auth\LoginController@login");

Route::get("/register-merchant/{planId}", "MerchantRegistrationController@showRegistrationForm")->name("merchant.register.form");
Route::post("/register-merchant", "MerchantRegistrationController@register")->name("merchant.register");

// Customer Portal Routes
Route::prefix('customer')->name('customer.')->group(function() {
    // Guest routes (not authenticated)
    Route::middleware('customer.guest')->group(function() {
        Route::get('login', 'Customer\CustomerAuthController@showLoginForm')->name('login');
        Route::post('login', 'Customer\CustomerAuthController@login');
    });

    // Authenticated customer routes
    Route::middleware('customer.auth')->group(function() {
        Route::post('logout', 'Customer\CustomerAuthController@logout')->name('logout');
        Route::get('dashboard', 'Customer\CustomerDashboardController@index')->name('dashboard');
        Route::get('invoices', 'Customer\CustomerInvoiceController@index')->name('invoices');
        Route::get('invoices/{id}', 'Customer\CustomerInvoiceController@show')->name('invoices.show');
    });
});

Route::get("/renew", function() {
    return view('renew');
})->middleware('auth')->name('subscription.renew');

Route::group(["prefix" => "dashboard", "middleware" => "auth"],function(){

    // Dashboard
    Route::get("/send-invoiceapi/{invoiceData}","OrderController@invoiceapi");
    Route::get("/changeStatus/{invoiceData}/changeto/{status}","OrderController@changeStatus");
    Route::get("/print-invoice/{invoiceData}/copy/{copy}","OrderController@print");
    Route::get("/print-invoice-images/{invoiceData}/copy/{copy}","OrderController@printimages");
    Route::get("/del-invoice","OrderController@delete");

    Route::get("/print-statement","OrderController@printStatementview");
    Route::get("/print-statements","OrderController@printStatement");

    Route::get("/print-salesinvoice/{id}","CustomerSaleInvoiceController@invoice");

    Route::get("/print-supplierinvoice/{id}","PurchaseInvoiceController@invoice");

    Route::get("/print-new-invoice/{id}","InvoiceController@print");
    // Barcode
    Route::get("/product-barcode/{id}","ProductController@barcode");

    Route::any("{any}", "DashboardController@dashboard")->where("any", "^(?!api/.*$).*$");
    // End

    // Api
    Route::group(["prefix" => "api"],function(){



        Route::post("/create-invoice","OrderController@create");

        Route::post("/update-invoice","OrderController@update");

        Route::post("/update-order-status","OrderController@updateStatus");

        Route::post("/remove-order-product","OrderController@removeOrderProduct");

        Route::get("/get-invoice-list","OrderController@getList");
        Route::get("/get-invoice-list-padding","OrderController@getListpadding");
        Route::get("/get-invoice-list-completed","OrderController@getListcompleted");
        Route::get("/get-invoice-list-canceled","OrderController@getListcanceled");
        Route::get("/get-invoice-list-barcode","OrderController@barcode");
        Route::get("/search-order-by-id","OrderController@searchById");

        Route::get("/get-invoice-data","OrderController@invoiceData");

        Route::get("/check-phone-number","OrderController@checkPhone");

        Route::get("/check-customer","OrderController@checkCustomer");

        // New Invoice System
        Route::post("/invoices","InvoiceController@store");
        Route::get("/invoices","InvoiceController@getList");
        Route::get("/invoices/{id}","InvoiceController@show");
        Route::get("/customers","InvoiceController@getCustomers");
        Route::post("/invoices/{id}/mark-paid","InvoiceController@markAsPaid");
        Route::post("/installments/{id}/pay","InvoiceController@payInstallment");

        // User
        Route::post("/add-user","UserController@add");

        Route::get("/get-user-list","UserController@getList");

        Route::get("/get-user-details","UserController@getUserDetails");

        Route::post("/update-user","UserController@update");

        Route::post("/delete-user","UserController@delete");

        Route::post("/get-my-profile","UserController@getProfile");

        // Merchant Profile
        Route::get("/get-merchant-profile","MerchantProfileController@show");
        Route::post("/update-merchant-profile","MerchantProfileController@update");
        Route::post("/remove-merchant-logo","MerchantProfileController@removeLogo");

        // Site Setting
        Route::get("/get-setting-data","SiteSettignController@getData");

        Route::post('/changephone',"SiteSettignController@changephone");

        Route::post('/add-stock',"SiteSettignController@addStock");

        Route::get("/product-list","ProductController@list");

        Route::get('/get-product-variations',"ProductController@getProductVariation");

        Route::post('/product-data-process',"ProductController@process");

        Route::post('/delete-data-process',"ProductController@processdelete");

        Route::get('/get-city-list',"CityController@list");

        Route::get('/get-page-list',"PageController@list");

        Route::get('/get-shipping-list',"ShippingController@list");

        Route::post("/store-product","ProductController@create");

        Route::post("/update-product","ProductController@update");

        Route::get('/get-product-list',"ProductController@getList");

        Route::post("/delete-product","ProductController@delete");

        Route::get("/get-product-details","ProductController@getDetails");

        Route::post("/delete-variant","ProductController@deleteVariation");

        Route::post("/update-variant-stock","ProductController@updateVariantQuantity");

        Route::post("/update-variation","ProductController@updateVariation");

        // Shipping crud
        Route::post("/store-shipping","ShippingController@store");

        Route::get("/list-shipping-crud","ShippingController@crudList");

        Route::post('/delete-shipping',"ShippingController@delete");

        Route::post("/update-shipping","ShippingController@update");
        // End

        // page crud
        Route::post("/store-page","PageController@store");

        Route::get("/list-page-crud","PageController@crudList");

        Route::post('/delete-page',"PageController@delete");

        Route::post("/update-page","PageController@update");
        // End


        // suppliers
        Route::get('/supplier-list','SuppliersController@list');
        Route::post('/supplier-store','SuppliersController@store');
        Route::post('/supplier-update','SuppliersController@update');
        Route::post('/supplier-delete','SuppliersController@delete');
        Route::post("/create-supplier-invoice","PurchaseInvoiceController@store");

        Route::post("/purchase-payments","PurchasePaymentsController@storePayment");

        Route::post("/store-sale-payment","CustomerSalePaymentsController@storePayment");
        // suppliers

        // Departments
        Route::get('/departments', 'DepartmentController@index');
        Route::post('/department-store', 'DepartmentController@store');
        Route::post('/department-update', 'DepartmentController@update');
        Route::post('/department-delete', 'DepartmentController@destroy');
        // end

        // Expense
        Route::post('/expense-store', 'ExpenseController@store');
        Route::get('/expenses', 'ExpenseController@index');
        // End

        // Sales
        Route::get('/sales', 'CustomerSaleInvoiceController@index');
        Route::get('/purchase', 'PurchaseInvoiceController@index');
        // End

        // Customers
        Route::get('/customer-list', 'CustomerController@index');
        Route::post('/customer-store', 'CustomerController@store');
        Route::post('/customer-update', 'CustomerController@update');
        Route::post('/customer-delete', 'CustomerController@delete');

        Route::post("/create-customer-invoice","CustomerSaleInvoiceController@store");

        // End

        // Categories
        Route::get('/categories', 'CategoryController@index');
        Route::get('/categories-tree', 'CategoryController@tree');
        Route::post('/category-store', 'CategoryController@store');
        Route::post('/category-update', 'CategoryController@update');
        Route::post('/category-delete', 'CategoryController@destroy');
        // End

        // Attributes
        Route::get('/attributes', 'AttributeController@index');
        Route::post('/attribute-store', 'AttributeController@store');
        Route::post('/attribute-update', 'AttributeController@update');
        Route::post('/attribute-delete', 'AttributeController@destroy');
        // End

        Route::get("/profit-loss","PurchaseInvoiceController@profitLoss");

        Route::get("/sales-invoice/{id}","CustomerSaleInvoiceController@invoice");

        // Partners
        Route::get('/partners', 'PartnerController@index');
        Route::post('/partner-store', 'PartnerController@store');
        Route::get('/partner-details', 'PartnerController@show');
        Route::post('/partner-update', 'PartnerController@update');
        Route::post('/partner-delete', 'PartnerController@destroy');
        Route::get('/partner-settlements/{id}', 'PartnerController@settlements');
        Route::post('/partner-settlements-generate', 'PartnerController@generateSettlements');
        Route::post('/partner-settlement-mark-paid/{id}', 'PartnerController@markSettlementPaid');
        Route::get('/partner-all-settlements', 'PartnerController@allSettlements');
        Route::get('/partner-profit-breakdown/{year}/{month}', 'PartnerController@profitBreakdown');
        // End

        // Treasury Management
        Route::get('/treasury', 'TreasuryController@index');
        Route::get('/treasury/transactions', 'TreasuryController@transactions');
        Route::get('/treasury/report', 'TreasuryController@report');
        Route::get('/treasury/export', 'TreasuryController@export');
        // End

        // Customer Bulk Payments
        Route::get('/customer-payments/outstanding/{customer}', 'CustomerPaymentController@getOutstandingInvoices');
        Route::post('/customer-payments/bulk', 'CustomerPaymentController@bulkPayment');
        // End

        // Quick Invoice
        Route::get('/quick-invoice/customer/{customer}/summary', 'QuickInvoiceController@getCustomerSummary');
        // End

        // Supplier Dropdown
        Route::get('/suppliers/dropdown', 'SupplierController@dropdown');
        Route::get('/suppliers', 'SupplierController@index');
        Route::post('/suppliers/store', 'SupplierController@store');
        Route::post('/suppliers/{id}/update', 'SupplierController@update');
        Route::delete('/suppliers/{id}', 'SupplierController@delete');
        // End

    });
    // End

});

Auth::routes(['login' => false]);
