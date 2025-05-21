@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ isset($post) ? 'Edit Post' : 'Create New Post' }}
                    </h2>
                </div>

                <form action="{{ isset($post) ? route('posts.update', $post) : route('posts.store') }}" 
                    method="POST" 
                    enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @if(isset($post))
                        @method('PUT')
                    @endif

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" 
                            name="title" 
                            id="title" 
                            value="{{ old('title', $post->title ?? '') }}"
                            class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-500 @enderror"
                            required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                        <textarea name="content" 
                            id="content" 
                            rows="4"
                            class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('content') border-red-500 @enderror"
                            required>{{ old('content', $post->content ?? '') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" 
                            name="image_url" 
                            id="image"
                            accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if(isset($post) && $post->image_url)
                            <div class="mt-2">
                                <img src="{{ $post->image_url }}" alt="Current image" class="h-32 w-32 object-cover rounded-lg">
                            </div>
                        @endif
                    </div>

                    <!-- Platforms -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Platforms</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($platforms as $platform)
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                        name="platforms[]" 
                                        id="platform_{{ $platform->id }}" 
                                        value="{{ $platform->id }}"
                                        {{ in_array($platform->id, old('platforms', isset($post) ? $post->platforms->pluck('id')->toArray() : [])) ? 'checked' : '' }}
                                        class="p-2 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="platform_{{ $platform->id }}" class="ml-2 block text-sm text-gray-900">
                                        {{ $platform->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('platforms')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Scheduling -->
                    <div>
                        <label for="scheduled_time" class="block text-sm font-medium text-gray-700">Schedule Post</label>
                        <input type="datetime-local" 
                            name="scheduled_time" 
                            id="scheduled_time"
                            value="{{ old('scheduled_time', isset($post) ? $post->scheduled_time->format('Y-m-d\TH:i') : '') }}"
                            class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('scheduled_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" 
                            id="status"
                            class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="draft" {{ old('status', $post->status ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="scheduled" {{ old('status', $post->status ?? '') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="published" {{ old('status', $post->status ?? '') === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('posts.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ isset($post) ? 'Update Post' : 'Create Post' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 