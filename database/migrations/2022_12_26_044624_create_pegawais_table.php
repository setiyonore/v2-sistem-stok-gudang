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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referensi_jabatan');
            $table->string('nama');
            $table->date('tgl_lahir');
            $table->string('nip')->nullable();
            $table->string('no_hp', 100);
            $table->string('alamat', 500);
            $table->foreign('referensi_jabatan')->references('id')->on('referensi');
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
        Schema::dropIfExists('pegawais');
    }
};
