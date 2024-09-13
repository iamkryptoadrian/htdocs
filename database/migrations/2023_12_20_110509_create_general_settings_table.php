<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('support_email')->nullable();
            $table->decimal('agent_commission', 5, 2)->default(0.00);
            $table->decimal('user_rewards', 5, 2)->default(0.00);
            $table->integer('envi_coin_price')->default(0);
            $table->integer('total_nights')->default(0)->nullable(false);
            $table->json('agent_withdraw_method')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('general_settings');
    }
}
