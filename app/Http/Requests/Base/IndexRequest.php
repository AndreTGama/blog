<?php

namespace App\Http\Requests\Base;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function limit(): int
    {
        return (int) $this->input('limit', 10);
    }

    public function page(): int
    {
        return (int) $this->input('page', 1);
    }

    public function orderBy(): string
    {
        return $this->input('order_by', 'created_at');
    }

    public function orderDirection(): string
    {
        return $this->input('order_direction', 'desc');
    }

    public function filters(): array
    {
        return $this->input('filters', []);
    }
}
