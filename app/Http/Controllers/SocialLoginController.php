<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    // redirect to provider
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // callback from provider
    public function callback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $user = User::updateOrCreate(
            [
                'email' => $socialUser->email,
            ],
            [
                'name' => $socialUser->name ?? 'No Name',
                'nickname' => $socialUser->nickname ?? null,
                'provider_id' => $socialUser->id,
                'provider_token' => $socialUser->token,
                'provider' => $provider,
                'role' => 'user',
            ]
        );

        Auth::login($user);

        return to_route('userHome');
    }
}
