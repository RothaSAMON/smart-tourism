<?php

namespace App\Traits\Permissions;

trait RolePermissionTrait
{
    public function canViewRoles(): bool
    {
        return $this->can('view roles');
    }

    public function canPreviewRoles(): bool
    {
        return $this->can('preview roles');
    }

    public function canCreateRoles(): bool
    {
        return $this->can('create roles');
    }

    public function canEditRoles(): bool
    {
        return $this->can('edit roles');
    }

    public function canDeleteRoles(): bool
    {
        return $this->can('delete roles');
    }
}
