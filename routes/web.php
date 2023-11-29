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


Auth::routes();
Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');
Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');
Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');
Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');
Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');
Route::post('generator_builder/generate-from-file', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile')->name('io_generator_builder_generate_from_file');

Route::get('/welcome', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');
Route::get('/execute-payment', [App\Http\Controllers\HomeController::class, 'execute']);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('types', App\Http\Controllers\TypeController::class);
    Route::resource('listings', App\Http\Controllers\ListingController::class);
    Route::get('/image-delete/{id}', [App\Http\Controllers\ListingController::class, 'delete_image'])->name('image.delete');
    Route::resource('agents', App\Http\Controllers\AgentController::class);
    Route::resource('categories', App\Http\Controllers\CategoryController::class);
    Route::resource('plans', App\Http\Controllers\PlanController::class);
});


//Route::get('paywithpaypal', array('as' => 'paywithpaypal','uses' => App\Http\Controllers\PaypalController::class, 'payWithPaypal'));
//Route::post('paypal', array('as' => 'paypal','uses' => App\Http\Controllers\PaypalController::class, 'postPaymentWithpaypal'));
//Route::get('paypal', array('as' => 'status','uses' => App\Http\Controllers\PaypalController::class, 'getPaymentStatus'));





