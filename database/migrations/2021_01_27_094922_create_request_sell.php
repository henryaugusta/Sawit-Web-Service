<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestSell extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_sell', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->string('est_weight');
            $table->string('est_price');
            $table->string('est_margin');
            $table->string('address');
            $table->string('lat');
            $table->string('long');
            $table->string('contact');
            $table->string('status');
            $table->text('file_name')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('driver_id')
                ->references('id')->on('users')->onDelete('cascade');;
            $table->foreign('staff_id')
                ->references('id')->on('users')->onDelete('cascade');;
            $table->foreign('updated_by')
                ->references('id')->on('users')->onDelete('cascade');;
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
        Schema::dropIfExists('request_sell');
    }
}
