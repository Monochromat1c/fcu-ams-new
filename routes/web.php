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
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LeaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ActivityController;

Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->name('login')->middleware('auth.redirect');
    // Route::get('/', 'asdf')->name('login');
    Route::get('/signup', 'signup')->name('signup');
    Route::post('/login', 'login')->name('login.submit');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(UserController::class)->group(function () {
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
        Route::get('/search', 'search')->name('asset.search');
        Route::get('/disposed', 'disposed')->name('asset.disposed');
        Route::post('/asset/add', 'store')->name('asset.add.store');
        Route::post('/asset/{id}', 'update')->name('asset.update');
        Route::post('/asset/import', 'import')->name('asset.import');
        Route::post('/asset/{id}/update-condition', 'updateCondition')->name('asset.update.condition');
        Route::delete('/asset/{id}', 'destroy')->name('asset.destroy');
        Route::put('/asset/{id}/return', 'return')->name('asset.return');
    }); 

    Route::controller(InventoryController::class)->group(function (){
        Route::get('/inventory/list', 'index')->name('inventory.list');
        Route::get('/inventory/{id}/view', 'show')->name('inventory.view');
        Route::get('/inventory/stock/in', 'create')->name('inventory.stock.in');
        Route::get('/inventory/stock/in/{id}/edit', 'edit')->name('inventory.stock.in.edit');
        Route::get('/inventory/stock/out', 'createStockOut')->name('inventory.stock.out');
        Route::get('/inventory/low-stock', 'lowStock')->name('inventory.low.stock');
        Route::get('/inventory/out-of-stock', 'outOfStock')->name('inventory.out.of.stock');
        Route::get('/inventories/export', 'export')->name('inventories.export');
        Route::get('/inventory/search-items', 'searchItems')->name('inventory.search.items');
        Route::get('/inventory/search', 'search')->name('inventory.search');
        Route::post('/inventory/stock/in', 'store')->name('inventory.stock.in.store');
        Route::post('/inventory/stock/in/{id}', 'update')->name('inventory.stock.in.update');
        Route::post('/inventory/stock/out', 'storeStockOut')->name('inventory.stock.out.store');
        Route::post('/inventory/import', 'import')->name('inventory.import');
        Route::delete('/inventory/{id}', 'destroy')->name('inventory.destroy');
        Route::get('/inventory/supply-request', 'showSupplyRequest')->name('inventory.supply.request');
        Route::post('/inventory/supply-request', 'storeSupplyRequest')->name('inventory.supply.request.store');
        Route::get('/inventory/supply-request/{request_group_id}', 'showSupplyRequestDetails')->name('inventory.supply-request.details');
        Route::get('/inventory/supply-request/{request_group_id}/print', 'printSupplyRequest')->name('inventory.supply.request.print');
        Route::post('/inventory/supply-request/{request_group_id}/approve', 'approveSupplyRequest')->name('inventory.supply-request.approve');
        Route::post('/inventory/supply-request/{request_group_id}/reject', 'rejectSupplyRequest')->name('inventory.supply-request.reject');
        Route::put('/inventory/supply-request/{request_group_id}/update', 'updateSupplyRequest')->name('inventory.supply-request.update');
        Route::get('/inventory/my-requests', 'myRequests')->name('inventory.my.requests');
        Route::post('/inventory/supply-request/{request_group_id}/cancel', 'cancelSupplyRequest')->name('inventory.supply-request.cancel');
        Route::get('/request/notifications', 'notifications')->name('request.notifications');
    });

    Route::controller(RequestController::class)->group(function () {
        Route::get('/requests', 'index')->name('requests.index');
        Route::delete('/requests/{request_group_id}', 'destroy')->name('requests.destroy');
        Route::post('/inventory/request-item', 'storeRequestedItem')->name('inventory.request.item.store');
        Route::get('/inventory/brands', 'getBrands')->name('inventory.brands');
        Route::get('/inventory/units', 'getUnits')->name('inventory.units');
        Route::get('/inventory/suppliers', 'getSuppliers')->name('inventory.suppliers');
    });

    // Route::controller(UserController::class)->group(function () {
    //     Route::post('/users', 'store')->name('users.store');
    // });

    Route::controller(LeaseController::class)->group(function () {
        Route::get('/lease', 'index')->name('lease.index');
        Route::get('/lease/create', 'create')->name('lease.create');
        Route::get('/lease/create/form', 'createForm')->name('lease.create.form');
        Route::get('/lease/{id}', 'show')->name('lease.show');
        Route::post('/lease/create/form', 'createForm')->name('lease.create.form.add');
        Route::post('/lease', 'store')->name('lease.store');
        Route::post('/lease/{lease}/end', 'endLease')->name('lease.end');
    });
    
    Route::controller(ReportController::class)->group(function () {
        Route::get('/reports', 'index')->name('reports.index');
        Route::get('/stock/out/{id}/details', 'stockOutDetails')->name('stock.out.details');
        Route::get('/purchase-order-details/{id}', 'purchaseOrderDetails')->name('purchase-order-details');
        Route::get('/reports/print', 'printReport')->name('reports.print');
        Route::get('/reports/print-assets', 'printAssetsReport')->name('reports.print-assets');
        Route::get('/reports/print-assigned', 'printAssignedAssets')->name('reports.print-assigned');
        Route::get('/reports/print-approved-request/{request_group_id}', 'printApprovedRequest')->name('reports.print-approved-request');
        Route::get('/reports/export-inventory', 'exportInventory')->name('reports.export-inventory');
        Route::get('/reports/export-assets', 'exportAssets')->name('reports.export-assets');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/user/profile', 'index')->name('profile.index');
        Route::post('/user/profile/update', 'update')->name('profile.update');
        Route::post('/user/profile/updatePersonalInformation',
        'updatePersonalInformation')->name('profile.updatePersonalInformation');
    });

    Route::controller(AlertController::class)->group(function () {
        Route::get('/alerts', 'index')->name('alerts.index');
        Route::get('/assets/{asset}', 'show')->name('asset.show');
        Route::get('/alerts/maintenance', 'maintenance')->name('alerts.maintenance');
        Route::get('/alerts/pending-requests', 'pendingRequests')->name('alerts.pending-requests');
        Route::get('/alerts/expiring-leases', 'expiringLeases')->name('alerts.expiring-leases');
    });

    Route::controller(UnitController::class)->group(function () {
        Route::post('/unit/add', 'add')->name('unit.add');
        Route::get('/unit/list', 'list')->name('unit.list');
    });

    Route::controller(CategoryController::class)->group(function (){
        Route::get('/category/index', 'index')->name('category.index');
        Route::get('/category/list', 'list')->name('category.list');
        Route::post('/category/add', 'add')->name('category.add');
        Route::post('/category/{id}', 'update')->name('category.update');
        Route::delete('/category/{id}', 'destroy')->name('category.destroy');
    });

    Route::controller(BrandController::class)->group(function (){
        Route::get('/brand/index', 'index')->name('brand.index');
        Route::get('/brand/list', 'list')->name('brand.list');
        Route::post('/brand/add', 'add')->name('brand.add');
        Route::post('/brand/{id}', 'update')->name('brand.update');
        Route::delete('/brand/{id}', 'destroy')->name('brand.destroy');
    });

    Route::controller(ConditionController::class)->group(function (){
        Route::get('/condition/index', 'index')->name('condition.index');
        Route::get('/condition/list', 'list')->name('condition.list');
        Route::post('/condition/add', 'add')->name('condition.add');
        Route::post('/condition/{id}', 'update')->name('condition.update');
        Route::delete('/condition/{id}', 'destroy')->name('condition.destroy');
    });

    Route::controller(DepartmentController::class)->group(function (){
        Route::get('/department/index', 'index')->name('department.index');
        Route::get('/department/list', 'list')->name('department.list');
        Route::post('/department/add', 'add')->name('department.add');
        Route::post('/department/{id}', 'update')->name('department.update');
        Route::delete('/department/{id}', 'destroy')->name('department.destroy');
    });
    // Route::controller(DepartmentController::class)->group(function (){
    //     Route::post('/department/add', 'add')->name('department.add');
    // });

    Route::controller(LocationController::class)->group(function (){
        Route::get('/location/index', 'index')->name('location.index');
        Route::get('/location/list', 'list')->name('location.list');
        Route::post('/location/add', 'add')->name('location.add');
        Route::post('/location/{id}', 'update')->name('location.update');
        Route::delete('/location/{id}', 'destroy')->name('location.destroy');
    });
    // Route::controller(LocationController::class)->group(function () {
    // Route::post('/location/add', 'add')->name('location.add');
    // });

    Route::controller(SiteController::class)->group(function (){
        Route::get('/site/index', 'index')->name('site.index');
        Route::get('/site/list', 'list')->name('site.list');
        Route::post('/site/add', 'add')->name('site.add');
        Route::post('/site/{id}', 'update')->name('site.update');
        Route::delete('/site/{id}', 'destroy')->name('site.destroy');
    });
    // Route::controller(SiteController::class)->group(function () {
    //     Route::post('/site/add', 'add')->name('site.add');
    // });

    Route::controller(StatusController::class)->group(function (){
        Route::get('/status/index', 'index')->name('status.index');
        Route::get('/status/list', 'list')->name('status.list');
        Route::post('/status/add', 'add')->name('status.add');
        Route::post('/status/{id}', 'update')->name('status.update');
    });

    Route::controller(RequestController::class)->group(function (){
        Route::get('/requests', 'index')->name('requests.index');
    });

    Route::controller(SupplierController::class)->group(function (){
        Route::get('/supplier/index', 'index')->name('supplier.index');
        Route::get('/supplier/list', 'list')->name('supplier.list');
        Route::post('/supplier/add', 'add')->name('supplier.add');
        Route::post('/supplier/{id}', 'update')->name('supplier.update');
        Route::delete('/supplier/{id}', 'destroy')->name('supplier.destroy');
    });
    // Route::controller(SupplierController::class)->group(function (){
    //     Route::post('/supplier/add', 'add')->name('supplier.add');
    //     Route::post('/supplier/delete', 'delete')->name('supplier.delete');
    // });

    Route::controller(UserController::class)->group(function () {
        Route::get('/user/index', 'index')->name('user.index');
        Route::post('/user/add', 'add')->name('user.add');
        Route::post('/user/{id}', 'update')->name('user.update');
        Route::delete('/user/{id}', 'destroy')->name('user.destroy');
    });

    Route::controller(ActivityController::class)->group(function () {
        Route::get('/activities', 'index')->name('activities.index');
    });

    Route::controller(PurchaseOrderController::class)->group(function (){
        Route::get('/purchase/order/index', 'index')->name('purchase.order.index');
        Route::post('/purchase/order/store', 'store')->name('purchase.order.store');
    });
});