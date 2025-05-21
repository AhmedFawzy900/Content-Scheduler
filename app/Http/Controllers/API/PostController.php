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

    public function index()
    {
        $posts = $this->postService->getAll();
        return PostResource::collection($posts);
    }

    public function create()
    {
        $platforms = Platform::all();
        return view('posts.create', compact('platforms'));
    }

    public function store(CreatePostRequest $request)
    {
        $post = $this->postService->createPost($request->validated(), Auth::user());
        return redirect()->route('dashboard')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function edit(Post $post)
    {
        $platforms = Platform::all();
        return view('posts.edit', compact('post', 'platforms'));
    }

    public function update(CreatePostRequest $request, Post $post)
    {
        $post = $this->postService->updatePost($post, $request->validated());
        return redirect()->route('dashboard')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $this->postService->delete($post->id);
        return redirect()->route('dashboard')->with('success', 'Post deleted successfully.');
    }

    public function analytics()
    {
        $analytics = $this->postService->getAnalytics(auth()->user());
        return response()->json($analytics);
    }
} 
