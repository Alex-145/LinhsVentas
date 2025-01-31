<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <img src="{{ asset('storage/pageweb/logologin1.png') }}" alt="Logo" class="h-20 w-auto" />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" class="text-[#135bcb] font-bold" />
                <x-input id="email" class="block mt-1 w-full border border-[#135bcb] focus:ring-[#ea6b22] focus:border-[#ea6b22]" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" class="text-[#135bcb] font-bold" />
                <x-input id="password" class="block mt-1 w-full border border-[#135bcb] focus:ring-[#ea6b22] focus:border-[#ea6b22]" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" class="text-[#ea6b22] focus:ring-[#ea6b22]" />
                    <span class="ms-2 text-sm text-[#135bcb]">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-[#135bcb] hover:text-[#ea6b22] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#ea6b22]" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4 bg-[#ea6b22] hover:bg-[#d95f1f] text-white">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
