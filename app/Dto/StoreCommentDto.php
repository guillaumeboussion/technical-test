<?php

namespace App\Dto;

final readonly class StoreCommentDto
{
    public function __construct(
        public string $content,
        public int $creatorId,
        public int $profileId,
    ) {
    }
}
