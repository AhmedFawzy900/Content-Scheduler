namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id && $post->status !== Post::STATUS_PUBLISHED;
    }

    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id && $post->status !== Post::STATUS_PUBLISHED;
    }
} 