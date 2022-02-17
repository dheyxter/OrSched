<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;;
use App\Model\Reservation;
use Carbon;

class RoomController extends Controller
{
    public function index()
    {

        $getdate = DB::SELECT("SELECT cast(GETDATE() as date) as getdate");
        // $today = Carbon\Carbon::now();
        $today = DB::SELECT("SELECT cast(GETDATE() as date) as getdate");
        $getdate = $getdate[0]->getdate;
        $employee = Auth::user()->employeeid;

        
        // dd($getdate);
        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 3) {
        $r1 = DB::table('jhay.orsched_reservations')
            ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
            ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
            ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
            ->where('room_id','=' ,'1')
            ->where('accept','=','1')
            ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
            ->get();
        } else
        $r1 = DB::table('jhay.orsched_reservations')
            ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
            ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
            ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
            ->where('room_id','=' ,'1')
            ->where('accept','=','1')
            ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
            ->where(DB::raw('jhay.orsched_reservations.entry_by', '=', '$employee'))
            ->get();

        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 3) {
        $r2 = DB::table('jhay.orsched_reservations')
            ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
            ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
             ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
            ->where('room_id','=' ,'2')
            ->where('accept','=','1')
            ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
            ->get();
        } else
            
        $r2 = DB::table('jhay.orsched_reservations')
            ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
            ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
            ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
            ->where('room_id','=' ,'2')
            ->where('accept','=','1')
            ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
            ->where(DB::raw('jhay.orsched_reservations.entry_by', '=', '$employee'))
            ->get();

        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 3) {
        $r3 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
         ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'3')
        ->where('accept','=','1')           
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
        ->get();
        } else

        $r3 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'3')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
       ->where(DB::raw('jhay.orsched_reservations.entry_by', '=', '$employee'))
        ->get();

        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 3) {
        $or1 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'4')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
        ->get();
        } else
        $or1 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'4')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
       ->where(DB::raw('jhay.orsched_reservations.entry_by', '=', '$employee'))
        ->get();
        
        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 3) {
        $or2 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'5')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
        ->get();
        } else
        $or2 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'5')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
       ->where(DB::raw('jhay.orsched_reservations.entry_by', '=', '$employee'))
        ->get();

        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 3) {
        $or3 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'6')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
        ->get();
        } else
        $or3 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'6')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
       ->where(DB::raw('jhay.orsched_reservations.entry_by', '=', '$employee'))
        ->get();

        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 3) {
        $or4 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'7')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
        ->get();
        } else
        $or4 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'7')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
       ->where(DB::raw('jhay.orsched_reservations.entry_by', '=', '$employee'))
        ->get();

        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 3) {
        $or5 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'8')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
        ->get();
        } else
        $or5 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'8')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
       ->where(DB::raw('jhay.orsched_reservations.entry_by', '=', '$employee'))
        ->get();

        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 3) {
        $or6 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'9')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
        ->get();
        } else
        $or6 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'9')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
       ->where(DB::raw('jhay.orsched_reservations.entry_by', '=', '$employee'))
        ->get();

        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 3) {
        $or7 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'10')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
        ->get();
        } else
        $or7 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'10')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
        ->where(DB::raw('jhay.orsched_reservations.entry_by', '=', '$employee'))
        ->get();

        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 3) {
        $or8 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'11')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
        ->get();
        } else
        $or8 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'11')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
        ->where(DB::raw('jhay.orsched_reservations.entry_by', '=', '$employee'))
        ->get();

        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 3) {
        $or9 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'12')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
        ->get();
        } else
        $or9 = DB::table('jhay.orsched_reservations')
        ->join('jhay.orsched_patients', 'jhay.orsched_reservations.patient_id', '=' , 'jhay.orsched_patients.id')
        ->join('jhay.orsched_schedule', 'jhay.orsched_patients.id', '=', 'jhay.orsched_schedule.patient_id')
        ->select('patlast','patfirst', 'patmiddle' , 'surgeon', 'procedures',  'op_status', 'date_finish' , 'jhay.orsched_schedule.patient_id', 'hpercode', 'anes', 'date_of_sched')
        ->where('room_id','=' ,'12')
        ->where('accept','=','1')            
        ->whereDate('jhay.orsched_schedule.date_of_sched','=', $getdate)
        ->where(DB::raw('jhay.orsched_reservations.entry_by', '=', '$employee'))
        ->get();

        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '".Auth::user()->employeeid."'");
        return view('Room.index', compact(
            'hpersonal',
            'r1',
            'r2',
            'r3',
            'or1',
            'or2',
            'or3',
            'or4',
            'or5',
            'or6',
            'or7',
            'or8',
            'or9',
            'getdate'
        ));
    }

    public function selectdateroom2(request $request)
    {
        $getdate = $request->selectdate;
        $datetoday = DB::SELECT("SELECT cast(GETDATE() as date) as datetoday");
        $datetoday = $datetoday[0]->datetoday;
        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '".Auth::user()->employeeid."'");
        // dd($hpersonal[0]->employeeid);
        $activeUser = $hpersonal[0]->employeeid;

        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 2  || LoggedUser::user_role() == 3) {
            $r1 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '1' and cast(sc.date_of_sched as date) = cast('$getdate' as date)");
            $r2 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '2' and cast(sc.date_of_sched as date) = cast('$getdate' as date)");
            $r3 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '3' and cast(sc.date_of_sched as date) = cast('$getdate' as date)");
            $or1 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '4' and cast(sc.date_of_sched as date) = cast('$getdate' as date)");

            $or2 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '5' and cast(sc.date_of_sched as date) = cast('$getdate' as date)");
            $or3 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '6' and cast(sc.date_of_sched as date) = cast('$getdate' as date)");
            $or4 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '7' and cast(sc.date_of_sched as date) = cast('$getdate' as date)");
            $or5 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '8' and cast(sc.date_of_sched as date) = cast('$getdate' as date)");
            $or6 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '9' and cast(sc.date_of_sched as date) = cast('$getdate' as date)");
            $or7 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '10' and cast(sc.date_of_sched as date) = cast('$getdate' as date)");
            $or8 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '11' and cast(sc.date_of_sched as date) = cast('$getdate' as date)");
            $or9 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '12' and cast(sc.date_of_sched as date) = cast('$getdate' as date)");
            // $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '".Auth::user()->employeeid."'");
        } 
        else {
            $r1 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '1' and cast(sc.date_of_sched as date) = cast('$getdate' as date) AND re.entry_by = '$activeUser'");
            $r2 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '2' and cast(sc.date_of_sched as date) = cast('$getdate' as date) AND re.entry_by = '$activeUser'");
            $r3 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '3' and cast(sc.date_of_sched as date) = cast('$getdate' as date) AND re.entry_by = '$activeUser'");
            $or1 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '4' and cast(sc.date_of_sched as date) = cast('$getdate' as date) AND re.entry_by = '$activeUser'");

            $or2 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '5' and cast(sc.date_of_sched as date) = cast('$getdate' as date) AND re.entry_by = '$activeUser'");
            $or3 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '6' and cast(sc.date_of_sched as date) = cast('$getdate' as date) AND re.entry_by = '$activeUser'");
            $or4 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '7' and cast(sc.date_of_sched as date) = cast('$getdate' as date) AND re.entry_by = '$activeUser'");
            $or5 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '8' and cast(sc.date_of_sched as date) = cast('$getdate' as date) AND re.entry_by = '$activeUser'");
            $or6 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '9' and cast(sc.date_of_sched as date) = cast('$getdate' as date) AND re.entry_by = '$activeUser'");
            $or7 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '10' and cast(sc.date_of_sched as date) = cast('$getdate' as date) AND re.entry_by = '$activeUser'");
            $or8 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '11' and cast(sc.date_of_sched as date) = cast('$getdate' as date) AND re.entry_by = '$activeUser'");
            $or9 = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.id = pa.id INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id WHERE re.room_id = '12' and cast(sc.date_of_sched as date) = cast('$getdate' as date) AND re.entry_by = '$activeUser'");
            // $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '".Auth::user()->employeeid."'");
        }
        return view('Room.index', compact(
            'hpersonal',
            'r1',
            'r2',
            'r3',
            'or1',
            'or2',
            'or3',
            'or4',
            'or5',
            'or6',
            'or7',
            'or8',
            'or9',
            // 'r4',
            'datetoday',
            'getdate'
        ));
    }

    public function status(Request $r){
        $id = $r->id;
        $hpercode = $r->hpercode;
        // dd($hpercode);
        DB::table('jhay.orsched_reservations')
        ->where('patient_id', $id)
        ->update([
            'op_status' => 1,
            'date_finish' => Carbon\Carbon::now()
        ]);

        DB::table('jhay.orsched_actlog')
        ->insert([
            'act_details' => 'Operation Done',
            'employeeid' => Auth::user()->employeeid,
            'patient_id' => $hpercode,
        ]);

        return 0;
    }
}
