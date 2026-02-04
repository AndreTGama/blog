<?php

namespace App\Http\Controllers\Auth;

use App\DataTransferObjects\Auth\Request\LoginCredentialsDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Http\Resources\User\UserResource;
use App\Http\Responses\ApiResponse;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = $this->authService->login(
                credentials: LoginCredentialsDTO::fromArray(
                    $request->validated()
                )
            );

            return ApiResponse::success(
                message: __('login.login.success'),
                data: new LoginResource($data),
                status: 200
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: __('login.login.error'),
                exception: $e->getMessage(),
                status: 500
            );
        }
    }

    /**
     * Retrieve the authenticated user's information.
     *
     * This method uses the AuthService to fetch the details of the currently
     * authenticated user. If successful, it returns a JSON response with the
     * user's data. In case of an exception, it returns an error response with
     * the exception message.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the user's
     *                                       data or an error message.
     *
     * @throws \Exception If an error occurs while retrieving the user's information.
     */
    public function me(): JsonResponse
    {
        try {
            $data = $this->authService->me();
            return ApiResponse::success(
                message: __('return.show.success', ['name' => __('user.singular')]),
                data: new UserResource($data),
                status: 200
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: __('return.show.error', ['name' => __('user.singular')]),
                exception: $e->getMessage(),
                status: 500
            );
        }
    }

    /**
     * Logs out the authenticated user.
     *
     * This method handles the logout process by delegating the task to the 
     * authentication service. If the logout is successful, it returns a success 
     * response. In case of an exception, it catches the error and returns an 
     * error response with the exception details.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * 
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the result 
     *                                        of the logout operation.
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request);
            return ApiResponse::success(
                message: __('login.logout.success'),
                data: null,
                status: 200
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: __('login.logout.error'),
                exception: $e->getMessage(),
                status: 500
            );
        }
    }
}
