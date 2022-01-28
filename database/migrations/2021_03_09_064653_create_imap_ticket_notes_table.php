<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImapTicketNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imap_ticket_notes', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->uuid('imap_ticket_uuid');
            $table->foreign('imap_ticket_uuid')->references('uuid')->on('imap_tickets')
                ->onDelete('cascade');
            $table->integer('note_staff_id')->default(0);
            $table->longText('message');
            $table->integer('sticky_note')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('imap_ticket_notes');
    }
}
