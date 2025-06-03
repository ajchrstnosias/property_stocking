<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Property Stocking System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])

            <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #F3F4F6; /* Light gray background */
        }
        .hero-section {
            background-image: url("{{ asset('images/campus_background.jpg') }}");
            background-size: cover;
            background-position: center;
            background-color: rgba(0, 0, 50, 0.6); /* Dark blueish overlay */
            background-blend-mode: multiply;
        }
        .nav-link {
            @apply px-3 py-2 rounded-md text-sm font-semibold text-white hover:bg-blue-700;
        }
        .footer-link {
            @apply text-sm text-gray-400 hover:text-white;
        }
        .feature-card {
            @apply bg-white p-6 rounded-lg shadow-lg flex flex-col items-center text-center;
        }
        .feature-card svg {
            @apply w-12 h-12 text-blue-600 mb-4;
        }
            </style>
    </head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-blue-800 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="flex-shrink-0">
                            <img class="h-10 w-auto" src="{{ asset('images/psu_logo.png') }}" alt="PSU Logo">
                        </a>
                        <div class="hidden md:block ml-10">
                            <div class="flex items-baseline space-x-4">
                                <a href="{{ url('/') }}" class="nav-link bg-blue-900">Home</a>
                                <a href="#about" class="nav-link">About Us</a>
                                <a href="#features" class="nav-link">Features</a>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6 space-x-4">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <button type="button" class="bg-blue-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-800 focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="md:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="{{ url('/') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-blue-900">Home</a>
                    <a href="#about" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-blue-700">About Us</a>
                    <a href="#features" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-blue-700">Features</a>
                     @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-blue-700">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-blue-700">Login</a>
                        @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-blue-700">Register</a>
                        @endif
                    @endauth
                    @endif
                </div>
            </div>
                </nav>

        <!-- Hero Section -->
        <header class="hero-section text-white py-20 md:py-32">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="flex justify-center mb-6">
                     <img class="h-20 w-auto" src="{{ asset('images/psu_logo.png') }}" alt="PSU Logo">
                </div>
                <h1 class="text-4xl font-extrabold sm:text-5xl md:text-6xl">
                    Property Stocking System
                </h1>
                <p class="mt-6 max-w-2xl mx-auto text-xl text-blue-100">
                    Track, Manage, and Secure Your Assets
                </p>
                <div class="mt-10">
                    <a href="{{ route('register') }}" class="inline-block bg-white text-blue-700 font-semibold py-3 px-8 rounded-lg shadow-md hover:bg-blue-50 transition duration-300">
                        Get Started
                    </a>
                </div>
            </div>
        </header>

        <!-- About Us Section -->
        <section id="about" class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                        About Us
                    </h2>
                    <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                        Our Property Stocking System is specifically designed to support the asset management needs of Pangasinan State University - Urdaneta Campus, ensuring efficient tracking and maintenance of campus resources.
                    </p>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="feature-card">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Efficient Asset Management</h3>
                        <p class="text-gray-600">Streamline the management of campus assets with real-time tracking, automated stock updates, and centralized inventory control.</p>
                    </div>
                    <div class="feature-card">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                                    </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">User-Friendly Request System</h3>
                        <p class="text-gray-600">Simplify the process for staff to request items, with instant email updates and clear communication for faster approvals.</p>
                    </div>
                    <div class="feature-card">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                                    </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Comprehensive Reporting</h3>
                        <p class="text-gray-600">Generate detailed reports for stock levels, item usage, and movement history, empowering administrators to make data-driven decisions.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-800 text-gray-300 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h5 class="text-lg font-semibold text-white mb-4">Property Stocking System</h5>
                        <p class="text-sm text-gray-400">Efficient asset tracking for PSU Urdaneta Campus. Helping you manage resources effectively.</p>
                    </div>
                    <div>
                        <h5 class="text-lg font-semibold text-white mb-4">Contact</h5>
                        <off class="footer-link">@psuurdofficial</p>
                        <p class="footer-link">Phone: (075) 632 2559</p>
                        <p class="mt-2 text-gray-400 text-sm">
                            Pangasinan State University - Urdaneta Campus,<br>
                            San Vicente, Urdaneta, Philippines, 2428
                        </p>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-700 pt-8 text-center">
                    <p class="text-sm text-gray-400">&copy; {{ date('Y') }} Property Stocking System. All Rights Reserved.</p>
                </div>
            </div>
        </footer>

        </div>
    <script>
        // Mobile menu toggle
        const menuButton = document.querySelector('[aria-controls="mobile-menu"]');
        const mobileMenu = document.getElementById('mobile-menu');
        let menuOpen = false;

        menuButton.addEventListener('click', () => {
            menuOpen = !menuOpen;
            mobileMenu.classList.toggle('hidden');
            menuButton.querySelectorAll('svg').forEach(svg => svg.classList.toggle('hidden'));
        });
    </script>
    </body>
</html>
