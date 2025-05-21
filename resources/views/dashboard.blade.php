@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Posts -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Posts</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ $totalPosts }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scheduled Posts -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Scheduled Posts</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ $scheduledPosts->count() }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Published Posts -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Published Posts</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ $publishedPosts->count() }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Connected Platforms -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Connected Platforms</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ $connectedPlatforms->count() }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Posts -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Posts</h3>
                    <div class="flow-root">
                        <ul class="-my-5 divide-y divide-gray-200">
                            @forelse($recentPosts as $post)
                                <li class="py-4">
                                    <div class="flex items-center space-x-4">
                                        @if($post->image_url)
                                            <div class="flex-shrink-0">
                                                <img class="h-12 w-12 rounded-lg object-cover" src="{{ $post->image_url }}" alt="{{ $post->title }}">
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $post->title }}</p>
                                            <p class="text-sm text-gray-500 truncate">{{ Str::limit($post->content, 50) }}</p>
                                        </div>
                                        <div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($post->status === 'published') bg-green-100 text-green-800
                                                @elseif($post->status === 'scheduled') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($post->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="py-4 text-center text-gray-500">No recent posts</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('posts.index') }}" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            View all posts
                        </a>
                    </div>
                </div>
            </div>

            <!-- Platform Analytics -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Platform Analytics</h3>
                    <div class="space-y-6">
                        @foreach($analytics['platform_stats'] as $platform => $stats)
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-sm font-medium text-gray-900">{{ ucfirst($platform) }}</h4>
                                    <span class="text-sm text-gray-500">{{ $stats['total_posts'] }} posts</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ ($stats['published_posts'] / max(1, $stats['total_posts'])) * 100 }}%"></div>
                                </div>
                                <div class="mt-1 flex justify-between text-xs text-gray-500">
                                    <span>Published: {{ $stats['published_posts'] }}</span>
                                    <span>Success Rate: {{ round(($stats['published_posts'] / max(1, $stats['total_posts'])) * 100) }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="mt-8 bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                <div class="flow-root">
                    <ul class="-mb-8">
                        @forelse($analytics['recent_activity'] as $post)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    {{ $post->title }}
                                                    <span class="font-medium text-gray-900">{{ $post->status }}</span>
                                                </p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time datetime="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-center text-gray-500">No recent activity</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 