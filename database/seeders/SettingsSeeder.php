<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->truncate();
        DB::table('settings')->insert([
            [
                'id' => 1,
                'name' => 'imap',
                'value' => 0,
                'type' => 'radio',
                'description' =>'Enable imap to use email ticketing feature',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'name' => 'attachment_extensions',
                'value' => 'png,jpg,jpeg,doc,pdf',
                'type' => 'text',
                'description' =>'Add attachment extensions separated by commas',
           
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],

            [
                'id' => 3,
                'name' => 'app_name',
                'value' => 'Ticketing Expert',
                'type' => 'text',
                'description' =>'You can provide your app name here',
           
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            
            [
                'id' => 4,
                'name' => 'system_logo',
                'value' => '',
                'type' => 'attachment',
                'description' =>'The system logo must be a file of type: .svg, .png',
           
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],

            [
                'id' => 5,
                'name' => 'footer_text',
                'value' => 'Copyright © 2020  A product from Modulespanel.com',
                'type' => 'text',
                'description' =>'Add the footer text to be displayed',
           
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
             [
                'id' => 6,
                'name' => 'privacy_policy',
                'value' => 'Add a privacy policy',
                'type' => 'text_area',
                'description' =>'Add the detailed privacy policy here',
           
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id' => 7,
                'name' => 'terms_of_use',
                'value' => 'Add the terms of use',
                'type' => 'text_area',
                'description' =>'You can add the terms of use from here',
           
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);
    }
}
