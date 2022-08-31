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
        Schema::create('partygallery', function(Blueprint $table){
            $table->id();
            $table->string('url');
            $table->unsignedBigInteger('party_id');
            $table->timestamp('date')->nullable();

            $table->foreign('party_id')
                ->references('id')
                ->on('party') ->onDelete('cascade');


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
