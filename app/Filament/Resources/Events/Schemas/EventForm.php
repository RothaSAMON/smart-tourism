<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EventForm
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
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('location')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date')
                    ->afterOrEqual('start_date')
                    ->required(),
                Textarea::make('description')
                    ->rows(4)
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
