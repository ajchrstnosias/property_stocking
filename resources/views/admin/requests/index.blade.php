<x-app-layout>
    <x-slot name="header_title">Manage Item Requests</x-slot>
    <x-slot name="title">Item Requests</x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">Manage Item Requests</h1>
            <div>
                <!-- Status Dropdown -->
                <form method="GET" action="{{ route('admin.requests.index') }}" class="inline-block">
                    <select name="status" onchange="this.form.submit()" class="form-select rounded-md shadow-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All Requests</option>
                        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending Approval</option>
                        <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>Approved (Issued)</option>
                        <option value="pending_return_approval" {{ $status == 'pending_return_approval' ? 'selected' : '' }}>Pending Return</option>
                        <option value="returned" {{ $status == 'returned' ? 'selected' : '' }}>Returned</option>
                        <option value="denied" {{ $status == 'denied' ? 'selected' : '' }}>Denied</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Session Messages -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Req. ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Requested By</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Item</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Qty Req.</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Item Stock</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date Requested</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($itemRequests as $itemRequest)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">#{{ $itemRequest->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $itemRequest->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $itemRequest->item->name ?? 'Item not found' }}
                                @if($itemRequest->item)
                                <div class="text-xs text-gray-500">Prop#: {{ $itemRequest->item->property_number }} / SN: {{ $itemRequest->item->serial_number ?? 'N/A' }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $itemRequest->requested_quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 {{ $itemRequest->item && $itemRequest->item->quantity < $itemRequest->requested_quantity ? 'text-red-500 font-bold' : '' }}">
                                {{ $itemRequest->item->quantity ?? 'N/A' }}
                            </td>
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
                                @if($itemRequest->remarks)
                                    <p class="text-xs text-gray-500 mt-1" title="Admin Remarks">Note: {{ Str::limit($itemRequest->remarks, 50) }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if ($itemRequest->status === 'pending')
                                    <form action="{{ route('admin.requests.approve', $itemRequest->id) }}" method="POST" class="inline-block mr-2" onsubmit="return confirm('Are you sure you want to APPROVE this item issuance? This will deduct item quantity.');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-600">Approve Issuance</button>
                                    </form>
                                    <button onclick="openDenyModal({{ $itemRequest->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">Deny</button>
                                @elseif ($itemRequest->status === 'pending_return_approval')
                                    <form action="{{ route('admin.requests.approveReturn', $itemRequest->id) }}" method="POST" class="inline-block mr-2" onsubmit="return confirm('Are you sure you want to APPROVE this item return? This will mark the item as returned and update stock.');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-teal-600 hover:text-teal-900 dark:text-teal-400 dark:hover:text-teal-600">Approve Return</button>
                                    </form>
                                     <button onclick="openDenyReturnModal({{ $itemRequest->id }})" class="text-orange-600 hover:text-orange-900 dark:text-orange-400 dark:hover:text-orange-600">Deny Return</button>
                                @else
                                    Processed by: {{ $itemRequest->processedBy->name ?? 'N/A' }} <br>
                                    <span class="text-xs">{{ $itemRequest->processed_at ? $itemRequest->processed_at->format('m/d/Y H:i') : ''}}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">
                                No item requests found with status '{{ $status }}'.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $itemRequests->appends(['status' => $status])->links() }} <!-- Ensure status is appended to pagination links -->
        </div>
    </div>

    <!-- Deny Request Modal -->
    <div id="denyModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="deny-modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="denyForm" method="POST"> 
                    @csrf
                    @method('PATCH')
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="deny-modal-title">Deny Item Issuance Request</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Are you sure you want to deny issuance request #<strong id="denyRequestId"></strong>?</p>
                                    <label for="remarks_deny" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-3">Reason for Denial (Optional):</label>
                                    <textarea name="remarks" id="remarks_deny" rows="3" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Confirm Deny Issuance
                        </button>
                        <button type="button" onclick="closeDenyModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-200 text-base font-medium text-gray-700 dark:text-gray-800 hover:bg-gray-50 dark:hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Deny Return Modal -->
    <div id="denyReturnModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="deny-return-modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="denyReturnForm" method="POST"> 
                    @csrf
                    @method('PATCH')
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="deny-return-modal-title">Deny Item Return Request</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Are you sure you want to deny return for request #<strong id="denyReturnRequestId"></strong>?</p>
                                    <label for="remarks_return_deny" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-3">Reason for Denying Return (Optional):</label>
                                    <textarea name="remarks" id="remarks_return_deny" rows="3" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-gray-900 dark:text-gray-100"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Confirm Deny Return
                        </button>
                        <button type="button" onclick="closeDenyReturnModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-200 text-base font-medium text-gray-700 dark:text-gray-800 hover:bg-gray-50 dark:hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const denyModal = document.getElementById('denyModal');
        const denyForm = document.getElementById('denyForm');
        const denyRequestId = document.getElementById('denyRequestId');
        const remarksDenyTextarea = document.getElementById('remarks_deny');

        const denyReturnModal = document.getElementById('denyReturnModal');
        const denyReturnForm = document.getElementById('denyReturnForm');
        const denyReturnRequestId = document.getElementById('denyReturnRequestId');
        const remarksReturnDenyTextarea = document.getElementById('remarks_return_deny');


        function openDenyModal(requestId) {
            denyRequestId.textContent = requestId;
            denyForm.action = "{{ url('admin/requests') }}/" + requestId + "/deny"; 
            denyModal.classList.remove('hidden');
        }

        function closeDenyModal() {
            denyModal.classList.add('hidden');
            if(remarksDenyTextarea) remarksDenyTextarea.value = '';
        }

        function openDenyReturnModal(requestId) {
            denyReturnRequestId.textContent = requestId;
            denyReturnForm.action = "{{ url('admin/requests') }}/" + requestId + "/deny-return";
            denyReturnModal.classList.remove('hidden');
        }

        function closeDenyReturnModal() {
            denyReturnModal.classList.add('hidden');
            if(remarksReturnDenyTextarea) remarksReturnDenyTextarea.value = '';
        }
    </script>
</x-app-layout> 