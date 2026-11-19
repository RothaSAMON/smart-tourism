<?php

namespace App\Traits\Permissions;

trait BookingPermissionTrait
{
    public function canViewBookings(): bool
    {
        return $this->can('view bookings');
    }

    public function canPreviewBookings(): bool
    {
        return $this->can('preview bookings');
    }

    public function canCreateBookings(): bool
    {
        return $this->can('create bookings');
    }

    public function canEditBookings(): bool
    {
        return $this->can('edit bookings');
    }

    public function canDeleteBookings(): bool
    {
        return $this->can('delete bookings');
    }
}
