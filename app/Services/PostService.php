<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Post;
use App\Models\Platform;
use App\Models\User;
use App\Services\Interfaces\PostServiceInterface;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService implements PostServiceInterface
{
    public function __construct(
        private readonly FileHelper $fileHelper
    ) {}

    public function getAll(array $filters = [],int $perPage = 10): LengthAwarePaginator
    {
        $query = Post::query();
        $user = auth()->user();
       
        $query->where('user_id', $user->id);
        
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['date'])) {
            $query->whereDate('scheduled_time', $filters['date']);
        }

        if (isset($filters['platform'])) {
            $query->whereHas('platforms', function ($query) use ($filters) {
                $query->where('platforms.id', $filters['platform']);
            });
        }

        return $query->latest()->paginate($perPage);
    }
    public function getAllPosts(array $filters = []): Collection
    {
        $query = Post::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['date'])) {
            $query->whereDate('scheduled_time', $filters['date']);
        }

        return $query->latest()->get();
    }

    public function getTotalPosts(User $user): int
    {
        return $user->posts()->count();
    }

    public function getScheduledPosts(User $user): Collection
    {
        return $user->posts()
            ->where('status', Post::STATUS_SCHEDULED)
            ->where('scheduled_time', '>', now())
            ->latest()
            ->get();
    }

    public function getPublishedPosts(User $user): Collection
    {
        return $user->posts()
            ->where('status', Post::STATUS_PUBLISHED)
            ->latest()
            ->get();
    }

    public function getRecentPosts(User $user, int $limit = 5): Collection
    {
        return $user->posts()
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function find(int $id)
    {
        return Post::findOrFail($id);
    }

    public function create(array $data): Post
    {
        $user = User::findOrFail($data['user_id']);
        return $this->createPost($data, $user);
    }

    public function update(int $id, array $data): Post
    {
        $post = Post::findOrFail($id);
        return $this->updatePost($post, $data);
    }

    public function delete(int $id): bool
    {
        $post = Post::findOrFail($id);
        
        if ($post->image_url) {
            $this->fileHelper->deleteFile($post->image_url);
        }
        
        return $post->delete();
    }

    public function createPost(array $data, User $user): Post
    {
        $post = $user->posts()->create($data);

        if (isset($data['platforms'])) {
            $post->platforms()->attach($data['platforms']);
        }

        return $post;
    }

    public function updatePost(Post $post, array $data): Post
    {

        $post->update($data);

        if (isset($data['platforms'])) {
            $post->platforms()->sync($data['platforms']);
        }

        return $post;
    }

    public function getAnalytics(User $user): array
    {
        return [
            'total_posts' => $this->getTotalPosts($user),
            'scheduled_posts' => $this->getScheduledPosts($user)->count(),
            'published_posts' => $this->getPublishedPosts($user)->count(),
            'platform_stats' => $this->getPlatformStats($user),
            'recent_activity' => $this->getRecentActivity($user)
        ];
    }

    public function validatePostCreation(User $user): void
    {
        // Add validation logic here
    }

    public function validatePlatformRequirements(Post $post, string $platformType): void
    {
        // Add platform-specific validation logic here
    }

    private function getPlatformStats(User $user): array
    {
        $stats = [];
        foreach ($user->platforms as $platform) {
            $stats[$platform->type] = [
                'total_posts' => $user->posts()
                    ->whereHas('platforms', function ($query) use ($platform) {
                        $query->where('platforms.id', $platform->id);
                    })
                    ->count(),
                'published_posts' => $user->posts()
                    ->whereHas('platforms', function ($query) use ($platform) {
                        $query->where('platforms.id', $platform->id);
                    })
                    ->where('status', Post::STATUS_PUBLISHED)
                    ->count()
            ];
        }
        return $stats;
    }

    private function getRecentActivity(User $user): Collection
    {
        return $user->posts()
            ->with('platforms')
            ->latest()
            ->limit(10)
            ->get();
    }
} 