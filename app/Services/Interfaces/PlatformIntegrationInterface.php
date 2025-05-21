<?php

namespace App\Services\Interfaces;

use App\Models\Post;
use App\Models\Platform;

interface PlatformIntegrationInterface
{
    public function publish(Post $post, Platform $platform): bool;
    public function validateContent(Post $post): void;
    public function getEngagementMetrics(Post $post): array;
}