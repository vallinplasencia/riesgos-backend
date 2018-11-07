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
//
//Route::get('/{xxx?}', function () {
//    return view('home.home');
//})->where('xxx', '.*');

Route::get('/{ruta?}', 'Home')->where('ruta', '.*');
