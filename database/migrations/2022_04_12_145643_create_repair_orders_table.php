<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_orders', function (Blueprint $table) {
            $table->id();
            $table->string('car_registration');
            $table->string('province');
            $table->string('image_path')->nullable();
            $table->string('color');
            $table->string('model');
            $table->string('vin');
            $table->double('current_distance')->nullable();
            $table->double('latest_distance')->nullable();

            $table->timestamp('car_received')->nullable();
            $table->timestamp('in_queued')->nullable();
            $table->timestamp('repairing')->nullable();
            $table->timestamp('last_check')->nullable();
            $table->timestamp('cleaning')->nullable();
            $table->timestamp('returning')->nullable();

            $table->double('cost')->default(0);

            $table->json('repair_list')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('branch_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('branch_id')->references('id')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repair_orders');
    }
}
