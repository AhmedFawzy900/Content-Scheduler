<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlatformResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'max_characters' => $this->max_characters,
            'image_required' => $this->image_required,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
} 