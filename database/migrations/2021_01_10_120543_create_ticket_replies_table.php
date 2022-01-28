<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_replies', function (Blueprint $table) {
            // $table->id();
            $table->uuid('uuid');
            $table->primary('uuid');
            $table->uuid('ticket_uuid');
            $table->foreign('ticket_uuid')->references('uuid')->on('tickets')
                ->onDelete('cascade');
            $table->integer('site_id')->default(0);
            $table->integer('replied_user_id')->default(0);
            $table->longText('message');
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
        Schema::dropIfExists('ticket_replies');
    }
}
