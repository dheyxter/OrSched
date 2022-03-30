<?php

namespace App\Http\Controllers\pain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\LoggedUser;
use App\Model\patient;
use App\Model\Pain\painPatient;


class PainPatientsController extends Controller
{

    public function getAllPainPatients(Request $r)
    {
        $employee = Auth::user()->employeeid;
        
        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 1) {
        $patients = painPatient::with('reservation')
        ->join('hospital.dbo.hpersonal', 'nora.paul.pain_patients.entry_by', '=', 'dbo.hpersonal.employeeid')
        ->leftJoin('nora.paul.pain_schedule', 'nora.paul.pain_patients.id', '=', 'nora.paul.pain_schedule.patient_id')
        ->whereYear('created_at', Carbon::now())
        ->get();
        } 
        else {
        $patients = painPatient::with('reservation')
        ->where('entry_by', Auth::user()->employeeid)
        ->get();
        }

     

        // $patID = $r->patient_id;
  
        // $histo = DB::SELECT("SELECT a.id, a.act_details, a.patient_id, a.created_at, b.lastname,b.firstname, b.middlename from jhay.orsched_actlog a INNER JOIN dbo.hpersonal b
        //     ON a.employeeid = b.employeeid ORDER BY created_at DESC");

        // $count = $patients ->count();
        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '".Auth::user()->employeeid."'");
        return view('pain.patients.getAllPainPatients', compact(
            'hpersonal',
             'patients'
            // 'count',
            // 'histo'
        )); 
    }

    public function painPatdetails(request $request)
    {
        // $patientdetails = patient::where('id', $request->patient_id)->with('reservation')->first();
        $painPatientdetails = toAccept::where('id', $request->patient_id)->with('reservation')
        ->join('hospital.dbo.hpersonal', 'jhay.vw_toAccept.entry_by', '=', 'dbo.hpersonal.employeeid')
        ->first();
        return response()->json($painPatientdetails);
    }

    public function painPatientdetails(request $request)
    {        
       
        $hpercode = $request->hpercode;
        
        $employeeid = Auth::user()->employeeid;
        $patients = DB::SELECT("SELECT * FROM hospital.jhay.orsched_patients");
        
        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '".Auth::user()->employeeid."'");
        
        $getPat = DB::UPDATE("EXEC nora.paul.pain_getPatients '$request->enccode',  '$request->hpercode', '".Auth::user()->employeeid."'");
        
        DB::table('nora.paul.pain_actlog')
        ->insert([
            'act_details' => 'Add New Patient',
            'employeeid' => $employeeid,
            'patient_id' => $hpercode
            
        ]);

        return redirect('/painPatients');

        
    }

    

    public function pain_JS_GenPatientList(request $request)
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

    public function pain_JS_GenEncounterList(request $request)
    {
        $enctrs = DB::SELECT("SELECT * from dex.AllEncounters('$request->hpercode') order by admdate desc");
        return response()->json($enctrs);
    }
}
