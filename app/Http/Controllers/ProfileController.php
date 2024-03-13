<?php

namespace App\Http\Controllers;

use App\Dto\StoreProfileDto;
use App\Enum\ProfileStatus;
use App\Http\Requests\Profile\StoreProfileRequest;
use App\Http\Resources\Admin\ProfileResource as AdminProfileResource;
use App\Http\Resources\Profile\ProfileResource;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $isAuth = $request->user() instanceof User;

        $profiles = $this->profileService->list(
            $isAuth
                ? null
                : ProfileStatus::Active
        );

        return $isAuth
            ? AdminProfileResource::collection($profiles)->response()
            : ProfileResource::collection($profiles)->response();
    }

    public function store(StoreProfileRequest $request): ProfileResource
    {
        $profile = $this->profileService->store(
            new StoreProfileDto(
                firstName: $request->input('first_name'),
                lastName: $request->input('last_name'),
                imageUrl: $request->input('image_url'),
                creatorId: $request->user()->id,
                status: ProfileStatus::Pending
            )
        );

        return ProfileResource::make($profile);
    }
}
