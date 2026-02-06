<?php

namespace App\DataTransferObjects\Common;

class PaginatedResponseDTO
{
    public function __construct(
        public array $data,
        public int   $currentPage,
        public int   $lastPage,
        public int   $perPage,
        public int   $total,
    ) {}

    public static function fromPaginator($paginator): self
    {
        return new self(
            data:        $paginator->items(),
            currentPage: $paginator->currentPage(),
            lastPage:    $paginator->lastPage(),
            perPage:     $paginator->perPage(),
            total:       $paginator->total(),
        );
    }
}
