<?php

namespace App\Http\Controllers\User;

use App\DataTransferObjects\User\Request\StoreUserDTO;
use App\DataTransferObjects\User\Request\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\IndexUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\Common\PaginatedResource;
use App\Http\Resources\User\UserResource;
use App\Responses\ApiResponse;
use App\Services\User\UserService;
use App\Models\User;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    /**
     * Retrieve a paginated list of users.
     *
     * @param IndexUserRequest $request The request object containing pagination and filter parameters.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing paginated user data.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException If the user is not authorized to view users.
     */
    public function index(IndexUserRequest $request)
    {
        $this->authorize('viewAny', User::class);
        $data = $this->userService->index(dto: $request->toDTO());

        return ApiResponse::success(
            message: 'Users retrieved successfully.',
            data: new PaginatedResource($data, UserResource::class),
            status: 200
        );
    }
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

    /**
     * Display the specified user.
     *
     * Retrieves a single user by their ID and returns their details as a resource.
     * Authorization is checked to ensure the authenticated user has permission to view the requested user.
     *
     * @param User $user The user instance to be displayed.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the user data.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException If the user is not authorized to view the requested user.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        return ApiResponse::success(
            message: 'User retrieved successfully.',
            data: new UserResource($user),
            status: 200
        );
    }


    /**
     * Update a user resource.
     *
     * @param UpdateUserRequest $request The validated request containing user update data
     * @param User $user The user model instance to be updated
     * @return \Illuminate\Http\JsonResponse JSON response with success or error status
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException If user is not authorized to update the resource
     *
     * Example response on success:
     * {
     *     "success": true,
     *     "message": "User updated successfully.",
     *     "data": { ... user data ... },
     *     "status": 200
     * }
     *
     * Example response on error:
     * {
     *     "success": false,
     *     "message": "Failed to update user.",
     *     "data": null,
     *     "status": 500
     * }
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $this->authorize('update', $user);
            $data = $this->userService->update($user, UpdateUserDTO::fromArray($request->validated()));
            return ApiResponse::success(
                message: 'User updated successfully.',
                data: $data,
                status: 200
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: 'Failed to update user.',
                exception: $e,
                data: null,
                status: 500
            );
        }
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $user The user instance to be deleted.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure of the delete operation.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException If the user is not authorized to delete the requested user.
     */
    public function destroy(User $user)
    {
        try {
            $this->authorize('delete', $user);
            $this->userService->delete($user);
            return ApiResponse::success(
                message: 'User deleted successfully.',
                data: null,
                status: 200
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: 'Failed to delete user.',
                exception: $e,
                data: null,
                status: 500
            );
        }
    }


    /**
     * Restore a soft-deleted user.
     *
     * @param User $user The user instance to be restored.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure.
     *         - On success (200): Returns the restored user data.
     *         - On failure (500): Returns an error message with exception details.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException If the user is not authorized to restore.
     *
     * @example
     *     POST /api/users/{id}/restore
     *     Response: { "message": "User restored successfully.", "data": {...}, "status": 200 }
     */
    public function restore(User $user)
    {
        try {
            $this->authorize('restore', $user);
            $data = $this->userService->restore($user);
            return ApiResponse::success(
                message: 'User restored successfully.',
                data: $data,
                status: 200
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: 'Failed to restore user.',
                exception: $e,
                data: null,
                status: 500
            );
        }
    }
}
