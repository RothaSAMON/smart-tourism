<?php

namespace App\Enums;

enum UserStatusEnum : string 
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public static function values(): array
    {
        return [
            self::ACTIVE->value,
            self::INACTIVE->value,
        ];
    }

     public static function showUserStausClass(string $status): string
    {
        return match ($status) {
            self::ACTIVE->value => 'badge bg-green-lt',
            self::INACTIVE->value => 'badge bg-orange-lt',
        };
    }
}