<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DailyController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\EmployeeControler;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LoansController;
use App\Http\Controllers\MackupController;
use App\Http\Controllers\RentsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TheJobController;
use App\Http\Controllers\WorksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

const pag=5;


Route::group(['prefix'=>'superAdmin'],function (){

    Route::group(['prefix'=>'employee'],function (){
        Route::post('save',[EmployeeControler::class,'save']);
        Route::get('show',[EmployeeControler::class,'show']);
        Route::get('edit/{id}',[EmployeeControler::class,'edit']);
        Route::post('update/{id}',[EmployeeControler::class,'update']);
        Route::get('delete/{id}',[EmployeeControler::class,'delete']);
        Route::get('getEmployee',[EmployeeControler::class,'getEmployee']);

    });

    Route::group(['prefix'=>'discount'],function (){
        Route::post('save',[DiscountController::class,'save']);
        Route::get('show',[DiscountController::class,'show']);
        Route::get('edit/{id}',[DiscountController::class,'edit']);
        Route::post('update/{id}',[DiscountController::class,'update']);
        Route::get('delete/{id}',[DiscountController::class,'delete']);
        Route::get('getPriceDiscount/{id}',[DiscountController::class,'getPriceDiscount']);
        Route::get('getDiscount',[DiscountController::class,'getDiscount']);
        Route::get('getPrice',[DiscountController::class,'getPrice']);


    });

    Route::group(['prefix'=>'category'],function (){
        Route::post('save',[CategoryController::class,'save']);
        Route::get('show',[CategoryController::class,'show']);
        Route::get('edit/{id}',[CategoryController::class,'edit']);
        Route::post('update/{id}',[CategoryController::class,'update']);
        Route::get('delete/{id}',[CategoryController::class,'delete']);
        Route::post('updateStatus/{id}',[CategoryController::class,'updateStatus']);
        Route::get('showMakeup',[CategoryController::class,'showMakeup']);
        Route::get('showStudio',[CategoryController::class,'showStudio']);

    });

    Route::group(['prefix'=>'subCategory'],function (){
        Route::post('save',[SubCategoryController::class,'save']);
        Route::get('show',[SubCategoryController::class,'show']);
        Route::get('edit/{id}',[SubCategoryController::class,'edit']);
        Route::post('update/{id}',[SubCategoryController::class,'update']);
        Route::get('delete/{id}',[SubCategoryController::class,'delete']);
        Route::get('getCategory/{id}',[SubCategoryController::class,'getCategory']);
        Route::get('getSubCategory',[SubCategoryController::class,'getSubCategory']);

    });

    Route::group(['prefix'=>'admin','middleware'=>'api'],function (){
        Route::post('save',[AdminAuthController::class,'save']);
        Route::get('show',[AdminAuthController::class,'show']);
        Route::get('edit/{id}',[AdminAuthController::class,'edit']);
        Route::post('update/{id}',[AdminAuthController::class,'update']);
        Route::get('delete/{id}',[AdminAuthController::class,'delete']);
        Route::post('login',[AdminAuthController::class,'login']);
        Route::post('forgetPassword',[AdminAuthController::class,'forgetPassword']);
    });

    Route::group(['prefix'=>'job'],function (){
        Route::post('save',[TheJobController::class,'save']);
        Route::get('show',[TheJobController::class,'show']);
        Route::get('edit/{id}',[TheJobController::class,'edit']);
        Route::post('update/{id}',[TheJobController::class,'update']);
        Route::get('delete/{id}',[TheJobController::class,'delete']);
        Route::get('getJobs',[TheJobController::class,'getJobs']);
        Route::get('getJobPrice/{name}',[TheJobController::class,'getJobPrice']);

    });


    Route::group(['prefix'=>'work'],function (){
        Route::post('save',[WorksController::class,'save']);
        Route::get('show',[WorksController::class,'show']);
        Route::get('edit/{id}',[WorksController::class,'edit']);
        Route::post('update/{id}',[WorksController::class,'update']);
        Route::get('delete/{id}',[WorksController::class,'delete']);


    });

    Route::group(['prefix'=>'rent'],function (){
        Route::post('save',[RentsController::class,'save']);
        Route::get('show',[RentsController::class,'show']);
        Route::get('edit/{id}',[RentsController::class,'edit']);
        Route::post('update/{id}',[RentsController::class,'update']);
        Route::get('delete/{id}',[RentsController::class,'delete']);
        Route::post('updateStatus/{id}',[RentsController::class,'updateStatus']);
    });

    Route::group(['prefix'=>'expense'],function (){
        Route::post('save',[ExpenseController::class,'save']);
        Route::get('show',[ExpenseController::class,'show']);
        Route::get('edit/{id}',[ExpenseController::class,'edit']);
        Route::post('update/{id}',[ExpenseController::class,'update']);
        Route::get('delete/{id}',[ExpenseController::class,'delete']);
    });

    Route::group(['prefix'=>'loans'],function (){
        Route::post('save',[LoansController::class,'save']);
        Route::get('show',[LoansController::class,'show']);
        Route::get('edit/{id}',[LoansController::class,'edit']);
        Route::post('update/{id}',[LoansController::class,'update']);
        Route::get('delete/{id}',[LoansController::class,'delete']);
    });

    Route::group(['prefix'=>'makeup'],function (){
        Route::post('save',[MackupController::class,'save']);
        Route::get('show',[MackupController::class,'show']);
        Route::get('edit/{id}',[MackupController::class,'edit']);
        Route::post('update/{id}',[MackupController::class,'update']);
        Route::get('delete/{id}',[MackupController::class,'delete']);


    });

    Route::group(['prefix'=>'studio'],function (){
        Route::post('save',[StudioController::class,'save']);
        Route::get('show',[StudioController::class,'show']);
        Route::get('edit/{id}',[StudioController::class,'edit']);
        Route::post('update/{id}',[StudioController::class,'update']);
        Route::get('delete/{id}',[StudioController::class,'delete']);
    });

    Route::group(['prefix'=>'daily'],function (){
//        Route::post('updateArriveMakeup/{id}',[DailyController::class,'updateArriveMakeup']);
//        Route::post('updateArriveStudio/{id}',[DailyController::class,'updateArriveStudio']);
        Route::post('updateStatusMakeup/{id}',[DailyController::class,'updateStatusMakeup']);
        Route::post('updateStatusStudio/{id}',[DailyController::class,'updateStatusStudio']);
        Route::get('showMakeup',[DailyController::class,'showMakeup']);
        Route::get('showStudio',[DailyController::class,'showStudio']);
//        Route::post('update/{id}',[DailyController::class,'update']);
//        Route::get('delete/{id}',[DailyController::class,'delete']);
    });


    Route::group(['prefix'=>'search'],function (){

        Route::get('SearchExpense',[SearchController::class,'SearchExpense']);
        Route::get('SearchLoans',[SearchController::class,'SearchLoans']);
        Route::get('SearchAdmin',[SearchController::class,'SearchAdmin']);
        Route::get('SearchEmployee',[SearchController::class,'SearchEmployee']);
        Route::get('SearchJob',[SearchController::class,'SearchJob']);
        Route::get('SearchDiscount',[SearchController::class,'SearchDiscount']);
        Route::get('SearchCategory',[SearchController::class,'SearchCategory']);
        Route::get('SearchSubCategory',[SearchController::class,'SearchSubCategory']);
        Route::get('SearchStudio',[SearchController::class,'SearchStudio']);
        Route::get('SearchMakeup',[SearchController::class,'SearchMakeup']);
        Route::get('SearchRents',[SearchController::class,'SearchRents']);
        Route::get('SearchWorks',[SearchController::class,'SearchWorks']);



    });

});


