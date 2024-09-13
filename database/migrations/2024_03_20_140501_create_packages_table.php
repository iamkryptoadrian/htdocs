<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name');
            $table->json('duration'); // {"days": X, "nights": Y}
            $table->string('short_description');
            $table->text('long_description');
            $table->decimal('package_initial_price', 10, 2)->nullable();
            $table->string('main_image')->nullable(); // Path to the main featured image
            $table->json('other_images')->nullable(); // Paths to other images in a gallery as a JSON array
            $table->decimal('service_charge', 10, 2)->nullable();
            $table->decimal('tax', 10, 2)->nullable();
            $table->decimal('marine_charges', 8, 2)->default(0.00);
            $table->integer('beds')->nullable();
            $table->integer('max_adults')->nullable();
            $table->integer('max_children')->nullable();
            $table->decimal('adult_price', 10, 2)->nullable();
            $table->decimal('children_price', 10, 2)->nullable();
            $table->decimal('kids_price', 10, 2)->nullable();
            $table->unsignedInteger('adult_price_start')->nullable();
            $table->unsignedInteger('children_price_start')->nullable();
            $table->unsignedInteger('kids_price_start_at')->nullable();
            $table->json('rooms'); // JSON detailing room options and their prices
            $table->json('services'); // JSON detailing services included in the package
            $table->json('addon_services_available')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
