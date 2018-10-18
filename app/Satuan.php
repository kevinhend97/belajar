<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table = 'satuan';
	protected $primaryKey = 'id_satuan';

    public function konversi()
    {
    	return $this->hasMany('App\Konversi', 'id_satuan');
    }

    public function barang()
    {
    	return $this->hasMany('App\Barang', 'id_satuan');
    }
}
