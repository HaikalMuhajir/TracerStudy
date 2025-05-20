<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Toggle Buttons -->
    <div class="flex justify-center space-x-4 mb-6">
        <button id="btn-otp" type="button" class="px-4 py-2 bg-indigo-600 text-white rounded">Login dengan OTP</button>
        <button id="btn-password" type="button" class="px-4 py-2 bg-gray-200 rounded">Login dengan Password</button>
    </div>

    <!-- OTP Form -->
    <form method="POST" action="{{ route('otp.send') }}" id="form-otp">
        @csrf

        <div>
            <x-input-label for="email_otp" :value="__('Email')" />
            <x-text-input id="email_otp" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-primary-button>Kirim OTP</x-primary-button>
        </div>
    </form>

    <!-- Password Login Form -->
    <form method="POST" action="{{ route('login') }}" id="form-password" style="display: none;">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email_pass" :value="__('Email')" />
            <x-text-input id="email_pass" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Toggle Script -->
    <script>
        const btnOtp = document.getElementById('btn-otp');
        const btnPassword = document.getElementById('btn-password');
        const formOtp = document.getElementById('form-otp');
        const formPassword = document.getElementById('form-password');

        btnOtp.addEventListener('click', () => {
            formOtp.style.display = 'block';
            formPassword.style.display = 'none';
            btnOtp.classList.add('bg-indigo-600', 'text-white');
            btnOtp.classList.remove('bg-gray-200');
            btnPassword.classList.remove('bg-indigo-600', 'text-white');
            btnPassword.classList.add('bg-gray-200');
        });

        btnPassword.addEventListener('click', () => {
            formOtp.style.display = 'none';
            formPassword.style.display = 'block';
            btnPassword.classList.add('bg-indigo-600', 'text-white');
            btnPassword.classList.remove('bg-gray-200');
            btnOtp.classList.remove('bg-indigo-600', 'text-white');
            btnOtp.classList.add('bg-gray-200');
        });
    </script>
</x-guest-layout>
