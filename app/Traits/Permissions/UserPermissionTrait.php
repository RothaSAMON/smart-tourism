<?php

namespace App\Traits\Permissions;

trait UserPermissionTrait
{
    public function canViewUsers(): bool
    {
        return $this->can('view users');
    }

    public function canPreviewUsers(): bool
    {
        return $this->can('preview users');
    }

    public function canCreateUsers(): bool
    {
        return $this->can('create users');
    }

    public function canEditUsers(): bool
    {
        return $this->can('edit users');
    }

    public function canDeleteUsers(): bool
    {
        return $this->can('delete users');
    }
}
