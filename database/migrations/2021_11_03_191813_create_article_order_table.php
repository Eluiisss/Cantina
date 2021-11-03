<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleOrderTable extends Migration
{
    public function up()
    {
        Schema::create('article_order', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->on('orders')->references('id');

            $table->unsignedBigInteger('article_id');
            $table->foreign('article_id')->on('articles')->references('id')->onDelete('cascade');

            $table->integer('quantity');
            $table->double('discount')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('article_order');
    }
}
