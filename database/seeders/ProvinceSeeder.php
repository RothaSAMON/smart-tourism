<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /*
    *
    * Command: php artisan db:seed --class=ProvinceSeeder
    *
    */
    public function run(): void
    {
        $provinces = [
            [
                'name' => 'Siem Reap',
                'description' => 'Home to the world-famous Angkor Archaeological Park, ancient Khmer temples, vibrant night markets, and rich cultural heritage.',
                'status' => 'active',
            ],
            [
                'name' => 'Phnom Penh',
                'description' => 'The bustling capital of Cambodia at the confluence of the Mekong and Tonle Sap rivers, featuring the Royal Palace, museums, and riverfront dining.',
                'status' => 'active',
            ],
            [
                'name' => 'Preah Sihanouk',
                'description' => 'Cambodia\'s premier coastal gateway known for white-sand beaches and tropical islands such as Koh Rong and Koh Rong Samloem.',
                'status' => 'active',
            ],
            [
                'name' => 'Kampot',
                'description' => 'A laid-back riverside town famous for world-renowned Kampot pepper plantations, colonial architecture, and Bokor National Park.',
                'status' => 'active',
            ],
            [
                'name' => 'Kep',
                'description' => 'A peaceful coastal province celebrated for its fresh seafood at the Crab Market, Kep National Park, and Rabbit Island (Koh Tonsay).',
                'status' => 'active',
            ],
            [
                'name' => 'Battambang',
                'description' => 'Cambodia\'s cultural and arts hub featuring French colonial shophouses, the famous Bamboo Train, bat caves, and lush rice paddies.',
                'status' => 'active',
            ],
            [
                'name' => 'Mondulkiri',
                'description' => 'A highland province in eastern Cambodia known for rolling hills, ethical elephant sanctuaries, indigenous Bunong culture, and Bousra Waterfall.',
                'status' => 'active',
            ],
            [
                'name' => 'Ratanakiri',
                'description' => 'A remote northeastern province famed for its volcanic crater lake Yeak Laom, red-earth roads, jungles, and ethnic minority villages.',
                'status' => 'active',
            ],
            [
                'name' => 'Koh Kong',
                'description' => 'An eco-tourism paradise bordering the Cardamom Mountains with mangrove forests, floating eco-lodges, and the Tatai Waterfall.',
                'status' => 'active',
            ],
            [
                'name' => 'Kampong Cham',
                'description' => 'A tranquil Mekong River province known for its seasonal bamboo bridge to Koh Pen Island, Nokor Bachey Temple, and rural charm.',
                'status' => 'active',
            ],
        ];

        foreach ($provinces as $province) {
            Province::updateOrCreate(
                ['name' => $province['name']],
                $province
            );
        }
    }
}

