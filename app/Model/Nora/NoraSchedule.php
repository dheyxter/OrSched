<?php

namespace App\Model\Nora;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NoraSchedule extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $incrementing = false;
    protected $table = 'nora.paul.nora_events';
    protected $fillable = [
        'title',
        'start',
        'end',
        'enccode',
        'patientNoraHpercode',
        'service_type',
        'patient_lastname' ,
		'patient_firstname',
		'patient_middlename',
        'patient_procedure',
        'induction_time' ,
        'referring_physician',
        'anesthesiologist',
        'duration_time',
        'patient_room',
        'svc_pvt',
        'patient_age',
        'patient_sex',
        'referral_received',
        
    ];
    protected $dates = ['deleted_at'];

}
