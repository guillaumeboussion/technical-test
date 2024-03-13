<?php

namespace App\Services;

use App\Dto\StoreCommentDto;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentService
{
    /**
     * Returns all comments for a given profile id.
     *
     * @param int $profileId
     * @return Collection<Comment>
     */
    public function getForProfile(int $profileId): Collection
    {
        return Comment::query()
            ->where('profile_id', $profileId)
            ->get();
    }

    public function store(StoreCommentDto $data): Comment
    {
        /** @var Comment $comment */
        $comment = Comment::query()->create([
            'content' => $data->content,
            'creator_id' => $data->creatorId,
            'profile_id' => $data->profileId,
        ]);

        return $comment;
    }

    /**
     * Returns the number of comments created on a given profile by a given user.
     *
     * @param int $userId
     * @param int $profileId
     * @return int
     */
    public function countUserCommentsForProfile(int $userId, int $profileId): int
    {
        return Comment::query()
            ->where('creator_id', $userId)
            ->where('profile_id', $profileId)
            ->count();
    }
}
