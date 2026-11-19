<?php

namespace App\Traits\Permissions;

trait EventPermissionTrait
{
    public function canViewEvents(): bool
    {
        return $this->can('view events');
    }

    public function canPreviewEvents(): bool
    {
        return $this->can('preview events');
    }

    public function canCreateEvents(): bool
    {
        return $this->can('create events');
    }

    public function canEditEvents(): bool
    {
        return $this->can('edit events');
    }

    public function canDeleteEvents(): bool
    {
        return $this->can('delete events');
    }
}
