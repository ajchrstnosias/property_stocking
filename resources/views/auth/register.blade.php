<x-guest-layout>
    <div class="mb-8 text-left">
        <h2 class="text-3xl font-bold text-gray-800">Register</h2>
        <p class="text-gray-600">Enter you details here</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- First Name -->
        <div>
            <x-input-label for="name" :value="__('First Name')" class="text-gray-700 font-semibold" />
            <x-text-input id="name" class="block mt-1 w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="name" :value="old('name')" required autofocus autocomplete="given-name" placeholder="Enter your first name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="mt-6">
            <x-input-label for="last_name" :value="__('Last Name')" class="text-gray-700 font-semibold" />
            <x-text-input id="last_name" class="block mt-1 w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" placeholder="Enter your last name" />
            {{-- <x-input-error :messages="$errors->get('last_name')" class="mt-2" /> --}}
            {{-- Add error handling for last_name if you modify controller and model --}}
        </div>

        <!-- Email Address -->
        <div class="mt-6">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
            <x-text-input id="password" class="block mt-1 w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            type="password" 
                            name="password" 
                            required autocomplete="new-password" 
                            placeholder="Create a password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-6">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-semibold" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full px-4 py-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            type="password" 
                            name="password_confirmation" required autocomplete="new-password" 
                            placeholder="Confirm your password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full justify-center py-3 text-base font-semibold" style="background-color: #0000CD; color: white;">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center text-sm text-gray-600">
            Already have an account? 
            <a class="font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('login') }}">
                Login
            </a>
        </div>
    </form>
</x-guest-layout>
