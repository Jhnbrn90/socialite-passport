# Socialite Passport

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jhnbrn90/socialite-passport.svg?style=flat-square)](https://packagist.org/packages/jhnbrn90/socialite-passport)
[![Build Status](https://img.shields.io/travis/Jhnbrn90/socialite-passport/master.svg?style=flat-square)](https://travis-ci.org/Jhnbrn90/socialite-passport)
[![Quality Score](https://img.shields.io/scrutinizer/g/jhnbrn90/socialite-passport.svg?style=flat-square)](https://scrutinizer-ci.com/g/jhnbrn90/socialite-passport)
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
```
'controller'  => [
    'class'     => \App\Http\Controllers\Auth\LoginController::class,
    'method'    => 'loginWithPassport',
]
```

Add the following environment variables to `.env`:

```
LARAVELPASSPORT_CLIENT_ID=3
LARAVELPASSPORT_CLIENT_SECRET=..............
LARAVELPASSPORT_REDIRECT_URI=https://app1.example.com/login/callback
LARAVELPASSPORT_HOST=https://auth.example.com
```

The `CLIENT_ID` and `CLIENT_SECRET` are obtained from the "ID provider", which uses Laravel Passport.

## Usage

The example configuration (above) assumes you have added a `loginWithPassport()` method to the default `LoginController`. 
This method will get the `$user` object injected (see https://socialiteproviders.netlify.com/providers/laravel-passport.html).

```php
<?php
use App\User;

class LoginController extends Controller 
{
    public function loginWithPassport($user)
    {
        // logic to create or log in a new user
        User::firstOrCreate(['name' => $user->user->name, 'email' => ...]);
    }
}
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

### Security

If you discover any security related issues, please email johnbraun@pm.me instead of using the issue tracker.

## Credits

- [John Braun](https://github.com/jhnbrn90)
- [All Contributors](../../contributors)
