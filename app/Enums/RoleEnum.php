<?php

namespace App\Enums;

enum RoleEnum: string
{
    case DEVELOPER = 'Developer';
    case ADMIN = 'Admin';
    case BUSINESS_OWNER = 'Business Owner';
    case USER = 'User';

    /**
     * Get a human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::DEVELOPER => 'Developer',
            self::ADMIN => 'Admin',
            self::BUSINESS_OWNER => 'Business Owner',
            self::USER => 'User',
        };
    }
}
