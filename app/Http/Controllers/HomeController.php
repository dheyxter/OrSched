<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon;
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
        $today = Carbon\Carbon::now();
        $employee = Auth::user()->employeeid;
        $patients = toAccept::with('reservation')
        ->join('hospital.dbo.hpersonal', 'jhay.vw_toAccept.entry_by', '=', 'dbo.hpersonal.employeeid')
        ->whereYear('jhay.vw_toAccept.created_at', '=', $today)
        ->where('accept', NULL)
        ->whereNull('cancel')
        ->orderBy('type', 'DESC')
        // ->whereMonth('jhay.vw_toAccept.created_at', '=', $today)
        ->get();

        // dd($patients);

        $patients1 = toAccept::with('reservation')
        ->join('hospital.dbo.hpersonal', 'jhay.vw_toAccept.entry_by', '=', 'dbo.hpersonal.employeeid')
        ->where('entry_by', Auth::user()->employeeid)
        ->where('accept', '=', null)
        // ->orwhereDate('jhay.vw_toAccept.created_at','=', $today)
        ->get();

        if(LoggedUser::user_role() == 1 || LoggedUser::user_role() == 2 || LoggedUser::user_role() == 3) {
            // ADMIN
            $pat = DB::SELECT("SELECT * from jhay.vw_toAccept WHERE cast(created_at as date)  = cast(getdate() as date)");
        }
        else
        // WARD
            $pat = DB::SELECT("SELECT * from jhay.vw_toAccept WHERE cast(created_at as date)  = cast(getdate() as date) AND entry_by = '$employee'");      
            // $pat = DB::SELECT("SELECT * FROM jhay.orsched_reservations AS re INNER JOIN jhay.orsched_patients pa ON re.patient_id = pa.id  WHERE pa.entry_by =  '$employee'");      

        $emer = DB::SELECT("SELECT COUNT(a.id) as total from jhay.orsched_reservations AS a INNER JOIN jhay.orsched_patients AS b on a.patient_id = b.id where a.type = 1 AND b.accept = 1 and year(b.created_at) = year(getdate())");
        $elec = DB::SELECT("SELECT COUNT(a.id) as total from jhay.orsched_reservations AS a INNER JOIN jhay.orsched_patients AS b on a.patient_id = b.id where a.type = 0 AND b.accept = 1 and year(b.created_at) = year(getdate())");
        // $tot = DB::SELECT("SELECT COUNT (id) as tot from jhay.orsched_reservations where op_status = '1'");
       
        $month = $request->month;
        if($request->month == '1')
        {
            $tot = DB:: SELECT("SELECT COUNT (id) as tot from jhay.orsched_reservations WHERE month(created_at) = '1' AND year(created_at) = year(getdate()) and  op_status = '1'");
        }
        elseif($request->month == '2')
        {
            $tot = DB:: SELECT("SELECT COUNT (id) as tot from jhay.orsched_reservations WHERE month(created_at) = '2' AND year(created_at) = year(getdate()) and  op_status = '1'");
        }
        elseif($request->month == '3')
        {
            $tot = DB:: SELECT("SELECT COUNT (id) as tot from jhay.orsched_reservations WHERE month(created_at) = '3' AND year(created_at) = year(getdate()) and  op_status = '1'");
        }
        elseif($request->month == '4')
        {
            $tot = DB:: SELECT("SELECT COUNT (id) as tot from jhay.orsched_reservations WHERE month(created_at) = '4' AND year(created_at) = year(getdate()) and  op_status = '1'");
        }
        elseif($request->month == '5')
        {
            $tot = DB:: SELECT("SELECT COUNT (id) as tot from jhay.orsched_reservations WHERE month(created_at) = '5' AND year(created_at) = year(getdate()) and  op_status = '1'");
        }
        elseif($request->month == '6')
        {
            $tot = DB:: SELECT("SELECT COUNT (id) as tot from jhay.orsched_reservations WHERE month(created_at) = '6' AND year(created_at) = year(getdate()) and  op_status = '1'");
        }
        elseif($request->month == '7')
        {
            $tot = DB:: SELECT("SELECT COUNT (id) as tot from jhay.orsched_reservations WHERE month(created_at) = '7' AND year(created_at) = year(getdate()) and  op_status = '1'");
        }
        elseif($request->month == '8')
        {
            $tot = DB:: SELECT("SELECT COUNT (id) as tot from jhay.orsched_reservations WHERE month(created_at) = '8' AND year(created_at) = year(getdate()) and  op_status = '1'");
        }
        elseif($request->month == '9')
        {
            $tot = DB:: SELECT("SELECT COUNT (id) as tot from jhay.orsched_reservations WHERE month(created_at) = '9' AND year(created_at) = year(getdate()) and  op_status = '1'");
        }
        elseif($request->month == '10')
        {
            $tot = DB:: SELECT("SELECT COUNT (id) as tot from jhay.orsched_reservations WHERE month(created_at) = '10' AND year(created_at) = year(getdate()) and  op_status = '1'");
        }
        elseif($request->month == '11')
        {
            $tot = DB:: SELECT("SELECT COUNT (id) as tot from jhay.orsched_reservations WHERE month(created_at) = '11' AND year(created_at) = year(getdate()) and  op_status = '1'");
        }
        elseif($request->month == '12')
        {
            $tot = DB:: SELECT("SELECT COUNT (id) as tot from jhay.orsched_reservations WHERE month(created_at) = '12' AND year(created_at) = year(getdate()) and  op_status = '1'");
        }
        else
        {
            $tot = DB:: SELECT("SELECT COUNT (id) as tot from jhay.orsched_reservations WHERE year(created_at) = year(getdate()) and  op_status = '1'");
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
            'mydata' => $mydata
        ]);
    }

    public function accept(Request $request) {
        $id = $request->id;
        $patID = $request->patient_id;
        $employeeid = $request->name;
        $namePat = $request->namePat;
        $nameEmp = $request->nameEmp;
        // dd($patID);

        DB::table('jhay.orsched_patients')
        ->where('id', $id)
            ->update([
                'accept_by' => $nameEmp,
                'accept' => '1'
            ]);
        
        DB::table('hospital.jhay.orsched_actlog')
        ->insert([
            'act_details' => 'Accept Patient Reservation', 
            'employeeid' => $employeeid,
            'patient_id' => $patID
        ]);

        return 0;
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

       return redirect('/');
    }


}
