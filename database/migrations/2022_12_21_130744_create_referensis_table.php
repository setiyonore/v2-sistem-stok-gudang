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
        Schema::create('referensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_referensi_id');
            $table->string('nama');
            $table->string('deskripsi')->nullable();
            //relationship jenis referensi
            $table->foreign('jenis_referensi_id')->references('id')->on('jenis_referensi');
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
        Schema::dropIfExists('referensis');
    }
};
