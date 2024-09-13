<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_settings', function (Blueprint $table) {
            $table->id();

            // Age Ranges and Discounts
            $table->string('adult_age')->default('13+');
            $table->decimal('adult_discount', 8, 2)->nullable();
            $table->string('children_age')->default('7-12');
            $table->decimal('children_discount', 8, 2)->nullable();
            $table->string('kids_age')->default('4-6');
            $table->decimal('kids_discount', 8, 2)->nullable();
            $table->string('Toddlers_age')->default('0-3');
            $table->decimal('Toddlers_discount', 8, 2)->nullable();

            // Boat Booking Settings
            $table->json('ports')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_settings');
    }
};
