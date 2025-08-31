<x-guest-layout>
    <div class="min-h-screen bg-cover bg-center flex items-center justify-center"
         style="background-image: url('{{ asset('images/background.png') }}');">
        <div class="bg-white bg-opacity-90 rounded-xl shadow-lg p-10 w-full max-w-md relative z-10">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logosekolah.png') }}" alt="Logo" class="h-20">
            </div>
            <h1 class="text-center text-2xl font-bold text-[#003B4B] tracking-widest mb-6">LOGIN</h1>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" class="text-[#003B4B]" />
                    <x-text-input id="email" class="block mt-1 w-full border-[#003B4B]" type="email"
                                  name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" class="text-[#003B4B]" />
                    <x-text-input id="password" class="block mt-1 w-full border-[#003B4B]" type="password"
                                  name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="text-[#003B4B] border-gray-300 rounded" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember Me') }}</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-500 hover:text-[#003B4B]" href="{{ route('password.request') }}">
                            {{ __('forgot your password?') }}
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <div class="text-center">
                    <button class="bg-[#035B73] hover:bg-[#003B4B] text-white px-6 py-2 rounded mx-auto block">
                        {{ __('LOG IN') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
