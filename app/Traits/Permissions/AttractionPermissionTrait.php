<?php

namespace App\Traits\Permissions;

trait AttractionPermissionTrait
{
    public function canViewAttractions(): bool
    {
        return $this->can('view attractions');
    }

    public function canPreviewAttractions(): bool
    {
        return $this->can('preview attractions');
    }

    public function canCreateAttractions(): bool
    {
        return $this->can('create attractions');
    }

    public function canEditAttractions(): bool
    {
        return $this->can('edit attractions');
    }

    public function canDeleteAttractions(): bool
    {
        return $this->can('delete attractions');
    }
}
