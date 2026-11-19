<?php

namespace App\Traits\Filament;

use Illuminate\Database\Eloquent\Model;

/**
 * Filament Resource authorization trait backed by App\Traits\Auth\RoleAndPermissionTrait.
 *
 * Define `protected static string $permissionResource = 'Provinces';` on the Resource.
 */
trait HasResourcePermissions
{
    protected static function checkResourcePermission(string $prefix): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        if (method_exists($user, 'isDeveloperRole') && $user->isDeveloperRole()) {
            return true;
        }

        $resource = static::$permissionResource ?? '';
        $method = $prefix.$resource;

        return $resource !== '' && method_exists($user, $method) && (bool) $user->{$method}();
    }

    public static function canViewAny(): bool
    {
        return static::checkResourcePermission('canView');
    }

    public static function canView(Model $record): bool
    {
        return static::checkResourcePermission('canPreview');
    }

    public static function canCreate(): bool
    {
        return static::checkResourcePermission('canCreate');
    }

    public static function canEdit(Model $record): bool
    {
        return static::checkResourcePermission('canEdit');
    }

    public static function canDelete(Model $record): bool
    {
        return static::checkResourcePermission('canDelete');
    }

    public static function canDeleteAny(): bool
    {
        return static::checkResourcePermission('canDelete');
    }
}
