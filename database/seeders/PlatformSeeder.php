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
                'description' => 'Share short updates and engage with your audience'
            ],
            [
                'name' => 'LinkedIn',
                'type' => 'linkedin',
                'description' => 'Professional networking and business content'
            ],
            [
                'name' => 'Instagram',
                'type' => 'instagram',
                'description' => 'Visual content and stories'
            ],
            [
                'name' => 'Facebook',
                'type' => 'facebook',
                'description' => 'Connect with friends and share content'
            ]
        ];

        foreach ($platforms as $platform) {
            Platform::create($platform);
        }
    }
} 