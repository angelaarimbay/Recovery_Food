<?php
 
use Illuminate\Support\Facades\Route;

    Route::group(['middleware' => 'guest'], function () {
        Route::post('login', 'Auth\LoginController@login');
    });
    Route::get('user', 'Auth\UserController@current');

    Route::group(['middleware' => 'api'], function () {
        Route::get('users', 'UserController@getUsers');
        Route::post('/changepassword', 'UserController@change_password'); 

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
        Route::get('msupp/get', 'Inventory\MasterlistSuppliesController@get');
        Route::get('msupp/suppCat', 'Inventory\MasterlistSuppliesController@suppCat');
        Route::get('msupp/validateItem', 'Inventory\MasterlistSuppliesController@validateItem');
        Route::get('msupp/sum', 'Inventory\MasterlistSuppliesController@sum');

        // Incoming Supplies
        Route::post('isupp/save', 'Inventory\IncomingSuppliesController@save');
        Route::get('isupp/get', 'Inventory\IncomingSuppliesController@get');
        Route::get('isupp/suppCat', 'Inventory\IncomingSuppliesController@suppCat');
        Route::get('isupp/suppName', 'Inventory\IncomingSuppliesController@suppName');
        Route::get('isupp/getTotalCurrentMonth', 'Inventory\IncomingSuppliesController@getTotalCurrentMonth');
   
        // Outgoing Supplies
        Route::post('osupp/save', 'Inventory\OutgoingSuppliesController@save');
        Route::get('osupp/get', 'Inventory\OutgoingSuppliesController@get');
        Route::get('osupp/suppCat', 'Inventory\OutgoingSuppliesController@suppCat');
        Route::get('osupp/suppName', 'Inventory\OutgoingSuppliesController@suppName');
        Route::get('osupp/branchName', 'Inventory\OutgoingSuppliesController@branchName');

        // Main Inventory
        Route::post('misupp/save', 'Inventory\MainInventoryController@save');
        Route::get('misupp/get', 'Inventory\MainInventoryController@get');
        Route::get('misupp/suppCat', 'Inventory\MainInventoryController@suppCat');

        // Inventory Summary
        Route::get('invsumm/get', 'Inventory\InventorySummaryController@get');

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

        // Suppliers List
        Route::post('supplist/save', 'Suppliers\SuppliersListController@save');
        Route::get('supplist/get', 'Suppliers\SuppliersListController@get');

        // Purchase Orders
        Route::post('porder/save', 'Suppliers\PurchaseOrdersController@save');
        Route::get('porder/get', 'Suppliers\PurchaseOrdersController@get');
        Route::get('porder/suppName', 'Suppliers\PurchaseOrdersController@suppName');

        // User Accounts
        Route::post('useracc/save', 'UserAccounts\UserAccountsController@save');
        Route::get('useracc/get', 'UserAccounts\UserAccountsController@get');


        Route::get('useracc/getPermission', 'UserController@getPermission');
        Route::get('useracc/getRoles', 'UserController@getRoles');
        Route::get('useracc/getUserRole', 'UserController@getUserRole');

        Route::post('useracc/storeRole', 'UserController@storeRole');
        Route::post('useracc/storePermission', 'UserController@storePermission');
        Route::post('useracc/storeRolePermission', 'UserController@storeRolePermission');
        Route::post('useracc/storeUserRole', 'UserController@storeUserRole');
        Route::post('useracc/removeUserRole', 'UserController@removeUserRole');

        Route::get('useracc/branchName', 'UserAccounts\UserAccountsController@branchName');

        // POS
        Route::post('pos/prodlist/save', 'POS\ProductsListController@save');
        Route::get('pos/prodlist/get', 'POS\ProductsListController@get');
        Route::get('sales_report/sales_count', 'POS\ProductsListController@getSalesCount');

        // Reports
        Route::get('walanjo', 'Reports\ReportsController@ExportMasterlist');
        Route::get('po', 'Reports\ReportsController@ExportPO');
    
        Route::get('sales_report/list', 'Reports\ReportsController@ListSP');
        Route::get('sales_report', 'Reports\ReportsController@ExportSP');
        Route::get('sales_report/info', 'Reports\ReportsController@getSPInfo');
    
        //from angela
        Route::get('reports/masterlist/get', 'Reports\ReportsController@ExportMasterlist1');
        Route::get('reports/incoming/supplies/get', 'Reports\ReportsController@ExportIncominglist');
        Route::get('reports/outgoing/supplies/get', 'Reports\ReportsController@ExportOutgoinglist');
        Route::get('reports/main/get', 'Reports\ReportsController@ExportMain');
        Route::get('reports/inventory/summary/get', 'Reports\ReportsController@ExportInventorysummary');
        Route::get('reports/sales/report/get', 'Reports\ReportsController@ExportSales');
        Route::get('reports/transaction/report/get', 'Reports\ReportsController@ExportTransaction');
        Route::get('reports/purchase/order/get', 'Reports\ReportsController@ExportPurchase');
        //from angela
    
    
    });
