<?php

namespace Database\Seeders\Permissions;

use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AttractionPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * php artisan db:seed --class="Database\Seeders\Permissions\AttractionPermissionSeeder"
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guardName = config('auth.defaults.guard') ?: 'web';
        $roles = [
            Role::firstOrCreate(['name' => RoleEnum::DEVELOPER->value, 'guard_name' => $guardName])->id,
            // Role::firstOrCreate(['name' => RoleEnum::ADMIN->value, 'guard_name' => $guardName])->id,
            // Role::firstOrCreate(['name' => RoleEnum::BUSINESS_OWNER->value, 'guard_name' => $guardName])->id,
            // Role::firstOrCreate(['name' => RoleEnum::USER->value, 'guard_name' => $guardName])->id,
        ];

        $permissionName = 'attractions';
        $actions = ['view', 'preview', 'create', 'edit', 'delete'];

        foreach ($actions as $action) {
            $this->generatePermission(
                ['name' => "$action $permissionName"],
                ['guard_name' => $guardName],
                $roles
            );
        }
    }

    /**
     * Generate or update a permission and associate roles.
     *
     * @param  array<string, mixed>  $whereName
     * @param  array<string, mixed>  $extraData
     * @param  array<int, int>  $roles
     */
    private function generatePermission(array $whereName, array $extraData, array $roles = []): void
    {
        $permission = Permission::updateOrCreate($whereName, $extraData);

        if (count($roles) > 0) {
            $permission->roles()->syncWithoutDetaching($roles);
        }
    }
}
