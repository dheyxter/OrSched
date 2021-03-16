<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'hospital.dbo.user_acc';
    protected $primaryKey ='employeeid';
    public $incrementing = false;
    public $timestamps = false ;

    public $fillable = [
        'employeeid',
        'user_name',
        'user_level',
        'user_pass',
        'user_exp'

    ];

    public static function storeDefault(Request $request)
    {

        $userName = $request->user_name;

        if (empty($userName)) {
            $userName = 'autho_' . $request->employeeid;
        }

        $userName = substr($userName, 0, 14);

        $userLevel = $request->user_level;
        if (empty($userLevel)) $userLevel = 0;

        $userPass = $request->user_pass;
        if (empty($userPass)) $userPass = 0;

        return User::updateOrCreate(
            ['employeeid' => $request->employeeid],
            [
                'employeeid' => $request->employeeid,
                'user_name' => $userName,
                'user_level' => $userLevel,
                'user_pass' => $userPass,
                'user_exp' => '2050-12-31 00:00:00.000'
            ]
        );

    }
    protected $hidden = [
        'user_pass',
    ];
}
