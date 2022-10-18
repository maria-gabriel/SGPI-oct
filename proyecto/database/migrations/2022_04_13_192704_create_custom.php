<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom', function (Blueprint $table) {
            $table->id();
            $table->string('custom', 30)->nullable();
            $table->string('customfade', 30)->nullable();
            $table->string('customcolor', 30)->nullable();
            $table->string('custombackground', 30)->nullable();
            $table->string('custommode', 30)->nullable();
            $table->string('custommenu', 30)->nullable();
            $table->string('customother', 30)->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('custom');
    }
}
