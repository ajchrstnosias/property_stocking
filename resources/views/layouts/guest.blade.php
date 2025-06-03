<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Property Stocking') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .form-column {
                background-color: #FFFFFF; /* White background for form */
            }
            .welcome-column {
                background-image: url('/images/campus_background.jpg'); /* Ensure this path is correct */
                background-size: cover;
                background-position: center;
                background-color: #0033A0; /* PSU Blue as a fallback */
            }
            .welcome-text-overlay {
                background-color: rgba(0, 51, 160, 0.7); /* PSU Blue with transparency */
                padding: 2rem;
                border-radius: 0.5rem;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex items-stretch">
            <!-- Left Column (Form) -->
            <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-8 form-column">
                <div class="w-full max-w-md">
                    <div class="flex justify-start items-center mb-8">
                        <a href="/">
                            <img src="{{ asset('images/psu_logo.png') }}" alt="PSU Logo" class="h-16 mr-3">
                        </a>
                        <h1 class="text-2xl font-bold text-gray-700">Property Stocking</h1>
                    </div>
                    {{ $slot }}
                </div>
            </div>

            <!-- Right Column (Welcome Message & Image) -->
            <div class="hidden md:flex w-1/2 flex-col items-center justify-center text-white p-10 welcome-column">
                <div class="text-center welcome-text-overlay">
                    <h2 class="text-4xl font-bold mb-4">Welcome to Property Stocking</h2>
                    <p class="text-lg">Streamline your inventory, track assets, and stay organized with ease.</p>
                </div>
            </div>
        </div>
    </body>
</html>
