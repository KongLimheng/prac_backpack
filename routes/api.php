<?php

use App\Http\Controllers\Admin\ContactsCrudController;
use App\Http\Controllers\API\searchController;
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

Route::post('contact', [ContactsCrudController::class, 'fetchContact']);



Route::get('contact', [searchController::class, 'index']);
Route::get('address', [searchController::class, 'search']);
Route::get('account', [searchController::class, 'searchAccount']);
