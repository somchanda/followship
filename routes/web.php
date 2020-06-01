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

Route::get('/', "Controller@redirect")->name('home');

Route::middleware('guest')->group(function (){
    Route::get('/register','AuthController@register')->name('register');
    Route::post('/register','AuthController@registerPost')->name('registerPost');
    Route::post('/login','AuthController@loginPost')->name('loginPost');
});
Route::middleware('auth')->group(function (){
//    Route::get('/',function (){
//        return view('loggedin.index');
//    })->name('test');
    Route::get('/logout','Auth\LoginController@logout')->name('logout');
});

