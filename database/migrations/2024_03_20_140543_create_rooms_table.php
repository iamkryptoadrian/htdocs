<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_type');
            $table->integer('beds');
            $table->integer('max_adults')->nullable();
            $table->integer('max_children')->nullable();
            $table->integer('max_guest');
            $table->integer('room_quantity');
            $table->decimal('empty_bed_charge', 8, 2)->default(0.00);
            $table->text('room_description')->nullable();
            $table->string('room_img')->nullable();
            $table->json('room_gallery')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {

    }
}
