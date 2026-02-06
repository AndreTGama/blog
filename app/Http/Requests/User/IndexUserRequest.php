<?php

namespace App\Http\Requests\User;

use App\DataTransferObjects\User\Request\IndexUsersDTO;
use App\Http\Requests\Base\IndexRequest;

class IndexUserRequest extends IndexRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'limit' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'page' => ['sometimes', 'integer', 'min:1'],

            'order_by' => ['sometimes', 'string', 'in:created_at,name,email'],
            'order_direction' => ['sometimes', 'string', 'in:asc,desc'],

            'filters' => ['sometimes', 'array'],
            'filters.search' => ['sometimes', 'string'],
        ];
    }

    public function toDTO(): IndexUsersDTO
    {
        return new IndexUsersDTO(
            limit: $this->limit(),
            page: $this->page(),
            orderBy: $this->orderBy(),
            orderDirection: $this->orderDirection(),
            filters: $this->filters(),
        );
    }
}
