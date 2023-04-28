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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referensi_satuan');
            $table->unsignedBigInteger('referensi_kategori');
            $table->string('nama');
            $table->string('stok')->nullable();
            //relationship referensi
            $table->foreign('referensi_satuan')->references('id')->on('referensi');
            $table->foreign('referensi_kategori')->references('id')->on('referensi');
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
        Schema::dropIfExists('barangs');
    }
};
