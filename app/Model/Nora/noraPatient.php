<?php

namespace App\Model\Nora;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class noraPatient extends Model
{
    use softDeletes;
    protected $table = 'nora.paul.nora_patients';
    protected $primaryKey ='id';
    public $timestamps = false ;

    protected $fillable = [
        'id','enccode', 'patientNoraHpercode', 'patlast', 'patfirst','patmiddle', 'patage', 'patsex', 'patward', 'adm_date', 'adm_time', 'entry_by'
    ];

    public function reservation() {
        return $this->hasMany('App\Model\Reservation','id');
    }
    protected $dates = ['deleted_at'];
}
