<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealMealitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_mealitems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->nullable()->constrained('meals')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('meal_item_id')->nullable()->constrained('meal_items')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->boolean('is_main')->default(false);
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
        Schema::dropIfExists('meal_mealitems');
    }
}
