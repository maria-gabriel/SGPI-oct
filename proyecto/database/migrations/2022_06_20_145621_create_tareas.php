<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->String('nombre',255);
            $table->longText('descripcion');
            $table->String('responsables',50)->nullable();
            $table->String('estado', 30);
            $table->date('inicio');
            $table->date('final');
            $table->unsignedBigInteger('id_proyecto')->nullable();
            $table->foreign('id_proyecto')->references('id')->on('proyectos')->onDelete('cascade');
            $table->unsignedBigInteger('id_user');
            $table->BigInteger('area')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->integer('iactivo')->default('1');
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
        Schema::dropIfExists('tareas');
    }
}
