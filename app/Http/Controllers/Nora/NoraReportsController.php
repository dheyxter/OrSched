<?php

namespace App\Http\Controllers\Nora;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Nora\NoraSchedule;

class NoraReportsController extends Controller
{
    public function printReport(Request $request){
        
        $start = $request->schedulePrint." 00:00:00";
        $end = $request->schedulePrint." 23:59:59";

        $data = NoraSchedule::whereDate('start', '>=', $start)
                       ->whereDate('end',   '<=', $end)
                       ->get();
                      
        return view('nora.printSchedule.noraPrintForm',compact('data'));
    }
}
