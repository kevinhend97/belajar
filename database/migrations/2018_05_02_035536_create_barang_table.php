<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id_barang');
            $table->string('kode_barang')->unique();
            $table->integer('id_kategori')->unsigned();
            $table->string('nama_barang');
            $table->string('merk');
            $table->integer('qty');
            $table->integer('batas_habis');
            $table->integer('wajib_beli');
            $table->integer('id_satuan')->unsigned();
            $table->bigInteger('harga_beli');
            $table->bigInteger('harga_jual');
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
        Schema::dropIfExists('barang');
    }
}
