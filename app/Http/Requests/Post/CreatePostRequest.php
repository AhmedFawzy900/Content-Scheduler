<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'nullable|image|max:2048',
            'scheduled_time' => 'required|date|after:now',
            'platforms' => 'required|array|min:1',
            'platforms.*' => 'exists:platforms,id',
            'status' => 'required|in:draft,scheduled,published'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The post title is required.',
            'content.required' => 'The post content is required.',
            'scheduled_time.required' => 'The scheduled time is required.',
            'scheduled_time.after' => 'The scheduled time must be in the future.',
            'platform_ids.required' => 'At least one platform must be selected.',
            'platform_ids.min' => 'At least one platform must be selected.',
            'platform_ids.*.exists' => 'One or more selected platforms are invalid.'
        ];
    }
} 