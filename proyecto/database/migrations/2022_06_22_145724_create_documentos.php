<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->String('nombre',255);
            $table->String('descripcion',255);
            $table->String('url',100);
            $table->String('url_edit',100);
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->String('nombre_doc');
            $table->unsignedBigInteger('cat_doc');
            $table->String('tipo',30);
            $table->String('extension',30);
            $table->foreign('cat_doc')->references('id')->on('cat_docs');
            $table->BigInteger('id_area')->nullable();
            $table->unsignedBigInteger('id_proyecto')->nullable();
            $table->foreign('id_proyecto')->references('id')->on('proyectos')->onDelete('cascade');
            $table->BigInteger('id_tarea')->nullable();
            $table->BigInteger('id_subtarea')->nullable();
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
        Schema::dropIfExists('documentos');
    }
}
