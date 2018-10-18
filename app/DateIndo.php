<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DateIndo extends Model
{
    public static function convertdate(){
        date_default_timezone_set('Asia/Jakarta');
        $date = date('dmy');
        return $date;
    }
}
