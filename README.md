# Socialite Passport

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jhnbrn90/socialite-passport.svg?style=flat-square)](https://packagist.org/packages/jhnbrn90/socialite-passport)
[![Total Downloads](https://img.shields.io/packagist/dt/jhnbrn90/socialite-passport.svg?style=flat-square)](https://packagist.org/packages/jhnbrn90/socialite-passport)

 This package provides an easy way to authenticate users via a central identity provider that uses Laravel Passport.
 
 In other words, allow users to login to "client" apps `app1.example.com` and `app2.example.com` using their account on `auth.example.com` (which uses Laravel passport). 
 
 This package is aimed at simplifying the socialite integration in the "client" app, and assumes an existing "ID provider" set-up with [Laravel Passport](https://laravel.com/docs/6.x/passport). 
 
 Generalized workflow:
 * Create new `OAuth Client` in the "ID provider"
 * Configure the `keys`, `redirect url` and `host` in the `.env` file of the "client"
 * Configure which `Controller` should be passed the authenticated OAuth `$user` object in the client
 * Register or log in the `$user` in the "client".

For more details, see the `Installation` and `Usage` sections below.

## Installation

You can install the package via composer:

```bash
composer require jhnbrn90/socialite-passport
```

Publish the configuration

```bash
php artisan vendor:publish --provider="JhnBrn90\SocialitePassport\SocialitePassportServiceProvider" --tag="config"
````

Configure the controller and method which should handle the authenticated user.
Furthermore, you can customize the route and route name which should be used to log in users.

```php
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
```

Next, the following environment variables should be added to `.env`, where `CLIENT_ID` and `CLIENT_SECRET` are obtained from the Laravel Passport identity provider.
The `REDIRECT_URI` variable will automatically map the correct callback route in the routes file. Therefore, this can be anything you'd like (convention is to use `login/[name-of-service]/callback`. 
  
```
LARAVELPASSPORT_CLIENT_ID=
LARAVELPASSPORT_CLIENT_SECRET=
LARAVELPASSPORT_REDIRECT_URI=/login/callback
LARAVELPASSPORT_HOST=https://auth.example.com
```

## Usage

The example configuration (above) assumes you have added a `loginWithPassport()` method to the default `LoginController`. 
This method will get the `$user` object injected (see https://socialiteproviders.netlify.com/providers/laravel-passport.html).

Example of the `OAuth2\User` object `$user`:

```json
SocialiteProviders\Manager\OAuth2\User {#273 ▼
  +accessTokenResponseBody: array:4 [▼
    "token_type" => "Bearer"
    "expires_in" => 31622400
    "access_token" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI4IiwianRpIjoiMzA0Yzg1ZTg3NDE2MzkwOGFiZjIyYzgxNjMzZTBmMzIzMjI0NmJjYTg4MGNkYTk3MmYwOTYxMjkzMTgzNmJkNzQ0OTlkZmNlYmJ ▶"
    "refresh_token" => "def502007a89551a0036b65af056132ba742d02b65cabe2ab51681b9d7b77291f5b20abc07f4375ce1ba2ccd3fb456914a19bc81892cfc2f4deea99514774b22961241a7f8552fd386cecfdd09e71fda ▶"
  ]
  +token: "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI4IiwianRpIjoiMzA0Yzg1ZTg3NDE2MzkwOGFiZjIyYzgxNjMzZTBmMzIzMjI0NmJjYTg4MGNkYTk3MmYwOTYxMjkzMTgzNmJkNzQ0OTlkZmNlYmJ ▶"
  +refreshToken: "def502007a89551a0036b65af056132ba742d02b65cabe2ab51681b9d7b77291f5b20abc07f4375ce1ba2ccd3fb456914a19bc81892cfc2f4deea99514774b22961241a7f8552fd386cecfdd09e71fda ▶"
  +expiresIn: 31622400
  +id: 1
  +nickname: null
  +name: "John"
  +email: "johnbraun@pm.me"
  +avatar: null
  +user: array:6 [▼
    "id" => 1
    "name" => "John"
    "email" => "johnbraun@pm.me"
    "email_verified_at" => null
    "created_at" => "2019-12-08 06:38:54"
    "updated_at" => "2019-12-08 06:38:54"
  ]
}}
```

```php
class LoginController extends Controller 
{
    public function loginWithPassport($user) // gets authenticated $user injected
    {
        // perform your logic here to create or log in a new user

        // example:
        User::firstOrCreate(['name' => $user->user->name, 'email' => ...]);
    }
}
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

### Security

If you discover any security related issues, please email johnbraun@pm.me instead of using the issue tracker.

## Credits

- [John Braun](https://github.com/jhnbrn90)
- [All Contributors](../../contributors)
