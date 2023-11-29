<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    'login'    => true,
    'register' => true,
    'reset'    => false,
    'confirm'  => false,
    'verify'   => false
]);

Route::group(
    ['namespace' => 'App\Http\Controllers\Frontend', 'prefix' => 'customer', 'as' => 'customer.'],
    fn() => Auth::routes([
        'login'    => true,
        'register' => true,
        'confirm'  => false,
        'verify'   => false
    ])
);
