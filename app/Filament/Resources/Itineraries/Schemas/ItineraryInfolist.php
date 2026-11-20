<?php

namespace App\Filament\Resources\Itineraries\Schemas;

use App\Filament\Resources\Attractions\AttractionResource;
use App\Models\ItineraryItem;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ItineraryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('user.name')
                    ->label('Traveler'),
                TextEntry::make('total_days')
                    ->label('Total Days')
                    ->suffix(' days'),
                TextEntry::make('budget')
                    ->money('USD'),
                RepeatableEntry::make('items')
                    ->label('Trip Destinations')
                    ->schema([
                        TextEntry::make('day_number')
                            ->label('Day')
                            ->prefix('Day ')
                            ->badge(),
                        TextEntry::make('visit_order')
                            ->label('Stop #'),
                        TextEntry::make('attraction.name')
                            ->label('Destination')
                            ->url(fn (ItineraryItem $record): ?string => $record->attraction
                                ? AttractionResource::getUrl('view', ['record' => $record->attraction])
                                : null)
                            ->color('primary'),
                    ])
                    ->columns(3)
                    ->placeholder('No destinations added yet')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
