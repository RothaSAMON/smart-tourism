<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EventInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('province.name')
                    ->label('Province'),
                TextEntry::make('location')
                    ->columnSpanFull(),
                TextEntry::make('start_date')
                    ->date(),
                TextEntry::make('end_date')
                    ->date(),
                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
