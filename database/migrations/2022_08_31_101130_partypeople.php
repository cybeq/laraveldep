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
        Schema::create('partypeople', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('party_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('okay')->default(0);
            $table->timestamps();

            $table->foreign('party_id')
                ->references('id')
                ->on('party') ->onDelete('cascade');

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
