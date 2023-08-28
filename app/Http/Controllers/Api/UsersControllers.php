<?php

namespace App\Http\Controllers\Api;

use App\Builder\ReturnMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUsersRequest;
use App\Http\Requests\Users\UpdateUsersRequest;
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
     * update
     *
     * @param  UpdateUsersRequest $req
     * @param  int $id
     * @return JsonResponse
     */
    public function update(int $id, UpdateUsersRequest $req): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $req->all();

            $user = User::findOrFail($id);
            $user->update($data);
            DB::commit();

            return ReturnMessage::message(
                false,
                'Account updated with success',
                'Account updated with success',
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
     * delete
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id)->delete();
            DB::commit();

            return ReturnMessage::message(
                false,
                'Account deleted with success',
                'Account deleted with success',
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
     * restore
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function restore(int $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = User::withTrashed()->find($id)->restore();
            DB::commit();

            return ReturnMessage::message(
                false,
                'Account restored with success',
                'Account restored with success',
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
     * delete
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = User::where('id', $id)->forceDelete();
            DB::commit();

            return ReturnMessage::message(
                false,
                'Account destroyed with success',
                'Account destroyed with success',
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
        $take = 10;

        if(request()->query('take')) $take = request()->query('take');
        $users = User::paginate($take);

        return ReturnMessage::message(
            false,
            'All users in system',
            'All users in system',
            null,
            $users,
            200
        );
    }
    /**
     * getOne
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function getOne(int $id): JsonResponse
    {
        try {
            $users = User::findOrFail($id);

            $users->posts = $users->posts();
            $users->comments = $users->comments();

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
    /**
     * updateProfileLoged
     *
     * @param  UpdateUsersRequest $req
     * @return JsonResponse
     */
    public function updateProfileLoged(UpdateUsersRequest $req): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $req->all();
            $id = auth()->user()->id;

            $user = User::findOrFail($id);
            $user->update($data);
            DB::commit();

            return ReturnMessage::message(
                false,
                'Account updated with success',
                'Account updated with success',
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
     * deleteProfileLoged
     *
     * @return JsonResponse
     */
    public function deleteProfileLoged(): JsonResponse
    {
        try {
            DB::beginTransaction();

            $id = auth()->user()->id;

            $user = User::findOrFail($id)->delete();
            DB::commit();

            return ReturnMessage::message(
                false,
                'Account deleted with success',
                'Account deleted with success',
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
    public function destroyProfileLoged(): JsonResponse
    {
        try {
            DB::beginTransaction();

            $id = auth()->user()->id;

            $user = User::where('id', $id)->forceDelete();
            DB::commit();

            return ReturnMessage::message(
                false,
                'Account destroyed with success',
                'Account destroyed with success',
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
}
