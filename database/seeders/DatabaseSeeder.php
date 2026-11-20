<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Permissions\AttractionPermissionSeeder;
use Database\Seeders\Permissions\BookingPermissionSeeder;
use Database\Seeders\Permissions\BusinessPermissionSeeder;
use Database\Seeders\Permissions\CategoryPermissionSeeder;
use Database\Seeders\Permissions\EventPermissionSeeder;
use Database\Seeders\Permissions\ItineraryPermissionSeeder;
use Database\Seeders\Permissions\PermissionPermissionSeeder;
use Database\Seeders\Permissions\ProvincePermissionSeeder;
use Database\Seeders\Permissions\RolePermissionSeeder;
use Database\Seeders\Permissions\TagPermissionSeeder;
use Database\Seeders\Permissions\UserPermissionSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * Command: php artisan db:seed --class=DatabaseSeeder
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => 'zaq1ZAQ!',
                'phone' => '+855 12 000 001',
                'status' => 'active',
                'user_type' => 'admin',
            ]
        );

        $this->call([
            RoleSeeder::class,

            // Permissions (one seeder per CRUD)
            ProvincePermissionSeeder::class,
            CategoryPermissionSeeder::class,
            AttractionPermissionSeeder::class,
            TagPermissionSeeder::class,
            BusinessPermissionSeeder::class,
            EventPermissionSeeder::class,
            BookingPermissionSeeder::class,
            ItineraryPermissionSeeder::class,
            UserPermissionSeeder::class,
            RolePermissionSeeder::class,
            PermissionPermissionSeeder::class,

            // Cambodia Tourism Data
            ProvinceSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            AttractionSeeder::class,
            BusinessSeeder::class,
            EventSeeder::class,
            BookingSeeder::class,
            ItinerarySeeder::class,
        ]);
    }
}
