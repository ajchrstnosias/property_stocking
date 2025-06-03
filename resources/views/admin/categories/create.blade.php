<x-app-layout>
    <x-slot name="header_title">Create New Category</x-slot>
    <x-slot name="title">New Category</x-slot>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <h1 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-6">Create New Category</h1>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @include('admin.categories._form')
            </form>
        </div>
    </div>
</x-app-layout> 