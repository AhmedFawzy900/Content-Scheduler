<?php

namespace App\Services\Interfaces;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostServiceInterface extends BaseServiceInterface
{
    /**
     * Get all posts with optional filters
     */
    public function getAll(array $filters = []): LengthAwarePaginator;

    /**
     * Get all posts for a user
     */
    public function getAllPosts(array $filters = []): Collection;

    /**
     * Get total posts count for a user
     */
    public function getTotalPosts(User $user): int;

    /**
     * Get scheduled posts for a user
     */
    public function getScheduledPosts(User $user): Collection;

    /**
     * Get published posts for a user
     */
    public function getPublishedPosts(User $user): Collection;

    /**
     * Get recent posts for a user
     */
    public function getRecentPosts(User $user, int $limit = 5): Collection;

    /**
     * Create a new post
     */
    public function create(array $data): Post;

    /**
     * Update an existing post
     */
    public function update(int $id, array $data): Post;

    /**
     * Delete a post
     */
    public function delete(int $id): bool;

    /**
     * Get analytics data for a user
     */
    public function getAnalytics(User $user): array;

    public function createPost(array $data, User $user): Post;
    public function updatePost(Post $post, array $data): Post;
    public function validatePostCreation(User $user): void;
    public function validatePlatformRequirements(Post $post, string $platformType): void;
} 