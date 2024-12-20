<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Model\patient;
use App\Model\toAccept;
use App\Http\Controllers\LoggedUser;
use App\Model\Reservation;

class HomeController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {   
        $hpersonal = DB::SELECT("EXEC [hospital].[jhay].[spIntranetmydata] '".Auth::user()->employeeid."'");
        $mydata = DB::select("SELECT * from jhay.orsched_user WHERE employeeid = '".Auth::user()->employeeid."'");
        $today = Carbon::now();
        $employee = Auth::user()->employeeid;
        $patients = toAccept::with('reservation')
        ->join('hospital.dbo.hpersonal', 'jhay.vw_toAccept.entry_by', '=', 'dbo.hpersonal.employeeid')
        ->whereYear('jhay.vw_toAccept.created_at', '=', $today)
        ->where('accept', NULL)
        ->whereNull('cancel_remarks_by')
        ->orderBy('type', 'DESC')
        // ->whereMonth('jhay.vw_toAccept.created_at', '=', $today)
        ->get();

        $check_ward = DB::SELECT("SELECT COUNT(*) as ward FROM jhay.orsched_user WHERE employeeid = '$employee' AND ward IS NOT NULL");
        $get_ward = $check_ward[0]->ward;
        if($get_ward > 1) {
            
        } else {

        }

        $ward = DB::TABLE('dbo.hward')
        ->where('wardstat','A' )
        ->get();

