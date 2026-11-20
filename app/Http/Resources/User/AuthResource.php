<?php

namespace App\Http\Resources\User;

use App\Enum\SpecialPermissionEnum;
use App\Http\Resources\Oauth\V1\UserWalletResource;
use App\Services\User\RoleService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'phone_number' => $this->phone_number,
            'user_type' => $this->user_type,
        ];
    }
}
