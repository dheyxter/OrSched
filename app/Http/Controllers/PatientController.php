<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Reservation;
use App\Model\patient;
use App\Model\toAccept;
use App\Model\Translog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class PatientController extends Controller
{
    public function index()
    {
        $patients = patient::with('reservation')->get();
        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '".Auth::user()->employeeid."'");
        return view('Patients.index', compact(
            'hpersonal',
            'patients'
        ));
    }

    public function mypatients(Request $r) {
        // dd($r->all());
        $employee = Auth::user()->employeeid;
    
        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '".Auth::user()->employeeid."'");
        $getid = DB::SELECT("SELECT TOP 1 * FROM jhay.orsched_user WHERE employeeid = '$employee'");
        $user_role = $getid[0]->user_role;

        if($user_role == 1 || $user_role == 4) {
            $patients = DB::SELECT("SELECT * from jhay.orsched_patients as a with (nolock)
                LEFT JOIN jhay.orsched_reservations as b with (nolock) ON a.id = b.patient_id
                LEFT JOIN dbo.hpersonal as c with (nolock) ON a.entry_by = c.employeeid
                LEFT JOIN jhay.orsched_schedule as d with (nolock) ON a.id = d.patient_id
                where a.entry_by = '$employee'
                AND year(a.created_at) = year(getdate())
                order by a.created_at desc
            ");

            // $patients = patient::with('reservation')
            // ->join('hospital.dbo.hpersonal', 'jhay.orsched_patients.entry_by', '=', 'dbo.hpersonal.employeeid')
            // ->leftJoin('hospital.jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
            // ->whereYear('jhay.orsched_patients.created_at', Carbon::now())
            // ->orderBy('jhay.orsched_patients.created_at', 'DESC')
            // ->get();
        } 

        else {
            $patients = DB::TABLE('jhay.orsched_patients as a')
            ->leftJoin('jhay.orsched_reservations as b', 'a.id', '=', 'b.patient_id')
            ->leftJoin('jhay.orsched_schedule as c', 'a.id', '=', 'c.patient_id')
            ->where('a.entry_by', $employee)
            ->whereYear('a.created_at', now())
            ->orderBy('a.created_at', 'DESC')
            ->get();
        }


        // $patID = $r->patient_id;
  
        // $histo = DB::SELECT("SELECT a.id, a.act_details, a.patient_id, a.created_at, b.lastname,b.firstname, b.middlename from jhay.orsched_actlog a INNER JOIN dbo.hpersonal b
        //     ON a.employeeid = b.employeeid ORDER BY created_at DESC");

        // $count = $patients ->count();
    

        return view('Patients.mypatients', compact(
            'hpersonal',
            'patients',
            // 'count',
            // 'histo',
            'user_role'
        )); 
    }

    public function histoPat(Request $r)
    {
        $patID = $r->patient_id;
        // dd($patID);
        $histo = DB::SELECT("SELECT a.id, a.act_details, a.patient_id, a.created_at, b.lastname,b.firstname, b.middlename from jhay.orsched_actlog a INNER JOIN dbo.hpersonal b
            ON a.employeeid = b.employeeid WHERE a.patient_id = $patID ORDER BY created_at DESC");
        dd($histo);
        return redirect('/mypatients');
    }

    public function addpatient(Request $request)
    {
        $patlast     =  $request->patlast;
        $patfirst    =  $request->patfirst;
        $patmiddle   =  $request->patmiddle;
        $patsex      =  $request->patsex;
        $patconnum   =  $request->patconnum;
        $patbirth    =  $request->patbirth;
        $employeeid = Auth::user()->employeeid;
        $created_at = Carbon::now();

        DB::table('hospital.jhay.orsched_patients')
        ->insert([
            'patlast' => $patlast,
            'patfirst' => $patfirst,
            'patmiddle' => $patmiddle,
            'patsex' => $patsex,
            'patconnum' => $patconnum,
            'patbirth' => $patbirth,
            'entry_by' => $employeeid,
            'created_at' => $created_at
        ]);
        
        DB::table('hospital.jhay.orsched_actlog')
        ->insert([
            'act_details' => 'Add New Patient',
            'employeeid' => $employeeid
        ]);
        return redirect()->route('mypatients');
    }

    public function patdetails(request $request)
    {
        // $patientdetails = patient::where('id', $request->patient_id)->with('reservation')->first();
        $patientdetails = toAccept::where('id', $request->patient_id)->with('reservation')
        ->join('hospital.dbo.hpersonal', 'jhay.vw_toAccept.entry_by', '=', 'dbo.hpersonal.employeeid')
        ->first();
        return response()->json($patientdetails);
    }

    public function JS_GenPatientList(request $request)
    {
        $hos_num = $request->hospnumber;
        $patlast = $request->patlast;
        $patfirst = $request->patfirst;
        $patmiddle = $request->patmiddle;


        // $patlist = DB::SELECT("SELECT hp.hpercode, hp.patlast, hp.patfirst, hp.patmiddle, hp.patbdate, hp.patbplace, hp.patsex, enccode = (SELECT top 1 enccode FROM henctr hc where hpercode = hp.hpercode ORDER BY hc.encdate DESC)
        // FROM [hospital].[dbo].[hperson] AS hp 
        // WHERE hpercode = '000000000708614'");
        $patlist = DB::SELECT("select * from jhay.fnPatSearch('%$request->hospnumber%', '%$request->patlast%', '%$request->patfirst%', '%$request->patmiddle%')");
        // $patlist = DB::SELECT()
        return response()->json($patlist);
    }

    public function JS_GenEncounterList(request $request)
    {
        $enctrs = DB::SELECT("SELECT * from dex.AllPatEncounters('$request->hpercode') order by admdate desc");
          return response()->json($enctrs);
    }

    public function patientdetails(request $request)
    {
        $hpercode = $request->hpercode;
        // dd($hpercode);
        $employeeid = Auth::user()->employeeid;
        $patients = DB::SELECT("SELECT * FROM hospital.jhay.orsched_patients");
        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '".Auth::user()->employeeid."'");
        $getPat = DB::UPDATE("EXEC jhay.getPatients '$request->enccode',  '$request->hpercode', '".Auth::user()->employeeid."'");

        DB::table('hospital.jhay.orsched_actlog')
        ->insert([
            'act_details' => 'Add New Patient',
            'employeeid' => $employeeid,
            'patient_id' => $hpercode
        ]);

        return redirect('/mypatients');

        
    }
}
