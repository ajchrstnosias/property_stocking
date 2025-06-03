<x-app-layout>
<x-slot name="header_title">Item Requests</x-slot>
    <x-slot name="title">Item Requests</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-semibold mb-4">Manage Item Requests</h2>
                    <p>
                        From here, you can view, approve, or deny item requests from staff.
                    </p>
                    <p class="mt-4">
                        Use the status filter to view pending, approved, or denied requests.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('admin.requests.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            View All Requests
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 