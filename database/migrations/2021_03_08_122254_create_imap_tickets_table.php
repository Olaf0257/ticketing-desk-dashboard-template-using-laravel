<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImapTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imap_tickets', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->primary('uuid');
            $table->bigInteger('tid')->unique();
            $table->integer('did')->default(0);

            $table->bigInteger('department_id')->unsigned();
            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade');

            $table->bigInteger('assigned_to')->unsigned()->nullable();
            $table->foreign('assigned_to')->references('id')->on('users')
                ->onDelete('cascade');

            $table->text('message_id');
            $table->text('subject');
            $table->longText('message');
            $table->string('from_name');
            $table->string('from_email');
            $table->integer('staff_unread')
                ->default(0);
            $table->integer('ticket_status_id')->default(1);
            $table->integer('ticket_urgency_id')->default(1);
            $table->timestamp('last_touched_at')->nullable();
            $table->string('source')->default('imap');
            $table->timestamp('closed_at')->nullable();
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
        Schema::dropIfExists('imap_tickets');
    }
}
