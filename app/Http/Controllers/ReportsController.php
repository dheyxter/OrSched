<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;

class ReportsController extends Controller
{

    public function index ()
    {
        return view('reports.index');
    }

    // VIEWING FUNCTIONS
    public function r1() {
        
        $total = DB::SELECT("SELECT * FROM jhay.vw_TotEmergent where year(created_at) = year(getdate())");
        return view('reports.r1', [
            'total'  => $total
        ]);
    }

    public function r2()
    {
        $total = DB::SELECT("SELECT * FROM jhay.vw_TotElective where year(created_at) = year(getdate())");
        return view('reports.r2',[
            'total' => $total
        ]);
    }

    public function all()
    {
        $total = DB::SELECT("SELECT * FROM jhay.vw_All where year(created_at) = year(getdate()) ORDER BY type DESC");
        return view('reports.all',[
            'total' => $total
        ]);
    }

    public function anesElec()
    {
        $total = DB::SELECT("SELECT * FROM jhay.vw_orschedAnes WHERE type = '0' and year(created_at) = year(getdate())");
        return view('reports.anesElec',[
            'total' => $total
        ]);
    }
    public function anesEmer()
    {
        $total = DB::SELECT("SELECT * FROM jhay.vw_orschedAnes WHERE type = '1' and year(created_at) = year(getdate())");
        return view('reports.anesEmer',[
            'total' => $total
        ]);
    }
    public function anesReport()
    {
        $total = DB::SELECT("SELECT * FROM jhay.vw_orschedAnes where year(created_at) = year(getdate())");
        return view('reports.anesReport',[
            'total' => $total
        ]);
    }

    // VIEWING WITH PARAMETERS
    public function r1Post(Request $r)
    {   
        $dateFrom = $r->dateFrom;
        $dateTo = $r->dateTo;
        $tscode = $r->tscode;
        $today = Carbon::now();

       if(empty($dataFrom) && empty($dateTo) && empty($tscode))
       {
        $total = DB::SELECT("EXEC hospital.dbo.sp_orsched_getEmergent '$today','$today','$tscode'");
           
       }
       elseif(!empty($dateFrom) && !empty($dateTo) && $tscode == NULL) 
       {
       $total = DB::SELECT("SELECT * FROM jhay.vw_TotEmergent where CAST(created_at as date) between '$dateFrom' and '$dateTo'");
       } 
       else {
          $total = DB::SELECT("EXEC hospital.dbo.sp_orsched_getEmergent '$dateFrom','$dateTo', '$tscode'");
       }
       return view('reports.r1', [
            'total'  => $total,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'tscode' => $tscode
        ]);
    }

    public function r2Post(Request $r)
    {
        $dateFrom = $r->dateFrom;
        $dateTo = $r->dateTo;
        $tscode = $r->tscode;
        $today = Carbon::now()->format('Y-m-d');

       if(empty($dataFrom) && empty($dateTo) && empty($tscode))
       {
        $total = DB::SELECT("EXEC hospital.dbo.sp_orsched_getElective '$today','$today','$tscode'");
           
       }
       elseif(!empty($dateFrom) && !empty($dateTo) && $tscode == NULL) 
       {
       $total = DB::SELECT("SELECT * FROM jhay.vw_TotElective where CAST(created_at as date) between '$dateFrom' and '$dateTo'");
       } 
       else {
          $total = DB::SELECT("EXEC hospital.dbo.sp_orsched_getElective '$dateFrom','$dateTo', '$tscode'");
       }
       return view('reports.r2', [
            'total'  => $total,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'tscode' => $tscode
        ]);
    }

