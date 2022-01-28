<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Helpers\Uuid;

class CannedResponseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('canned_responses')->insert([
            [
                'uuid' => Uuid::getUuid(),
                'name' => 'Working on it',
                'body' => 'We have received your message and we are working on it.',
                'active' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'uuid' => Uuid::getUuid(),
                'name' => 'ticket closing',
                'body' => 'Thanks for working with us! We are closing this ticket now.',
                'active' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'uuid' => Uuid::getUuid(),
                'name' => 'Escalated',
                'body' => 'Your support request has been escalated.',
                'active' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'uuid' => Uuid::getUuid(),
                'name' => 'Still working',
                'body' => 'We are still working on your case.',
                'active' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            
        ]);
    }
}
