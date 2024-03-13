<?php

namespace App\Http\Resources\Profile;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Comment $resource
 */
class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'profile_id' => $this->resource->profile_id,
            'comment' => $this->resource->content,
            'created_at' => $this->resource->created_at,
            'profile' => ProfileResource::make($this->whenLoaded('profile')),
        ];
    }
}
