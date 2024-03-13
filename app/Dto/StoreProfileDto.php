<?php

namespace App\Dto;

use App\Enum\ProfileStatus;

final readonly class StoreProfileDto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $imageUrl,
        public int $creatorId,
        public ProfileStatus $status,
    ) {
    }
}
