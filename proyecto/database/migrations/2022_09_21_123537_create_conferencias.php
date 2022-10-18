<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConferencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conferencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            $table->string('cargo',50);
            $table->integer('id_dir');
            $table->integer('id_sub')->nullable();
            $table->integer('id_dep')->nullable();
            $table->string('celular')->nullable();
            $table->string('nombre');
            $table->string('programa');
            $table->string('tipo',30);
            $table->string('feini',50);
            $table->string('fefin',50);
            $table->string('sede',100);
            $table->string('emision',100);
            $table->string('receptores');
            $table->integer('participantes');
            $table->integer('grabar');
            $table->string('comentarios');
            $table->integer('estado')->default(1); // 1. En curso | 2. Finalizada
            $table->string('link')->nullable();
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
        Schema::dropIfExists('conferencias');
    }
}
