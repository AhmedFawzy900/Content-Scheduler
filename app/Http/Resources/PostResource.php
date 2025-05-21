<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'image_url' => $this->image_url,
            'scheduled_time' => $this->scheduled_time,
            'status' => $this->status,
            'character_count' => $this->character_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => new UserResource($this->whenLoaded('user')),
            'platforms' => PlatformResource::collection($this->whenLoaded('platforms')),
            'post_platforms' => PostPlatformResource::collection($this->whenLoaded('postPlatforms')),
            'can_be_scheduled' => $this->canBeScheduled(),
            'can_be_published' => $this->canBePublished(),
            'is_draft' => $this->isDraft(),
            'is_scheduled' => $this->isScheduled(),
            'is_published' => $this->isPublished(),
        ];
    }
} 