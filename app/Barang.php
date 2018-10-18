<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';

    public function kategori()
    {
    	return $this->belongsTo('App\Kategori');
    }

    public function satuan()
    {
    	return $this->belongsTo('App\Satuan');
    }
}
