<?php

namespace JhnBrn90\SocialitePassport;

use Illuminate\Support\ServiceProvider;

class SocialitePassportServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('socialite-passport.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'socialite-passport');
    }
}
