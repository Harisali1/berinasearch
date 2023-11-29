<?php

use App\Http\Controllers\Frontend;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'customer', 'as' => 'customer.', 'middleware' => 'customer'], function () {

});
