<?php

namespace App\Services\Auth;

use App\DataTransferObjects\Auth\Request\LoginCredentialsDTO;
use App\DataTransferObjects\Auth\Response\LoginResponseDTO;
use App\DataTransferObjects\Users\Response\UserResponseDTO;
use App\Exceptions\InvalidCredentialsException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{

    /**
     * Attempts to authenticate a user with the provided login credentials.
     *
     * @param LoginCredentialsDTO $credentials The user's login credentials (email and password).
     * @return LoginResponseDTO Returns a DTO containing the access token, token type, and user information upon successful authentication.
     *
     * @throws InvalidCredentialsException If the provided credentials are invalid.
     */
    public function login(LoginCredentialsDTO $credentials): LoginResponseDTO
    {
        if (!Auth::attempt(credentials: [
            'email'    => $credentials->email,
            'password' => $credentials->password,
        ])) {
            throw new InvalidCredentialsException();
        }

        $user = Auth::user();

        $token = $this->createAuthToken($user);

        return new LoginResponseDTO(
            access_token: $token,
            token_type: 'Bearer',
            user: $user
        );
    }

    /**
     * Generate an authentication token for the given user.
     *
     * This method creates a new personal access token for the specified user
     * and returns it as a plain text string. The token can be used to authenticate
     * API requests on behalf of the user.
     *
     * @param User $user The user for whom the authentication token is being created.
     * @return string The generated plain text authentication token.
     */
    private function createAuthToken(User $user): string
    {
        return $user->createToken('auth_token')->plainTextToken;
    }

    /**
     * Logs out the currently authenticated user by deleting their current access token.
     *
     * @param Request $request The HTTP request instance containing the authenticated user.
     * 
     * @return void
     */
    public function logout(Request $request): void
    {
        $request->user()->currentAccessToken()->delete();
    }

    /**
     * Retrieve the currently authenticated user.
     *
     * @return UserResponseDTO The authenticated user instance.
     */
    public function me(): UserResponseDTO
    {
        $user = Auth::user();

        return new UserResponseDTO(
            id: (string) $user->id,
            name: $user->name,
            email: $user->email,
            email_verified_at: $user->email_verified_at,
            last_login: $user->last_login,
            created_at: $user->created_at,
            updated_at: $user->updated_at,
        );
    }
}
