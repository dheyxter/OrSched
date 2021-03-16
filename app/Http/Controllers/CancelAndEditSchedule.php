<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use \Carbon\Carbon;
use Auth;

class CancelAndEditSchedule extends Controller
{
    
    public function cancelSChedule(Request $r){

        $id = $r->id;
        $hpercode = $r->patient_id;
        // dd($hpercode);
        DB::table('jhay.orsched_patients')
        ->where('id', $id)
        ->update([
            'scheduled' => NULL
        ]);
        
        DB::table('jhay.orsched_reservations')
        ->where('patient_id', $id)
        ->delete();

        DB::table('jhay.orsched_schedule')
        ->where('patient_id', $id)
        ->delete();

        DB::table('jhay.orsched_actlog')
        ->insert([
            'act_details' => 'Cancelled Schedule',
            'employeeid' => Auth::user()->employeeid,
            'patient_id' =>$hpercode,
        ]);

        return 'okay';

    }

    public function defer(Request $r){

        $id = $r->id;
        $hpercode = $r->patient_id;
        // dd($hpercode);
        DB::table('jhay.orsched_reservations')
        ->where('patient_id', $id)
        ->update([
            'defer' => '1'
        ]);
        
        DB::table('jhay.orsched_actlog')
        ->insert([
            'act_details' => 'Deferred Schedule',
            'employeeid' => Auth::user()->employeeid,
            'patient_id' =>$hpercode,
        ]);

        return 'okay';

    }

    public function undo_defer(Request $r){

        $id = $r->id;
        $hpercode = $r->patient_id;
        // dd($hpercode);
        DB::table('jhay.orsched_reservations')
        ->where('patient_id', $id)
        ->update([
            'defer' => NULL
        ]);
        
        DB::table('jhay.orsched_actlog')
        ->insert([
            'act_details' => 'Undo Deferred Schedule',
            'employeeid' => Auth::user()->employeeid,
            'patient_id' =>$hpercode,
        ]);

        return 'okay';

    }

    public function EditSchedule(Request $request){
        $id = $request->pat_id;
        $newTime = $request->newtime;
        $newOut = $request->newtimeout;

        //GET THE CURRENT DATE
        $currentDateTime = DB::table('jhay.orsched_reservations')
        ->where('patient_id', $id)
        ->get();

        //ATTACH THE DATE TO THE NEW TIME
        $newFrom = Carbon::parse($currentDateTime[0]->date_from)->format('Y-m-d').' '.$newTime;
        $newTo = Carbon::parse($currentDateTime[0]->date_to)->format('Y-m-d').' '.$newOut;
        
        //INSERT THE NEW FORMULA TO THIS
        $newTime = DB::table('jhay.orsched_reservations')
        ->where('patient_id', $id)
        ->update([
            'date_from' => $newFrom,
            'date_to' => $newTo
        ]);

        //ALTER THE END TIME
        $newLatestTime =  $newOut.':00.0000000';
        $newLatestInsert = DB::table('jhay.orsched_schedule')
        ->where('patient_id', $id)
        ->update([
            'latest_sched' => $newLatestTime
        ]);
        
        if($newTime && $newLatestInsert ){
            DB::table('jhay.orsched_actlog')
            ->insert([
                'act_details' => 'Edit time of patient ID: '.$id,
                'employeeid' => Auth::user()->user_name.' | '.Auth::user()->employeeid
            ]);

            return redirect()->route('myschedules');
        }
        else{
            return 'Something went wrong';
        }
    }
}
