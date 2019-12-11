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

```php
class LoginController extends Controller 
{
    public function loginWithPassport($user) // gets authenticated $user injected
    {
        // perform your logic here to create or log in a new user

        // example:
        User::firstOrCreate(['name' => $user['name'], 'email' => ...]);
    }
}
```

Example of the `OAuth2\User` object `$user` (as JSON):

```json
{
  "accessTokenResponseBody": {
    "token_type": "Bearer",
    "expires_in": 31622400,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI4IiwianRpIjoiM2ZjODMwOTE3OTBmMmJmZWRiY2JhMzZiMGUyOGYzNzc1YTIyNThhMWI0OGMzOWM0MDUyMmRjN2IzZDE2NWU5MmQ4MzA0YjYwMTFkNTY4MjQiLCJpYXQiOjE1NzU5MDExNDAsIm5iZiI6MTU3NTkwMTE0MCwiZXhwIjoxNjA3NTIzNTQwLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.RVnhK1qTjNOvcI-BoYGUO_jCJ8oe_wBhgIyxoN-x00Yu2_c3Vco-y1b765AV1033Jh-_tz--ZNvqM1QoOc6JBDbXAmFoS_cPKfvdfPdNPMl-VgHsnl4OmfOFKlam7JW7UIWgDS0GFbAFa0KZK_3IIkfKLG8bUFc-9DyVPpXJgkShAO6ZdTolVPHiT4FGPAIXhrpbADkGncEng8QlrwRVXyHIjVwsMYAC7WU-4eVjyL45N0YzZPmTXxLHAedpPa6YqbVAY6OOBajhyah9b4bwjI1j5o11inZkcLpbQIxBWd7wivtFB28duGDOMmDSurCIseO3iDKLUC-ppH27hmwSG2JwENCde1SBNCjEkn6q6mINKTfdp8W5LJUIogHnxfsRQH4LAXvOlx_RkA9vOedV18TocH7uMnGK34IDP2KzWhu6EYgGSNnXi5TCLNES-Hm7CJN5YrU4FrKiOmdi9ttg0YjzTFE5TkpHvlKu6Ym_qadnygUnmZl_Gd5m0_7iV9vqhb0S5-dTh8RkoUmzac-lo8d3e4pdhJ1p3OrrXklO41Bs7AwpMM-5kcxSwwnwqDjLOrO2O5Knl3Kf8E0dVo4CQpq3Ry9SydAhEqEcjQeMNXiShuggwolVrE_WLnC4nW_VpQIvYlvcT23H2PX_Xdj1w8UVEElUrgFVYrzNoBBrJxM",
    "refresh_token": "def50200847d476003f4cf5bd36a49a9dccb3d0a010eb3a4ff030d5b4eb0aae30bcd9cbf1c65cab34d6309acf2757e37286e1c9db963bfad72dc40f51ff531b45d3bb329f95b6353659446fb0d748b4879aabd335c2642ad6c7eb1b0e685552ecd8c35fb858e15a8141a7c0f964625e20452ef05e47e1e980d3f0a5a5ebafc173bf1dc57f88fbb231723a3e04b362983632d84a411c3691a07fd391db6dd415671fe94706d4b47c2fc008166230ceb14b2b9bc6031e591677c485b9cfd2715e93d47cc0407dcb0e69487329020ba4ac3899b4975fcbbc9e3ef3fc8368610cbbde074345621bfecde465938cee6372ab033ea8ded4d31892d4d5d6fb8b099b0c29205faca5c248ad1eb66329b6f328966bbb987a7a761e81b3774d6ab9952b9c1d5f62fefc9df380227e488bdc754a1b22a7d989a906b3cdd22946b9d8358e13f52e4bae189c59ce7263ad988328edb8f9d8556aaecf8b7771be539b745893f8d9e"
  },
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI4IiwianRpIjoiM2ZjODMwOTE3OTBmMmJmZWRiY2JhMzZiMGUyOGYzNzc1YTIyNThhMWI0OGMzOWM0MDUyMmRjN2IzZDE2NWU5MmQ4MzA0YjYwMTFkNTY4MjQiLCJpYXQiOjE1NzU5MDExNDAsIm5iZiI6MTU3NTkwMTE0MCwiZXhwIjoxNjA3NTIzNTQwLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.RVnhK1qTjNOvcI-BoYGUO_jCJ8oe_wBhgIyxoN-x00Yu2_c3Vco-y1b765AV1033Jh-_tz--ZNvqM1QoOc6JBDbXAmFoS_cPKfvdfPdNPMl-VgHsnl4OmfOFKlam7JW7UIWgDS0GFbAFa0KZK_3IIkfKLG8bUFc-9DyVPpXJgkShAO6ZdTolVPHiT4FGPAIXhrpbADkGncEng8QlrwRVXyHIjVwsMYAC7WU-4eVjyL45N0YzZPmTXxLHAedpPa6YqbVAY6OOBajhyah9b4bwjI1j5o11inZkcLpbQIxBWd7wivtFB28duGDOMmDSurCIseO3iDKLUC-ppH27hmwSG2JwENCde1SBNCjEkn6q6mINKTfdp8W5LJUIogHnxfsRQH4LAXvOlx_RkA9vOedV18TocH7uMnGK34IDP2KzWhu6EYgGSNnXi5TCLNES-Hm7CJN5YrU4FrKiOmdi9ttg0YjzTFE5TkpHvlKu6Ym_qadnygUnmZl_Gd5m0_7iV9vqhb0S5-dTh8RkoUmzac-lo8d3e4pdhJ1p3OrrXklO41Bs7AwpMM-5kcxSwwnwqDjLOrO2O5Knl3Kf8E0dVo4CQpq3Ry9SydAhEqEcjQeMNXiShuggwolVrE_WLnC4nW_VpQIvYlvcT23H2PX_Xdj1w8UVEElUrgFVYrzNoBBrJxM",
  "refreshToken": "def50200847d476003f4cf5bd36a49a9dccb3d0a010eb3a4ff030d5b4eb0aae30bcd9cbf1c65cab34d6309acf2757e37286e1c9db963bfad72dc40f51ff531b45d3bb329f95b6353659446fb0d748b4879aabd335c2642ad6c7eb1b0e685552ecd8c35fb858e15a8141a7c0f964625e20452ef05e47e1e980d3f0a5a5ebafc173bf1dc57f88fbb231723a3e04b362983632d84a411c3691a07fd391db6dd415671fe94706d4b47c2fc008166230ceb14b2b9bc6031e591677c485b9cfd2715e93d47cc0407dcb0e69487329020ba4ac3899b4975fcbbc9e3ef3fc8368610cbbde074345621bfecde465938cee6372ab033ea8ded4d31892d4d5d6fb8b099b0c29205faca5c248ad1eb66329b6f328966bbb987a7a761e81b3774d6ab9952b9c1d5f62fefc9df380227e488bdc754a1b22a7d989a906b3cdd22946b9d8358e13f52e4bae189c59ce7263ad988328edb8f9d8556aaecf8b7771be539b745893f8d9e",
  "expiresIn": 31622400,
  "id": 1,
  "nickname": null,
  "name": "John",
  "email": "johnbraun@pm.me",
  "avatar": null,
  "user": {
    "id": 1,
    "name": "John",
    "email": "johnbraun@pm.me",
    "email_verified_at": null,
    "created_at": "2019-12-08 06:38:54",
    "updated_at": "2019-12-08 06:38:54"
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
