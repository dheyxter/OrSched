<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\CheckCtr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Model\toAccept;
use Carbon;

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

        return  DB::select("SELECT top 1 * from hospital.dbo.user_acc
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

      public function display() {
        $today = Carbon\Carbon::now();
        $pat_scheduled = DB::SELECT("SELECT * from jhay.vw_toAccept WHERE cast(created_at as date)  = cast(getdate() as date) AND accept is not null AND type = 1 ORDER BY created_at desc");
         $patients = toAccept::with('reservation')
        ->join('hospital.dbo.hpersonal', 'jhay.vw_toAccept.entry_by', '=', 'dbo.hpersonal.employeeid')
        ->whereYear('jhay.vw_toAccept.created_at', '=', $today)
        ->where('accept', NULL)
        ->where('type', 1)
        ->whereNull('cancel_remarks_by')
        ->orderBy('type', 'DESC')
        ->get();


        return view('admin.display', compact(
            'pat_scheduled',
            'patients'
        ));
    }
}
