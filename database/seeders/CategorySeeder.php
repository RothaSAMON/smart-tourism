<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /*
    *
    * Command: php artisan db:seed --class=CategorySeeder
    *
    */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Historical & Temples',
                'description' => 'Ancient Angkorian temples, archaeological ruins, and historic Khmer monuments.',
                'status' => 'active',
            ],
            [
                'name' => 'Beaches & Islands',
                'description' => 'Tropical islands, coastal beaches, snorkeling reefs, and seaside getaways.',
                'status' => 'active',
            ],
            [
                'name' => 'Nature & Wildlife',
                'description' => 'National parks, waterfalls, volcanic lakes, and ethical wildlife sanctuaries.',
                'status' => 'active',
            ],
            [
                'name' => 'Culture & Museums',
                'description' => 'Royal palaces, national museums, pagodas, traditional arts, and local heritage sites.',
                'status' => 'active',
            ],
            [
                'name' => 'Food & Markets',
                'description' => 'Traditional markets, street food streets, seafood hubs, and culinary experiences.',
                'status' => 'active',
            ],
            [
                'name' => 'Adventure & Eco-Tourism',
                'description' => 'Jungle trekking, kayaking, bamboo trains, zip-lining, and community eco-tours.',
                'status' => 'active',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}

