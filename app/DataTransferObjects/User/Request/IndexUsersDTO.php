<?php

namespace App\DataTransferObjects\User\Request;

class IndexUsersDTO
{
    public function __construct(
        public readonly int $limit,
        public readonly int $page,
        public readonly string $orderBy,
        public readonly string $orderDirection,
        public readonly array $filters,
    ) {}
}
