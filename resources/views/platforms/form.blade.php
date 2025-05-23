@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ isset($platform) ? 'Edit Platform' : 'Add New Platform' }}
                    </h2>
                </div>
                @if ($errors->any())
                    <div class="mb-4">
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Whoops!</strong>
                            <span class="block sm:inline">There were some problems with your input.</span>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <form action="{{ isset($platform) ? route('platforms.update', $platform) : route('platforms.store') }}" 
                    method="POST" 
                    enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @if(isset($platform))
                        @method('PUT')
                    @endif

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Platform Name</label>
                        <input type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name', $platform->name ?? '') }}"
                            class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
                            required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Platform Type</label>
                        <select name="type" 
                            id="type"
                            class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('type') border-red-500 @enderror"
                            required>
                            <option value="">Select a platform type</option>
                            <option value="twitter" {{ old('type', $platform->type ?? '') == 'twitter' ? 'selected' : '' }}>Twitter</option>
                            <option value="facebook" {{ old('type', $platform->type ?? '') == 'facebook' ? 'selected' : '' }}>Facebook</option>
                            <option value="instagram" {{ old('type', $platform->type ?? '') == 'instagram' ? 'selected' : '' }}>Instagram</option>
                            <option value="linkedin" {{ old('type', $platform->type ?? '') == 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- <!-- API Key -->
                    <div>
                        <label for="api_key" class="block text-sm font-medium text-gray-700">API Key</label>
                        <input type="text" 
                            name="api_key" 
                            id="api_key" 
                            value="{{ old('api_key', $platform->api_key ?? '') }}"
                            class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('api_key') border-red-500 @enderror">
                        @error('api_key')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- API Secret -->
                    <div>
                        <label for="api_secret" class="block text-sm font-medium text-gray-700">API Secret</label>
                        <input type="password" 
                            name="api_secret" 
                            id="api_secret" 
                            value="{{ old('api_secret', $platform->api_secret ?? '') }}"
                            class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('api_secret') border-red-500 @enderror">
                        @error('api_secret')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div> --}}

                    <!-- Icon -->
                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700">Platform Icon</label>
                        <div class="mt-1 flex items-center space-x-4">
                            @if(isset($platform) && $platform->icon_url)
                                <div class="flex-shrink-0">
                                    <img src="{{ $platform->icon_url }}" alt="Platform icon" class="h-16 w-16 object-cover rounded-lg">
                                </div>
                            @endif
                            <div class="flex-grow">
                                <input type="file" 
                                    name="icon" 
                                    id="icon"
                                    accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="mt-1 text-sm text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        @error('icon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if(isset($platform) && $platform->icon)
                            <div class="mt-2">
                                <label class="block text-sm font-medium text-gray-700">Current Icon:</label>
                                <img src="{{ $platform->icon }}" alt="Current Platform Icon" class="h-16 w-16 object-cover rounded-lg mt-1">
                            </div>
                        @endif
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-1">
                            <label class="inline-flex items-center">
                                <input type="checkbox" 
                                    name="status" 
                                    value="1"
                                    {{ old('status', isset($platform) ? ($platform->status == 'active' ? 1 : 0) : 0) ? 'checked' : '' }}
                                    class="p-2 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Active</span>
                            </label>
                        </div>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('platforms.index') }}" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ isset($platform) ? 'Update Platform' : 'Create Platform' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 