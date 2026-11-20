<?php

namespace App\Traits\Permissions;

trait ItineraryPermissionTrait
{
    public function canViewItineraries(): bool
    {
        return $this->can('view itineraries');
    }

    public function canPreviewItineraries(): bool
    {
        return $this->can('preview itineraries');
    }

    public function canCreateItineraries(): bool
    {
        return $this->can('create itineraries');
    }

    public function canEditItineraries(): bool
    {
        return $this->can('edit itineraries');
    }

    public function canDeleteItineraries(): bool
    {
        return $this->can('delete itineraries');
    }
}

