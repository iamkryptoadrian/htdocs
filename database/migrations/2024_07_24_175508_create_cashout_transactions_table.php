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
        Schema::create('cashout_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trx_id', 50)->unique();
            $table->string('agent_code');
            $table->string('cashout_method');
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->text('rejection_reason')->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashout_transactions');
    }
};
