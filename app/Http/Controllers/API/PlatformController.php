<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlatformController extends Controller
{
    public function index()
    {
        $platforms = Platform::all();
        $userPlatforms = Auth::user()->platforms()->pluck('platforms.id')->toArray();

        $platforms = $platforms->map(function ($platform) use ($userPlatforms) {
            $platform->is_active = in_array($platform->id, $userPlatforms);
            return $platform;
        });

        return view('platforms.index', compact('platforms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:twitter,instagram,linkedin'
        ]);

        $platform = Platform::create($request->all());
        return redirect()->route('platforms.index')->with('success', 'Platform created successfully');
    }

    public function show(Platform $platform)
    {
        return view('platforms.show', compact('platform'));
    }

    public function update(Request $request, Platform $platform)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|string|in:twitter,instagram,linkedin'
        ]);

        $platform->update($request->all());
        return redirect()->route('platforms.index')->with('success', 'Platform updated successfully');
    }

    public function destroy(Platform $platform)
    {
        $platform->delete();
        return redirect()->route('platforms.index')->with('success', 'Platform deleted successfully');
    }

    public function toggle(Platform $platform)
    {
        $user = Auth::user();
        
        if ($user->platforms()->where('platforms.id', $platform->id)->exists()) {
            $user->platforms()->detach($platform->id);
            $message = 'Platform deactivated successfully';
        } else {
            $user->platforms()->attach($platform->id);
            $message = 'Platform activated successfully';
        }

        return redirect()->route('platforms.index')->with('success', $message);
    }

    protected function getCharacterLimit(string $type): ?int
    {
        return match ($type) {
            'twitter' => 280,
            'linkedin' => 3000,
            default => null
        };
    }
} 