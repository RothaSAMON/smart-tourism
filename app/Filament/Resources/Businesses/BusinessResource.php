<?php

namespace App\Filament\Resources\Businesses;

use App\Filament\Resources\Businesses\Pages\CreateBusiness;
use App\Filament\Resources\Businesses\Pages\EditBusiness;
use App\Filament\Resources\Businesses\Pages\ListBusinesses;
use App\Filament\Resources\Businesses\Pages\ViewBusiness;
use App\Filament\Resources\Businesses\Schemas\BusinessForm;
use App\Filament\Resources\Businesses\Schemas\BusinessInfolist;
use App\Filament\Resources\Businesses\Tables\BusinessesTable;
use App\Models\Business;
use App\Traits\Filament\HasResourcePermissions;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BusinessResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = Business::class;

    protected static string $permissionResource = 'Businesses';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static string|UnitEnum|null $navigationGroup = 'Services & Bookings';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BusinessForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BusinessInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BusinessesTable::configure($table);
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
            'index' => ListBusinesses::route('/'),
            'create' => CreateBusiness::route('/create'),
            'view' => ViewBusiness::route('/{record}'),
            'edit' => EditBusiness::route('/{record}/edit'),
        ];
    }
}
