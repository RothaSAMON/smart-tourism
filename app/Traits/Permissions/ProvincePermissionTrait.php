<?php

namespace App\Traits\Permissions;

trait ProvincePermissionTrait
{
    public function canViewProvinces(): bool
    {
        return $this->can('view provinces');
    }

    public function canPreviewProvinces(): bool
    {
        return $this->can('preview provinces');
    }

    public function canCreateProvinces(): bool
    {
        return $this->can('create provinces');
    }

    public function canEditProvinces(): bool
    {
        return $this->can('edit provinces');
    }

    public function canDeleteProvinces(): bool
    {
        return $this->can('delete provinces');
    }
}
