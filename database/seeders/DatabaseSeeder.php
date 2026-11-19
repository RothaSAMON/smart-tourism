<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
                'name' => 'Admin',
                'password' => Hash::make('zaq1ZAQ!'),
                'phone' => '+855 12 000 001',
                'status' => 'active',
                'user_type' => 'admin',
            ]
        );

        $this->call([
            ProvinceSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            AttractionSeeder::class,
            BusinessSeeder::class,
            EventSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
