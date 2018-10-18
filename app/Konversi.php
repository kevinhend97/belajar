<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Konversi extends Model
{
    protected $table = 'konversi';
    protected $primaryKey = 'id_konversi';

    public function satuan()
    {
    	return $this->belongsTo('App\Satuan');
    }
}
