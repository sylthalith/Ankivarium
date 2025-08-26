<?php

namespace App\Services;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login($user)
    {
        Auth::login($user);
        session()->regenerate();
    }

    public function register(array $attributes)
    {
        $user = User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'] ?? null,
            'password' => isset($attributes['password'])
                ? Hash::make($attributes['password'])
                : null,
        ]);

        event(new Registered($user));

        $this->login($user);

        return $user;
    }

    public function authenticateWithSocialAccount($provider, $providerId, $username)
    {
        $socialAccount = $this->findSocialAccount($provider, $providerId);

        if ($socialAccount) {
            $user = $socialAccount->user;

            $this->login($user);

            return $user;
        }

        $user = $this->register(['name' => $username]);

        $user->socialAccount()->create([
            'provider' => $provider,
            'provider_id' => $providerId,
        ]);

        return $user;
    }
    public function findSocialAccount($provider, $providerId)
    {
        return SocialAccount::where('provider', $provider)
            ->where('provider_id', $providerId)
            ->first();
    }
}
