<?php

namespace App\Http\Resources\Common;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginatedResource extends JsonResource
{
    protected string $resourceClass;

    public function __construct(LengthAwarePaginator $paginator, string $resourceClass)
    {
        parent::__construct($paginator);
        $this->resourceClass = $resourceClass;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $resource = $this->resourceClass;

        return [
            'items' => $resource::collection($this->resource->items()),
            'pagination' => [
                'current_page' => $this->resource->currentPage(),
                'last_page' => $this->resource->lastPage(),
                'per_page' => $this->resource->perPage(),
                'total' => $this->resource->total(),
            ],
        ];
    }
}
