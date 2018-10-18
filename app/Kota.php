<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    //
    protected $table = 'kota';
    protected $primaryKey = 'id_kota';

    public function provinsi()
    {
    	return $this->belongsTo('App\Provinsi');
    }
}
