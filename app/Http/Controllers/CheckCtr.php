<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

trait CheckCtr
{

    protected  function authAccount(Request $request)
        {
            $user_name = $request->user_name;
            $user_pass = $request->user_pass;

            $account = DB::select("select top 1 * from hospital.jhay.intranet_user where user_name = '$user_name'");
            
            if (Hash::check($user_pass, $account[0]->user_pass)) {
                return $account;
            }
            else   
                return null;
        }
    

    protected function authHomisAccount(Request $request)
    {
        $username = $request->user_name;
        $password = $request->user_pass;

        return  DB::select("
            select top 1 * from hospital.dbo.user_acc
            where  user_name = '$username'
            and user_pass = webapp.dbo.ufn_crypto('$password',1)
            ");
    }

    public function index()
    {
        return view('welcome');
    }
}
