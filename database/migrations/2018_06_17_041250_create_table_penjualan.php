<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->increments('id_penjualan');
            $table->enum('status', ['Kredit', 'Lunas']);
            $table->string('kode_penjualan', 20);
            $table->string('kode_pelanggan', 20);
            $table->integer('id_user')->unsigned();
            $table->integer('total_item')->unsigned();
            $table->integer('diskon')->unsigned();
            $table->bigInteger('total_harga')->unsigned();
            $table->bigInteger('bayar')->unsigned();
            $table->bigInteger('diterima')->unsigned();
            $table->bigInteger('piutang')->unsigned();
            $table->date('tgl_tempo')->nullable();
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
        Schema::dropIfExists('penjualan');
    }
}
