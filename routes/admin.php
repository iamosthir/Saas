<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group and "admin" prefix.
|
*/

// Guest routes (not authenticated as admin)
Route::middleware('admin.guest')->group(function () {
    Route::get('login', 'Admin\AdminAuthController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\AdminAuthController@login')->name('admin.login.submit');
});

// Authenticated admin routes
Route::middleware('admin.auth')->group(function () {
    // Logout
    Route::post('logout', 'Admin\AdminAuthController@logout')->name('admin.logout');

    // Dashboard
    Route::get('/', 'Admin\AdminDashboardController@index')->name('admin.dashboard');
    Route::get('/dashboard', 'Admin\AdminDashboardController@index');

    // Merchants Management
    Route::prefix('merchants')->name('admin.merchants.')->group(function () {
        Route::get('/', 'Admin\AdminMerchantController@index')->name('index');
        Route::get('/create', 'Admin\AdminMerchantController@create')->name('create');
        Route::post('/', 'Admin\AdminMerchantController@store')->name('store');
        Route::get('/{merchant}', 'Admin\AdminMerchantController@show')->name('show');
        Route::get('/{merchant}/edit', 'Admin\AdminMerchantController@edit')->name('edit');
        Route::put('/{merchant}', 'Admin\AdminMerchantController@update')->name('update');
        Route::delete('/{merchant}', 'Admin\AdminMerchantController@destroy')->name('destroy');
        Route::post('/{merchant}/toggle-status', 'Admin\AdminMerchantController@toggleStatus')->name('toggle-status');
    });

    // Users Management (within merchants)
    Route::prefix('merchants/{merchant}/users')->name('admin.users.')->group(function () {
        Route::get('/', 'Admin\AdminUserController@index')->name('index');
        Route::get('/create', 'Admin\AdminUserController@create')->name('create');
        Route::post('/', 'Admin\AdminUserController@store')->name('store');
        Route::get('/{user}/edit', 'Admin\AdminUserController@edit')->name('edit');
        Route::put('/{user}', 'Admin\AdminUserController@update')->name('update');
        Route::delete('/{user}', 'Admin\AdminUserController@destroy')->name('destroy');
    });

    // Subscription Management
    Route::prefix('subscriptions')->name('admin.subscriptions.')->group(function () {
        Route::get('/', 'Admin\AdminSubscriptionController@index')->name('index');
        Route::get('/plans', 'Admin\AdminSubscriptionController@plans')->name('plans');
        Route::post('/plans', 'Admin\AdminSubscriptionController@storePlan')->name('plans.store');
        Route::put('/plans/{plan}', 'Admin\AdminSubscriptionController@updatePlan')->name('plans.update');
        Route::delete('/plans/{plan}', 'Admin\AdminSubscriptionController@destroyPlan')->name('plans.destroy');

        // Merchant subscription actions
        Route::post('/{merchant}/extend', 'Admin\AdminSubscriptionController@extend')->name('extend');
        Route::post('/{merchant}/revoke', 'Admin\AdminSubscriptionController@revoke')->name('revoke');
        Route::put('/{merchant}/update-dates', 'Admin\AdminSubscriptionController@updateDates')->name('update-dates');
        Route::put('/{merchant}/change-plan', 'Admin\AdminSubscriptionController@changePlan')->name('change-plan');
    });

    // Admin Profile
    Route::get('/profile', 'Admin\AdminProfileController@edit')->name('admin.profile.edit');
    Route::put('/profile', 'Admin\AdminProfileController@update')->name('admin.profile.update');
    Route::put('/profile/password', 'Admin\AdminProfileController@updatePassword')->name('admin.profile.password');
});
