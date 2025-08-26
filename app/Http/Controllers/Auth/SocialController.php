<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\VKAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    private AuthService $authService;
    private VKAuthService $VKAuthService;

    public function __construct(AuthService $authService, VKAuthService $VKAuthService)
    {
        $this->authService = $authService;
        $this->VKAuthService = $VKAuthService;
    }

    public function handleGoogleRedirect()
    {
        Log::info('Google OAuth: Initiating redirect');
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        Log::info('Google OAuth Callback: User data received', [
            'provider_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'session_id' => session()->getId(),
        ]);

        $this->authService->authenticateWithSocialAccount('google', $user->id, $user->name);

        Log::info('Google OAuth Callback: User authenticated', [
            'auth_check' => Auth::check(),
            'user' => Auth::user() ? Auth::user()->toArray() : null,
            'session_id' => session()->getId(),
        ]);

        return redirect()->route('dashboard');
    }

    public function handleYandexRedirect()
    {
        return Socialite::driver('yandex')->redirect();
    }

    public function handleYandexCallback()
    {
        $user = Socialite::driver('yandex')->user();

        $this->authService->authenticateWithSocialAccount('yandex', $user->id, $user->name);

        return redirect()->route('dashboard');
    }

    public function handleVKCallback(Request $request)
    {
        $codeVerifier = session('vk_code_verifier');
        $code = $request->query('code');
        $deviceId = $request->query('device_id');
        $state = $request->query('state');
        $expectedState = session('vk_state');

        $user = $this->VKAuthService->authenticate($codeVerifier, $code, $deviceId, $state, $expectedState)['user'];

        $name = $user['first_name'] . ' ' . $user['last_name'];

        $this->authService->authenticateWithSocialAccount('vk', $user['user_id'], $name);

        return redirect()->route('dashboard');
    }
}
