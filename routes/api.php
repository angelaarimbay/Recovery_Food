<?php
 
use Illuminate\Support\Facades\Route;
   // Branches
   Route::post('branches/attachment', 'Branches\BranchesController@attachment'); //post nga lang e
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

   // Inventory
   Route::post('msupp/save', 'Inventory\MasterlistSuppliesController@save');
   Route::get('msupp/get', 'Inventory\MasterlistSuppliesController@get');
   Route::get('msupp/suppCat', 'Inventory\MasterlistSuppliesController@suppCat');
   Route::get('msupp/validateItem', 'Inventory\MasterlistSuppliesController@validateItem');
   Route::get('msupp/sum', 'Inventory\MasterlistSuppliesController@sum');

   Route::post('isupp/save', 'Inventory\IncomingSuppliesController@save');
   Route::get('isupp/get', 'Inventory\IncomingSuppliesController@get');

   
 
    // // dashboard
    // Route::get('get/accumulation/top',             'Accumulation\AccumulationController@AccumulationToplist');
    // Route::get('get/accumulation/chart1',             'Accumulation\AccumulationController@AccumulationCrestaZone');

    // // accumulation
    // Route::get('get/accumulation/list',             'Accumulation\AccumulationController@AccumulationList');
    // Route::get('get/accumulation/company/list',     'Accumulation\AccumulationController@AccumulationPerCompany');
    // Route::post('upload/accumulation/excel',        'Accumulation\AccumulationController@AccumulationUploadExcel');


    // Route::get('get/survey/list', 'Risk\RiskSectionController@getSurveyList');
    // Route::post('store/survey', 'Risk\RiskSectionController@storeSurvey');
    // Route::post('upload/survey', 'Risk\RiskSectionController@uploadSurvey');
