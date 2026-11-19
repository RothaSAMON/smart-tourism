<?php

namespace App\Enums;

enum RoleEnum: string
{
    case DEVELOPER = 'developer';
    case ADMIN = 'admin';
    case BUSINESS_OWNER = 'business_owner';
    case USER = 'user';

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
