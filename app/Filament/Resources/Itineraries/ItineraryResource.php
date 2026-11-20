<?php

namespace App\Filament\Resources\Itineraries;

use App\Filament\Resources\Itineraries\Pages\CreateItinerary;
use App\Filament\Resources\Itineraries\Pages\EditItinerary;
use App\Filament\Resources\Itineraries\Pages\ListItineraries;
use App\Filament\Resources\Itineraries\Pages\ViewItinerary;
use App\Filament\Resources\Itineraries\Schemas\ItineraryForm;
use App\Filament\Resources\Itineraries\Schemas\ItineraryInfolist;
use App\Filament\Resources\Itineraries\Tables\ItinerariesTable;
use App\Models\Itinerary;
use App\Traits\Filament\HasResourcePermissions;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ItineraryResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = Itinerary::class;

    protected static string $permissionResource = 'Itineraries';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMap;

    protected static string|UnitEnum|null $navigationGroup = 'Services & Bookings';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ItineraryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ItineraryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ItinerariesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListItineraries::route('/'),
            'create' => CreateItinerary::route('/create'),
            'view' => ViewItinerary::route('/{record}'),
            'edit' => EditItinerary::route('/{record}/edit'),
        ];
    }
}
