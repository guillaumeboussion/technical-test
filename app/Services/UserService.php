<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getById(int $id): ?User
    {
        /** @var null|User $user */
        $user = User::query()->find($id);

        return $user;
    }
}
