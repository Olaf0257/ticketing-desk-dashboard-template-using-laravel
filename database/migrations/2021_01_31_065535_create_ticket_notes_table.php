<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_notes', function (Blueprint $table) {
           // $table->id();
            $table->uuid('uuid');
            $table->uuid('ticket_uuid');
            $table->foreign('ticket_uuid')->references('uuid')->on('tickets')
                ->onDelete('cascade');
            $table->integer('site_id')->default(0);
            $table->integer('note_user_id')->default(0);
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
        Schema::dropIfExists('ticket_notes');
    }
}
