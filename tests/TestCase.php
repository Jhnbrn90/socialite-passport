<?php

namespace JhnBrn90\SocialitePassport\Tests;

use Orchestra\Testbench\TestCase as Base;
use JhnBrn90\SocialitePassport\SocialitePassportServiceProvider;

class TestCase extends Base
{
    /**
     * Register the package's Service Provider
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            SocialitePassportServiceProvider::class,
        ];
    }
}
