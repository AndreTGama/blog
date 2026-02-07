<?php

namespace App\DataTransferObjects\User\Request;

use App\Http\Requests\User\UpdateUserRequest;

class UpdateUserDTO
{
    /**
     * UpdateUserDTO constructor.
     *
     * @param string|null $name The user's name. Null if not being updated.
     * @param string|null $email The user's email address. Null if not being updated.
     * @param int|null $role_id The user's role ID. Null if not being updated.
     * @param string|null $password The user's password. Null if not being updated.
     */
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $email,
        public readonly ?int $role_id,
        public readonly ?string $password,
    ) {}


    /**
     * Create an UpdateUserDTO instance from an HTTP request.
     *
     * @param UpdateUserRequest $request The HTTP request containing user update data
     * @return self A new instance of UpdateUserDTO with data from the request
     */
    public static function fromRequest(UpdateUserRequest $request): self
    {
        return new self(
            name: $request->input('name'),
            email: $request->input('email'),
            role_id: $request->input('role_id'),
            password: $request->input('password'),
        );
    }

    /**
     * Create an UpdateUserDTO instance from an associative array.
     *
     * @param array $data The associative array containing user update data
     * @return self A new instance of UpdateUserDTO with data from the array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            role_id: $data['role_id'] ?? null,
            password: $data['password'] ?? null,
        );
    }

    /**
     * Convert the UpdateUserDTO instance to an associative array.
     *
     * @return array<string, mixed> An array containing the user data with keys:
     *                              - 'name': The user's name
     *                              - 'email': The user's email address
     *                              - 'role_id': The user's role identifier
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->name !== null) {
            $data['name'] = $this->name;
        }

        if ($this->email !== null) {
            $data['email'] = $this->email;
        }

        if ($this->role_id !== null) {
            $data['role_id'] = $this->role_id;
        }

        if ($this->password !== null) {
            $data['password'] = $this->password;
        }

        return $data;
    }
}
