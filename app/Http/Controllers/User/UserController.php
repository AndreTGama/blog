<?php

namespace App\Http\Controllers\User;

use App\DataTransferObjects\User\Request\StoreUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Responses\ApiResponse;
use App\Http\Services\User\UserService;
use App\Models\User;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    /**
     * Store a new user in the system.
     *
     * This method handles the creation of a new user by validating the incoming request,
     * converting it to a Data Transfer Object (DTO), and delegating the storage logic
     * to the user service. It returns a standardized API response with appropriate
     * status codes.
     *
     * @param StoreUserRequest $request The validated user creation request containing
     *                                   user data (name, email, password, etc.)
     *
     * @return \Illuminate\Http\JsonResponse A JSON response with status code 201 on success
     *                                        or 500 on failure. Success response includes
     *                                        the created user data. Error response includes
     *                                        exception details for debugging.
     *
     * @throws \Exception Caught and handled internally, returning a 500 error response
     *
     * @example
     * POST /api/users
     * {
     *     "name": "John Doe",
     *     "email": "john@example.com",
     *     "password": "securePassword123"
     *     "confirmation_password": "securePassword123",
     *     "role_id": 2
     * }
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $this->authorize('create', User::class);
            $data = $this->userService->store(StoreUserDTO::fromArray($request->validated()));
            return ApiResponse::success(
                message: 'User created successfully.',
                data: $data,
                status: 201
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: 'Failed to create user.',
                exception: $e,
                data: null,
                status: 500
            );
        }
    }
}
