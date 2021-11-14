<?php

use Illuminate\Support\Facades\Route;

Route::get('seeder', 'UserController@createSeeder');
Route::group(['middleware' => 'guest'], function () {
    Route::post('login', 'Auth\LoginController@login');
});
Route::get('user', 'Auth\UserController@current');
Route::post('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'api'], function () {

    // Dashboard
    Route::get('dashboard/getSupp', 'Dashboard\MainController@getSupp');
    Route::get('dashboard/getProd', 'Dashboard\MainController@getProd');
    Route::get('dashboard/getPO', 'Dashboard\MainController@getPO');
    Route::get('dashboard/getUser', 'Dashboard\MainController@getUser');
    Route::get('dashboard/getSalesGraph', 'Dashboard\MainController@getSalesGraph');
    Route::get('dashboard/getProductsGraph', 'Dashboard\MainController@getProductsGraph');

    // Manage Branches
    Route::post('branches/attachment', 'Branches\BranchesController@attachment');
    Route::post('branches/save', 'Branches\BranchesController@save');
    Route::get('branches/get', 'Branches\BranchesController@get');

    // Branches Inventory
    Route::get('branches/inventory/get', 'Branches\BranchesInventoryController@get');
    Route::get('branches/inventory/get2', 'Branches\BranchesInventoryController@get2');
    Route::get('branches/inventory/suppCat', 'Branches\BranchesInventoryController@suppCat');
    Route::get('branches/inventory/branchName', 'Branches\BranchesInventoryController@branchName');
    Route::get('branches/inventory/prodCat', 'Branches\BranchesInventoryController@prodCat');
    Route::get('branches/inventory/prodSubCat', 'Branches\BranchesInventoryController@prodSubCat');

    // Supplies Category
    Route::post('supplies/save', 'Categories\SuppliesCategoryController@save');
    Route::get('supplies/get', 'Categories\SuppliesCategoryController@get');

    // Products Category
    Route::post('products/save', 'Categories\ProductsCategoryController@save');
    Route::get('products/get', 'Categories\ProductsCategoryController@get');

    // Products Category
    Route::post('productssub/save', 'Categories\ProductsSubCategoryController@save');
    Route::get('productssub/get', 'Categories\ProductsSubCategoryController@get');

    // Masterlist Supplies
    Route::post('msupp/save', 'Inventory\MasterlistSuppliesController@save');

    Route::get('msupp/suppName', 'Inventory\MasterlistSuppliesController@suppName');
    Route::get('msupp/get', 'Inventory\MasterlistSuppliesController@get');
    Route::get('msupp/suppCat', 'Inventory\MasterlistSuppliesController@suppCat');
    Route::get('msupp/validateItem', 'Inventory\MasterlistSuppliesController@validateItem');
    Route::get('msupp/sum', 'Inventory\MasterlistSuppliesController@sum');
    Route::get('msupp/suppliers', 'Inventory\MasterlistSuppliesController@suppliers');

    // Incoming Supplies
    Route::post('isupp/save', 'Inventory\IncomingSuppliesController@save');
    Route::get('isupp/get', 'Inventory\IncomingSuppliesController@get');
    Route::get('isupp/suppliers', 'Inventory\IncomingSuppliesController@suppliers');
    Route::get('isupp/suppCat', 'Inventory\IncomingSuppliesController@suppCat');
    Route::get('isupp/suppName', 'Inventory\IncomingSuppliesController@suppName');
    Route::get('isupp/getTotalCurrentMonth', 'Inventory\IncomingSuppliesController@getTotalCurrentMonth');

    // Outgoing Supplies
    Route::post('osupp/save', 'Inventory\OutgoingSuppliesController@save');
    Route::get('osupp/get', 'Inventory\OutgoingSuppliesController@get');
    Route::get('osupp/suppCat', 'Inventory\OutgoingSuppliesController@suppCat');
    Route::get('osupp/suppName', 'Inventory\OutgoingSuppliesController@suppName');
    Route::get('osupp/branchName', 'Inventory\OutgoingSuppliesController@branchName');
    Route::get('osupp/suppValidate', 'Inventory\OutgoingSuppliesController@validateQuantity');
    Route::get('osupp/request/list', 'Inventory\OutgoingSuppliesController@getRequest');
    Route::get('osupp/request/items/list', 'Inventory\OutgoingSuppliesController@getRequested');
    Route::post('osupp/request/process', 'Inventory\OutgoingSuppliesController@processRequest');

    // Main Inventory
    Route::post('misupp/save', 'Inventory\MainInventoryController@save');
    Route::get('misupp/get', 'Inventory\MainInventoryController@get');
    Route::get('misupp/suppCat', 'Inventory\MainInventoryController@suppCat');

    // Inventory Summary
    Route::get('invsumm/get', 'Inventory\InventorySummaryController@get');

    // Supplies Inventory (Branch)
    Route::post('suppinven/save', 'Inventory\SuppliesInventoryController@store');
    Route::get('suppinven/get', 'Inventory\SuppliesInventoryController@get');
    Route::get('deductedsupp/get', 'Inventory\DeductedSuppliesController@get');
    Route::get('requestsupp/supplies/list', 'Inventory\RequestSuppliesController@getSuppliesList');
    Route::post('requestsupp/supplies/save', 'Inventory\RequestSuppliesController@storeSupplies');
    Route::get('requestsupp/get', 'Inventory\RequestSuppliesController@get');
    Route::get('requestsupp/request/list', 'Inventory\RequestSuppliesController@getRequested');
    Route::post('requestsupp/request/complete', 'Inventory\RequestSuppliesController@completeRequest');
    Route::post('requestsupp/request/cancel', 'Inventory\RequestSuppliesController@cancelRequest');

    // Masterlist Products
    Route::post('mprod/save', 'Products\MasterlistProductsController@save');
    Route::get('mprod/get', 'Products\MasterlistProductsController@get');
    Route::get('mprod/prodCat', 'Products\MasterlistProductsController@prodCat');
    Route::get('mprod/prodSubCat', 'Products\MasterlistProductsController@prodSubCat');

    // Incoming Products
    Route::post('inprod/save', 'Products\IncomingProductsController@save');
    Route::get('inprod/get', 'Products\IncomingProductsController@get');
    Route::get('inprod/prodCat', 'Products\IncomingProductsController@prodCat');
    Route::get('inprod/prodSubCat', 'Products\IncomingProductsController@prodSubCat');
    Route::get('inprod/prodName', 'Products\IncomingProductsController@prodName');

    // Outgoing Products
    Route::post('outprod/save', 'Products\OutgoingProductsController@save');
    Route::get('outprod/get', 'Products\OutgoingProductsController@get');
    Route::get('outprod/prodCat', 'Products\OutgoingProductsController@prodCat');
    Route::get('outprod/prodSubCat', 'Products\OutgoingProductsController@prodSubCat');
    Route::get('outprod/prodName', 'Products\OutgoingProductsController@prodName');
    Route::get('outprod/branchName', 'Products\OutgoingProductsController@branchName');
    Route::get('outprod/prodValidate', 'Products\OutgoingProductsController@validateQuantity');

    // Suppliers List
    Route::post('supplist/save', 'Suppliers\SuppliersListController@save');
    Route::get('supplist/get', 'Suppliers\SuppliersListController@get');

    // Purchase Orders
    Route::post('porder/save', 'Suppliers\PurchaseOrdersController@save');
    Route::get('porder/get', 'Suppliers\PurchaseOrdersController@get');
    Route::get('porder/suppName', 'Suppliers\PurchaseOrdersController@suppName');

    // Company
    Route::post('settings/company/logo/upload', 'Settings\SettingsController@uploadLogo');
    Route::post('settings/company/logo/store', 'Settings\SettingsController@storeLogo');
    Route::post('settings/company/logo/delete', 'Settings\SettingsController@deleteLogo');

    Route::get('settings/company/logo/get', 'Settings\SettingsController@getLogo');

    Route::post('settings/vat/store', 'Settings\SettingsController@storeVat');
    Route::get('settings/vat/get', 'Settings\SettingsController@getVat');

    // User Accounts
    Route::post('useracc/save', 'UserController@save');
    Route::get('useracc/get', 'UserController@get');
    Route::get('useracc/getPermission', 'UserController@getPermission');
    Route::get('useracc/getRoles', 'UserController@getRoles');

    Route::get('useracc/getUserRole', 'UserController@getUserRole');
    Route::get('users', 'UserController@getUsers');
    Route::post('/changepassword', 'UserController@change_password');
    Route::post('useracc/storeRole', 'UserController@storeRole');
    Route::post('useracc/storePermission', 'UserController@storePermission');
    Route::post('useracc/storeRolePermission', 'UserController@storeRolePermission');
    Route::post('useracc/storeUserRole', 'UserController@storeUserRole');
    Route::post('useracc/removeUserRole', 'UserController@removeUserRole');
    Route::get('useracc/branchName', 'UserController@branchName');

    // POS
    Route::post('pos/prodlist/save', 'POS\ProductsListController@save');
    Route::get('pos/receipt', 'Reports\ReportsController@Receipt'); //change mo nlang kung ano proper syo
    Route::get('pos/today', 'POS\ProductsListController@getSalesToday'); //change mo nlang kung ano proper naming syo

    Route::get('pos/prodlist/get', 'POS\ProductsListController@get');
    Route::get('sales_report/sales_count', 'POS\ProductsListController@getSalesCount');

    // Reports
    Route::get('reports/masterlistsupplies/get', 'Reports\ReportsController@MasterlistSuppliesReport');
    Route::get('reports/incomingsupplies/get', 'Reports\ReportsController@IncomingSuppliesReport');
    Route::get('reports/outgoingsupplies/get', 'Reports\ReportsController@OutgoingSuppliesReport');
    Route::get('reports/maininventory/get', 'Reports\ReportsController@MainInventoryReport');
    Route::get('reports/inventorysummary/get', 'Reports\ReportsController@InventorySummaryReport');
    Route::get('reports/sales/get', 'Reports\ReportsController@SalesReport');
    Route::get('reports/transaction/get', 'Reports\ReportsController@TransactionReport');
    Route::get('reports/purchaseorder/get', 'Reports\ReportsController@PurchaseOrderReport');

    Route::get('sales_report/list', 'Reports\ReportsController@ListSP');
    Route::get('sales_report', 'Reports\ReportsController@ExportSP');
    Route::get('sales_report/info', 'Reports\ReportsController@getSPInfo');
});
