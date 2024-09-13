<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle');
            $table->string('main_image');
            $table->json('icon_textList');
            $table->text('description_1');
            $table->text('description_2');
            $table->json('gallery');
            $table->string('menu_sub_title');
            $table->string('menu_title');
            $table->json('menu_categories');
            $table->json('items_list');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
};
