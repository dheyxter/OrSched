<?php

namespace App\Model\Pain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PainSchedule extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $incrementing = false;
    protected $table = 'nora.paul.pain_events';
    protected $fillable = [
        'title',
        'start',
        'end',
        'enccode',
        'patientPainHpercode',        
        'patient_lastname' ,
		'patient_firstname',
		'patient_middlename',
        'patient_age',
        'patient_sex',
        'pain_diagnosis',
        'management' ,
        'disposition',
        'referringPhysician',
        'painCODROD'
        
    ];

    protected $dates = ['deleted_at'];
}
