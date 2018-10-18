<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';

    public function produk()
    {
    	return $this->hasMany('App/Barang', 'id_kategori');
    }
}
