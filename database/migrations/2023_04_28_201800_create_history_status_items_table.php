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
        Schema::create('history_status_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->date('tanggal');
            $table->unsignedBigInteger('referensi_status_item');
            $table->unsignedBigInteger('referensi_jenis_transaksi');
            $table->foreign('referensi_status_item')->references('id')->on('referensi');
            $table->foreign('referensi_jenis_transaksi')->references('id')->on('referensi');
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
        Schema::dropIfExists('history_status_items');
    }
};
