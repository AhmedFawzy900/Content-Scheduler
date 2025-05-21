@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Create New Post</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea name="content" id="content" rows="4" required
                        class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="scheduled_time" class="block text-sm font-medium text-gray-700">Schedule Time</label>
                    <input type="datetime-local" name="scheduled_time" id="scheduled_time" value="{{ old('scheduled_time') }}" required
                        class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('scheduled_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Platforms</label>
                    <div class="mt-2 space-y-2">
                        @foreach($platforms as $platform)
                        <div class="flex items-center">
                            <input type="checkbox" name="platform_ids[]" value="{{ $platform->id }}" id="platform_{{ $platform->id }}"
                                class="p-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                {{ in_array($platform->id, old('platform_ids', [])) ? 'checked' : '' }}>
                            <label for="platform_{{ $platform->id }}" class="ml-2 block text-sm text-gray-700">
                                {{ $platform->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @error('platform_ids')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 