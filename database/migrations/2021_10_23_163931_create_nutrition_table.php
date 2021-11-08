<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNutritionTable extends Migration
{
    public function up()
    {
        Schema::create('nutrition', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_veg')->nullable()->default(false);
            $table->boolean('is_allergy')->default(false);
            $table->double('calories')->nullable();
            $table->double('sodium')->nullable();
            $table->double('proteins')->nullable();
            $table->string('ingredients_description', 3000);
            $table->string('allergy_description', 3000)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nutrition');
    }
}
