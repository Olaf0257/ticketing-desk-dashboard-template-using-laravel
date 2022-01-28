<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImapTicketStatusLivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imap_ticket_status_lives', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->primary('uuid');

            $table->uuid('ticket_uuid');
            $table->foreign('ticket_uuid')->references('uuid')->on('imap_tickets')
                ->onDelete('cascade');

            $table->integer('previous_status_id');
            $table->integer('current_status_id');
            $table->integer('life_time');
            $table->integer('assigned_to')->nullable();
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
        Schema::dropIfExists('imap_ticket_status_lives');
    }
}
