<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Helpers\Uuid;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'uuid' => Uuid::getUuid(),
                'name' => 'ticket_status_management',
                'role' => 'staff',
                'description' => 'Enable the feature for staffs to manage ticket statuses',
                'status' => false,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'uuid' => Uuid::getUuid(),
                'name' => 'departments_management',
                'role' => 'staff',
                'description' => 'Enable the feature for staffs to manage departments',
                'status' => false,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'uuid' => Uuid::getUuid(),
                'name' => 'tags_management',
                'role' => 'staff',
                'description' => 'Enable the feature for staffs to manage tags',
                'status' => false,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'uuid' => Uuid::getUuid(),
                'name' => 'knowledge_base_management',
                'role' => 'staff',
                'description' => 'Enable the feature for staffs to manage knowledge bases',
                'status' => false,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]

        ]);
    }
}
