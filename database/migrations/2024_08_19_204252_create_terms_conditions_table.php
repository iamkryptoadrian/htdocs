<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('terms_conditions', function (Blueprint $table) {
            $table->id();
            $table->text('content'); // This will store the terms and conditions content
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('terms_conditions');
    }
};
