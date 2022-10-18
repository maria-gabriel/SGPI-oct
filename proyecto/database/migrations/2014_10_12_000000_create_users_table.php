<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username',100)->unique();
            $table->string('password');
            $table->string('nombre',100);
            $table->string('apepa',100);
            $table->string('apema',100);
            $table->BigInteger('area')->nullable();
            $table->BigInteger('id_dir')->nullable();
            $table->integer('sexo')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email',100)->nullable();
            $table->integer('iactivo')->default(1);
            $table->integer('tipo_usuario')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
