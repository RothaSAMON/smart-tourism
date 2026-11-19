<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /*
    *
    * Command: php artisan db:seed --class=BookingSeeder
    *
    */
    public function run(): void
    {
        $customers = [
            User::firstOrCreate(
                ['email' => 'sophea.chan@example.kh'],
                [
                    'name' => 'Sophea Chan',
                    'password' => 'password',
                    'phone' => '+855 17 222 333',
                    'status' => 'active',
                    'user_type' => 'user',
                ]
            ),
            User::firstOrCreate(
                ['email' => 'visal.kem@example.kh'],
                [
                    'name' => 'Visal Kem',
                    'password' => 'password',
                    'phone' => '+855 92 444 555',
                    'status' => 'active',
                    'user_type' => 'user',
                ]
            ),
            User::firstOrCreate(
                ['email' => 'bopha.lim@example.kh'],
                [
                    'name' => 'Bopha Lim',
                    'password' => 'password',
                    'phone' => '+855 77 666 777',
                    'status' => 'active',
                    'user_type' => 'user',
                ]
            ),
        ];

        $businesses = Business::pluck('id', 'name');

        $bookings = [
            [
                'customer' => $customers[0]->id,
                'business' => 'Angkor Heritage Boutique Hotel',
                'booking_date' => '2026-12-05',
                'people' => 2,
                'total_price' => 145.00,
                'status' => 'confirmed',
            ],
            [
                'customer' => $customers[1]->id,
                'business' => 'Mekong Riverfront Tours',
                'booking_date' => '2026-11-24',
                'people' => 4,
                'total_price' => 120.00,
                'status' => 'confirmed',
            ],
            [
                'customer' => $customers[2]->id,
                'business' => 'Kampot Pepper Eco-Lodge',
                'booking_date' => '2026-12-12',
                'people' => 3,
                'total_price' => 195.00,
                'status' => 'pending',
            ],
            [
                'customer' => $customers[0]->id,
                'business' => 'Koh Rong Dive & Snorkel Center',
                'booking_date' => '2026-12-19',
                'people' => 2,
                'total_price' => 110.00,
                'status' => 'pending',
            ],
            [
                'customer' => $customers[1]->id,
                'business' => 'Khmer Kitchen Restaurant',
                'booking_date' => '2026-12-06',
                'people' => 6,
                'total_price' => 84.50,
                'status' => 'confirmed',
            ],
            [
                'customer' => $customers[2]->id,
                'business' => 'Kep Seaside Resort',
                'booking_date' => '2026-12-28',
                'people' => 2,
                'total_price' => 160.00,
                'status' => 'cancelled',
            ],
        ];

        foreach ($bookings as $item) {
            $businessId = $businesses[$item['business']] ?? null;

            if (! $businessId) {
                continue;
            }

            Booking::updateOrCreate(
                [
                    'user_id' => $item['customer'],
                    'business_id' => $businessId,
                    'booking_date' => $item['booking_date'],
                ],
                [
                    'people' => $item['people'],
                    'total_price' => $item['total_price'],
                    'status' => $item['status'],
                ]
            );
        }
    }
}

