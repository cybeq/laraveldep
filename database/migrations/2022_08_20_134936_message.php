<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('sent_to_id');
            $table->text('body');
            $table->text('subject');

            // It's better to work with default timestamp names:
            $table->timestamps();

            // `sender_id` field referenced the `id` field of `users` table:
            $table->foreign('sender_id')
                ->references('id')
                ->on('users') ->onDelete('cascade');

            // Let's add another foreign key on the same table,
            // but this time fot the `sent_to_id` field:
            $table->foreign('sent_to_id')
                ->references('id')
                ->on('users') ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
