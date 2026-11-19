<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Province;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /*
    *
    * Command: php artisan db:seed --class=EventSeeder
    *
    */
    public function run(): void
    {
        $provinces = Province::pluck('id', 'name');

        $events = [
            [
                'province' => 'Phnom Penh',
                'title' => 'Bon Om Touk (Cambodian Water Festival)',
                'description' => 'Cambodia\'s grand annual celebration marking the reversal of the Tonle Sap River, featuring traditional long-boat races, illuminated floats, and fireworks along Sisowath Quay.',
                'start_date' => '2026-11-23',
                'end_date' => '2026-11-25',
                'location' => 'Sisowath Quay Riverfront, Phnom Penh',
            ],
            [
                'province' => 'Siem Reap',
                'title' => 'Angkor Sankranta (Khmer New Year)',
                'description' => 'A vibrant multi-day Khmer New Year festival at Angkor Archaeological Park celebrating traditional games, Apsara dance performances, and local crafts.',
                'start_date' => '2027-04-14',
                'end_date' => '2027-04-16',
                'location' => 'Angkor Wat & Siem Reap Riverside',
            ],
            [
                'province' => 'Siem Reap',
                'title' => 'Angkor Wat International Half Marathon',
                'description' => 'An internationally acclaimed charity road race winding through the ancient stone temples and shaded jungle avenues of Angkor Archaeological Park.',
                'start_date' => '2026-12-06',
                'end_date' => '2026-12-06',
                'location' => 'Central Sanctuary of Angkor Wat, Siem Reap',
            ],
            [
                'province' => 'Preah Sihanouk',
                'title' => 'Cambodia Sea Festival',
                'description' => 'An annual coastal tourism festival celebrating Cambodia\'s beaches with live concerts, seafood expos, water sports competitions, and cultural parades.',
                'start_date' => '2026-12-18',
                'end_date' => '2026-12-20',
                'location' => 'Ochheuteal Beach, Sihanoukville',
            ],
            [
                'province' => 'Kampot',
                'title' => 'Kampot Writers & Readers Festival',
                'description' => 'A creative gathering of Cambodian and international authors, musicians, and artists along the scenic Kampot River.',
                'start_date' => '2026-11-27',
                'end_date' => '2026-11-29',
                'location' => 'Old Town Riverside, Kampot',
            ],
            [
                'province' => 'Battambang',
                'title' => 'Phare Ponleu Selpak Cultural Week',
                'description' => 'A week-long showcase of contemporary Cambodian circus arts, live traditional music, visual art exhibitions, and community workshops.',
                'start_date' => '2027-02-12',
                'end_date' => '2027-02-18',
                'location' => 'Phare Campus, Anh Chanh Village, Battambang',
            ],
        ];

        foreach ($events as $item) {
            $provinceId = $provinces[$item['province']] ?? null;

            if (! $provinceId) {
                continue;
            }

            Event::updateOrCreate(
                ['title' => $item['title']],
                [
                    'province_id' => $provinceId,
                    'description' => $item['description'],
                    'start_date' => $item['start_date'],
                    'end_date' => $item['end_date'],
                    'location' => $item['location'],
                ]
            );
        }
    }
}

