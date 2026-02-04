<?php

namespace App\DataTransferObjects\Auth\Response;

use App\Models\User;

class LoginResponseDTO
{
    /**
     * Data Transfer Object representing the response for a successful authentication.
     *
     * @param string $access_token The access token issued to the authenticated user.
     * @param string $token_type The type of the token (e.g., "Bearer").
     * @param User $user The authenticated user information.
     */
    public function __construct(
        public string $access_token,
        public string $token_type,
        public User $user
    ) {}
}
