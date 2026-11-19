<?php

namespace App\Traits\Auth;

use App\Enums\RoleEnum;
use App\Traits\Permissions\AttractionPermissionTrait;
use App\Traits\Permissions\BookingPermissionTrait;
use App\Traits\Permissions\BusinessPermissionTrait;
use App\Traits\Permissions\CategoryPermissionTrait;
use App\Traits\Permissions\EventPermissionTrait;
use App\Traits\Permissions\PermissionPermissionTrait;
use App\Traits\Permissions\ProvincePermissionTrait;
use App\Traits\Permissions\RolePermissionTrait;
use App\Traits\Permissions\TagPermissionTrait;
use App\Traits\Permissions\UserPermissionTrait;

trait RoleAndPermissionTrait
{
    use AttractionPermissionTrait;
    use BookingPermissionTrait;
    use BusinessPermissionTrait;
    use CategoryPermissionTrait;
    use EventPermissionTrait;
    use PermissionPermissionTrait;
    use ProvincePermissionTrait;
    use RolePermissionTrait;
    use TagPermissionTrait;
    use UserPermissionTrait;

    public function isDeveloperRole(): bool
    {
        return $this->hasRole(RoleEnum::DEVELOPER->value);
    }

    public function isAdminRole(): bool
    {
        return $this->hasRole(RoleEnum::ADMIN->value);
    }

    public function isBusinessOwnerRole(): bool
    {
        return $this->hasRole(RoleEnum::BUSINESS_OWNER->value);
    }

    public function isUserRole(): bool
    {
        return $this->hasRole(RoleEnum::USER->value);
    }
}
