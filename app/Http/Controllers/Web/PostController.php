<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\PlatformServiceInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;
    protected $platformService;

    public function __construct(
        PostServiceInterface $postService,
        PlatformServiceInterface $platformService
    ) {
        $this->postService = $postService;
        $this->platformService = $platformService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'date', 'platform']);
        $posts = $this->postService->getAll($filters, 10); // 10 items per page
        $platforms = $this->platformService->getActive();
        
        return view('posts.index', compact('posts', 'platforms', 'filters'));
    }

    public function create()
    {
        $platforms = $this->platformService->getActive();
        return view('posts.form', compact('platforms'));
    }

    public function store(CreatePostRequest $request)
    {
        $validated = $request->validated();
        try{
            $validated['user_id'] = auth()->user()->id;
            $this->postService->create($validated);

            return redirect()->route('posts.index')
                ->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create platform: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $post = $this->postService->find($id);
        $platforms = $this->platformService->getAll();
        return view('posts.form', compact('post', 'platforms'));
    }

    public function update(CreatePostRequest $request, $id)
    {
        $validated = $request->validated();

        try{
            $this->postService->update($id, $validated);

            return redirect()->route('posts.index')
                ->with('success', 'Post updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create platform: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $this->postService->delete($id);
        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully.');
    }

    public function analytics()
    {
        $analytics = $this->postService->getAnalytics(auth()->user());
        return response()->json($analytics);
    }
} 