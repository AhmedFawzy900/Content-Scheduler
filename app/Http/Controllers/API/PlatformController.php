<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use App\Services\PlatformService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PlatformController extends Controller
{
    protected $platformService;

    public function __construct(PlatformService $platformService)
    {
        $this->platformService = $platformService;
    }

    /**
     * Get all platforms with user's active status
     */
    public function index(): JsonResponse
    {
        $platforms = $this->platformService->getActive();
        $userPlatforms = $this->platformService->getConnectedPlatforms(Auth::user());

        $platforms = $platforms->map(function ($platform) use ($userPlatforms) {
            $platform->is_active = $userPlatforms->contains($platform->id);
            return $platform;
        });

        return response()->json($platforms);
    }

    /**
     * Toggle platform active status for the authenticated user
     */
    public function toggleActive(Platform $platform): JsonResponse
    {
        $user = Auth::user();
        
        if($platform->user_id != $user->id){
            return response()->json([
                'success' => false,
                'message' => "you are not the owner of this platform",
            ]);
        }

        if ($platform->status == 'active') {
            $platform->status = 'inActive';
        }else{
            $platform->status = 'active';
        }
        $platform->save();
        return response()->json([
            'success' => true,
            'message' => 'platform toggled successfully to ' . $platform->status,
        ]);
    }
}