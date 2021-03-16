<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;


class UserController extends Controller
{
    public function index() {
        $user = DB::SELECT("EXEC jhay.sp_getEmp");
    
        return view('admin.user', compact(
            'user'
        ));
    }

    public function empdetails(request $request)
    {   
        $user = DB::SELECT("EXEC jhay.sp_getEmp");
        $employeedetails = DB::SELECT("EXEC jhay.sp_getEmpRole '$request->employeeid'");
        return view('admin.user', compact(
            'employeedetails',
            'user'
        ));
    }

    public function changeRole(Request $r)
    {   
        $empid = $r->empid;
        $role = $r->role;

        DB::UPDATE("UPDATE jhay.orsched_user set user_role=$role where employeeid = '$empid'");
        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '".Auth::user()->employeeid."'");

        return redirect('/User');
    }

    public function change(Request $r)
    {
        $role = $r->user_role;
        $get_user = DB::table('jhay.orsched_user')
        ->where([
            'user_role' => $role
        ])
        ->orderby('id', 'DESC')
        ->get();
    }
}
