<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubtareas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtareas', function (Blueprint $table) {
            $table->id();
            $table->String('nombre',255);
            $table->longText('descripcion');
            $table->String('responsables',50)->nullable();
            $table->String('estado', 30);
            $table->date('inicio');
            $table->date('final');
            $table->BigInteger('id_user');
            $table->BigInteger('area')->nullable();
            $table->unsignedBigInteger('id_tarea');
            $table->foreign('id_tarea')->references('id')->on('tareas')->onDelete('cascade');
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
        Schema::dropIfExists('subtareas');
    }
}
