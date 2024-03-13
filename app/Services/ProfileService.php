<?php

namespace App\Services;

use App\Dto\StoreProfileDto;
use App\Enum\ProfileStatus;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Collection;

class ProfileService
{
    public function getById(int $id): ?Profile
    {
        /** @var null|Profile $profile */
        $profile = Profile::query()->find($id);

        return $profile;
    }

    /**
     * Returns all profiles with the given status if argument is provided
     *
     * @param ProfileStatus|null $status
     * @return Collection<Profile>
     */
    public function list(?ProfileStatus $status = null): Collection
    {
        $query = Profile::query();

        if ($status !== null) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    public function store(StoreProfileDto $data): Profile
    {
        /** @var Profile $profile */
        $profile = Profile::query()->create([
            'first_name' => $data->firstName,
            'last_name' => $data->lastName,
            'creator_id' => $data->creatorId,
            'status' => $data->status,
            'image_url' => $data->imageUrl,
        ]);

        return $profile;
    }
}
