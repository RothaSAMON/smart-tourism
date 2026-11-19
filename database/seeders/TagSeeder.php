<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /*
    *
    * Command: php artisan db:seed --class=TagSeeder
    *
    */
    public function run(): void
    {
        $tags = [
            'UNESCO Heritage',
            'Family Friendly',
            'Sunset Spot',
            'Eco-Friendly',
            'Photography',
            'Budget Friendly',
            'Luxury',
            'Cultural Experience',
            'Island Hopping',
            'Street Food',
        ];

        foreach ($tags as $name) {
            Tag::updateOrCreate(
                ['name' => $name],
                ['status' => 'active']
            );
        }
    }
}

