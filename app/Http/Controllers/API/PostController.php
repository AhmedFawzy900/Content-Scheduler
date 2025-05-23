<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Platform;
use App\Models\Post;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'date']);
        $posts = $this->postService->getAll($filters, 10); // 10 items per page
        return PostResource::collection($posts);
    }

   
    public function store(CreatePostRequest $request)
    {
        $post = $this->postService->createPost($request->validated(), Auth::user());
        return response()->json(['success' => true, 'post' => new PostResource($post)]);
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function update(CreatePostRequest $request, Post $posts_api)
    {

        $post = $this->postService->updatePost($posts_api, $request->validated());
        return response()->json(['success' => true,'post' => new PostResource($post)]);
    }

    public function destroy(Post $posts_api)
    {
        $this->postService->delete($posts_api->id);
        return response()->json(['success' => true,'message' => "Post deleted successfully!"]);
    }

    public function analytics()
    {
        $analytics = $this->postService->getAnalytics(auth()->user());
        return response()->json($analytics);
    }
} 
