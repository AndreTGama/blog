<?php

namespace App\Http\Controllers\Api;

use App\Builder\ReturnMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\SendEmailToResetPassword;
use App\Http\Requests\Users\StoreUsersRequest;
use App\Http\Requests\Users\UpdatePassword;
use App\Http\Requests\Users\UpdateUsersRequest;
use App\Mail\sendCodeToForgetPassword;
use App\Mail\sendWelcome;
use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UsersControllers extends Controller
{
    /**
     * Store a new user record in the database.
     *
     * @param  StoreUsersRequest $req
     * @return JsonResponse
     */
    public function store(StoreUsersRequest $req): JsonResponse
    {
        $data = $req->all();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'type_user_id' => 3,
            'photo_name' => 'user_default.png',
        ]);

        $mail = new sendWelcome($user);
        Mail::to($data['email'])->send($mail);

        return ReturnMessage::message(
            false,
            'Account created with success',
            'Account created with success',
            null,
            $user,
            201
        );
    }
    /**
     * Update an existing user record in the database.
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
    /**
     * destroyProfileLoged
     *
     * @return JsonResponse
     */
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
    /**
     * sendEmailToResetPassword
     *
     * @return JsonResponse
     */
    public function sendEmailToResetPassword(SendEmailToResetPassword $req): JsonResponse
    {
        $data = $req->validated();
        $ip = $req->ip();
        $email = $data['email'];
        $user = User::withTrashed()->where('email', $email)->first();

        $code = uniqid();

        $resetsPasswordsUser = ResetPassword::where(['user_id' => $user->id, 'used' => false])->get();

        if(!empty($resetsPasswordsUser)) {
            foreach($resetsPasswordsUser as $reset) {
                ResetPassword::find($reset->id)->delete();
            }
        }

        ResetPassword::create([
            'code' => $code,
            'ip' => $ip,
            'user_id' => $user->id
        ]);

        $mail = new sendCodeToForgetPassword($user, $code);
        Mail::to($data['email'])->send($mail);

        return ReturnMessage::message(
            false,
            'Code has been sent to your email.',
            'Code has been sent to your email.',
            null,
            null,
            200
        );
    }
    /**
     * resetPassword
     *
     * @return JsonResponse
     */
    public function resetPassword(UpdatePassword $req): JsonResponse
    {
        $data = $req->validated();
        $code = $data['code'];
        $password = $data['password'];

        $resetPassword = ResetPassword::where('code', $code)->first();

        ResetPassword::find($resetPassword->id)->update(['used' => true]);

        User::find($resetPassword->user_id)->update([
            'password' => $password
        ]);

        return ReturnMessage::message(
            false,
            'Update Password.',
            'Update Password.',
            null,
            null,
            200
        );
    }
}
