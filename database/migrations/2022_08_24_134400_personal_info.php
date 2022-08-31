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
        Schema::create('personal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('alcohol')->default('Brak danych');
            $table->text('drugs')->default('Brak danych');
            $table->text('kids')->default('Brak danych');
            $table->text('smokes')->default('Brak danych');
            $table->text('job')->default('Brak danych');
            $table->text('hobby')->default('Brak danych');
            // It's better to work with default timestamp names:
            $table->timestamps();

            // `sender_id` field referenced the `id` field of `users` table:
            $table->foreign('user_id')
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
        //
    }
};
