<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referensi_jenis_perusahaan');
            $table->string('nama');
            $table->string('alamat', 500)->nullable();
            $table->string('no_hp');
            $table->string('email');
            $table->string('pic')->nullable();
            $table->string('no_hp_pic')->nullable();
            $table->foreign('referensi_jenis_perusahaan')->references('id')->on('referensi');
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
        Schema::dropIfExists('perusahaans');
    }
};
