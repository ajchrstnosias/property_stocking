<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Property Stocking') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .sidebar {
                background-color: #1E3A8A; /* Dark Blue for sidebar */
            }
            .sidebar a.active {
                background-color: #2563EB; /* Lighter Blue for active */
            }
            .stat-card {
                background-color: #F3F4F6; /* Light gray for stat cards */
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        <div class="flex h-screen">
            <!-- Sidebar -->
            <aside class="sidebar w-64 min-h-screen p-6 flex flex-col text-white">
                <div class="flex items-center justify-center mb-10 flex-col">
                    <img src="{{ asset('images/psu_logo.png') }}" alt="PSU Logo" class="h-20">
                    <h2 class="mt-2 text-lg font-semibold">Property Stocking</h2>
                </div>
                <nav class="flex-grow">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center py-3 px-4 rounded-lg {{ request()->routeIs('dashboard') && !Str::contains(request()->fullUrl(), '#') ? 'active' : '' }}">
                        <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                        Dashboard
                    </a>

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" 
                           class="mt-3 flex items-center py-3 px-4 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                            </svg>
                            Item Requests
                        </a>
                        <a href="{{ route('admin.items.index') }}" 
                           class="mt-3 flex items-center py-3 px-4 rounded-lg {{ request()->routeIs('admin.items.*') ? 'active' : '' }}">
                            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM5 11a1 1 0 100 2h8a1 1 0 100-2H5zM3 15a2 2 0 114 0H3zM3 5a2 2 0 114 0H3z" /></svg>
                            Manage Items
                        </a>
                        <a href="{{ route('admin.categories.index') }}" 
                           class="mt-3 flex items-center py-3 px-4 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" /></svg>
                            Manage Categories
                        </a>
                        <a href="{{ route('admin.locations.index') }}" 
                           class="mt-3 flex items-center py-3 px-4 rounded-lg {{ request()->routeIs('admin.locations.*') ? 'active' : '' }}">
                            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                            Manage Locations
                        </a>
                        <a href="{{ route('admin.reports.transactions.form') }}" 
                           class="mt-3 flex items-center py-3 px-4 rounded-lg {{ request()->routeIs('admin.reports.transactions.form') ? 'active' : '' }}">
                            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 6a2 2 0 012-2h2a2 2 0 012 2v0a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM2 12a2 2 0 012-2h2a2 2 0 012 2v0a2 2 0 01-2 2H4a2 2 0 01-2-2v0zM8 6a2 2 0 012-2h2a2 2 0 012 2v0a2 2 0 01-2 2H10a2 2 0 01-2-2V6zM8 12a2 2 0 012-2h2a2 2 0 012 2v0a2 2 0 01-2 2H10a2 2 0 01-2-2v0zM14 6a2 2 0 012-2h2a2 2 0 012 2v0a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM14 12a2 2 0 012-2h2a2 2 0 012 2v0a2 2 0 01-2 2h-2a2 2 0 01-2-2v0z" /> <path d="M4 16a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1z" />
                            </svg>
                            Transaction Reports
                        </a>
                        {{-- Add links for User Management, Request Approval here --}}
                    @else
                        {{-- Staff specific links can go here if any, or just the general inventory/request links --}}
                        {{-- <a href="{{ route('dashboard') }}#borrowed-items" 
                            class="mt-3 flex items-center py-3 px-4 rounded-lg {{ Str::contains(request()->fullUrl(), '#borrowed-items') ? 'active' : '' }}">
                                <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                            My Borrowed Items
                        </a> --}}
                        <a href="{{ route('requests.myIndex') }}" 
                            class="mt-3 flex items-center py-3 px-4 rounded-lg {{ request()->routeIs('requests.myIndex') ? 'active' : '' }}">
                            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            My Item Requests
                        </a>
                    @endif
                </nav>
                <div class="mt-auto">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center py-3 px-4 rounded-lg">
                            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Header -->
                <header class="bg-white dark:bg-gray-800 shadow-md p-4">
                    <div class="flex justify-between items-center">
                        <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $header_title ?? 'Page Title' }}</h1>
                        <div class="flex items-center">
                            <span class="text-gray-600 dark:text-gray-300 mr-3">Welcome, {{ Auth::user()->name }}! ({{ ucfirst(Auth::user()->role) }})</span>
                            {{-- Add any other header items like notifications here --}}
                        </div>
                    </div>
                </header>

                <!-- Page Content Area -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900 p-6">
                {{ $slot }}
            </main>
            </div>
        </div>
    </body>
</html>
