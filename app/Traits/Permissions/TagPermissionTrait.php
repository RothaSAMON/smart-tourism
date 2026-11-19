<?php

namespace App\Traits\Permissions;

trait TagPermissionTrait
{
    public function canViewTags(): bool
    {
        return $this->can('view tags');
    }

    public function canPreviewTags(): bool
    {
        return $this->can('preview tags');
    }

    public function canCreateTags(): bool
    {
        return $this->can('create tags');
    }

    public function canEditTags(): bool
    {
        return $this->can('edit tags');
    }

    public function canDeleteTags(): bool
    {
        return $this->can('delete tags');
    }
}
