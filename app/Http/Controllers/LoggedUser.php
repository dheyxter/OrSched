<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoggedUser extends Controller
{
    public static function getUser(){
//FULL NAME RETRIEVAL
        $username = Auth::user()->employeeid;
        $getname = DB::SELECT("EXEC jhay.sp_getEmployee '$username'");

        foreach($getname as $name){
            $fullname = $name->lastname.', '.$name->firstname.' '.$name->middlename;
        }    
        
        return $fullname;
//END OF FULL NAME RETRIEVAL
    }

    public static function getTitle(){
        //POSITION
                $username = Auth::user()->employeeid;
                $getTitle = DB::SELECT("EXEC jhay.sp_getEmployee '$username'");
        
                foreach($getTitle as $name){
                    $title = $name->postitle;
                }    
                return $title;
        //END OF POSITION
            }

    public static function user_role(){

        $employeeid = Auth::user()->employeeid;
        $getrole = DB::table('jhay.orsched_user')->where('employeeid', $employeeid)->get();
        if(count($getrole)>0){
            return $getrole[0]->user_role;
        }
        else{
            return 0;
        }
    }

    public static function userid(){

        $employeeid = Auth::user()->employeeid;
        return $employeeid;
    }
}
