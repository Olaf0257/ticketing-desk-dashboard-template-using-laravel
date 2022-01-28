<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldsInImapTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('imap_tickets', function (Blueprint $table) {
            // $table->dropColumn('tid');
            $table->binary('message')->change();
        });
        \DB::statement("ALTER Table imap_tickets MODIFY COLUMN tid INTEGER NOT NULL UNIQUE AUTO_INCREMENT  AFTER uuid;");
        \DB::statement("ALTER Table imap_tickets  AUTO_INCREMENT  = 10000001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imap_tickets', function (Blueprint $table) {
            $table->longText('message')->change();
        });
    }
}
