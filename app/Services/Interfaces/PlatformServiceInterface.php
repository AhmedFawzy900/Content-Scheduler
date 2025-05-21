<?php

namespace App\Services\Interfaces;

use App\Models\Platform;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface PlatformServiceInterface
{
    /**
     * Get all platforms
     */
    public function getAll(): Collection;

    /**
     * Get connected platforms for a user
     */
    public function getConnectedPlatforms(User $user): Collection;

    /**
     * Connect a platform to a user
     */
    public function connectPlatform(User $user, int $platformId): bool;

    /**
     * Disconnect a platform from a user
     */
    public function disconnectPlatform(User $user, int $platformId): bool;

    /**
     * Create a new platform
     */
    public function create(array $data): mixed;

    /**
     * Find a platform by ID
     */
    public function find(int $id): Platform;

    /**
     * Update a platform
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a platform
     */
    public function delete(int $id): bool;
} 