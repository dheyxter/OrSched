<?php

namespace App\Http\Controllers\Pain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Pain\PainSchedule;
use Carbon\Carbon;

class PainReportsController extends Controller
{
    public function printReport(Request $request){
       
        $scheduleDateStart = Carbon::parse($request->schedulePrintStart);
        $scheduleDateEnd = Carbon::parse($request->schedulePrintEnd)->addDays(1);
        
        if($request->schedulePrintEnd == null ){
            $start = $scheduleDateStart->addDays(-1)->format('Y-m-d H:i');
            $end = $scheduleDateStart->addDays(2)->format('Y-m-d H:i');
        }else{
            $end = $scheduleDateEnd->format('Y-m-d H:i');
            $start = $scheduleDateStart->format('Y-m-d H:i');
        }

       // dd($request,$start,$end);
       
        
       


        $data = PainSchedule::whereDate('start', '>=', $start)
                       ->whereDate('end',   '<=', $end)
                       ->orderBy('start', 'asc')
                       ->get();
                    //   dd($start,$end,$data);
        return view('pain.printSchedule.painPrintForm',compact('data'));
    }
}
