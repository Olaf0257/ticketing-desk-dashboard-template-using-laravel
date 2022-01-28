<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
           UsersTableSeeder::class,
           TicketStatusSeeder::class,
           TicketUrgencySeeder ::class,
           DepartmentSeeder::class,
         //  TicketSeeder::class,
           LanguageSeeder::class,
           SettingsSeeder::class,
           PermissionSeeder::class,
           EmailTemplateSeeder::class,
           TagTableSeeder::class,
           CannedResponseTableSeeder::class,
         //  FaqCategoryTableSeeder::class,
         //  KbCategoryTableSeeder::class,
          // KbArticleSeeder::class,
          // FaqTableSeeder::class,
       ]);
    }
}
