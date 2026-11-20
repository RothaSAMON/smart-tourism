<?php

namespace App\Services\User;

use App\Enums\UserStatusEnum;

class UserStatusChecker
{
    private $parentStatus;

    /**
     * Check if user is allowed based on status
     *
     * @param mixed $user
     */
    public function isAllowed($user): bool
    {
        $status = $user->status;

        // get parent once

        // INACTIVE → deny unless explicitly allowed
        if (
            (
                $status === UserStatusEnum::INACTIVE->value ||
                $this->parentStatus === UserStatusEnum::INACTIVE->value
            )
        ) {
            return false;
        }

        return true;
    }

    /**
     * Return appropriate error message
     */
    public function getErrorMessage($user, bool $allowInactive = false): string
    {
        $status = $user->status;

        if ($status === UserStatusEnum::INACTIVE->value || $this->parentStatus === UserStatusEnum::INACTIVE->value && !$allowInactive) {
            return 'This account is inactive. You cannot access this service.';
        }

        return 'Access denied due to this account status.';
    }
}
