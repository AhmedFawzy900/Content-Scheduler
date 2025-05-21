<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostPlatformResource extends JsonResource
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
            'post_id' => $this->post_id,
            'platform_id' => $this->platform_id,
            'status' => $this->status,
            'published_at' => $this->published_at,
            'error_message' => $this->error_message,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'platform' => new PlatformResource($this->whenLoaded('platform')),
        ];
    }
} 