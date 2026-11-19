<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Customer')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('business_id')
                    ->relationship('business', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                DatePicker::make('booking_date')
                    ->required(),
                TextInput::make('people')
                    ->numeric()
                    ->integer()
                    ->minValue(1)
                    ->default(1)
                    ->required(),
                TextInput::make('total_price')
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0)
                    ->default(0)
                    ->required(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }
}
