<?php

namespace App\Services;

use App\Models\User;
use App\Models\Platform;
use App\Services\Interfaces\PlatformServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class PlatformService implements PlatformServiceInterface
{
    public function getAll(): Collection
    {
        // Check if the authenticated user is the owner of the platform
        $user = auth()->user();
        return Platform::where('user_id', $user->id)->get();
    }

    /**
     * Get connected platforms for a user
     */

    public function getConnectedPlatforms(User $user): Collection
    {
        return $user->platforms;
    }

    /**
     * Connect a platform to a user
     */

    public function connectPlatform(User $user, int $platformId): bool
    {
        if (!$user->platforms()->where('platforms.id', $platformId)->exists()) {
            $user->platforms()->attach($platformId);
            return true;
        }
        return false;
    }

    /**
     * Disconnect a platform from a user
     */

    public function disconnectPlatform(User $user, int $platformId): bool
    {
        if ($user->platforms()->where('platforms.id', $platformId)->exists()) {
            $user->platforms()->detach($platformId);
            return true;
        }
        return false;
    }

    public function create(array $data): mixed
    {
        return Platform::create($data);
    }
    /**
     * find a platform
     */
    public function find(int $id): Platform
    {
        return Platform::findOrFail($id);
    }

    /**
     * Update a platform
     */

    public function update(int $id, array $data): bool
    {
        $platform = Platform::findOrFail($id);
        return $platform->update($data);
    }

    public function delete(int $id): bool
    {
        $platform = Platform::findOrFail($id);
        return $platform->delete();
    }
} 