<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',100)->nullable();;
            $table->integer('perfil')->default(4);  // 1. pro  | 2. admin
            $table->integer('disponible')->default(1); // 1. disponible | 2. ocupado
            $table->string('username', 30)->nullable();
            $table->unsignedBigInteger('id_user');
            $table->integer('confirmacion')->default('2');
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
        Schema::dropIfExists('admins');
    }
}
