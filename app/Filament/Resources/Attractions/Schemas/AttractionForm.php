<?php

namespace App\Filament\Resources\Attractions\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class AttractionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('province_id')
                    ->relationship('province', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('address')
                    ->maxLength(255)
                    ->nullable(),
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
                TimePicker::make('opening_hour')
                    ->seconds(false)
                    ->nullable(),
                TimePicker::make('closing_hour')
                    ->seconds(false)
                    ->nullable(),
                TextInput::make('entrance_fee')
                    ->numeric()
                    ->prefix('$')
                    ->default(0)
                    ->minValue(0)
                    ->required(),
                TextInput::make('average_rating')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->maxValue(5)
                    ->step(0.01)
                    ->required(),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('attractions')
                    ->nullable()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->rows(4)
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }
}
