<?php

namespace JhnBrn90\SocialitePassport;

use Illuminate\Support\ServiceProvider;
use JhnBrn90\SocialitePassport\Http\Controllers\AuthenticationController;
use JhnBrn90\SocialitePassport\Providers\EventServiceProvider;

class SocialitePassportServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'../../routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('socialite-passport.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'socialite-passport');
        $this->mergeConfigFrom(__DIR__.'/../config/services.php', 'services');

        $this->app->register(EventServiceProvider::class);

        $this->app->bind('AuthenticationController', function () {
            return new AuthenticationController();
        });
    }
}
