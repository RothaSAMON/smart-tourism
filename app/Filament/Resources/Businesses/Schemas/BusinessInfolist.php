<?php

namespace App\Filament\Resources\Businesses\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BusinessInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('user.name')
                    ->label('Owner'),
                TextEntry::make('category'),
                TextEntry::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'pending' => 'warning',
                        'inactive' => 'danger',
                        default => 'gray',
                    }),
                TextEntry::make('address')
                    ->columnSpanFull(),
                TextEntry::make('latitude')
                    ->placeholder('-'),
                TextEntry::make('longitude')
                    ->placeholder('-'),
                TextEntry::make('phone'),
                TextEntry::make('website')
                    ->url(fn (?string $state): ?string => $state, shouldOpenInNewTab: true),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
