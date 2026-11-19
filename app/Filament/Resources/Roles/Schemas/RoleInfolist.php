<?php

namespace App\Filament\Resources\Roles\Schemas;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RoleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('guard_name')
                    ->badge(),
                RepeatableEntry::make('users')
                    ->label('Users')
                    ->schema([
                        TextEntry::make('name')
                            ->url(fn (User $record): string => UserResource::getUrl('view', ['record' => $record]))
                            ->color('primary'),
                        TextEntry::make('email'),
                    ])
                    ->columns(2)
                    ->placeholder('No users')
                    ->columnSpanFull(),
                TextEntry::make('permissions.name')
                    ->label('Permissions')
                    ->badge()
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
