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
            $table->string('name');
            $table->foreignId('NRE');
            //$table->string('dni');
            $table->string('class');
            $table->string('email')->unique();
            $table->string('phone');
            $table->foreignId('userType');
            $table->string('password');
            $table->tinyInteger('banned');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('NRE')->references('id')->on('nres');
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
