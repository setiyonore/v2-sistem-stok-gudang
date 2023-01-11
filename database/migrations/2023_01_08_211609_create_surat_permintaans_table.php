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
        Schema::create('surat_permintaan', function (Blueprint $table) {
            $table->id();
            $table->string('no_sp');
            $table->date('tanggal');
            $table->unsignedBigInteger('referensi_status_sp');
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('pelanggan_id');
            $table->unsignedBigInteger('pegawai_id');
            $table->foreign('referensi_status_sp')->references('id')->on('referensi');
            $table->foreign('pelanggan_id')->references('id')->on('perusahaan');
            $table->foreign('pegawai_id')->references('id')->on('pegawai');
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
        Schema::dropIfExists('surat_permintaans');
    }
};
