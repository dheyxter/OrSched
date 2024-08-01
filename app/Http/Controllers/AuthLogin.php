<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Hash;
class AuthLogin extends Controller
{
    public static function auhtHomisAccount(Request $data) {

        $username = $data->username;
        $password = $data->password;

        return  DB::SELECT("SELECT * from hospital.dbo.user_acc INNER JOIN hospital.dbo.hpersonal on hospital.dbo.user_acc.employeeid = hospital.dbo.hpersonal.employeeid
        where hospital.dbo.hpersonal.empstat = 'A' and hospital.dbo.user_acc.user_name = '$username'
        and hospital.dbo.user_acc.user_pass = webapp.dbo.ufn_crypto('$password',1)
        ");
       

    }

    public static function authCDOEAccount(Request $request) {
         $username = $request->username;
        $password = $request->password;
        
        //do the moves
        $cdoe = DB::TABLE("webapp.dbo.user_account")->where(['username' => $username ])->first();

        if(!empty($cdoe)) {
            if(!Hash::check($password, $cdoe->password)) { return false; } 
            else { 
                return DB::select("SELECT TOP 1 * from webapp.dbo.user_account where username = '$username' "); }
        }

    }

    public function login_api(Request $request) {
        
        $username = $request->username;
        $password = $request->password;
        $authAccount = $request->account;

        // return $username;

        // check if it select cdoe else homis auth
        if($authAccount == 'cdoe')
        {
            $data = $this->authCDOEAccount($request);

            if ($data == false )  {
                return redirect()
                    ->back()
                    ->withErrors(['wrong' => 'Invalid username or password for CDOE'])
                    ->withInput()
                    ->with('wrong', 'Invalid username or password for CDOE' );
            }
            
            $emp = $data[0]->empid;   

            $check = DB::TABLE("hospital.jhay.orsched_user")
            ->where('employeeid', $emp)    
            ->first();
            

            if(empty($check)){
                DB::table('hospital.jhay.orsched_user')
                ->insert([
                    'employeeid' => $emp,
                    'user_role' => '4',
                    'system' => 'cdoe'
                ]);
            }
            else {
                $check2 = DB::TABLE("hospital.jhay.orsched_user")
                ->select('system')
                ->where('employeeid', $emp)  
                ->first();
                
                if(empty($check2->system)) {
                    DB::table('hospital.jhay.orsched_user')
                    ->where('employeeid', $emp)  
                    ->update([
                        'system' => 'cdoe'
                    ]); 
                }
            }
            Auth::loginUsingId($data[0]->empid);

            return redirect()->intended();
            
            try{
        
            } catch (Throwable $e) {
                return $e;

            }

        }
        else
        {
            $data =   $this->auhtHomisAccount($request);
            if (count ($data) < 1)  {
                return redirect()
                    ->back()
                    ->withErrors(['wrong' => 'Invalid username or password for HOMIS'])
                    ->withInput()
                    ->with('wrong', 'Invalid username or password for HOMIS' );
            }

            $emp = $data[0]->employeeid;

            $check = DB::TABLE("hospital.jhay.orsched_user")
            ->where('employeeid', $emp)    
            ->first();

            if(empty($check)){
                DB::table('hospital.jhay.orsched_user')
                ->insert([
                    'employeeid' => $emp,
                    'user_role' => '',
                    'system' => 'homis'
                ]);
            }
            else {
                $check3 = DB::TABLE("hospital.jhay.orsched_user")
                ->select('system')
                ->where('employeeid', $emp)  
                ->first();
                // dd($check3->system);
               
                if(empty($check3->system)) {
    
                    DB::table('hospital.jhay.orsched_user')
                    ->where('employeeid', $emp)  
                    ->update([
                        'system' => 'homis'
                    ]); 
                }
            }
            Auth::loginUsingId($data[0]->employeeid);

            return redirect()->intended();
            
            try{
        
            } catch (Throwable $e) {
                return $e;

            }
        }
    }

        // http://192.168.7.82:81/orsched_tunnel?empid=BALDEX&enctr=ADM1568842Jul302024175207

    public function tunnel(Request $r) {
        $empid = $r->empid;
        $enctr = $r->enctr;

   
    if(Auth::check()) {
        if( Auth::User()->employeeid ==  $empid){
            $this->get_enccode($enctr, $empid);
            return redirect()->route('mypatients');
        } else {
            $check = DB::TABLE('jhay.orsched_user')->where('employeeid', $empid)->first();
             $this->get_enccode($enctr, $empid);
           
            Auth::loginUsingId($check->employeeid);
            return redirect()->route('mypatients');
        }
    } else {
        $check = DB::TABLE('jhay.orsched_user')->where('employeeid', $empid)->first();
            if($check) {
                 $this->get_enccode($enctr, $empid);
                Auth::loginUsingId($check->employeeid);
            } else {
                $getuser = DB::TABLE('hospital.dbo.hpersonal')->where('employeeid', $empid)->where('empstat', 'A')->first();
                if($getuser) {
                    DB::TABLE('jhay.orsched_user')->insert([
                        'employeeid'    => $getuser->employeeid,
                        'user_role'     => 0,
                        'is_confirm'    => 1,
                        'created_at'    => now()
                    ]);
                    $this->get_enccode($enctr, $empid);
                    Auth::loginUsingId($check->employeeid);
                } else {
                    return response()->json(['error' => 'Unauthorized access'], 403);
                } 
            }
        return redirect()->route('mypatients');
    }
 }

    public function get_enccode($enctr, $empid) {
        // check first if encounter is existing
        $f_check  = DB::TABLE('jhay.orsched_patients')->where('enccode', $enctr)->first();
        // get hpercode
       
        // check if encounter was present and entered by current logged user
        $check  = DB::TABLE('jhay.orsched_patients')->where('enccode', $enctr)->where('entry_by')->first();

        // if checked was not valid, get the encounter based on the conditions
        if(!$check) {
            // $gethpercode = $f_check->hpercode;
            $gethpercode = DB::TABLE('dbo.hadmlog')->where('enccode', $enctr)->where('admstat', 'A')->first();
            $enctrs = DB::SELECT("SELECT TOP 1 * from dex.AllPatEncounters('$gethpercode->hpercode') where admstat = 'A' order by admdate desc");    
            $enccode    =  $enctrs[0]->enccode;
            $hpercode   =  $enctrs[0]->hpercode;
            $patlast    =  $enctrs[0]->patlast;
            $patfirst   =  $enctrs[0]->patfirst;
            $patmiddle  =  $enctrs[0]->patmiddle;
            $patage     =  $enctrs[0]->patage;
            $patsex     =  $enctrs[0]->patsex;
            $tscode     =  $enctrs[0]->tscode;
            $ward       =  $enctrs[0]->ward;
            $admdate    =  $enctrs[0]->admdate;
            $adm_time   =  $enctrs[0]->admdate;
          
            DB::TABLE('jhay.orsched_patients')
            ->insert([
                'enccode'   => $enccode,
                'hpercode'  => $hpercode,
                'patlast'   => $patlast,
                'patfirst'  => $patfirst,
                'patmiddle' => $patmiddle,
                'patage'    => $patage,
                'patsex'    => $patsex,
                'tscode'    => $tscode,
                'patward'   => $ward,
                'adm_date'  => $admdate,
                'adm_time'  => $admdate,
                'entry_by'  => $empid,
                'created_at' => now()
            ]);
        } else {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
    }
}
