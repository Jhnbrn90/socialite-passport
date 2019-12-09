<?php

use Illuminate\Support\Facades\Route;

Route::get(config('socialite-passport.route.uri'), [
    'middleware' => 'web',
    'uses' => 'AuthenticationController@redirectToProvider'
])->name(config('socialite-passport.route.name'));

Route::get(config('services.laravelpassport.redirect'), [
    'middleware' => 'web',
    'uses' => 'AuthenticationController@handleProviderCallback'
]);
