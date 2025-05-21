<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessScheduledPosts extends Command
{
    protected $signature = 'posts:process-scheduled';
    protected $description = 'Process all scheduled posts that are due for publication';

    public function handle()
    {
        $posts = Post::where('status', Post::STATUS_SCHEDULED)
            ->where('scheduled_time', '<=', now())
            ->get();

        foreach ($posts as $post) {
            try {
                $this->processPost($post);
            } catch (\Exception $e) {
                Log::error("Failed to process post {$post->id}: " . $e->getMessage());
                $this->error("Failed to process post {$post->id}: " . $e->getMessage());
            }
        }

        $this->info("Processed {$posts->count()} posts");
    }

    protected function processPost(Post $post)
    {
        // Mock publishing process
        foreach ($post->platforms as $platform) {
            // Simulate platform-specific validation
            if ($this->validatePlatformRequirements($post, $platform)) {
                // Update platform status
                $post->platforms()->updateExistingPivot($platform->id, [
                    'platform_status' => 'published'
                ]);
                
                Log::info("Published post {$post->id} to {$platform->name}");
            } else {
                Log::warning("Failed to publish post {$post->id} to {$platform->name} - validation failed");
            }
        }

        // Update post status
        $post->update(['status' => Post::STATUS_PUBLISHED]);
    }

    protected function validatePlatformRequirements(Post $post, $platform): bool
    {
        // Platform-specific validation rules
        $rules = [
            'twitter' => 280,
            'linkedin' => 3000,
            'instagram' => 2200,
            'facebook' => 63206
        ];

        $limit = $rules[$platform->type] ?? 1000;
        return strlen($post->content) <= $limit;
    }
} 