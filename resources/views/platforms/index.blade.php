@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Social Media Platforms</h2>
                    <a href="{{ route('platforms.create') }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Platform
                    </a>
                </div>

                <!-- Platforms Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($platforms as $platform)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <img class="h-12 w-12 rounded-full" src="{{ $platform->icon }}" alt="{{ $platform->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-medium text-gray-900">{{ $platform->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $platform->type }}</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('platforms.edit', $platform) }}" 
                                            class="text-indigo-600 hover:text-indigo-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('platforms.destroy', $platform) }}" method="POST" class="inline delete-platform-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-900 delete-platform-btn">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                        @push('scripts')
                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                document.querySelectorAll('.delete-platform-btn').forEach(function(btn) {
                                                    btn.addEventListener('click', function(e) {
                                                        e.preventDefault();
                                                        Swal.fire({
                                                            title: 'Are you sure?',
                                                            text: "You won't be able to revert this!",
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: 'Yes, delete it!'
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                btn.closest('form').submit();
                                                            }
                                                        });
                                                    });
                                                });
                                            });
                                        </script>
                                        @endpush
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500">Status:</span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $platform->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $platform->status == 'active' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    {{-- <div class="mt-2 flex items-center justify-between text-sm">
                                        <span class="text-gray-500">Posts:</span>
                                        <span class="font-medium text-gray-900">{{ $platform->posts_count }}</span>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No platforms</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new platform.</p>
                                <div class="mt-6">
                                    <a href="{{ route('platforms.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Add Platform
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 