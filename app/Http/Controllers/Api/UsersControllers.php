<?php

namespace App\Http\Controllers\Api;

use App\Builder\ReturnMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUsersRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UsersControllers extends Controller
{
    /**
     * store
     *
     * @param  StoreUsersRequest $req
     * @return JsonResponse
     */
    public function store(StoreUsersRequest $req): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $req->all();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'type_user_id' => 3,
                'photo_name' => 'user_default.png',
            ]);
            DB::commit();

            return ReturnMessage::message(
                false,
                'Account created with success',
                'Account created with success',
                null,
                $user,
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ReturnMessage::message(
                false,
                $e->getMessage(),
                $e->getMessage(),
                null,
                [],
                400
            );
        }
    }
    /**
     * getAll
     *
     * Get all users active in system
     *
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        try {
            $users = User::all();

            return ReturnMessage::message(
                false,
                'All users in system',
                'All users in system',
                null,
                $users,
                200
            );
        } catch (\Exception $e) {
            return ReturnMessage::message(
                false,
                $e->getMessage(),
                $e->getMessage(),
                null,
                [],
                400
            );
        }
    }
    /**
     * getProfileLoged
     *
     * Get info user loged
     *
     * @return JsonResponse
     */
    public function getProfileLoged(): JsonResponse
    {
        try {
            $id = auth()->user()->id;

            $user = User::find($id);

            return ReturnMessage::message(
                false,
                'Information found',
                'Information found',
                null,
                $user,
                200
            );
        } catch (\Exception $e) {
            return ReturnMessage::message(
                false,
                $e->getMessage(),
                $e->getMessage(),
                null,
                [],
                400
            );
        }
    }
}
