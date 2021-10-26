<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('categories_id');
            $table->foreign('categories_id')->references('id')->on('categories');

            $table->unsignedBigInteger('nutrition_id');
            $table->foreign('nutrition_id')->references('id')->on('nutrition');

            $table->string('name', 20);
            $table->integer('stock');
            $table->double('price');
            $table->double('discount');
            $table->string('image');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
}