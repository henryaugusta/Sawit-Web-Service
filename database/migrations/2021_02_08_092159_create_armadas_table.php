<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArmadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('armadas', function (Blueprint $table) {
            $table->id();
            $table->string('merk_mobil')->nullable();
            $table->string('nopol')->unique()->nullable();
            $table->string('no-mesin')->unique()->nullable();
            $table->float('max-cap',18,4)->nullable();
            $table->float('max-weight',18,4)->nullable();
            $table->string('photo_1')->nullable();
            $table->string('photo_2')->nullable();
            $table->string('photo_3')->nullable();
            $table->string('photo_4')->nullable();
            $table->string('photo_5')->nullable();
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
        Schema::dropIfExists('armadas');
    }
}
