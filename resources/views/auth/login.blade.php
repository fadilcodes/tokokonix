<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600 ">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col items-end justify-end mt-4">
            <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    <button class="text-1xl w-full  bg-[#01c2a2] pt-2 pb-2 rounded-lg font-bold text-white hover:bg-[#02aa8e]">{{ __('Log in') }}</button>
            </x-responsive-nav-link>
             @if (Route::has('password.request'))
                <a class=" underline text-sm text-[#4a4a4a] hover:text-[#01c2a2] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

        </div>
       
    </form>
     <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                    <button class="text-1xl w-full border-2 border-[#01c2a2] pt-1 pb-1 rounded-lg font-bold">{{ __('Register') }}</button>
                        </x-responsive-nav-link>
</x-guest-layout>
