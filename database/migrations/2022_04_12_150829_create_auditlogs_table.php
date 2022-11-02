<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditlogs', function (Blueprint $table) {
            $table->id();
            $table->enum("action",["CREATE","EDIT","UPDATE","DELETE","LOGIN","LOGOUT"]);
            $table->unsignedBigInteger('user_id');
            $table->string('source');
            $table->json('object')->nullable();
            $table->timestamp('created_at');

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auditlogs');
    }
}
