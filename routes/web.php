<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LeaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\LocationController;

Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->name('login');
    Route::get('/signup', 'signup')->name('signup');
    Route::post('/login', 'login')->name('login.submit');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(UserController::class)->group(function () {
    Route::post('/users', 'store')->name('users.store');
    Route::post('/users', 'signup')->name('users.signup');
});

Route::middleware(['auth.user'])->group(function () {
    Route::controller(IndexController::class)->group(function () {
        Route::get('/test', 'testForm')->name('testForm');
    });

    Route::controller(DashboardController::class)->group(function (){
        Route::get('/dashboard', 'dashboard')->name('dashboard');
    }); 

    Route::controller(AssetController::class)->group(function (){
        Route::get('/asset/list', 'index')->name('asset.list');
        Route::get('/asset/export', 'exportToExcel')->name('asset.export');
        Route::get('/asset/{id}/view', 'show')->name('asset.view');
        Route::get('/asset/add', 'create')->name('asset.add');
        Route::get('/asset/{id}/edit', 'edit')->name('asset.edit');
        Route::get('/maintenance', 'maintenance')->name('maintenance');
        Route::get('/asset/export', 'export')->name('asset.export');
        Route::get('/asset/{id}/qrCode', 'generateQrCode')->name('asset.qrCode');
        Route::post('/asset/add', 'store')->name('asset.add.store');
        Route::post('/asset/{id}', 'update')->name('asset.update');
        Route::post('/asset/import', 'import')->name('asset.import');
        Route::delete('/asset/{id}', 'destroy')->name('asset.delete');
    }); 

    Route::controller(InventoryController::class)->group(function (){
        Route::get('/inventory/list', 'index')->name('inventory.list');
        Route::get('/inventory/{id}/view', 'show')->name('inventory.view');
        Route::get('/inventory/stock/in', 'create')->name('inventory.stock.in');
        Route::get('/inventory/stock/in/{id}/edit', 'edit')->name('inventory.stock.in.edit');
        Route::get('/inventory/stock/out', 'createStockOut')->name('inventory.stock.out');
        Route::post('/inventory/stock/in', 'store')->name('inventory.stock.in.store');
        Route::post('/inventory/stock/in/{id}', 'update')->name('inventory.stock.in.update');
        Route::post('/inventory/stock/out', 'storeStockOut')->name('inventory.stock.out.store');
        Route::delete('/inventory/{id}', 'destroy')->name('inventory.delete');
    });

    Route::controller(SupplierController::class)->group(function (){
        Route::post('/supplier/add', 'add')->name('supplier.add');
        Route::post('/supplier/delete', 'delete')->name('supplier.delete');
    });

    // Route::controller(UserController::class)->group(function () {
    //     Route::post('/users', 'store')->name('users.store');
    // });

    Route::controller(LeaseController::class)->group(function () {
        Route::get('/lease', 'index')->name('lease.index');
        Route::get('/lease/create', 'create')->name('lease.create');
        Route::get('/lease/create/form', 'createForm')->name('lease.create.form');
        Route::post('/lease/create/form', 'createForm')->name('lease.create.form.add');
        Route::post('/lease', 'store')->name('lease.store');
    });
    
    Route::controller(ReportController::class)->group(function () {
        Route::get('/reports', 'index')->name('reports.index');
        Route::get('/stock/out/{id}/details', 'stockOutDetails')->name('stock.out.details');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/user/profile', 'index')->name('profile.index');
        Route::post('/user/profile/update', 'update')->name('profile.update');
    });

    Route::controller(AlertController::class)->group(function () {
        Route::get('/alerts', 'index')->name('alerts.index');
    });

    Route::controller(UnitController::class)->group(function () {
        Route::post('/unit/add', 'add')->name('unit.add');
    });

    Route::controller(SiteController::class)->group(function () {
        Route::post('/site/add', 'add')->name('site.add');
    });

    Route::controller(LocationController::class)->group(function () {
        Route::post('/location/add', 'add')->name('location.add');
    });

     Route::controller(CategoryController::class)->group(function (){
        Route::post('/category/add', 'add')->name('category.add');
    });

    Route::controller(DepartmentController::class)->group(function (){
        Route::post('/department/add', 'add')->name('department.add');
    });
});