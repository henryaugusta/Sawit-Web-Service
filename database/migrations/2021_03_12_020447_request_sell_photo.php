<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RequestSellPhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_sell_photo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("request_sell_id");
            $table->foreign("request_sell_id")->references("id")->on("request_sell")->onDelete("cascade");
            $table->string("path");
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
        Schema::dropIfExists('request_sell_photo');
    }
}
