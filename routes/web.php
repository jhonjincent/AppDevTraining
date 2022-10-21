<?php

use Illuminate\Support\Facades\Route;
use App\User;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home') -> middleware('auth');

Route::get('/reports', 'ReportController@index')->name('reports') -> middleware('auth');

Route::get('/users', 'UserController@index')->name('users') -> middleware('auth');

Route::get('/departments', 'DepartmentController@index')->name('departments') -> middleware('auth');

Route::get('/companies', 'CompanyController@index')->name('companies') -> middleware('auth');

Route::post('/store-owner', 'ReportController@storeowner');

Route::post('/store-comment', 'ReportController@storecomment');

