<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class toAccept extends Model
{
    protected $table = 'jhay.vw_toAccept';
    protected $primaryKey ='id';
    public $timestamps = false ;


    public function reservation() {
        return $this->hasMany('App\Model\Reservation','id');
    }
}
