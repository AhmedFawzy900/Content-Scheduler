<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Platform;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Get all platforms
        $platforms = Platform::all();

        // Create some sample posts
        $posts = [
            [
                'title' => 'Product Launch Announcement',
                'content' => 'We are excited to announce our new product launch! Stay tuned for more details.',
                'status' => Post::STATUS_SCHEDULED,
                'scheduled_time' => now()->addHours(2)->format('Y-m-d H:i:s'),
                'user_id' => 1
    
            ],
            [
                'title' => 'Weekly Tech Update',
                'content' => 'Here are the latest tech trends and updates from this week.',
                'status' => Post::STATUS_SCHEDULED,
                'scheduled_time' => now()->addDays(1)->format('Y-m-d H:i:s'),
                'user_id' => 1
            ],
            [
                'title' => 'Industry Insights',
                'content' => 'Deep dive into the latest industry trends and what they mean for your business.',
                'status' => Post::STATUS_SCHEDULED,
                'scheduled_time' => now()->subHours(1)->format('Y-m-d H:i:s'), // This one should be processed immediately
                'user_id' => 1
            ],
        ];

        foreach ($posts as $postData) {
            $post = Post::create($postData);
            // Attach all platforms to each post
            $post->platforms()->attach($platforms);
        }
    }
} 