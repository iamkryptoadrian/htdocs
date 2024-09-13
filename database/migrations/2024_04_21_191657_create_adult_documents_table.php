<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('adult_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('booking_id');
            $table->string('id_document_path')->nullable();
            $table->string('license_document_path')->nullable();
            $table->string('other_document_path')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('family_members')->onDelete('cascade');
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('adult_documents');
    }
};
