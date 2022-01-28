<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->longText('description')->after('name');
            $table->binary('value')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('settings', 'description'))
        {
            Schema::table('settings', function (Blueprint $table)
            {
                $table->dropColumn('description');
            });
        }
        Schema::table('settings', function (Blueprint $table) {
            $table->string('value')->change();
        });
    }
}
