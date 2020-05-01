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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/product', 'ProductController'); //สร้างเส้นทางการทำงาน Product
Route::get('/product/{id}/delete', 'ProductController@delete'); //ลบข้อมูล

Route::resource('/producttype', 'ProductTypeController'); //สร้างเส้นทางการทำงาน Product
Route::get('/producttype/{id}/delete', 'ProductTypeController@delete'); //ลบข้อมูล

Route::resource('/store', 'StoreController'); //สร้างเส้นทางการทำงาน Product
Route::get('/store/{id}/delete', 'StoreController@delete'); //ลบข้อมูล

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');