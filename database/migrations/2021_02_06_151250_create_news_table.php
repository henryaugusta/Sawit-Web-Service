<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("pict_url")->nullable();
            $table->text("content");
            $table->text("link")->nullable();
            $table->unsignedBigInteger("posted_by");
            $table->foreign('posted_by')->references('id')
                ->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('access_type')->nullable();
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
        Schema::dropIfExists('news');
    }
}
