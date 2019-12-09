<?php

namespace JhnBrn90\SocialitePassport\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;

class AuthenticationController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::with('laravelpassport')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('laravelpassport')->user();

        $controller = resolve(config('socialite-passport.controller.class'));
        $method = config('socialite-passport.controller.method');

        return $controller->{$method}($user);
    }
}
