<?php

namespace App\Http\Resources\Admin;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Profile $resource
 */
class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'status' => $this->resource->status,
            'creator_id' => $this->resource->creator_id,
            'creator' => $this->whenLoaded(
                'creator',
                fn () => UserResource::make($this->resource->creator)
            ),
            'image_url' => $this->resource->image_url,
            'created_at' => $this->resource->created_at,
        ];
    }
}
