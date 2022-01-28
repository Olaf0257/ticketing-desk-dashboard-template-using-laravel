<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDatatypesInDepartments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->text('host')->nullable()->change();
            $table->text('port')->nullable()->change();
            $table->text('mail_box')->nullable()->change();
            $table->text('smtp_host')->nullable()->change();
            $table->text('smtp_port')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            // $table->string('host')->nullable()->change();
            $table->string('port')->nullable()->change();
            $table->string('mail_box', 100)->nullable()->change();
            // $table->string('smtp_host')->nullable()->change();
            $table->string('smtp_port')->nullable()->change();
        });
    }
}
    