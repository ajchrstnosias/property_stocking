<x-guest-layout>
    <div class="mb-8 text-left">
        <h2 class="text-3xl font-bold text-gray-800">Log in</h2>
        <p class="text-gray-600">Welcome back! Please enter your details.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 pr-10" 
                                type="password" 
                                name="password" 
                                required autocomplete="current-password" 
                                placeholder="Enter your password" />
                <button type="button" onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 right-0 px-3 flex items-center text-sm text-gray-600 hover:text-gray-800">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                        <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.18l.881-.881a1.651 1.651 0 011.18-.489h14.552a1.651 1.651 0 011.18.489l.881.881a1.651 1.651 0 010 1.18l-.881.881a1.651 1.651 0 01-1.18.489H2.727a1.651 1.651 0 01-1.18-.489l-.881-.881zM10 15a5 5 0 100-10 5 5 0 000 10z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full justify-center py-3 text-base font-semibold" style="background-color: #0000CD; color: white;">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center text-sm text-gray-600">
            Don't have an account? 
            <a class="font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('register') }}">
                Register
            </a>
        </div>

        <div class="mt-4 text-center text-sm text-gray-600">
            or Log in as an 
            <a href="{{ route('login') }}?as=admin" class="font-medium text-indigo-600 hover:text-indigo-500">
                Admin
            </a>
        </div>
    </form>

    <script>
        function togglePasswordVisibility(id) {
            const passwordInput = document.getElementById(id);
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            // Optionally, change the eye icon here if you have two different icons
        }
    </script>
</x-guest-layout>
