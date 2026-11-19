<?php

namespace App\Traits\Permissions;

trait BusinessPermissionTrait
{
    public function canViewBusinesses(): bool
    {
        return $this->can('view businesses');
    }

    public function canPreviewBusinesses(): bool
    {
        return $this->can('preview businesses');
    }

    public function canCreateBusinesses(): bool
    {
        return $this->can('create businesses');
    }

    public function canEditBusinesses(): bool
    {
        return $this->can('edit businesses');
    }

    public function canDeleteBusinesses(): bool
    {
        return $this->can('delete businesses');
    }
}
