<?php

namespace App\DataTransferObjects\Users\Response;

use App\Models\User;

class UserResponseDTO
{
    /**
     * Data Transfer Object representing the response for a successful authentication.
     *
     * @param User $user The authenticated user information.
     */
    public function __construct(
        public string  $id,
        public string  $name,
        public string  $email,
        public ?string $email_verified_at,
        public ?string $last_login,
        public string  $created_at,
        public string  $updated_at,
    ) {}
}
