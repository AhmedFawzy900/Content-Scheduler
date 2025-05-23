<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'title',
        'content',
        'image_url',
        'scheduled_time',
        'status',
        'user_id',
        'character_count'
    ];

    protected $casts = [
        'scheduled_time' => 'datetime',
        'character_count' => 'integer'
    ];

    public const STATUS_DRAFT = 'draft';
    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_PUBLISHED = 'published';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class,
            'post_platform',
        )->withTimestamps();
    }

    public function postPlatforms(): HasMany
    {
        return $this->hasMany(PostPlatform::class);
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isScheduled(): bool
    {
        return $this->status === self::STATUS_SCHEDULED;
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function canBeScheduled(): bool
    {
        return $this->isDraft() && $this->scheduled_time > now();
    }

    public function canBePublished(): bool
    {
        return $this->isScheduled() && $this->scheduled_time <= now();
    }

    public static function checkDailyLimit(User $user): bool
    {
        $today = now()->startOfDay();
        $count = self::where('user_id', $user->id)
            ->where('created_at', '>=', $today)
            ->count();
        
        return $count < 10;
    }


    public function setImageUrlAttribute($value)
    {
        if ($value) {
            // Store the image in the 'public/ads' directory
            $imageName = time() . '_' . $value->getClientOriginalName(); // Unique name
            $value->move(public_path('assets/images/post'), $imageName); // Move to public/ads
            $this->attributes['image_url'] = $imageName; // Save the path
        }
    }

    public function getImageUrlAttribute()
    {
        if (isset($this->attributes['image_url']) && $this->attributes['image_url']) {
            return asset('assets/images/post/' . $this->attributes['image_url']); // Use the public path with the image name
        } else {
            return null;
        }
    }
} 