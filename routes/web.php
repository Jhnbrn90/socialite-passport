<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', [
    'middleware' => 'web',
    'uses' => 'AuthenticationController@redirectToProvider'
])->name('login');

Route::get('/login/callback', [
    'middleware' => 'web',
    'uses' => 'AuthenticationController@handleProviderCallback'
]);
