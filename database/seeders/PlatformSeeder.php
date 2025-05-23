<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = [
            [
                'name' => 'Twitter',
                'type' => 'twitter',
                'status' => 'active',
                'user_id' => 1
            ],
            [
                'name' => 'LinkedIn',
                'type' => 'linkedin',
                'status' => 'active',
                'user_id' => 1
            ],
            [
                'name' => 'Instagram',
                'type' => 'instagram',
                'status' => 'active',
                'user_id' => 1
            ],
            [
                'name' => 'Facebook',
                'type' => 'facebook',
                'status' => 'active',
                'user_id' => 1
            ]
        ];

        foreach ($platforms as $platform) {
            Platform::create($platform);
        }
    }
} 