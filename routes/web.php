<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DesignationController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('user.create');
// });
Route::resource('customer',CustomerController::class);
Route::resource('designation',DesignationController::class);
Route::get('/',[CustomerController::class,'listing'])->name('customer.listing');
