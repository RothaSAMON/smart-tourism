<?php

namespace App\Filament\Resources\Attractions\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AttractionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('image')
                    ->disk('public')
                    ->columnSpanFull(),
                TextEntry::make('name'),
                TextEntry::make('province.name')
                    ->label('Province'),
                TextEntry::make('category.name')
                    ->label('Category'),
                TextEntry::make('address')
                    ->placeholder('-'),
                TextEntry::make('latitude')
                    ->placeholder('-'),
                TextEntry::make('longitude')
                    ->placeholder('-'),
                TextEntry::make('opening_hour')
                    ->time('H:i')
                    ->placeholder('-'),
                TextEntry::make('closing_hour')
                    ->time('H:i')
                    ->placeholder('-'),
                TextEntry::make('entrance_fee')
                    ->money('USD'),
                TextEntry::make('average_rating'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
