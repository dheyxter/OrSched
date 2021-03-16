<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransLog extends Model
{
    protected $table = 'jhay.orsched_actlog';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
