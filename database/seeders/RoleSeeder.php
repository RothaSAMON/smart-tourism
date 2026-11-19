<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * php artisan db:seed --class="Database\Seeders\RoleSeeder"
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guardName = config('auth.defaults.guard') ?: 'web';

        foreach (RoleEnum::cases() as $role) {
            Role::firstOrCreate([
                'name' => $role->value,
                'guard_name' => $guardName,
            ]);
        }

        $developer = Role::where('name', RoleEnum::DEVELOPER->value)
            ->where('guard_name', $guardName)
            ->first();

        if ($developer) {
            User::where('user_type', 'admin')->each(function (User $user) use ($developer): void {
                $user->assignRole($developer);
            });
        }
    }
}
