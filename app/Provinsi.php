<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsi';
	protected $primaryKey = 'id';

    public function kota()
    {
    	return $this->hasMany('App\Kota', 'provinsi_id');
    }
}