    public function allPost(Request $r)
    {
        // $dateFrom = Carbon::parse($r->dateFrom)->format('Y-m-d');
        // $dateTo = Carbon::parse($r->dateTo)->format('Y-m-d');
        $dateFrom = $r->dateFrom;
        $dateTo = $r->dateTo;
        $tscode = $r->tscode;
        // $today = Carbon::now()->format('Y-m-d');
        $today = Carbon::now();

       if(empty($dataFrom) && empty($dateTo) && empty($patWard))
       {
        $total = DB::SELECT("EXEC hospital.dbo.sp_orsched_getAll '$today','$today','$tscode'");
       }
       elseif(!empty($dateFrom) && !empty($dateTo) && $tscode == NULL) 
       {
       $total = DB::SELECT("SELECT * FROM jhay.vw_orschedAll where CAST(created_at as date) between '$dateFrom' and '$dateTo'");
       } 
       else {
          $total = DB::SELECT("EXEC hospital.dbo.sp_orsched_getAll '$dateFrom','$dateTo', '$tscode'");
       }
       return view('reports.all', [
            'total'  => $total,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'tscode' => $tscode
        ]);   
    }
    // ANES SCHEDULE
    public function anesAll(Request $r)
    {
        $dateFrom = $r->dateFrom;
        $dateTo = $r->dateTo;
        $today = Carbon::now();

       if(empty($dataFrom) && empty($dateTo))
       {
        $total = DB::SELECT("EXEC hospital.dbo.sp_orsched_getReportAnes '$today','$today'");
           
       }
       elseif(!empty($dateFrom) && !empty($dateTo)) 
       {
       $total = DB::SELECT("SELECT * FROM jhay.vw_orschedAnes where CAST(created_at as date) between '$dateFrom' and '$dateTo'");
       } 
       else {
          $total = DB::SELECT("EXEC hospital.dbo.sp_orsched_getReportAnes '$dateFrom','$dateTo'");
       }
       return view('reports.anesReport', [
            'total'  => $total,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ]);   
    }

    public function anesEmerFilter(Request $r)
    {
        $dateFrom = $r->dateFrom;
        $dateTo = $r->dateTo;
        $today = Carbon::now();

       if(empty($dataFrom) && empty($dateTo))
       {
        $total = DB::SELECT("EXEC hospital.dbo.sp_orsched_getAnesEmer '$today','$today'");
           
       }
       else {
          $total = DB::SELECT("EXEC hospital.dbo.sp_orsched_getAnesEmer '$dateFrom','$dateTo'");
       }
       return view('reports.anesEmer', [
            'total'  => $total,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ]);   
    }

    public function anesElecFilter(Request $r)
    {
        $dateFrom = $r->dateFrom;
        $dateTo = $r->dateTo;
        $today = Carbon::now();

       if(empty($dataFrom) && empty($dateTo))
       {
        $total = DB::SELECT("EXEC hospital.dbo.sp_orsched_getAnesElec '$today','$today'");
           
       }
       else {
          $total = DB::SELECT("EXEC hospital.dbo.sp_orsched_getAnesElec '$dateFrom','$dateTo'");
       }
       return view('reports.anesElec', [
            'total'  => $total,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ]);   
    }

    // PRINTING FUNCTIONS
    public function print1(Request $r)
    {
        $dateFrom = $r->dateFrom;
        $dateTo = $r->dateTo;
        $tscode = $r->tscode;

        if(!empty($dateFrom) && !empty ($dateTo) && !empty($tscode))
        {
            $tot = DB::SELECT("SELECT * FROM jhay.vw_TotEmergent WHERE cast(created_at as date) between '$dateFrom' and '$dateTo' and tscode = '$tscode' ORDER BY created_at");
        }
        else
        {   
            $tot = DB::SELECT("SELECT * FROM jhay.vw_TotEmergent WHERE cast(created_at as date) between '$dateFrom' and '$dateTo' ORDER BY created_at");
        } 
       
        return view('print.r1',[
            'tot' => $tot,
        ]); 
    }

    public function print2(Request $r)
    {
        $dateFrom = $r->dateFrom;
        $dateTo = $r->dateTo;
        $tscode = $r->tscode;

        if(!empty($dateFrom) && !empty ($dateTo) && !empty($tscode))
        {
            $tot = DB::SELECT("SELECT * FROM jhay.vw_TotElective WHERE cast(created_at as date) between '$dateFrom' and '$dateTo' and tscode = '$tscode' ORDER BY created_at");
        }
        else
        {   
            $tot = DB::SELECT("SELECT * FROM jhay.vw_TotElective WHERE cast(created_at as date) between '$dateFrom' and '$dateTo' ORDER BY created_at");
        } 

        return view('print.r2',[
            'tot' => $tot
        ]);   
    }

