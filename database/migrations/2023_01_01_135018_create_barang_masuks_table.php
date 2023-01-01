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
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('yang_menyerahkan');
            $table->unsignedBigInteger('pegawai_id');
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('penyedia_id');
            $table->foreign('pegawai_id')->references('id')->on('pegawai');
            $table->foreign('penyedia_id')->references('id')->on('perusahaan');
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
        Schema::dropIfExists('barang_masuks');
    }
};
