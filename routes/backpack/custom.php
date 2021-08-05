<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('contacts', 'ContactsCrudController');
    // Route::crud('user', 'UserCrudController');
    Route::crud('account', 'AccountCrudController');
    Route::crud('option', 'OptionCrudController');

       /**
     * SELECT2 AJAX
     */
    Route::namespace('API')->name('web-api.')->prefix('api')->group(function () {
        Route::apiResource('address', 'Addresses\AddressController')->only(['index']);
    });

    Route::post('convertUser', 'API\Users\userController@store')->name('user.convertUser');
    Route::crud('leads', 'LeadsCrudController');
}); // this should be the absolute last line of this file