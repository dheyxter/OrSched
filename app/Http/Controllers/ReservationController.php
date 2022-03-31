<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Model\Reservation;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function anesSched()
    {
        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '".Auth::user()->employeeid."'");
        $roomtoday = 1;
        $datetoday = Carbon::now()->format('Y-m-d');
        $elec = 0;
        $emer = 1;
        
        $scheds = DB::SELECT(
            "SELECT * FROM jhay.orsched_reservations AS re 
            INNER JOIN jhay.orsched_patients pa 
            ON re.patient_id = pa.id      
            where re.created_at  = getdate()
            ");
        
        $scheds = DB::SELECT( "SELECT * from jhay.vw_toAccept where date_of_sched = '$datetoday' AND accept = '1' AND cancel is null ORDER BY annex");   
        
        $pat = DB::SELECT("SELECT * FROM jhay.orsched_patients as a INNER JOIN hpersonal as b ON a.entry_by = b.employeeid");
        
        $schedcount = count($scheds);
        return view('Calendar.sched', compact(
            'hpersonal',
            'roomtoday',
            'datetoday',
            'schedcount',
            'scheds',
            'elec',
            'emer',
            'pat'
        ));
    }

    public function anesSched2(Request $r)
    {
        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '".Auth::user()->employeeid."'");
        $employeeid = $hpersonal[0]->employeeid;
        $datetoday = $r->selectdate;   
        if(LoggedUser::user_role() == 0) {
            $scheds = DB::SELECT( "SELECT * from jhay.vw_toAccept where date_of_sched = '$datetoday' AND accept = '1' AND entry_by = '$employeeid' AND cancel is null ORDER BY patlast" );     
        } else {
            $scheds = DB::SELECT( "SELECT * from jhay.vw_toAccept where date_of_sched = '$datetoday' AND accept = '1' AND cancel is null ORDER BY annex");   
        }
        
        $schedcount = count($scheds);
        // dd($schedcount, $scheds);
        return view('Calendar.sched', compact(
            'hpersonal',
            'datetoday',
            'schedcount',
            'scheds'
        ));
    }

    public function getAnesUpdate(Request $r)
    {
        $patient_id = $r->patID;
        $time_start = $r->time_start;
        $time_duration = $r->time_duration;
        $case_num = $r->case_num;
        $room = $r->room;
        $surgeon = $r->surgeons;
        $typeAnes = $r->typeAnes; 
        $anes = $r->anes; //none
        $procedure = $r->procedure;
        $instrument = $r->instrument;
        $employeeid = Auth::user()->employeeid;
        $updated_at = Carbon::now();
        // dd($r->all(), $anes);

        $updte = DB::table('jhay.orsched_reservations')
        ->where ('patient_id', $patient_id)
        ->update([
            'timeStart'     => $time_start,
            'timeDuration'  => $time_duration,
            'case_num'      => $case_num,
            'room_id'       => $room,
            'surgeon'       => $surgeon,
            'anes'          => $anes,
            'procedures'    => $procedure,
            'instru'        => $instrument,
            'updated_by'    => $employeeid,
            'updated_at'    => $updated_at   
        ]);

        if($updte) {
        DB::table('hospital.jhay.orsched_actlog')
        ->insert([
            'act_details' => 'Updated Patient Schedule by Anesthesiologist', 
            'employeeid' => $employeeid,
            'patient_id' => $patient_id
        ]);
            return 'success';
        } else {
            return 'failed';
        }

        // return redirect('/anesSched2');    
    }

    public function myschedules(request $request)
    {
        $timeStart = '07:00:00';
        $timeEnd = '16:00:00';
        $elec = 0;
        $emer = 1;
        $employee = Auth::user()->employeeid;
        $time = DB::SELECT("SELECT GETDATE() as datetoday");
        $datetoday = Carbon::now()->format('Y-m-d');
        $available_time = $this->time_available($request);
        $roomtoday = 1;

        $scheds = DB::SELECT(
            "SELECT * FROM jhay.orsched_reservations AS re 
            INNER JOIN jhay.orsched_patients pa 
            ON re.patient_id = pa.id      
            where re.created_at  = getdate()
            ");

        $count = DB::SELECT(
            "SELECT COUNT (re.id) as total
            FROM jhay.orsched_reservations AS re 
            INNER JOIN jhay.orsched_patients pa 
            ON re.patient_id = pa.id 
            WHERE room_id = '$roomtoday' and accept = '1'");

        $res = DB::SELECT("SELECT * FROM jhay.orsched_reservations");
        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 3) {
            $pat = DB::SELECT("SELECT * FROM jhay.orsched_patients as a INNER JOIN hpersonal as b ON a.entry_by = b.employeeid");
        }
        else {
            $pat = DB::SELECT("SELECT * FROM jhay.orsched_patients as a INNER JOIN hpersonal as b ON a.entry_by = b.employeeid WHERE a.entry_by = '$employee'");
        }

        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '$employee'");
        $schedcount = count($scheds);

        $trigger = $request->myTrigger;
        // return $getTrigger;
        if(!empty($trigger)){
            $getTrigger = $trigger;
        }else{
            $getTrigger = '';
        }
        
        return view('Calendar.myschedxx', compact(
            'hpersonal',
            'datetoday',
            'scheds',
            'roomtoday',
            'time',
            'pat',
            'schedcount',
            'available_time',
            'res',
            'count',
            'getTrigger',
            'timeStart',
            'timeEnd',
            'elec',
            'emer'
            
        ));
    }

    public function schedlist(request $request)
    {
        $timeStart = '07:00:00';
        $timeEnd = '16:00:00';
        $elec = 0;
        $emer = 1;
        $employee = Auth::user()->employeeid;
        $time = DB::SELECT("SELECT GETDATE() as datetoday");
        $datetoday = Carbon::now()->format('Y-m-d');
        $available_time = $this->time_available($request);
        $roomtoday = 1;

        $scheds = DB::SELECT(
            "SELECT * FROM jhay.orsched_reservations AS re 
            INNER JOIN jhay.orsched_patients pa 
            ON re.patient_id = pa.id      
            where re.created_at  = getdate()
            ");

        $count = DB::SELECT(
            "SELECT COUNT (re.id) as total
            FROM jhay.orsched_reservations AS re 
            INNER JOIN jhay.orsched_patients pa 
            ON re.patient_id = pa.id 
            WHERE room_id = '$roomtoday' and accept = '1'");

        $res = DB::SELECT("SELECT * FROM jhay.orsched_reservations");
        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 3) {
            $pat = DB::SELECT("SELECT * FROM jhay.orsched_patients as a INNER JOIN hpersonal as b ON a.entry_by = b.employeeid");
        }
        else {
            $pat = DB::SELECT("SELECT * FROM jhay.orsched_patients as a INNER JOIN hpersonal as b ON a.entry_by = b.employeeid WHERE a.entry_by = '$employee'");
        }

        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '$employee'");
        $schedcount = count($scheds);

        $trigger = $request->myTrigger;
        // return $getTrigger;
        if(!empty($trigger)){
            $getTrigger = $trigger;
        }else{
            $getTrigger = '';
        }
        
        return view('Calendar.schedlist', compact(
            'hpersonal',
            'datetoday',
            'scheds',
            'roomtoday',
            'time',
            'pat',
            'schedcount',
            'available_time',
            'res',
            'count',
            'getTrigger',
            'timeStart',
            'timeEnd',
            'elec',
            'emer'
            
        ));
    }

    public function schedlist_gen(request $request)
    {
        $timeStart = '07:59:59';
        $timeEnd = '16:00:00';
        $elec = 0;
        $emer = 1;
        $employee = Auth::user()->employeeid;
        $enteredBy = LoggedUser::getUser();
        $time = DB::SELECT("SELECT GETDATE() as datetoday");
        $datetoday = $request->selectdate;
        $roomtoday = $request->selectroom;
       if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2) {
        $scheds = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re 
        INNER JOIN jhay.orsched_patients pa ON re.patient_id = pa.id 
        INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id
        WHERE accept = 1 and cast(re.created_at as date) = '$datetoday'");
       }
       else
       {
        $scheds = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.patient_id = pa.id WHERE accept = 1 AND cast(re.created_at as date) = '$datetoday' AND re.entry_by = '$employee'");
       }
        $pat = DB::SELECT("SELECT * FROM jhay.orsched_patients as a INNER JOIN hpersonal as b ON a.entry_by = b.employeeid WHERE accept = 1 AND a.entry_by = '$employee'");
        $pat1 = DB::SELECT("SELECT * FROM jhay.orsched_patients as a INNER JOIN hpersonal as b ON a.entry_by = b.employeeid WHERE accept = 1");
        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '$employee'");
        
        $schedcount = count($scheds);
        $count = DB::SELECT(
            "SELECT COUNT (*) as total
            FROM jhay.orsched_reservations AS re 
            INNER JOIN jhay.orsched_patients pa 
            ON re.patient_id = pa.id 
            WHERE 
            year(re.created_at) = year(getdate()) and month(re.created_at) = month(getdate()) and day(re.created_at) = day(getdate()) AND
            room_id = '$roomtoday' and accept = '1'");

        $trigger = $request->myTrigger;
        // return $getTrigger;
        if(!empty($trigger)){
            $getTrigger = $trigger;
        }else{
            $getTrigger = '';
        }

        return view('Calendar.schedlist', compact(
            'hpersonal',
            'datetoday',
            'scheds',
            'roomtoday',
            'time',
            'pat',
            'pat1',
            'enteredBy',
            'schedcount',
            // 'available_time',
            'getTrigger',
            'count',
            'timeStart',
            'timeEnd',
            'elec',
            'emer'
        ));
    }

    public function addAnes(Request $r)
    {
        $ann_id = $r->patient_id;
        $patient_name = $r->patient_name;
        $anes = $r->anes;
        $hpercode = $r->hpercode;
        // dd($r->all());

        $update = Reservation::where('patient_id', '=', $ann_id) 
        ->update([
                'anes' => $anes
            ]);

            // dd($update);
        if($update){
            DB::table('jhay.orsched_actlog')
            ->insert([
                'act_details' => 'Anesthesiologist: Dr. '.$anes.'',
                'employeeid' => Auth::user()->employeeid,
                'patient_id' => $hpercode
            ]);
            return 'success';
        }
        else{
            return 'failed';
        }
    }

    public static function anestype()
    {
        return DB::SELECT("SELECT * FROM hospital.dcc.or_lib_anesthesia");
    }

    public static function doclist()
    {
        return DB::SELECT("SELECT hpersonal.employeeid, hpersonal.lastname, hpersonal.firstname, hpersonal.middlename, hprovider.empdegree, htypser.tsdesc, hprovider.licno from hpersonal 
        INNER JOIN hprovider 
        ON hpersonal.employeeid = hprovider.employeeid
        INNER JOIN htypser
        ON hpersonal.deptcode = htypser.tscode
        WHERE hprovider.empstat = 'A' AND htypser.tsdesc = 'SURGERY' OR htypser.tsdesc = 'ORTHOPEDICS' OR htypser.tsdesc = 'OPHTHALMOLOGY' OR htypser.tsdesc = 'OBSTETRICS' OR htypser.tsdesc = 'ENT-HNS'
        ORDER BY htypser.tsdesc");
    }

    public static function aneslist()
    {
        return DB::SELECT("SELECT hpersonal.employeeid, hpersonal.lastname, hpersonal.firstname, hpersonal.middlename, hprovider.empdegree, htypser.tsdesc, hprovider.licno from hpersonal 
        INNER JOIN hprovider 
        ON hpersonal.employeeid = hprovider.employeeid
        INNER JOIN htypser
        ON hpersonal.deptcode = htypser.tscode
        WHERE hprovider.empstat = 'A' AND htypser.tsdesc = 'Pain Clinic/Anesthesia'
        ORDER BY hpersonal.lastname");
    }

    public function selectdateroom(request $request)
    {
        $timeStart = '07:59:59';
        $timeEnd = '16:00:00';
        $elec = 0;
        $emer = 1;
        $employee = Auth::user()->employeeid;
        $enteredBy = LoggedUser::getUser();
        $time = DB::SELECT("SELECT GETDATE() as datetoday");
        $datetoday = $request->selectdate;
        $roomtoday = $request->selectroom;
       if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2) {
        // $scheds = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.patient_id = pa.id WHERE accept = 1 AND room_id = '$roomtoday' and cast(re.created_at as date) = cast(getdate() as date)");
        // $scheds = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.patient_id = pa.id WHERE accept = 1 AND room_id = '$roomtoday' and cast(re.created_at as date) = '$datetoday'");
        $scheds = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re 
        INNER JOIN jhay.orsched_patients pa ON re.patient_id = pa.id 
        INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id
        WHERE accept = 1 AND room_id = '$roomtoday' and cast(re.created_at as date) = '$datetoday'");
       }
       else
       {
        $scheds = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.patient_id = pa.id WHERE accept = 1 AND room_id = '$roomtoday' and re.entry_by = '$employee'");
       }
        $pat = DB::SELECT("SELECT * FROM jhay.orsched_patients as a INNER JOIN hpersonal as b ON a.entry_by = b.employeeid WHERE accept = 1 AND a.entry_by = '$employee'");
        $pat1 = DB::SELECT("SELECT * FROM jhay.orsched_patients as a INNER JOIN hpersonal as b ON a.entry_by = b.employeeid WHERE accept = 1");
        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '$employee'");
        
        $schedcount = count($scheds);
        // $available_time = $this->time_available($request);
        $count = DB::SELECT(
            "SELECT COUNT (*) as total
            FROM jhay.orsched_reservations AS re 
            INNER JOIN jhay.orsched_patients pa 
            ON re.patient_id = pa.id 
            WHERE 
            -- cast(date_from as date) = cast(getdate() as date) and 
            year(re.created_at) = year(getdate()) and month(re.created_at) = month(getdate()) and day(re.created_at) = day(getdate()) AND
            room_id = '$roomtoday' and accept = '1'");

        $trigger = $request->myTrigger;
        // return $getTrigger;
        if(!empty($trigger)){
            $getTrigger = $trigger;
        }else{
            $getTrigger = '';
        }

        return view('Calendar.myschedxx', compact(
            'hpersonal',
            'datetoday',
            'scheds',
            'roomtoday',
            'time',
            'pat',
            'pat1',
            'enteredBy',
            'schedcount',
            // 'available_time',
            'getTrigger',
            'count',
            'timeStart',
            'timeEnd',
            'elec',
            'emer'
        ));
    }

    // REMARKS
    public function remarks(Request $r){
        $patient_id = $r->patient_id;
        $patient_name = $r->patient_name;
        $remarks = $r->remarks;
        $hpercode = $r->hpercode;
        // dd($hpercode);
        $update = DB::table('jhay.orsched_reservations')
            ->where('patient_id' , $patient_id)
            ->update([
                'remarks' => $remarks
            ]);
        if($update){
            DB::table('jhay.orsched_actlog')
            ->insert([
                'act_details' => 'Remarks: '.$remarks.'',
                'employeeid' => Auth::user()->employeeid,
                'patient_id' => $hpercode
            ]);
            return 'success';
        }
        else{
            return 'failed';
        }
    }

    public function change_annex(Request $request){
        $annex = $request->annex;
        $date = $request->date;
        // dd($date);
        $get_schedule = DB::table('jhay.orsched_schedule')
        ->where([
            'date_of_sched' => Carbon::parse($date),
            'annex' => $annex
            ])
        ->orderby('id', 'DESC') 
        ->get();

        if(count($get_schedule) >= 0){
            // dd($get_schedule);
            // return Carbon::parse('08:00')->format('H:i');
            return count($get_schedule);
        }
        else{
            // $time = Carbon::parse($get_schedule[0]->latest_sched)->format('H:i');
            // $add_time = Carbon::parse($time)->addMinutes(30)->format('H:i');
            // return $add_time;
        }
    }

    //SCHEDULE TIME
    public function time_available(Request $request){

        if(!empty($request)){
            $get_schedule = DB::table('jhay.orsched_schedule')
            ->where('date_of_sched', Carbon::parse($request->selectdate))
            ->orderby('id', 'DESC')
            ->get();
            if(count($get_schedule)==0){
                return Carbon::parse('08:00')->format('H:i');
            }
            else{
                // $time = Carbon::parse($get_schedule[0]->latest_sched)->format('H:i');
                // $add_time = Carbon::parse($time)->addMinutes(30)->format('H:i');
                // return $add_time;
            }
        }
        else{
            $get_schedule = DB::table('jhay.orsched_schedule')
            ->where('date_of_sched', Carbon::now())
            ->orderby('id', 'DESC')
            ->get();

            if(count($get_schedule)==0){
                return Carbon::parse('08:00')->format('H:i');
            }
            else{
                // $time = Carbon::parse($get_schedule[0]->latest_sched)->format('H:i');
                // $add_time = Carbon::parse($time)->addMinutes(30)->format('H:i');
                // return $add_time;
            }
        }
    }

    public function addschedule(request $request)
    {
        // $t = $request->surgeon;
        // dd($t);
        // $timein = $request->date.' '.$request->time.':00.000';
        // $timeout = $request->date.' '.$request->timeout.':00.000';
        $patID = $request->patID;
        $type = $request->type;
        $room = $request->room;
        $patient = $request->patient;
        $patid = $request->patid;
        $emp = Auth::user()->employeeid;
        $surgeon = $request->surgeon;
        $caseNum = $request->caseNum;
        $timeStart = $request->timeStart;
        $timeDuration = $request->timeDuration;
        $typeAnes = $request->typeAnes;
        $instru = $request->instru;
        $procedures = $request->procedures;
        // $time1 = $request->time;
        // $time2 = $request->timeout;

        // $timex1 = Carbon::createFromFormat('H:i', $time1);
        // $timex2 = Carbon::createFromFormat('H:i', $time2);

        // $op_duration = $timex2->diffInMinutes($timex1);  

        // dd($request->all());

        DB::table('hospital.jhay.orsched_reservations')->insert([  
            'patient_id'=>$patid,
            'room_id'=>$room,
            'type'=>$type,
            'surgeon'=>$surgeon,
            'procedures'=>$procedures,
            'entry_by'=> $emp,
            'reservation_status'=> '1',
            'case_num' => $caseNum,
            'timeStart' => $timeStart,
            'timeDuration' => $timeDuration,
            'typeAnes' => $typeAnes,
            'instru' => $instru,
            'created_at'=>Carbon::now(),
        ]);

        DB::table('jhay.orsched_patients')
            ->where('id', $patid)
            ->update([
                'scheduled' => '1'
            ]);

        // DB::UPDATE("insert into jhay.orsched_reservations (date_from, date_to, patient_id, room_id, entry_by, reservation_status, created_at)
        // values ('$timein', '$timeout', '$request->patient', '$request->room', '".Auth::user()->employeeid."', '1', cast(getdate() as date))");

        DB::table('hospital.jhay.orsched_actlog')->insert([
            'act_details'=>'Add New Reservations',
            'employeeid'=>$emp,
            'patient_id'=>$patID
        ]);

        // DB::UPDATE("insert into jhay.orsched_actlog (act_details, employeeid)
        // values ('Add New Reservations', '".Auth::user()->employeeid."')");
        $time = DB::SELECT("SELECT GETDATE() as datetoday");
        $datetoday = $request->selectdate;
        $roomtoday = $request->selectroom;
        $pat = DB::SELECT("SELECT * FROM [jhay].[orsched_patients] where entry_by = '$emp'");
        $scheds = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.patient_id = pa.id WHERE room_id = '$roomtoday'");
        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '$emp'");

        $schedcount = count($scheds);

        $type = $request->type;
        $schedule_date =$request->date;
        $schedule_date =Carbon::parse($request->date);
        $schedule_annex = $request->room;
        $schedule_surgeon = $request->surgeon;
        // $schedule_patient = $request->patname;
        // $schedule_timeout = $request->timeout;
        // $schedule_timeout = Carbon::parse($request->timeout)->format('H:i');
        // dd($schedule_surgeon);
        DB::table('jhay.orsched_schedule')
        ->insert([
            'annex' => $schedule_annex,
            'type' =>$type,
            'date_of_sched' => $schedule_date,
            // 'latest_sched' => $schedule_timeout,
            'surgeons_name' => $schedule_surgeon,
            // 'scheduled_patient' => $schedule_patient,
            'patient_id' => $patid
        ]);

        return redirect()->route('myschedules');
    }


    public function emerSchedule(Request $request)
    {

        $patID = $request->patID;
        $type = $request->type;
        $room = $request->room;
        $patient = $request->patient;
        $patid = $request->patid;
        $emp = Auth::user()->employeeid;
        $surgeon = $request->surgeon;
        $caseNum = $request->caseNum;
        $timeStart = $request->timeStart;
        $timeDuration = $request->timeDuration;
        $typeAnes = $request->typeAnes;
        $instru = $request->instru;
        $procedures = $request->procedures;

        DB::table('hospital.jhay.orsched_reservations')->insert([  
            'patient_id'=>$patid,
            'room_id'=>$room,
            'type'=>$type,
            'surgeon'=>$surgeon,
            'procedures'=>$procedures,
            'entry_by'=> $emp,
            'reservation_status'=> '1',
            'case_num' => $caseNum,
            'timeStart' => $timeStart,
            'timeDuration' => $timeDuration,
            'typeAnes' => $typeAnes,
            'instru' => $instru,
            'created_at'=>Carbon::now(),
        ]);

        DB::table('jhay.orsched_patients')
            ->where('id', $patid)
            ->update([
                'scheduled' => '1'
            ]);

        // DB::UPDATE("insert into jhay.orsched_reservations (date_from, date_to, patient_id, room_id, entry_by, reservation_status, created_at)
        // values ('$timein', '$timeout', '$request->patient', '$request->room', '".Auth::user()->employeeid."', '1', cast(getdate() as date))");

        DB::table('hospital.jhay.orsched_actlog')->insert([
            'act_details'=>'Add New Reservations',
            'employeeid'=>$emp,
            'patient_id'=>$patID
        ]);

        // DB::UPDATE("insert into jhay.orsched_actlog (act_details, employeeid)
        // values ('Add New Reservations', '".Auth::user()->employeeid."')");
        $time = DB::SELECT("SELECT GETDATE() as datetoday");
        $datetoday = $request->selectdate;
        $roomtoday = $request->selectroom;
        $pat = DB::SELECT("SELECT * FROM [jhay].[orsched_patients] where entry_by = '$emp'");
        $scheds = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.patient_id = pa.id WHERE room_id = '$roomtoday'");
        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '$emp'");

        $schedcount = count($scheds);

        $type = $request->type;
        $schedule_date =$request->date;
        $schedule_date =Carbon::parse($request->date);
        $schedule_annex = $request->room;
        $schedule_surgeon = $request->surgeon;
        // $schedule_patient = $request->patname;
        // $schedule_timeout = $request->timeout;
        // $schedule_timeout = Carbon::parse($request->timeout)->format('H:i');
        // dd($schedule_surgeon);
        DB::table('jhay.orsched_schedule')
        ->insert([
            'annex' => $schedule_annex,
            'type' =>$type,
            'date_of_sched' => $schedule_date,
            // 'latest_sched' => $schedule_timeout,
            'surgeons_name' => $schedule_surgeon,
            // 'scheduled_patient' => $schedule_patient,
            'patient_id' => $patid
        ]);

        return redirect()->route('myschedules');
    }

    public function newCalendar(Request $r)
    {
        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '".Auth::user()->employeeid."'");
        if($r->ajax()) {
            $datetoday = Carbon::now()->format('Y-m-d');
            $scheds = DB::SELECT( "SELECT * from jhay.vw_toAccept where annex in (select min(annex) from jhay.vw_toAccept group by annex)
            and cast(date_of_sched as date) = '$datetoday'
            order by annex");
            
            return response()->json($scheds);
        }
        return view('Calendar.calendar', compact(
            'hpersonal',
        ));
    }

    public function createCalendar()
    {
        return view('Calendar.calendar');
    }

    public function storeCalendar(Request $request)
    {
        // $timein = $request->date.' '.$request->time.':00.000';
        // $timeout = $request->date.' '.$request->timeout.':00.000';
        $room = $request->room;
        $patient = $request->patient;

        DB::UPDATE("INSERT INTO jhay.orsched_reservations (patient_id, room_id, entry_by, reservation_status, created_at)
        values ($request->patient', '$request->room', '".Auth::user()->employeeid."', '1', cast(getdate() as date))");

        DB::UPDATE("insert into jhay.orsched_actlog (act_details, employeeid)
        values ('Add New Reservations', '".Auth::user()->employeeid."')");

        $time = DB::SELECT("SELECT GETDATE() as datetoday");
        $datetoday = $request->selectdate;
        $roomtoday = $request->selectroom;
        $scheds = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.patient_id = pa.id WHERE room_id = '$roomtoday'");
        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '".Auth::user()->employeeid."'");
        return view('Calendar.calendar', compact(
            'hpersonal',
            'datetoday',
            'scheds',
            'roomtoday',
            'time'
        ));
    }

}
