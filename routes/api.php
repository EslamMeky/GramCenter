<?php

use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('test/add',[TestController::class,'add']);
Route::get('test/show',[TestController::class,'show']);
Route::get('test/edit/{id}',[TestController::class,'edit']);
Route::post('test/update/{id}',[TestController::class,'update']);
Route::get('test/delete/{id}',[TestController::class,'delete']);

