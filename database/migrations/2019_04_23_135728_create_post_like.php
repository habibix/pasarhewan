<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostLike extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_like', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('post_id')->references('id')->on('post')->onDelete('cascade');
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
        Schema::dropIfExists('post_like');
    }
}
