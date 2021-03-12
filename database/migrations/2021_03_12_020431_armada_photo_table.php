<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArmadaPhotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('armada_photo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("armada_id");
            $table->foreign("armada_id")->references("id")->on("armadas")->onDelete("cascade");
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
        Schema::dropIfExists('armada_photo');
    }
}