        $patients1 = toAccept::with('reservation')
        ->join('hospital.dbo.hpersonal', 'jhay.vw_toAccept.entry_by', '=', 'dbo.hpersonal.employeeid')
        ->where('entry_by', Auth::user()->employeeid)
        ->where('accept', '=', null)
        ->get();
        
        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 3) {
            // ADMIN
            $pat = DB::SELECT("SELECT * from jhay.vw_toAccept WHERE cast(created_at as date)  = cast(getdate() as date)");
        }
        else
        // WARD
            $pat = DB::SELECT("SELECT * from jhay.vw_toAccept WHERE cast(created_at as date)  = cast(getdate() as date) AND entry_by = '$employee'");      
            

        $emer = DB::SELECT("SELECT COUNT(a.id) as total from jhay.orsched_reservations AS a INNER JOIN jhay.orsched_patients AS b on a.patient_id = b.id where a.type = 1 AND b.accept = 1 and year(b.created_at) = year(getdate())");
        $elec = DB::SELECT("SELECT COUNT(a.id) as total from jhay.orsched_reservations AS a INNER JOIN jhay.orsched_patients AS b on a.patient_id = b.id where a.type = 0 AND b.accept = 1 and year(b.created_at) = year(getdate())");
        // $tot = DB::SELECT("SELECT COUNT (id) as tot from jhay.orsched_reservations where op_status = '1'");
       
        $month = $request->month;
        $query = "SELECT COUNT(id) as tot FROM jhay.orsched_reservations WHERE year(created_at) = year(getdate()) AND op_status = '1'";
        if ($month >= 1 && $month <= 12) {
            $query .= " AND month(created_at) = :month";
            $tot = DB::select($query, ['month' => $month]);
        } else {
            $tot = DB::select($query);
        }

        $tot1 = DB::SELECT("SELECT COUNT(id) as tot from jhay.orsched_reservations where op_status = '1' and cast(date_finish as date) = cast(getdate() as date)");
        $patcount = count($pat);
        $patcount1 = count($patients);

        
        $trigger = $request->myTrigger;
        if(!empty($trigger)){
            $getTrigger = $trigger;
        }else{
           
        }

        $datetoday = $request->selectdate;
        $roomtoday = $request->selectroom;
        $scheds = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re 
        INNER JOIN jhay.orsched_patients pa ON re.patient_id = pa.id 
        INNER JOIN jhay.orsched_schedule sc ON pa.id = sc.patient_id
        WHERE accept = 1 and cast(re.created_at as date) = '$datetoday'");
        $schedcount = count($scheds);

        $roomNames = [
            1 => 'Room 1 - MIS',
            2 => 'Room 2 - ER',
            3 => 'Room 3 - Surgery',
            4 => 'Room 4 - OB Gyne',
            5 => 'Room 5 - ENT',
            6 => 'Room 6 - Ortho',
            7 => 'Room 7 - Ophtha',
            8 => 'Room 8 - Surgery',
        ];

        return view('home',[
            'emer'=> $emer,
            'elec'=> $elec,
            'todday' => $today,
            'pat' => $pat,
            // 'pat1' => $pat1,
            'patcount' => $patcount,
            'patients' => $patients,
            'patients1' => $patients1,
            'patcount1' => $patcount1,
            'hpersonal' => $hpersonal,
            'tot' => $tot,
            'tot1' => $tot1,
            'datetoday' => $datetoday,
            'roomtoday' => $roomtoday,
            'scheds' => $scheds,
            'schedcount' => $schedcount,
            'getTrigger' => $trigger,
            'mydata' => $mydata,
            'roomNames' => $roomNames
        ]);
    }

    public function accept(Request $request) {
        $id = $request->id;
        $patID = $request->patient_id;
        $employeeid = $request->name;
        $namePat = $request->namePat;
        $nameEmp = $request->nameEmp;

        DB::table('jhay.orsched_patients')
        ->where('id', $id)
            ->update([
                'accept_by' => $nameEmp,
                'accept' => '1'
            ]);

        DB::TABLE('jhay.orsched_schedule')
        ->where('patient_id', $id)
        ->update([
            'accepted_by'   => $nameEmp,
            'accepted_at'   => now(),
        ]);
        
        DB::table('hospital.jhay.orsched_actlog')
        ->insert([
            'act_details' => 'Accept Patient Reservation', 
            'employeeid' => $employeeid,
            'patient_id' => $patID
        ]);

        return 0;
    }

    public function cancel(Request $request) {
        $id = $request->id;
        $patID = $request->patient_id;
        $employeeid = $request->name;
        $namePat = $request->namePat;
        $nameEmp = $request->nameEmp;
        // dd($patID);

        DB::TABLE('jhay.orsched_reservations')
        ->where('patient_id', $id)
        ->update([
            'deleted_at'    => Carbon::now()
        ]);

        DB::TABLE('jhay.orsched_schedule')
        ->where('patient_id', $id)
        ->update([
            'deleted_at'    => Carbon::now(),
            'cancel_by' => $nameEmp,
            'cancel' => 1
        ]);
        
        DB::table('hospital.jhay.orsched_actlog')
        ->insert([
            'act_details' => 'Cancel Patient Schedule', 
            'employeeid' => $employeeid,
            'patient_id' => $patID
        ]);

        return 0;
    }

    public function cancelRemarks(Request $r) {
        $employee = Auth::user()->employeeid;
        $today = Carbon::now();
        $hosp_id = $r->hospID;
        $cancelRemarks = $r->cancelRemarks;

        DB::TABLE('jhay.orsched_schedule')
        ->where('patient_id', $hosp_id)
        ->update([
            'cancel_remarks'    => $cancelRemarks,
            'cancel_remarks_by' => $employee,
            'cancel_remarks_at' => $today
        ]);
        return redirect()->route('home');

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

    public function addAnes(Request $r)
    {
        $ann_id = $r->patient_id;
        $patient_name = $r->patient_name;
        // $anes = $r->anes;
        $anes = implode(', ', $r->anes);
        $hpercode = $r->hpercode;
        // dd($anes);
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

    public function ChartReport()
    {
        return view('ChartReport');
    }

    public function Charts()
    {
        $chart = DB::SELECT("EXEC dex.spOrsched_ChartData");
    }


    public function is_confirm(Request $r)
    {   
       $empid = $r->employeeid;
       $updt = DB::UPDATE("UPDATE jhay.orsched_user SET is_confirm = '1' WHERE employeeid = '$empid'");

       return redirect('/orScheduler');
    }

    public function comments() {
        $feedback = DB::SELECT("SELECT * FROM jhay.orsched_feedback ORDER BY created_at");

        return view('admin.comments', compact(
            'feedback'
        ));
    }


    public function save_comments(Request $r) {

        $employee =Auth::user()->employeeid;
        $message = $r->message;

            DB::TABLE('jhay.orsched_feedback')
            ->insert([
                'username'     => $employee,
                'message'      => $message,
                'status'       => 1,
                'created_at'   => Carbon::now(),
 
            ]);

        return redirect()->back()->with('status', 'Feedback / Comment Saved Successfully!');

    }

    public function prog_remarks(Request $r) {
        $id             = $r->feedback_id;
        $prog_message   = $r->prog_message;
        $employee       = Auth::user()->employeeid;

            DB::TABLE('jhay.orsched_feedback')
            ->where('id', $id)
            ->update([
                'remarks'       => $prog_message,
                'remarks_by'    => $employee,
                'status'        => 2,
                'updated_at'    => Carbon::now(),
            ]);
        
        return redirect()->back()->with('status', 'Programmer Feedback Successfully!');

    }

    public function resolved(Request $r) {
        $id = $r->id;
        DB::TABLE('jhay.orsched_feedback')
        ->where('id', $id)
        ->update([
            'status'        => 3,
            'updated_at'    => Carbon::now(),
        ]);

        return redirect()->back();
    }


}
