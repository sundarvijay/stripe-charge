<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', ProductController::class .'@index')->name('products.index');
Route::get('/products', ProductController::class .'@index')->name('products.index');
Route::get('/products/{product}', ProductController::class .'@show')->name('products.show');
Route::post('/payment/process-payment/{price}', PaymentController::class. '@processPayment')->name('payment.processPayment');
