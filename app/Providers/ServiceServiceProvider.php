<?php

namespace App\Providers;

use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\PlatformServiceInterface;
use App\Services\PostService;
use App\Services\PlatformService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(PostServiceInterface::class, PostService::class);
        $this->app->bind(PlatformServiceInterface::class, PlatformService::class);
    }

    public function boot()
    {
        //
    }
} 