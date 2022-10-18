<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatAccesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_accesos', function (Blueprint $table) {
            $table->id();
                $table->string('perfiles',50);
                $table->string('ruta',100);
                $table->string('nombre',30);
                $table->tinyInteger('iactivo')->nullable(false)->default('1');
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
        Schema::dropIfExists('cat_accesos');
    }
}
