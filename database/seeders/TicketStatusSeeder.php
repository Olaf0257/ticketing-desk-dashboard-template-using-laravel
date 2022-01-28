<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_statuses')->insert([
            [
                'title' => 'Opened',
                'color' => '#fc544b',
                'text_color' => '#fff',
            ],
            [
                'title' => 'In-Progress',
                'color' => '#ffa426',
                'text_color' => '#fff',
            ],
            [
                'title' => 'On-Hold',
                'color' => '#191d21',
                'text_color' => '#fff',
            ],
            [
                'title' => 'Answered',
                'color' => '#47c363',
                'text_color' => '#fff',
            ],
            [
                'title' => 'Closed',
                'color' => '#cdd3d8',
                'text_color' => '#fff',
            ],
            [
                'title' => 'Awaiting',
                'color' => '#6777ef',
                'text_color' => '#191d21',
            ],

        ]);
    }
}
