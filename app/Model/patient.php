<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
    protected $table = 'jhay.orsched_patients';
    protected $primaryKey ='id';
    public $timestamps = false ;

    protected $fillable = [
        'enccode', 'hpercode', 'patlast', 'patfirst','patmiddle', 'patage', 'patsex', 'patward', 'adm_date', 'adm_time', 'entry_by'
    ];

    public function reservation() {
        return $this->hasMany('App\Model\Reservation','id');
    }
}
