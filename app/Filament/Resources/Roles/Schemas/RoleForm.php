<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\GridDirection;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        $permissions = Permission::query()->get();

        $groupedPermissions = $permissions
            ->groupBy(fn (Permission $permission): string => $permission->type ?: static::guessGroup($permission->name))
            ->sortKeys();

        $actionOrder = ['view', 'create', 'delete', 'edit', 'preview'];

        $permissionComponents = [];

        foreach ($groupedPermissions as $group => $groupPermissions) {
            $sortedPermissions = $groupPermissions->sortBy(function (Permission $permission) use ($actionOrder, $group): int {
                $action = static::actionLabel($permission->name, $group);
                $position = array_search(strtolower($action), $actionOrder, true);

                return $position === false ? 999 : $position;
            })->values();

            $options = $sortedPermissions
                ->mapWithKeys(fn (Permission $permission): array => [
                    (string) $permission->id => Str::headline(static::actionLabel($permission->name, $group)),
                ])
                ->all();

            $stateKey = 'permission_group_'.Str::slug($group, '_');

            $permissionComponents[] = CheckboxList::make($stateKey)
                ->label(Str::headline($group))
                ->options($options)
                ->columns(min(4, max(1, count($options))))
                ->gridDirection(GridDirection::Row)
                ->bulkToggleable()
                ->dehydrated()
                ->afterStateHydrated(function (CheckboxList $component, $record) use ($sortedPermissions): void {
                    if (! $record) {
                        $component->state([]);

                        return;
                    }

                    $groupIds = $sortedPermissions->pluck('id')->all();

                    $selectedIds = $record->permissions()
                        ->whereIn('id', $groupIds)
                        ->pluck('id')
                        ->map(fn ($id): string => (string) $id)
                        ->all();

                    $component->state($selectedIds);
                });
        }

        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('guard_name')
                    ->default('web')
                    ->required()
                    ->maxLength(255),
                Section::make('Permissions')
                    ->description('Assign permissions grouped by module.')
                    ->schema($permissionComponents ?: [
                        TextInput::make('no_permissions')
                            ->hidden()
                            ->dehydrated(false),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),
            ]);
    }

    protected static function actionLabel(string $permissionName, string $group): string
    {
        $suffix = ' '.$group;

        if (str_ends_with($permissionName, $suffix)) {
            return trim(substr($permissionName, 0, -strlen($suffix)));
        }

        return Str::before($permissionName, ' ') ?: $permissionName;
    }

    protected static function guessGroup(string $permissionName): string
    {
        $parts = explode(' ', $permissionName, 2);

        return $parts[1] ?? $permissionName;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<int, string>
     */
    public static function extractPermissionIds(array $data): array
    {
        $ids = [];

        foreach ($data as $key => $value) {
            if (! str_starts_with($key, 'permission_group_')) {
                continue;
            }

            foreach ((array) $value as $id) {
                if ($id !== null && $id !== '') {
                    $ids[] = (string) $id;
                }
            }
        }

        return array_values(array_unique($ids));
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function removePermissionGroupData(array $data): array
    {
        foreach (array_keys($data) as $key) {
            if (str_starts_with($key, 'permission_group_')) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
