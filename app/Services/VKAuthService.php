<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class VKAuthService
{
    protected string $authURL = 'https://id.vk.com/oauth2/auth';
    protected string $userInfoURL = 'https://id.vk.com/oauth2/user_info';
    protected string $logoutURL = 'https://id.vk.com/oauth2/logout';
    protected string $redirectURI;
    protected string $clientId;

    public function __construct()
    {
        $this->redirectURI = config('services.vk.redirect');
        $this->clientId = config('services.vk.client_id');
    }

    public function authenticate($codeVerifier, $code, $deviceId, $state, $expectedState)
    {
        $this->validateState($state, $expectedState);

        if (!$codeVerifier) {
            throw new Exception('Отсутствует code_verifier');
        }

        $accessToken = $this->getAccessToken($codeVerifier, $code, $deviceId, $state);

        return $this->getUserInfo($accessToken);

    }

    public function validateState($state, $expectedState)
    {
        if ($state !== session('vk_state')) {
            throw new Exception('Неверный state');
        }
    }

    public function getAccessToken($codeVerifier, $code, $deviceId, $state)
    {
        $response = Http::asForm()->post($this->authURL, [
            'grant_type' => 'authorization_code',
            'code_verifier' => $codeVerifier,
            'redirect_uri' => $this->redirectURI,
            'code' => $code,
            'client_id' => $this->clientId,
            'device_id' => $deviceId,
            'state' => $state,
        ]);

        if (!$response->successful()) {
            throw new Exception($response->json()['error_description']);
        }

        return $response->json()['access_token'];
    }

    public function getUserInfo($accessToken)
    {
        $response = Http::asForm()->post($this->userInfoURL, [
            'client_id' => $this->clientId,
            'access_token' => $accessToken,
        ]);

        if (!$response->successful()) {
            throw new Exception($response->json()['error_description']);
        }

        return $response->json();
    }

    public function logout($accessToken)
    {
        Http::asForm()->post($this->logoutURL, [
            'client_id' => $this->clientId,
            'access_token' => $accessToken,
        ]);
    }
}
