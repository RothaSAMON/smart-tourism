<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /*
    *
    * Command: php artisan db:seed --class=BusinessSeeder
    *
    */
    public function run(): void
    {
        $owner = User::firstOrCreate(
            ['email' => 'sokha.business@smarttourism.kh'],
            [
                'name' => 'Sokha Dara',
                'password' => 'password',
                'phone' => '+855 12 345 678',
                'status' => 'active',
                'user_type' => 'user',
            ]
        );

        $businesses = [
            [
                'name' => 'Angkor Heritage Boutique Hotel',
                'category' => 'Hotel',
                'address' => 'Wat Bo Road, Krong Siem Reap, Cambodia',
                'latitude' => 13.3568912,
                'longitude' => 103.8612345,
                'phone' => '+855 63 965 100',
                'website' => 'https://angkorheritage.example.kh',
                'status' => 'active',
            ],
            [
                'name' => 'Khmer Kitchen Restaurant',
                'category' => 'Restaurant',
                'address' => 'Alley West, Pub Street Area, Siem Reap, Cambodia',
                'latitude' => 13.3545123,
                'longitude' => 103.8548901,
                'phone' => '+855 63 964 154',
                'website' => 'https://khmerkitchen.example.kh',
                'status' => 'active',
            ],
            [
                'name' => 'Mekong Riverfront Tours',
                'category' => 'Tour Operator',
                'address' => 'Sisowath Quay, Daun Penh, Phnom Penh, Cambodia',
                'latitude' => 11.5724189,
                'longitude' => 104.9285412,
                'phone' => '+855 23 218 900',
                'website' => 'https://mekongtours.example.kh',
                'status' => 'active',
            ],
            [
                'name' => 'Kampot Pepper Eco-Lodge',
                'category' => 'Eco-Lodge',
                'address' => 'Makprang Commune, Kampot Province, Cambodia',
                'latitude' => 10.6481234,
                'longitude' => 104.1654321,
                'phone' => '+855 33 932 450',
                'website' => 'https://kampotecolodge.example.kh',
                'status' => 'active',
            ],
            [
                'name' => 'Koh Rong Dive & Snorkel Center',
                'category' => 'Water Sports',
                'address' => 'Koh Touch Village, Koh Rong, Preah Sihanouk, Cambodia',
                'latitude' => 10.7068123,
                'longitude' => 103.2819456,
                'phone' => '+855 88 712 3456',
                'website' => 'https://kohrongdive.example.kh',
                'status' => 'active',
            ],
            [
                'name' => 'Kep Seaside Resort',
                'category' => 'Resort',
                'address' => 'Beach Road 33A, Krong Kep, Cambodia',
                'latitude' => 10.4865123,
                'longitude' => 104.3021987,
                'phone' => '+855 36 210 888',
                'website' => 'https://kepseaside.example.kh',
                'status' => 'pending',
            ],
        ];

        foreach ($businesses as $business) {
            Business::updateOrCreate(
                ['name' => $business['name']],
                array_merge($business, ['user_id' => $owner->id])
            );
        }
    }
}

