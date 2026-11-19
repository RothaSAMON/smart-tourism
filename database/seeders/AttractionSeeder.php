<?php

namespace Database\Seeders;

use App\Models\Attraction;
use App\Models\Category;
use App\Models\Province;
use Illuminate\Database\Seeder;

class AttractionSeeder extends Seeder
{
    /*
    *
    * Command: php artisan db:seed --class=AttractionSeeder
    *
    */
    public function run(): void
    {
        $provinces = Province::pluck('id', 'name');
        $categories = Category::pluck('id', 'name');

        $attractions = [
            [
                'province' => 'Siem Reap',
                'category' => 'Historical & Temples',
                'name' => 'Angkor Wat',
                'description' => 'The largest religious monument in the world and a UNESCO World Heritage Site built in the 12th century by King Suryavarman II.',
                'latitude' => 13.4124693,
                'longitude' => 103.8669857,
                'address' => 'Krong Siem Reap, Siem Reap Province, Cambodia',
                'opening_hour' => '05:00:00',
                'closing_hour' => '17:30:00',
                'entrance_fee' => 37.00,
                'average_rating' => 4.90,
            ],
            [
                'province' => 'Siem Reap',
                'category' => 'Historical & Temples',
                'name' => 'Bayon Temple',
                'description' => 'Located at the center of Angkor Thom, renowned for its 216 serene smiling stone faces carved into 54 Gothic-style towers.',
                'latitude' => 13.4412695,
                'longitude' => 103.8588936,
                'address' => 'Angkor Thom, Krong Siem Reap, Cambodia',
                'opening_hour' => '07:30:00',
                'closing_hour' => '17:30:00',
                'entrance_fee' => 37.00,
                'average_rating' => 4.80,
            ],
            [
                'province' => 'Phnom Penh',
                'category' => 'Culture & Museums',
                'name' => 'Royal Palace of Cambodia',
                'description' => 'Official residence of the King of Cambodia, showcasing classic Khmer architecture, gilded roofs, and the Silver Pagoda.',
                'latitude' => 11.5639618,
                'longitude' => 104.9312142,
                'address' => 'Samdech Sothearos Blvd (3), Phnom Penh, Cambodia',
                'opening_hour' => '08:00:00',
                'closing_hour' => '17:00:00',
                'entrance_fee' => 10.00,
                'average_rating' => 4.70,
            ],
            [
                'province' => 'Phnom Penh',
                'category' => 'Culture & Museums',
                'name' => 'Tuol Sleng Genocide Museum',
                'description' => 'A former high school turned S-21 prison during the Khmer Rouge era, preserved today as an important historical memorial and museum.',
                'latitude' => 11.5494284,
                'longitude' => 104.9175573,
                'address' => 'Street 113, Boeung Keng Kang 3, Phnom Penh, Cambodia',
                'opening_hour' => '08:00:00',
                'closing_hour' => '17:00:00',
                'entrance_fee' => 5.00,
                'average_rating' => 4.75,
            ],
            [
                'province' => 'Preah Sihanouk',
                'category' => 'Beaches & Islands',
                'name' => 'Koh Rong Island',
                'description' => 'A paradise island off the coast of Sihanoukville with powdery white beaches, crystal-clear turquoise water, and bioluminescent plankton.',
                'latitude' => 10.7130194,
                'longitude' => 103.2471528,
                'address' => 'Koh Rong, Preah Sihanouk Province, Cambodia',
                'opening_hour' => '06:00:00',
                'closing_hour' => '22:00:00',
                'entrance_fee' => 0.00,
                'average_rating' => 4.65,
            ],
            [
                'province' => 'Kampot',
                'category' => 'Nature & Wildlife',
                'name' => 'Preah Monivong Bokor National Park',
                'description' => 'A misty mountain plateau overlooking the Gulf of Thailand with historic French colonial ruins, waterfalls, and cool mountain air.',
                'latitude' => 10.6256789,
                'longitude' => 104.0175123,
                'address' => 'Bokor Mountain, Kampot Province, Cambodia',
                'opening_hour' => '06:00:00',
                'closing_hour' => '18:00:00',
                'entrance_fee' => 0.00,
                'average_rating' => 4.50,
            ],
            [
                'province' => 'Kep',
                'category' => 'Food & Markets',
                'name' => 'Kep Crab Market',
                'description' => 'Iconic seaside market where local fishermen haul in blue swimmer crabs cooked fresh with aromatic Kampot green peppercorns.',
                'latitude' => 10.4832145,
                'longitude' => 104.2943210,
                'address' => 'Road 33A, Krong Kep, Kep Province, Cambodia',
                'opening_hour' => '06:30:00',
                'closing_hour' => '20:00:00',
                'entrance_fee' => 0.00,
                'average_rating' => 4.55,
            ],
            [
                'province' => 'Battambang',
                'category' => 'Adventure & Eco-Tourism',
                'name' => 'Battambang Bamboo Train (Norry)',
                'description' => 'A unique motorized bamboo platform riding along rural railway tracks through scenic Cambodian countryside and rice fields.',
                'latitude' => 13.0695412,
                'longitude' => 103.2371894,
                'address' => 'O Dambong, Battambang Province, Cambodia',
                'opening_hour' => '07:30:00',
                'closing_hour' => '17:30:00',
                'entrance_fee' => 5.00,
                'average_rating' => 4.45,
            ],
            [
                'province' => 'Mondulkiri',
                'category' => 'Nature & Wildlife',
                'name' => 'Bousra Waterfall',
                'description' => 'A spectacular three-tiered waterfall surrounded by dense jungle in Mondulkiri, popular for sightseeing, swimming, and zip-lining.',
                'latitude' => 12.5678123,
                'longitude' => 107.4192345,
                'address' => 'Pech Chreada District, Mondulkiri Province, Cambodia',
                'opening_hour' => '07:00:00',
                'closing_hour' => '17:30:00',
                'entrance_fee' => 2.50,
                'average_rating' => 4.60,
            ],
            [
                'province' => 'Ratanakiri',
                'category' => 'Nature & Wildlife',
                'name' => 'Yeak Laom Volcanic Lake',
                'description' => 'A nearly circular emerald volcanic crater lake nestled in protected forest, ideal for swimming and walking its scenic 3km trail.',
                'latitude' => 13.7305612,
                'longitude' => 107.0156789,
                'address' => 'Banlung, Ratanakiri Province, Cambodia',
                'opening_hour' => '07:00:00',
                'closing_hour' => '17:30:00',
                'entrance_fee' => 2.00,
                'average_rating' => 4.70,
            ],
            [
                'province' => 'Koh Kong',
                'category' => 'Adventure & Eco-Tourism',
                'name' => 'Tatai Waterfall',
                'description' => 'A lush riverside cascade in the Cardamom Mountains reachable by boat or kayak, offering natural rock pools and eco-lodge stays.',
                'latitude' => 11.5841234,
                'longitude' => 103.0954321,
                'address' => 'Tatai Commune, Koh Kong Province, Cambodia',
                'opening_hour' => '07:00:00',
                'closing_hour' => '17:00:00',
                'entrance_fee' => 3.00,
                'average_rating' => 4.60,
            ],
            [
                'province' => 'Kampong Cham',
                'category' => 'Culture & Museums',
                'name' => 'Koh Pen Bamboo Bridge',
                'description' => 'A handcrafted seasonal bamboo bridge rebuilt each dry season connecting Kampong Cham town to tranquil Koh Pen Island on the Mekong.',
                'latitude' => 11.9885432,
                'longitude' => 105.4682109,
                'address' => 'Krong Kampong Cham, Kampong Cham Province, Cambodia',
                'opening_hour' => '06:00:00',
                'closing_hour' => '19:00:00',
                'entrance_fee' => 1.00,
                'average_rating' => 4.40,
            ],
        ];

        foreach ($attractions as $item) {
            $provinceId = $provinces[$item['province']] ?? null;
            $categoryId = $categories[$item['category']] ?? null;

            if (! $provinceId || ! $categoryId) {
                continue;
            }

            Attraction::updateOrCreate(
                ['name' => $item['name']],
                [
                    'province_id' => $provinceId,
                    'category_id' => $categoryId,
                    'description' => $item['description'],
                    'latitude' => $item['latitude'],
                    'longitude' => $item['longitude'],
                    'address' => $item['address'],
                    'opening_hour' => $item['opening_hour'],
                    'closing_hour' => $item['closing_hour'],
                    'entrance_fee' => $item['entrance_fee'],
                    'average_rating' => $item['average_rating'],
                ]
            );
        }
    }
}

