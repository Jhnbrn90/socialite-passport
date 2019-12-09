<?php

namespace JhnBrn90\SocialitePassport\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SocialiteWasCalled::class => [
            'SocialiteProviders\\LaravelPassport\\LaravelPassportExtendSocialite@handle'
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
