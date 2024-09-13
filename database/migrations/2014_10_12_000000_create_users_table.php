<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('id_number')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('profile_image')->nullable()->default('default.jpg');
            $table->string('number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->integer('family_members_count')->default(0);
            $table->string('street_address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('activation_date')->nullable();
            $table->rememberToken();
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
        // Drop users table
        Schema::dropIfExists('users');
    }
};
