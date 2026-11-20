<?php

namespace App\Services\User;

use App\Enums\ErrorCodeEnum;
use App\Enums\UserStatusEnum;
use App\Models\User;
use App\Libraries\ExceptionLib;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Authenticate and validate a user based on credentials, status, parent status, and roles.
     *
     * @param string $username
     * @param string $password
     * @param array|null $allowedRoles
     * @return User
     * @throws \App\Http\Exceptions\CustomHttpException
     */
    public static function authenticate(string $email, string $password): User
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            ExceptionLib::throwCustomException(
                'User not found.',
                ErrorCodeEnum::USER_NOT_FOUND->value,
            );
        }

        // Check whether the stored password is a valid password hash.
        $hashInfo = password_get_info($user->password);

        if (
            $hashInfo['algoName'] === 'unknown'
            || !Hash::check($password, $user->password)
        ) {
            ExceptionLib::throwCustomException(
                'Invalid credentials.',
                ErrorCodeEnum::WRONG_CREDENTIALS->value,
            );
        }

        if (in_array($user->status, [UserStatusEnum::INACTIVE->value])) {
            ExceptionLib::throwCustomException(
                'User is inactive or blocked.',
                ErrorCodeEnum::FORBIDDEN->value,
            );
        }

        return $user;
    }
}
