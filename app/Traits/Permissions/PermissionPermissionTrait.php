<?php

namespace App\Traits\Permissions;

trait PermissionPermissionTrait
{
    public function canViewPermissions(): bool
    {
        return $this->can('view permissions');
    }

    public function canPreviewPermissions(): bool
    {
        return $this->can('preview permissions');
    }

    public function canCreatePermissions(): bool
    {
        return $this->can('create permissions');
    }

    public function canEditPermissions(): bool
    {
        return $this->can('edit permissions');
    }

    public function canDeletePermissions(): bool
    {
        return $this->can('delete permissions');
    }
}
