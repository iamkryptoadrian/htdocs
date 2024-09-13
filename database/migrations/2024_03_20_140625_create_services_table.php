<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->text('description');
            $table->decimal('price', 10, 2)->nullable(); // Make price nullable to allow free services
            $table->string('image_path')->nullable(); // Path to the service's image, nullable in case some services don't have images
            $table->boolean('allowed_selection')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
}


