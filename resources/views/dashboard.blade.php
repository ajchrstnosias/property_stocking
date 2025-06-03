<x-app-layout>
    <x-slot name="header_title">
        @if (Auth::user()->role === 'admin')
            Admin Dashboard
        @else
            Staff Dashboard
        @endif
    </x-slot>
    <x-slot name="title">
        @if (Auth::user()->role === 'admin')
            Admin Dashboard
        @else
            Staff Dashboard
        @endif
    </x-slot>

    <div class="space-y-8">
        <!-- Session Messages -->
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Overview Section -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-4">Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if (Auth::user()->role === 'admin')
                    <!-- Total Items Card -->
                    <div class="stat-card p-6 rounded-lg shadow-md text-center">
                        <h3 class="text-4xl font-bold text-blue-600">{{ $totalItems ?? 0 }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Total Items</p>
                    </div>
                    <!-- In Stock Card -->
                    <div class="stat-card p-6 rounded-lg shadow-md text-center">
                        <h3 class="text-4xl font-bold text-green-600">{{ $inStockItems ?? 0 }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Total Quantity In Stock</p>
                    </div>
                    <!-- Categories Card -->
                    <div class="stat-card p-6 rounded-lg shadow-md text-center">
                        <h3 class="text-4xl font-bold text-purple-600">{{ $categoriesCount ?? 0 }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Categories</p>
                    </div>
                @else <!-- Staff View -->
                    <div class="stat-card p-6 rounded-lg shadow-md text-center">
                        <h3 class="text-4xl font-bold text-blue-600">{{ $totalBorrowedItemsCount ?? 0 }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">My Total Items Borrowed</p>
                    </div>
                @endif
            </div>
        </div>

        @if (Auth::user()->role === 'staff')
        <!-- My Borrowed Items Section (for Staff) has been removed as per user request. -->
        <!-- This functionality is now covered by the 'My Item Requests' page. -->
        @endif

        @if (Auth::user()->role === 'admin')
        <!-- All Borrowed Items Section (for Admin) -->
        <div id="all-borrowed-items">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">All Currently Borrowed Items</h2>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Staff Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Item Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Property #</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Qty</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date Issued</th>
                            {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($borrowedItemsByStaff ?? [] as $request)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $request->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $request->item->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $request->item->property_number ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $request->requested_quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $request->updated_at->format('m/d/Y') }}</td>
                                {{-- <td class="px-6 py-4 whitespace-nowrap text-sm"> --}}
                                    {{-- Placeholder for admin actions e.g. Mark as Returned --}}
                                {{-- </td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">
                                    No items are currently borrowed by staff.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Request System Section -->
        <div id="item-requests">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    @if(Auth::user()->role === 'admin')
                        Recent Item Requests
                    @else
                        My Recent Item Requests
                    @endif
                </h2>
                @if(Auth::user()->role === 'staff')
                    <a href="{{ route('requests.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg inline-flex items-center">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        New Item Request
                    </a>
                @endif
                </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Item</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($recentRequests as $request)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $request->created_at->format('m/d/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $request->item->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $request->requested_quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = '';
                                        switch ($request->status) {
                                            case 'approved':
                                                $statusClass = 'bg-green-100 text-green-800';
                                                break;
                                            case 'pending':
                                                $statusClass = 'bg-yellow-100 text-yellow-800';
                                                break;
                                            case 'denied':
                                                $statusClass = 'bg-red-100 text-red-800';
                                                break;
                                            default:
                                                $statusClass = 'bg-gray-100 text-gray-800';
                                        }
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">
                                    No recent requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
