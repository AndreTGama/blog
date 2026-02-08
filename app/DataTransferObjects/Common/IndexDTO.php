<?php

namespace App\DataTransferObjects\Common;

class IndexDTO
{
    public function __construct(
        public readonly int $limit,
        public readonly int $page,
        public readonly string $orderBy,
        public readonly string $orderDirection,
        public readonly array $filters,
    ) {}
}
