<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImapTicketTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imap_ticket_tag', function (Blueprint $table) {
            $table->id();
            $table->uuid('imap_ticket_uuid')->references('uuid')->on('imap_tickets')
            ->onDelete('cascade');
            $table->uuid('tag_uuid')->references('uuid')->on('tags')
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imap_ticket_tag');
    }
}
