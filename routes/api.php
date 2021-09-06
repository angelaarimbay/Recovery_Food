<?php
 
use Illuminate\Support\Facades\Route;

   // Supplies Category
   Route::post('supplies/save', 'Categories\SuppliesCategoryController@save');
   Route::get('supplies/get', 'Categories\SuppliesCategoryController@get');

   // Products Category
   Route::post('products/save', 'Categories\ProductsCategoryController@save');
   Route::get('products/get', 'Categories\ProductsCategoryController@get');

   
 
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
