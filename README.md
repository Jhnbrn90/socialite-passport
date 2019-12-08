# Socialite Passport

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jhnbrn90/socialite-passport.svg?style=flat-square)](https://packagist.org/packages/jhnbrn90/socialite-passport)
[![Build Status](https://img.shields.io/travis/Jhnbrn90/socialite-passport/master.svg?style=flat-square)](https://travis-ci.org/Jhnbrn90/socialite-passport)
[![Quality Score](https://img.shields.io/scrutinizer/g/jhnbrn90/socialite-passport.svg?style=flat-square)](https://scrutinizer-ci.com/g/jhnbrn90/socialite-passport)
[![Total Downloads](https://img.shields.io/packagist/dt/jhnbrn90/socialite-passport.svg?style=flat-square)](https://packagist.org/packages/jhnbrn90/socialite-passport)

 ... Description of what the package does goes here...

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

The example configuration (above) assumes you have added a `loginWithPassport()` method to the default `LoginController`. 
This method will get the `$user` object injected (see https://socialiteproviders.netlify.com/providers/laravel-passport.html).

```php
<?php
class LoginController extends Controller 
{
    loginWithPassport($user)
    {
        // logic to create or log in a new user
        User::firstOrCreate([...]);
    }
}
```

## Usage

... how to use the package ...

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
