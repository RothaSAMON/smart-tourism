<?php

namespace Database\Seeders;

use App\Models\Attraction;
use App\Models\Itinerary;
use App\Models\ItineraryItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class ItinerarySeeder extends Seeder
{
    /*
    * This method is used to seed the database with itinerary data.
    * Command: php artisan db:seed --class=ItinerarySeeder
    * @return void
    */
    public function run(): void
    {
        $traveler = User::where('email', 'sophea.chan@example.kh')->first()
            ?? User::first();

        if (! $traveler) {
            return;
        }

        $attractions = Attraction::pluck('id', 'name');

        $trips = [
            [
                'title' => 'My Siem Reap Vacation',
                'total_days' => 3,
                'budget' => 350.00,
                'items' => [
                    ['attraction' => 'Angkor Wat', 'day_number' => 1, 'visit_order' => 1],
                    ['attraction' => 'Bayon Temple', 'day_number' => 1, 'visit_order' => 2],
                    ['attraction' => 'Battambang Bamboo Train (Norry)', 'day_number' => 2, 'visit_order' => 1],
                    ['attraction' => 'Koh Pen Bamboo Bridge', 'day_number' => 3, 'visit_order' => 1],
                ],
            ],
            [
                'title' => 'Phnom Penh Heritage Weekend',
                'total_days' => 2,
                'budget' => 180.00,
                'items' => [
                    ['attraction' => 'Royal Palace of Cambodia', 'day_number' => 1, 'visit_order' => 1],
                    ['attraction' => 'Tuol Sleng Genocide Museum', 'day_number' => 2, 'visit_order' => 1],
                ],
            ],
            [
                'title' => 'Southern Coast Escape: Kampot, Kep & Koh Rong',
                'total_days' => 3,
                'budget' => 420.00,
                'items' => [
                    ['attraction' => 'Preah Monivong Bokor National Park', 'day_number' => 1, 'visit_order' => 1],
                    ['attraction' => 'Kep Crab Market', 'day_number' => 2, 'visit_order' => 1],
                    ['attraction' => 'Koh Rong Island', 'day_number' => 3, 'visit_order' => 1],
                ],
            ],
        ];

        foreach ($trips as $tripData) {
            $itinerary = Itinerary::updateOrCreate(
                [
                    'user_id' => $traveler->id,
                    'title' => $tripData['title'],
                ],
                [
                    'total_days' => $tripData['total_days'],
                    'budget' => $tripData['budget'],
                ]
            );

            foreach ($tripData['items'] as $item) {
                $attractionId = $attractions[$item['attraction']] ?? null;

                if (! $attractionId) {
                    continue;
                }

                ItineraryItem::updateOrCreate(
                    [
                        'itinerary_id' => $itinerary->id,
                        'day_number' => $item['day_number'],
                        'visit_order' => $item['visit_order'],
                    ],
                    [
                        'attraction_id' => $attractionId,
                    ]
                );
            }
        }
    }
}

