<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';

     public function produk()
    {
    	return $this->hasMany('App/Produk', 'id_supplier');
    }
}
