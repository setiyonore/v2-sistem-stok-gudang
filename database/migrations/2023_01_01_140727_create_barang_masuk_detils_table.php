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
        Schema::create('barang_masuk_detil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_masuk_id');
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('jumlah');
            $table->foreign('barang_id')->references('id')->on('barang');
            $table->foreign('barang_masuk_id')->references('id')->on('barang_masuk');
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
        Schema::dropIfExists('barang_masuk_detils');
    }
};
