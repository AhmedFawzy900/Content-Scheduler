@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Content Management</h2>
                    <a href="{{ route('posts.create') }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create New Post
                    </a>
                </div>

                <!-- Filters Section -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <form action="{{ route('posts.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Status</option>
                                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>

                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="date" id="date" value="{{ request('date') }}"
                                class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="platform" class="block text-sm font-medium text-gray-700">Platform</label>
                            <select name="platform" id="platform" class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Platforms</option>
                                @foreach($platforms as $platform)
                                    <option value="{{ $platform->id }}" {{ request('platform') == $platform->id ? 'selected' : '' }}>
                                        {{ $platform->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Posts Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Platforms</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scheduled For</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($posts as $post)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($post->image_url)
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-lg object-cover" src="{{ $post->image_url }}" alt="{{ $post->title }}">
                                                </div>
                                            @endif
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $post->title }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($post->content, 50) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            @foreach($post->platforms as $platform)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ $platform->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($post->status === 'published') bg-green-100 text-green-800
                                            @elseif($post->status === 'scheduled') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $post->scheduled_time->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('posts.edit', $post) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline delete-post-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-900 delete-post-btn">Delete</button>
                                        </form>
                                        @push('scripts')
                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                document.querySelectorAll('.delete-post-btn').forEach(function(btn) {
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
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        No posts found. <a href="{{ route('posts.create') }}" class="text-indigo-600 hover:text-indigo-900">Create your first post</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($posts->hasPages())
                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 