<?php

return [
    'controller' => [
        'class' => \App\Http\Controllers\Auth\LoginController::class,
        'method' => 'loginWithPassport',
    ],

    'route' => [
        'name' => 'login',
        'uri' => '/login',
    ],
];
