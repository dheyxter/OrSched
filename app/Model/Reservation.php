<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'jhay.orsched_reservations';
    protected $primaryKey ='id';
    public $timestamps = false ;

    protected $fillable = [
       'anes','patient_id', 'room_id', 'entry_by', 'reservation_status', 'created_at'
    ];
}
