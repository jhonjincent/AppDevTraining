<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/user-with-phone', 'userController@userwithphone');


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/example', function(){
    $comparts = array(
    [
        'id' => 1,
        'name' => 'Laptop',
        'price' => 50000
    ],
    [
        'id' => 2,
        'name' => 'Graphic Card',
        'price' => 7000
    ],
    [
        'id' => 3,
        'name' => 'Monitor',
        'price' => 5000
    ],
    [
        'id' => 4,
        'name' => 'Memory',
        'price' => 2000
    ],
    [
        'id' => 5,
        'name' => 'Mother Board',
        'price' => 100
    ]);

    foreach($comparts as $part){
    if($part ['price'] >= 5000){
        echo "SCENARIO 1: ", $part['name'] . '<br>';
    }
    elseif($part ['price'] < 1000){
        echo "SCENARIO 2: ", $part['name'], " = ";
        echo $part['price']*3 . '<br>';
    }};
    
});

Route::get('/users/list', 'userController@index')->name('users.list') -> middleware('auth');

Route::get('/products','ProductController@index')->name('products.list') -> middleware('auth');

Route::get('/employees', 'employeeController@index')->name('employees') -> middleware('auth');

Route::get('/customers', 'CustomerController@index')->name('customers') -> middleware('auth');