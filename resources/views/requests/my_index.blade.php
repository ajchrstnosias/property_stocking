<x-app-layout>
    <x-slot name="header_title">My Item Requests</x-slot>
    <x-slot name="title">My Item Requests</x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">My Item Requests</h1>
            <a href="{{ route('requests.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg inline-flex items-center">
                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                New Item Request
            </a>
        </div>
        <div class="mb-4 text-right">
            <a href="{{ route('requests.myTransactionsReportPdf') }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg inline-flex items-center">
                <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a.5.5 0 00-1 0v3.793l-1.146-1.147a.5.5 0 00-.708.708l2 2a.5.5 0 00.708 0l2-2a.5.5 0 00-.708-.708L11 11.793V8z" clip-rule="evenodd" />
                </svg>
                Download My Transactions (PDF)
            </a>
        </div>

        <!-- Session Messages -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md dark:bg-green-700 dark:text-green-100 dark:border-green-600" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md dark:bg-red-700 dark:text-red-100 dark:border-red-600" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Status Filter Dropdown -->
        <form method="GET" action="{{ route('requests.myIndex') }}" class="mb-6">
            <div class="flex items-center">
                <label for="status" class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-300">Filter by status:</label>
                <select name="status" id="status" onchange="this.form.submit()" class="form-select rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All My Requests</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending Approval</option>
                    <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>Approved (Issued)</option>
                    <option value="pending_return_approval" {{ $status == 'pending_return_approval' ? 'selected' : '' }}>Pending Return</option>
                    <option value="returned" {{ $status == 'returned' ? 'selected' : '' }}>Returned</option>
                    <option value="denied" {{ $status == 'denied' ? 'selected' : '' }}>Denied</option>
                </select>
            </div>
        </form>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Req. ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Item</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Qty Req.</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date Requested</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Admin Remarks</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($myRequests as $itemRequest)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">#{{ $itemRequest->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $itemRequest->item->name ?? 'Item not found' }}
                                @if($itemRequest->item)
                                <div class="text-xs text-gray-500">Prop#: {{ $itemRequest->item->property_number }} / SN: {{ $itemRequest->item->serial_number ?? 'N/A' }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $itemRequest->requested_quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $itemRequest->created_at->format('m/d/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClass = '';
                                    $statusText = ucfirst($itemRequest->status);
                                    switch ($itemRequest->status) {
                                        case 'approved': $statusClass = 'bg-green-100 text-green-800'; $statusText = 'Approved (Issued)'; break;
                                        case 'pending': $statusClass = 'bg-yellow-100 text-yellow-800'; $statusText = 'Pending Approval'; break;
                                        case 'pending_return_approval': $statusClass = 'bg-blue-100 text-blue-800'; $statusText = 'Pending Return'; break;
                                        case 'returned': $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200'; $statusText = 'Returned'; break;
                                        case 'denied': $statusClass = 'bg-red-100 text-red-800'; break;
                                        default: $statusClass = 'bg-gray-100 text-gray-800';
                                    }
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-normal text-sm text-gray-500 dark:text-gray-400">
                                @if($itemRequest->remarks)
                                    <p class="text-xs" title="{{ $itemRequest->remarks }}">{{ Str::limit($itemRequest->remarks, 70) }}</p>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">
                                You have no item requests @if($status !== 'all') with status '{{ $status }}' @endif.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $myRequests->appends(['status' => $status])->links() }}
        </div>
    </div>
</x-app-layout> 