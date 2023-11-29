<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], function() {
    Route::get('listings', [App\Http\Controllers\API\ListingAPIController::class, 'index']);
    Route::post('listings', [App\Http\Controllers\API\ListingAPIController::class, 'store']);
    Route::get('listings/{id}', [App\Http\Controllers\API\ListingAPIController::class, 'show']);
    Route::post('listings/{id}', [App\Http\Controllers\API\ListingAPIController::class, 'update']);
    Route::delete('listings/{id}', [App\Http\Controllers\API\ListingAPIController::class, 'destroy']);
    Route::post('listing/images', [App\Http\Controllers\API\ListingAPIController::class, 'listingImagesAdd']);
    Route::post('listing/favorite', [App\Http\Controllers\API\ListingAPIController::class, 'favoriteListing']);
    Route::get('user/listings/', [App\Http\Controllers\API\ListingAPIController::class, 'userListing']);
    Route::get('user/favorite/listings/', [App\Http\Controllers\API\ListingAPIController::class, 'userFavoriteListing']);

    Route::put('user/profile', [App\Http\Controllers\API\ProfileAPIController::class, 'update']);
    Route::post('user/profile/image', [App\Http\Controllers\API\ProfileAPIController::class, 'profileImageUpdate']);

    Route::get('agents', [App\Http\Controllers\API\AgentAPIController::class, 'index']);
    Route::post('agents', [App\Http\Controllers\API\AgentAPIController::class, 'store']);
    Route::get('agents/{id}', [App\Http\Controllers\API\AgentAPIController::class, 'show']);
    Route::post('agents/{id}', [App\Http\Controllers\API\AgentAPIController::class, 'update']);
    Route::delete('agents/{id}', [App\Http\Controllers\API\AgentAPIController::class, 'destroy']);

    Route::get('categories', [App\Http\Controllers\API\CategoryAPIController::class, 'index']);
    Route::post('categories', [App\Http\Controllers\API\CategoryAPIController::class, 'store']);
    Route::get('categories/{id}', [App\Http\Controllers\API\CategoryAPIController::class, 'show']);
    Route::post('categories/{id}', [App\Http\Controllers\API\CategoryAPIController::class, 'update']);
    Route::delete('categories/{id}', [App\Http\Controllers\API\CategoryAPIController::class, 'destroy']);

    Route::get('plans', [App\Http\Controllers\API\PlanAPIController::class, 'index']);
    Route::post('plans', [App\Http\Controllers\API\PlanAPIController::class, 'store']);
    Route::get('plans/{id}', [App\Http\Controllers\API\PlanAPIController::class, 'show']);
    Route::post('plans/{id}', [App\Http\Controllers\API\PlanAPIController::class, 'update']);
    Route::delete('plans/{id}', [App\Http\Controllers\API\PlanAPIController::class, 'destroy']);

    Route::get('invoices', [App\Http\Controllers\API\InvoiceController::class, 'index'])->name('invoice');
    Route::post('stripe/subscription', [App\Http\Controllers\API\StripeAPIController::class, 'subscription'])->name('stripe.subscription');

});

Route::post('create-payment', [App\Http\Controllers\API\PayPalController::class, 'postPaymentWithpaypal'])->name('payment');
Route::get('execute-payment', [App\Http\Controllers\API\PayPalController::class, 'getPaymentStatus'])->name('payment.success');
Route::get('create-plan', [App\Http\Controllers\API\PayPalController::class, 'createPlan'])->name('create.plan');
Route::get('execute-plan/{success}', [App\Http\Controllers\API\PayPalController::class, 'executePlan'])->name('execute.plan');
Route::get('list-plan', [App\Http\Controllers\API\PayPalController::class, 'listPlan'])->name('list.plan');
Route::get('plan/{id}', [App\Http\Controllers\API\PayPalController::class, 'showPlan'])->name('show.plan');
Route::get('plan/{id}/activate', [App\Http\Controllers\API\PayPalController::class, 'activePlan'])->name('active.plan');
Route::post('plan/{id}/agreement/create', [App\Http\Controllers\API\PayPalController::class, 'agreementPlan'])->name('agreement.plan');


Route::get('user/roles', [App\Http\Controllers\API\RoleAPIController::class, 'index']);
Route::get('user/states', [App\Http\Controllers\API\CityController::class, 'index']);
Route::post('user/register', [App\Http\Controllers\API\RegisterAPIController::class, 'store']);
Route::post('user/login', [App\Http\Controllers\API\LoginAPIController::class, 'store']);
Route::post('user/forgot_password/', [App\Http\Controllers\API\ProfileAPIController::class, 'forgotPassword']);
Route::post('user/update_password/', [App\Http\Controllers\API\ProfileAPIController::class, 'updatePassword']);
Route::post('search', [App\Http\Controllers\API\SearchAPIController::class, 'index']);
Route::post('search/filter', [App\Http\Controllers\API\SearchAPIController::class, 'filter']);