    public function printAll(Request $r)
    {
        $dateFrom = $r->dateFrom;
        $dateTo = $r->dateTo;
        $tscode = $r->tscode;
        // dd($tscode);

        if(!empty($dateFrom) && !empty ($dateTo) && !empty($tscode))
        {
            $tot = DB::SELECT("SELECT * FROM jhay.vw_All WHERE cast(created_at as date) between '$dateFrom' and '$dateTo' and tscode = '$tscode' ORDER BY created_at");
        }
        else
        {   
            $tot = DB::SELECT("SELECT * FROM jhay.vw_All WHERE cast(created_at as date) between '$dateFrom' and '$dateTo' ORDER BY created_at");
        } 

        // $tot = DB::SELECT("SELECT * FROM jhay.vw_All WHERE cast(created_at as date) between '$dateFrom' and '$dateTo' and tscode = '$tscode' ORDER BY type DESC");
        return view('print.all', [
            'tot' => $tot
        ]);
    }
    
    public function anesElecPrint(Request $r)
    {
        $dateFrom = $r->dateFrom;
        $dateTo = $r->dateTo;
        $tot = DB::SELECT("SELECT * FROM jhay.vw_orschedAnes where cast(created_at as date) between '$dateFrom' and '$dateTo' and type = 0 ORDER BY type DESC");
        return view('print.anesElec',[
            'tot' => $tot
        ]);   
    }

    public function anesEmerPrint(Request $r)
    {
        $dateFrom = $r->dateFrom;
        $dateTo = $r->dateTo;
        $tot = DB::SELECT("SELECT * FROM jhay.vw_orschedAnes where cast(created_at as date) between '$dateFrom' and '$dateTo' and type = 1 ORDER BY type DESC");
        return view('print.anesEmer',[
            'tot' => $tot
        ]);   
    }

    public function anesAllPrint(Request $r)
    {
        $dateFrom = $r->dateFrom;
        $dateTo = $r->dateTo;
        // dd($dateFrom, $dateTo);
        $tot = DB::SELECT("SELECT * FROM jhay.vw_orschedAnes WHERE cast(created_at as date) between '$dateFrom' and '$dateTo' ORDER BY type DESC");
        return view('print.anesAll',[
            'tot' => $tot
        ]);   
    }

    // WARDLIST FUNCTION
    public static function wardlist()
    {
        return DB::SELECT("SELECT DISTINCT a.tscode
        from jhay.orsched_patients as a
        INNER JOIN jhay.orsched_reservations as b ON a.id = b.patient_id
        INNER JOIN jhay.orsched_schedule as c ON b.patient_id = c.patient_id
        INNER JOIN hospital.dbo.hpersonal as d ON a.entry_by = d.employeeid
        where a.scheduled = 1  and b.type = 1 ");
    }

    public static function wardlist1()
    {
        return DB::SELECT(" SELECT DISTINCT a.tscode
        from jhay.orsched_patients as a
        INNER JOIN jhay.orsched_reservations as b ON a.id = b.patient_id
        INNER JOIN jhay.orsched_schedule as c ON b.patient_id = c.patient_id
        INNER JOIN hospital.dbo.hpersonal as d ON a.entry_by = d.employeeid
        where a.scheduled = 1 and b.type = 0");
    }

    public static function wardlist2()
    {
        return DB::SELECT("SELECT DISTINCT a.tscode
        from jhay.orsched_patients as a
        INNER JOIN jhay.orsched_reservations as b ON a.id = b.patient_id
        INNER JOIN jhay.orsched_schedule as c ON b.patient_id = c.patient_id
        INNER JOIN hospital.dbo.hpersonal as d ON a.entry_by = d.employeeid
        where a.scheduled = 1 ");
    }

    public function trans_log()
    {
        $logs = DB::SELECT("SELECT * from jhay.vw_OrschedActLog ORDER BY created_at");

        return view('reports.translog', [
            'logs' => $logs
        ]);
    }



}
