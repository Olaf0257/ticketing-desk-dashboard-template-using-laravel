<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->primary('uuid');
            $table->integer('site_id')->default(0);
            $table->bigInteger('tid')->unique();
            $table->integer('did')->default(0);

            $table->bigInteger('ticket_user_id')->unsigned();
            $table->foreign('ticket_user_id')->references('id')->on('users')
                ->onDelete('cascade');

            $table->bigInteger('opened_user_id')->unsigned();
            $table->foreign('opened_user_id')->references('id')->on('users')
                ->onDelete('cascade');


            $table->bigInteger('assigned_to')->unsigned()->nullable();
            $table->foreign('assigned_to')->references('id')->on('users');

            // $table->string('opened_by', 100)->default('user');
            $table->text('title');
            $table->longText('message');
            $table->integer('ticket_status_id')->default(1);
            $table->integer('ticket_urgency_id')->default(1);
            $table->timestamp('last_touched_at')->nullable();
            $table->string('source')->default('web');
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
        Schema::dropIfExists('tickets');
    }
}
