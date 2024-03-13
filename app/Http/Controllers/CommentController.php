<?php

namespace App\Http\Controllers;

use App\Dto\StoreCommentDto;
use App\Http\Requests\Profile\StoreCommentRequest;
use App\Http\Resources\Profile\CommentResource;
use App\Models\Profile;
use App\Services\CommentService;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CommentController extends Controller
{
    public function __construct(
        private readonly CommentService $commentService,
        private readonly ProfileService $profileService,
    ) {
    }

    public function store(StoreCommentRequest $request, int $profile_id): JsonResponse|CommentResource
    {
        $profile = $this->profileService->getById($profile_id);

        if (! $profile instanceof Profile) {
            return new JsonResponse(
                data: [
                    'message' => 'Profile not found'
                ],
                status: ResponseAlias::HTTP_NOT_FOUND
            );
        }

        $commentsCountForUser = $this->commentService->countUserCommentsForProfile(
            $request->user()->id,
            $profile_id
        );

        if ($commentsCountForUser > 0) {
            return new JsonResponse(
                data: [
                    'message' => 'You can not comment more than once'
                ],
                status: ResponseAlias::HTTP_BAD_REQUEST
            );
        }

        $comment = $this->commentService->store(
            new StoreCommentDto(
                content: $request->input('content'),
                creatorId: $request->user()->id,
                profileId: $profile_id,
            )
        );

        return CommentResource::make($comment);
    }

    public function listForProfile(int $profileId): JsonResponse
    {
        $comments = $this->commentService->getForProfile($profileId);

        return CommentResource::collection($comments)->response();
    }
}
