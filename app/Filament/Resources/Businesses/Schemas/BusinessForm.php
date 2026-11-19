<?php

namespace App\Filament\Resources\Businesses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BusinessForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Owner')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('category')
                    ->required()
                    ->maxLength(255),
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'pending' => 'Pending',
                    ])
                    ->default('active')
                    ->required(),
                TextInput::make('address')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('latitude')
                    ->numeric()
                    ->minValue(-90)
                    ->maxValue(90)
                    ->step(0.0000001)
                    ->nullable(),
                TextInput::make('longitude')
                    ->numeric()
                    ->minValue(-180)
                    ->maxValue(180)
                    ->step(0.0000001)
                    ->nullable(),
                TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                TextInput::make('website')
                    ->url()
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
