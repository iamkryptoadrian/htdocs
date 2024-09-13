<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_guest_id')->nullable();
            $table->string('main_guest_first_name')->nullable();
            $table->string('main_guest_last_name')->nullable();
            $table->string('main_guest_email')->nullable();
            $table->string('main_guest_phone_number')->nullable();
            $table->string('booking_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('package_id');
            $table->string('package_name');
            $table->json('rooms_details');
            $table->json('room_guest_details');
            $table->integer('no_of_rooms');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->decimal('package_charges', 10, 2);
            $table->decimal('additional_services_total', 10, 2);
            $table->decimal('marine_fee', 10, 2);
            $table->decimal('total_surcharge_amount', 10, 2);
            $table->decimal('sub_total', 10, 2);
            $table->decimal('service_charge', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('net_total', 10, 2);
            $table->json('included_services');
            $table->json('additional_services');
            $table->json('activity_assignment')->nullable();
            $table->json('selected_family_members');
            $table->enum('booking_status', ['Pending For Payment', 'confirmed', 'cancelled', 'completed', 'Active'])->default('Pending For Payment');
            $table->enum('payment_status', ['Paid', 'Pending', 'Failed'])->default('Pending');
            $table->string('transaction_id')->nullable();
            $table->string('stripe_session_id')->nullable();
            $table->string('coupon_code')->nullable();
            $table->decimal('discount_amt', 10, 2)->default(0.00);
            $table->string('agent_code')->nullable();
            $table->decimal('agent_commission', 10, 2)->default(0.00);
            $table->boolean('email_sent')->default(false);
            $table->enum('arrival_method', ['by_boat','charter_boat','self_arrangement','not_selected'])->default('not_selected');
            $table->string('arrival_port_name')->nullable();
            $table->string('drop_off_port_name')->nullable();
            $table->time('arrival_time')->nullable();
            $table->time('departure_time')->nullable();
            $table->json('arrival_guest_list')->nullable();
            $table->json('departure_guest_list')->nullable();
            $table->integer('total_guest_arrival')->nullable();
            $table->integer('total_guest_departure')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
