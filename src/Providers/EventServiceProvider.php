<?php

namespace JhnBrn90\SocialitePassport\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\\LaravelPassport\\LaravelPassportExtendSocialite@handle'
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
