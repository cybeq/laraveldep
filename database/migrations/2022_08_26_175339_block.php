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
        Schema::create('blocks', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('blocked_id');
            $table->unsignedBigInteger('blocked_by_id');
            $table->timestamp('date')->nullable();

            $table->foreign('blocked_id')
                ->references('id')
                ->on('users') ->onDelete('cascade');

            $table->foreign('blocked_by_id')
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
