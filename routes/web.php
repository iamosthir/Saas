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


    // Print contracts (requires contracts permission)
    Route::get("/contracts/{id}/print","ContractController@print")->middleware('merchant.permission:contracts');

    Route::any("{any}", "DashboardController@dashboard")->where("any", "^(?!api/.*$).*$");
    // End

    // Api
    Route::group(["prefix" => "api"],function(){

        // Get merchant permissions
        Route::get("/get-merchant-permissions","DashboardController@getMerchantPermissions");

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
        Route::get("/invoices/{id}/activity-logs","InvoiceController@getActivityLogs");
        Route::get("/customers","InvoiceController@getCustomers");
        Route::post("/invoices/{id}/mark-paid","InvoiceController@markAsPaid");
        Route::post("/installments/{id}/pay","InvoiceController@payInstallment");
        Route::get("/invoices/templates/list","InvoiceController@getTemplates");

        // Invoice Template Management
        Route::get("/invoice-templates","InvoiceTemplateController@index");
        Route::post("/invoice-templates","InvoiceTemplateController@store");
        Route::get("/invoice-templates/{id}","InvoiceTemplateController@show");
        Route::put("/invoice-templates/{id}","InvoiceTemplateController@update");
        Route::delete("/invoice-templates/{id}","InvoiceTemplateController@destroy");
        Route::post("/invoice-templates/{id}/toggle-active","InvoiceTemplateController@toggleActive");

        // Contract Template Management (requires contracts permission)
        Route::middleware('merchant.permission:contracts')->group(function() {
            Route::prefix('contract-templates')->group(function() {
                Route::get('/', 'ContractTemplateController@index');
                Route::post('/', 'ContractTemplateController@store');
                Route::get('/{id}', 'ContractTemplateController@show');
                Route::put('/{id}', 'ContractTemplateController@update');
                Route::delete('/{id}', 'ContractTemplateController@destroy');
                Route::post('/{id}/toggle-active', 'ContractTemplateController@toggleActive');
            });

            // Contract Management
            Route::prefix('contracts')->group(function() {
                Route::get('/', 'ContractController@index');
                Route::post('/', 'ContractController@store');
                Route::get('/{id}', 'ContractController@show');
                Route::put('/{id}', 'ContractController@update');
                Route::delete('/{id}', 'ContractController@destroy');
                Route::patch('/{id}/status', 'ContractController@updateStatus');
            });
        });

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

        // POS System Routes (requires pos permission)
        Route::group(['prefix' => 'pos', 'namespace' => 'Pos', 'middleware' => 'merchant.permission:pos'], function() {
            // Initialize
            Route::get('/initialize', 'PosController@initialize');

            // Products
            Route::get('/products/search', 'PosProductController@search');
            Route::get('/products/popular', 'PosProductController@popular');
            Route::get('/products/barcode/{barcode}', 'PosProductController@scanBarcode');
            Route::get('/products/category/{categoryId}', 'PosProductController@byCategory');
            Route::get('/products/{id}', 'PosProductController@show');
            Route::get('/products/{id}/stock', 'PosProductController@checkStock');

            // Sales
            Route::get('/sales', 'PosSaleController@index');
            Route::post('/sales', 'PosSaleController@store');
            Route::get('/sales/parked', 'PosSaleController@getParkedSales');
            Route::get('/sales/drafts', 'PosSaleController@getDrafts');
            Route::get('/sales/{id}', 'PosSaleController@show');
            Route::put('/sales/{id}', 'PosSaleController@update');
            Route::delete('/sales/{id}', 'PosSaleController@destroy');
            Route::post('/sales/{id}/items', 'PosSaleController@addItem');
            Route::put('/sales/{saleId}/items/{itemId}', 'PosSaleController@updateItem');
            Route::delete('/sales/{saleId}/items/{itemId}', 'PosSaleController@removeItem');
            Route::post('/sales/{id}/complete', 'PosSaleController@complete');
            Route::post('/sales/{id}/park', 'PosSaleController@park');
            Route::post('/sales/{id}/unpark', 'PosSaleController@unpark');
            Route::post('/sales/{id}/void', 'PosSaleController@void');

            // Refunds
            Route::get('/sales/{id}/refundable-items', 'PosSaleController@getRefundableItems');
            Route::post('/sales/{id}/refund-full', 'PosSaleController@refundFull');
            Route::post('/sales/{id}/refund-partial', 'PosSaleController@refundPartial');

            // Payments
            Route::post('/payments', 'PosPaymentController@process');
            Route::get('/payments/{saleId}/summary', 'PosPaymentController@summary');
            Route::get('/payments/{saleId}/quick-amounts', 'PosPaymentController@quickAmounts');

            // Customers
            Route::get('/customers', 'PosCustomerController@index');
            Route::post('/customers', 'PosCustomerController@store');
            Route::get('/customers/find-by-phone', 'PosCustomerController@findByPhone');
            Route::get('/customers/{id}', 'PosCustomerController@show');
            Route::get('/customers/{id}/history', 'PosCustomerController@purchaseHistory');

            // Inventory
            Route::post('/inventory/adjust', 'PosInventoryController@adjust');
            Route::get('/inventory/movements', 'PosInventoryController@movements');
            Route::get('/inventory/low-stock', 'PosInventoryController@lowStock');
            Route::get('/inventory/{productId}/stock', 'PosInventoryController@stockLevel');

            // Settings
            Route::get('/settings', 'PosSettingsController@show');
            Route::put('/settings', 'PosSettingsController@update');
            Route::post('/settings/reset', 'PosSettingsController@reset');

            // Sync (Offline)
            Route::post('/sync/upload', 'PosSyncController@upload');
            Route::get('/sync/pending', 'PosSyncController@pending');
            Route::post('/sync/process', 'PosSyncController@process');
            Route::post('/sync/retry', 'PosSyncController@retry');
            Route::get('/sync/status', 'PosSyncController@status');

            // Print
            Route::get('/print/{saleId}/receipt', 'PosPrintController@receipt');
            Route::get('/print/{saleId}/escpos', 'PosPrintController@escpos');
            Route::get('/print/{saleId}/html', 'PosPrintController@html');
            Route::get('/print/{saleId}', 'PosPrintController@print');
            Route::post('/print/{saleId}/whatsapp', 'PosPrintController@sendWhatsApp');
            Route::get('/print/whatsapp/status', 'PosPrintController@whatsappStatus');
        });
        // End POS

    });
    // End

});

Auth::routes(['login' => false]);
