<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImapRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imap_replies', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->primary('uuid');
            $table->uuid('imap_ticket_uuid');
            $table->foreign('imap_ticket_uuid')->references('uuid')->on('imap_tickets')
                ->onDelete('cascade');
            $table->string('replied_to');
            $table->integer('replied_staff_id')->default(0);
            $table->string('replied_user_name')->nullable();
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
        Schema::dropIfExists('imap_replies');
    }
}
