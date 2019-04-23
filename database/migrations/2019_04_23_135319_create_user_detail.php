<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('gender', 10);
            $table->date('date_birth');
            $table->string('no_hp', 13);
            $table->string('no_wa', 13);
            $table->string('about', 150);
            $table->string('provinsi', 150);
            $table->string('kab_kota', 150);
            $table->string('kecamatan', 150);
            $table->string('desa', 150);
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
        Schema::dropIfExists('user_detail');
    }
}
