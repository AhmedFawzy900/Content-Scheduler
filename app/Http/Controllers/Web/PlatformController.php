<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Platform\StorePlatform;
use App\Services\Interfaces\PlatformServiceInterface;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    protected $platformService;

    public function __construct(PlatformServiceInterface $platformService)
    {
        $this->platformService = $platformService;
    }

    public function index()
    {
        $platforms = $this->platformService->getAll();
        return view('platforms.index', compact('platforms'));
    }

    public function create()
    {
        return view('platforms.form');
    }

    public function store(StorePlatform $request)
    {
        $validated = $request->validated();
        try{
            $validated['user_id'] = auth()->user()->id;
            $this->platformService->create($validated);
    
            return redirect()->route('platforms.index')
                ->with('success', 'Platform created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create platform: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $platform = $this->platformService->find($id);
        return view('platforms.form', compact('platform'));
    }

    public function update(StorePlatform $request, $id)
    {
        $validated = $request->validated();
        try {
            $this->platformService->update($id, $validated);
            return redirect()->route('platforms.index')
                ->with('success', 'Platform updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to find platform: ' . $e->getMessage());
        }
       
    }

    public function destroy($id)
    {
        $this->platformService->delete($id);
        return redirect()->route('platforms.index')
            ->with('success', 'Platform deleted successfully.');
    }
} 