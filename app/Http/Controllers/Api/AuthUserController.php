<?php

namespace App\Http\Controllers\Api;

use App\Enums\ErrorCodeEnum;
use App\Enums\RoleEnum;
use App\Enums\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Exceptions\CustomHttpException;
use App\Http\Resources\User\AuthResource;
use App\Libraries\ExceptionLib;
use App\Libraries\ResponseLib;
use App\Models\User;
use App\Services\User\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class AuthUserController extends Controller
{
    public function authorizeUser(Request $req)
    {
        $user = $req->user()->load('roles');

        $userData = (new AuthResource($user))->resolve($req);

        return response()->json([
            'data' => [
                ...$userData,
            ],
        ]);
    }

    public function register(Request $req)
    {
        $validated = $req->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        try {
            $user = User::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'name' => $validated['name'],
                    'password' => $validated['password'],
                    'phone' => $validated['phone'] ?? null,
                    'status' => UserStatusEnum::ACTIVE->value,
                    'user_type' => 'user',
                ]
            );

            $userRole = Role::where('name', RoleEnum::USER->value)
                ->where('guard_name', 'web')
                ->first();

            if ($userRole) {
                $user->assignRole($userRole);
            }

            $user->refresh()->load('roles');

            $res = $user->createToken('auth-token');

            return ResponseLib::success(
                message: 'Register Successfully.',
                status: Response::HTTP_CREATED,
                data: (new AuthResource($user))->resolve($req),
                additional: [
                    'token' => [
                        'accessToken' => $res->accessToken,
                        'tokenType' => 'Bearer',
                    ],
                    'success' => true,
                ]
            );
        } catch (CustomHttpException $th) {
            ExceptionLib::throwCustomException(
                $th->getMessage(),
                $th->getErrorCode()
            );
        } catch (\Throwable $e) {
            logger()->error('Error in method: '.__METHOD__, [
                'exception' => $e,
                'custom_data' => optional($req)->except(['password', 'password_confirmation']),
            ]);

            report($e);

            return ResponseLib::error(
                message: 'Registration failed.',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
                additional: ['success' => false]
            );
        }
    }

    public function login(Request $req)
    {
        $req->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        try {
            $user = AuthService::authenticate($req->email, $req->password);
            $user->load('roles');

            $res = $user->createToken('auth-token');

            return ResponseLib::success(
                message: 'Login Successfully.',
                data: [
                    ...(new AuthResource($user))->resolve($req),
                ],
                additional: [
                    'token' => [
                        'accessToken' => $res->accessToken,
                        'tokenType' => 'Bearer',
                    ],
                    'success' => true,
                ]
            );
        } catch (CustomHttpException $th) {
            ExceptionLib::throwCustomException(
                $th->getMessage(),
                $th->getErrorCode()
            );
        } catch (\Throwable $e) {
            logger()->error('Error in method: '.__METHOD__, [
                'exception' => $e,
                'custom_data' => optional($req)->except(['password']),
            ]);

            report($e);

            return ResponseLib::error(
                message: 'Authentication failed.',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
                additional: ['success' => false]
            );
        }
    }

    public function logout(Request $req)
    {
        try {
            $token = $req->user()->token();
            $token?->revoke();

            return ResponseLib::success(message: 'Logout was successful.', additional: ['success' => true]);
        } catch (\Throwable $e) {
            return ResponseLib::error(message: 'Failed to logout.', additional: ['success' => false]);
        }
    }

    public function updatePassword(Request $req)
    {
        $req->validate([
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'confirmed', 'min:8'],
        ]);

        try {
            if (! Hash::check($req->old_password, $req->user()->password)) {
                ExceptionLib::throwCustomException(
                    'Invalid old password.',
                    ErrorCodeEnum::INVALID_OLD_PASSWORD->value
                );
            }

            $user = $req->user();
            $user->password = $req->new_password;
            $user->save();

            return ResponseLib::success(message: 'Updated successfully.', additional: ['success' => true]);
        } catch (CustomHttpException $th) {
            ExceptionLib::throwCustomException(
                $th->getMessage(),
                $th->getErrorCode()
            );
        } catch (\Throwable $e) {
            return ResponseLib::error(message: 'Failed to update password.', additional: ['success' => false]);
        }
    }

    public function updateAuthUser(Request $req)
    {
        $user = $req->user();

        $req->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'new_password' => ['nullable', 'confirmed', 'min:8'],
            'auth_password' => ['required_with:new_password', 'string'],
        ]);

        try {
            if ($req->filled('new_password')) {
                if (! Hash::check($req->auth_password, $user->password)) {
                    ExceptionLib::throwCustomException(
                        'Wrong credentials',
                        ErrorCodeEnum::WRONG_CREDENTIALS->value
                    );
                }

                $user->password = $req->new_password;
            }

            if ($req->has('name')) {
                $user->name = $req->name;
            }

            if ($req->has('email')) {
                $user->email = $req->email;
            }

            if ($req->has('phone')) {
                $user->phone = $req->phone;
            }

            $user->save();
            $user->load('roles');

            return ResponseLib::success(
                message: 'Account updated successfully.',
                data: ['user' => new AuthResource($user)],
                additional: ['success' => true]
            );
        } catch (CustomHttpException $th) {
            throw $th;
        } catch (\Throwable $e) {
            return ResponseLib::error(
                message: 'Failed to update account: '.$e->getMessage(),
                additional: ['success' => false]
            );
        }
    }
}
