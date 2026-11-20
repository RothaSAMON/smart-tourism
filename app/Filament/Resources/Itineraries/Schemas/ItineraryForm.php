<?php

namespace App\Filament\Resources\Itineraries\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ItineraryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Traveler')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. My Siem Reap Vacation'),
                TextInput::make('total_days')
                    ->numeric()
                    ->integer()
                    ->minValue(1)
                    ->default(1)
                    ->required(),
                TextInput::make('budget')
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0)
                    ->default(0)
                    ->required(),
                Repeater::make('items')
                    ->label('Trip Destinations')
                    ->relationship()
                    ->schema([
                        Select::make('attraction_id')
                            ->relationship('attraction', 'name')
                            ->label('Attraction')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('day_number')
                            ->label('Day')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->default(1)
                            ->required(),
                        TextInput::make('visit_order')
                            ->label('Order')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->default(1)
                            ->required(),
                    ])
                    ->columns(4)
                    ->defaultItems(0)
                    ->addActionLabel('Add Destination')
                    ->columnSpanFull(),
            ]);
    }
}
