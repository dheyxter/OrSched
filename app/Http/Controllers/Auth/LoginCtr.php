<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\CheckCtr;
use Illuminate\Support\Facades\Auth;
use DB;

class LoginCtr extends Controller
{
    // use CheckCtr;

    public function index()
    {
        return view('welcome');
    }

    public static function authHomisAccount(Request $request)
    {
        $username = $request->user_name;
        $password = $request->user_pass;

        return  DB::select("
                select top 1 * from hospital.dbo.user_acc
                where  user_name = '$username'
                and user_pass = webapp.dbo.ufn_crypto('$password',1)
            ");
    }

    public function login(Request $request)
    {
        $data = $this->authHomisAccount($request);
       
        if (count ($data) < 1)
        {
            // return 'something went wrong';
            return redirect()
              ->back()
              ->withErrors(['wrong' => 'Invalid username or password'])
              ->withInput()
              ->with('wrong', 'Invalid username or password' );
        }

        Auth::loginUsingId($data[0]->employeeid);
        return redirect('/');
    }

    public function logout() {

        Auth::logout();
        return redirect('/');
    
      }
}
