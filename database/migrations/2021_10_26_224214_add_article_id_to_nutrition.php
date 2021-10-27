<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArticleIdToNutrition extends Migration
{
    public function up()
    {
        Schema::table('nutrition', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id')->nullable()->after('id'); //Unique es para el 1:1
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('nutrition', function (Blueprint $table) {
            $table->dropForeign(['article_id']);
            $table->dropColumn('article_id');
        });
    }
}
