<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTicketFieldsInTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            // $table->dropColumn('tid');
            $table->binary('message')->change();
            $table->dropForeign('tickets_assigned_to_foreign');
            $table->foreign('assigned_to')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->change();
        });
        \DB::statement("ALTER Table tickets MODIFY COLUMN tid INTEGER NOT NULL UNIQUE AUTO_INCREMENT  AFTER uuid;");
        \DB::statement("ALTER Table tickets  AUTO_INCREMENT  = 10000001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->longText('message')->change();
        });
    }
}