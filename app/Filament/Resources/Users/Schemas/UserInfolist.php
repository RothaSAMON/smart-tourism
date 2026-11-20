<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email'),
                TextEntry::make('email_verified_at')
                    ->dateTime()
                    ->placeholder('Unverified'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('user_type')
                    ->label('User Type'),
                TextEntry::make('status')
                    ->label('Status'),
                TextEntry::make('phone')
                    ->label('Phone'),
                ViewEntry::make('roles_and_permissions')
                    ->label('Roles & Permissions')
                    ->view('filament.resources.users.infolists.roles-and-permissions', fn (User $record): array => [
                        'user' => $record,
                        'roles' => $record->roles,
                        'groupedPermissions' => $record->getAllPermissions()
                            ->groupBy(fn (Permission $permission): string => $permission->type ?: Str::after($permission->name, ' '))
                            ->sortKeys(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
