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
        Schema::create('party', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->boolean('public');
            $table->integer('minage')->default(0);
            $table->integer('maxage')->default(200);
            $table->integer('maxcount')->default(100000);
            $table->string('image');
            $table->string('goal')->nullable();
            $table->string('place');
            $table->string('city');
            $table->string('region');
            $table->string('title');
            $table->string('why');
            $table->timestamp('start_time');


           $table->timestamps();

            $table->foreign('owner_id')
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
