<?php
 
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => 'guest'], function () { 
   Route::post('login', 'Auth\LoginController@login');
});

Route::group(['middleware' => 'api'], function () {
   
// Manage Branches
   Route::post('branches/attachment', 'Branches\BranchesController@attachment');
   Route::post('branches/save', 'Branches\BranchesController@save');
   Route::get('branches/get', 'Branches\BranchesController@get');

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

   // Products List
   Route::post('prodlist/save', 'Products\ProductsListController@save');
   Route::get('prodlist/get', 'Products\ProductsListController@get');
   Route::get('prodlist/prodCat', 'Products\ProductsListController@prodCat');
   Route::get('prodlist/prodSubCat', 'Products\ProductsListController@prodSubCat');

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
 
 
   });    

    