<?php

namespace App\Traits\Permissions;

trait CategoryPermissionTrait
{
    public function canViewCategories(): bool
    {
        return $this->can('view categories');
    }

    public function canPreviewCategories(): bool
    {
        return $this->can('preview categories');
    }

    public function canCreateCategories(): bool
    {
        return $this->can('create categories');
    }

    public function canEditCategories(): bool
    {
        return $this->can('edit categories');
    }

    public function canDeleteCategories(): bool
    {
        return $this->can('delete categories');
    }
}
