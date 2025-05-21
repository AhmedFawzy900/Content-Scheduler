<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostPlatform extends Model
{
    protected $fillable = [
        'post_id',
        'platform_id',
        'platform_status',
        'scheduled_time',
        'published_at',
        'error_message'
    ];

    protected $casts = [
        'scheduled_time' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }
} 