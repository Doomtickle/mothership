<?php

Route::get('/', 'HomeController@index')->name('home');
Auth::routes();

Route::prefix('api/v1')->group(function () {
    Route::get('search', 'ListingsSearchController@index');
    Route::get('listing/{mlsNumber}', 'ListingController@show');
    Route::get('listings', 'ListingController@index');
    Route::any('omnibar', 'OmnibarController@create');
    Route::get('allMapListings', 'MapSearchController@index');
    Route::get('agentlistings', 'AgentListingsController@index');
    Route::get('agents', 'AgentSearchController@index');
    Route::get('agentdata', 'AgentSearchController@show');
    Route::get('updatedListings', 'UpdatedListingsController@index');
});
