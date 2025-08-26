<x-app-layout title="Вход в аккаунт">
    @push('styles')
        @vite(['resources/css/center-div.css'])
    @endpush

    <div class="center">
        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <div class="input-group">
                <label for="name">Имя пользователя</label>
                <input id="name" name="name" type="text" required>
                <x-input-error :messages="$errors->get('name')"></x-input-error>
            </div>
            <div class="input-group">
                <label for="password">Пароль</label>
                <input id="password" name="password" type="password" required>
                <x-input-error :messages="$errors->get('password')"></x-input-error>
            </div>
            <label for="remember">Запомнить</label>
            <input id="remember" name="remember" type="checkbox">
            <button type="submit">Вход</button>
        </form>

        <div id="VkIdSdkOneTap"></div>
    </div>

    @php
        $codeVerifier = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
        $state = \Illuminate\Support\Str::random(32);
        $codeChallenge = rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');
        session(['vk_code_verifier' => $codeVerifier, 'vk_state' => $state]);
        \Log::info('Generated VK params:', [
        'code_verifier' => $codeVerifier,
        'code_challenge' => $codeChallenge,
        'state' => $state,
    ]);
    @endphp

    @push('scripts')
        <script src="https://unpkg.com/@vkid/sdk@2.6.0/dist-sdk/umd/index.js"></script>
        <script>
            const VKID = window.VKIDSDK

            VKID.Config.init({
                app: '{{ config('services.vk.client_id') }}',
                redirectUrl: '{{ config('services.vk.redirect') }}',
                state: '{{ $state }}',
                codeChallenge: '{{ $codeChallenge }}',
                scope: 'email phone',
            });

            const oneTap = new VKID.OneTap();

            const container = document.getElementById('VkIdSdkOneTap');
            if (container) {
                oneTap.render({
                    container: container,
                    scheme: VKID.Scheme.LIGHT,
                    lang: VKID.Languages.RUS,
                    styles: {
                        width: 44, // Компактная ширина
                        height: 44, // Компактная высота
                        borderRadius: 22, // Скругленные углы
                    },
                }).on(VKID.WidgetEvents.ERROR, handleError); // handleError — какой-либо обработчик ошибки.
            }
        </script>
    @endpush
</x-app-layout>
