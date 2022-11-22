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

        return  DB::select("
          Select top 1 * from hospital.dbo.user_acc
          where  user_name = '$username'
          and user_pass = webapp.dbo.ufn_crypto('$password',1)
        ");
       

    }

    public static function authCDOEAccount(Request $request)
    {
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

    public function login_api(Request $request)
    {
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
}
