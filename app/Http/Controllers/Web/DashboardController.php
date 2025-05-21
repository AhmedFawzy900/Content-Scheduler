<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\PlatformServiceInterface;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    protected $postService;
    protected $platformService;

    public function __construct(
        PostServiceInterface $postService,
        PlatformServiceInterface $platformService
    ) {
        $this->postService = $postService;
        $this->platformService = $platformService;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        
        $totalPosts = $this->postService->getTotalPosts($user);
        $scheduledPosts = $this->postService->getScheduledPosts($user);
        $publishedPosts = $this->postService->getPublishedPosts($user);
        $recentPosts = $this->postService->getRecentPosts($user);
        $connectedPlatforms = $this->platformService->getConnectedPlatforms($user);
        $analytics = $this->postService->getAnalytics($user);

        return view('dashboard', compact(
            'totalPosts',
            'scheduledPosts',
            'publishedPosts',
            'recentPosts',
            'connectedPlatforms',
            'analytics'
        ));
    }
} 