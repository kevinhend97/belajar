<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePelanggan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->increments('id_pelanggan');
            $table->string('kode_pelanggan');
            $table->string('nama', 100);
            $table->text('alamat');
            $table->string('telp',20);
            $table->integer('kota_id')->unsigned();
            $table->integer('provinsi_id')->unsigned();
            $table->timestamps();

            $table->foreign('provinsi_id')->references('id')->on('provinsi')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kota_id')->references('id_kota')->on('kota')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pelanggan');
    }
}
