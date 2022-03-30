<?php

namespace App\Http\Controllers\Pain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Pain\PainSchedule;
use App\Model\Pain\PainPatient;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class PainSchedulerController extends Controller
{
    public function index(Request $request)
    {	//dd($request);
		
		

		$enccode = $request->enccode;
		
		$patientDetails = painPatient::where('enccode', $enccode)->get()->first();	
		$patientPainHpercode = $patientDetails['hpercode'];
		$patientLastName = $patientDetails['patlast'];
		$patientFirstName = $patientDetails['patfirst'];
		$patientMiddleName = $patientDetails['patmiddle'];
		$patientName = $patientLastName.", ".$patientFirstName." ".$patientMiddleName;
		$patientRoom= $patientDetails['patward'];
		$patientAge = $patientDetails['patage'];
		$patientSex = $patientDetails['patsex'];

		$events = array();
    	if($request->ajax())
    	{ 
				
			
    		$data = PainSchedule::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->get(['id', 'title', 'start', 'end']);

			
			
			foreach($data as $sched){
				$color = null;
				$day = Carbon::parse($sched->start)->format('l');

				switch ($day) {
					case "Monday":
						$color = '#20c997';
						break;
					case "Tuesday":
						$color = 'yellow';
						break;
					case "Wednesday":
						$color = '#0dcaf0';
						break;
					case "Thursday":
						$color = '#fd7e14';
						break;
					case "Friday":
						$color = '#d63384';
						break;
					case "Saturday":
						$color = '#198754';
						break;	
					case "Sunday":
						$color = '#ffc107';
						break;	

					default:
					  break;
				  }
				$events[] = [
					'id' => $sched->id,
					'title' => $sched->title,
					'start' => $sched->start,
					'end' => $sched->end,
					'color' => $color,
					

				];
			}
			
            return response()->json($events);
    	}
		
    	return view('pain.scheduler.painScheduler',compact('patientName','enccode','patientRoom','patientAge','patientSex' , 'patientPainHpercode'));
    }

	// public static function anestheologistList()
    // {
    //     return DB::SELECT("SELECT hpersonal.employeeid, hpersonal.lastname, hpersonal.firstname, hpersonal.middlename, hprovider.empdegree, htypser.tsdesc, hprovider.licno from hpersonal 
    //     INNER JOIN hprovider 
    //     ON hpersonal.employeeid = hprovider.employeeid
    //     INNER JOIN htypser
    //     ON hpersonal.deptcode = htypser.tscode
    //     WHERE hprovider.empstat = 'A' AND htypser.tsdesc = 'Pain Clinic/Anesthesia'
    //     ORDER BY hpersonal.lastname");
    // }

    public function action(Request $request)
    {	
		$enccode = $request->enccode;
		
		$employeeid = Auth::user()->employeeid;

		$patientDetailsAdd = painPatient::where('enccode', $enccode)->get()->first();	
		
		$patientLastNameAdd = $patientDetailsAdd['patlast'];
		$patientFirstNameAdd = $patientDetailsAdd['patfirst'];
		$patientMiddleNameAdd = $patientDetailsAdd['patmiddle'];
		$patientRoomAdd = $patientDetailsAdd['patward'];
		$patientAgeAdd = $patientDetailsAdd['patage'];
		$patientSexAdd = $patientDetailsAdd['patsex'];
		
		
		//$patientName = $patientLastName.", ".$patientFirstName." ".$patientMiddleName;
			// dd($request);

			
    	if($request->ajax())
    	{	
    		if($request->type == 'add')
    		{				
				
				$event = PainSchedule::create([
    				'title'		=>	$request->title,
    				'start'		=>	$request->start,
    				'end'		=>	$request->end,
					'service_type' => $request->serviceTypeAdd,
					'enccode'   =>  $enccode,
					'patientPainHpercode' => $request->patientPainHpercode,
					'patient_age' => $patientAgeAdd,
					'patient_sex' => $patientSexAdd,
					'patient_lastname' => $patientLastNameAdd,
					'patient_firstname' => $patientFirstNameAdd,
					'patient_middlename' => $patientMiddleNameAdd,
					'pain_diagnosis' =>	$request->painDiagnosis,
					'management' =>	$request->management,
					'disposition'=>	$request->disposition,
					'referringPhysician'=>	$request->referringPhysician,
					'painCODROD' =>	$request->painCODROD
					
    			]);
				
				$latestId = DB::table('nora.paul.pain_events')->orderBy('id','desc')->first();
				
				
				DB::table('nora.paul.pain_patients')
				->where ('enccode', $enccode)->increment('scheduled', 1);
				
									
					$lastGeneratedEventid = (int)$latestId->id;
					$eventId = $lastGeneratedEventid ;
					DB::table('nora.paul.pain_actlog')
					->insert([
						'act_details' => 'Add New Schedule',
						'events_id' => $eventId,					
						'employeeid' => $employeeid,
						'patient_id' => $request->patientPainHpercode
						
					]);
				
    			//return response()->json($event);
				return view('pain.layouts.master');
    		}

    		if($request->type == 'update')
    		{
    			$event = PainSchedule::find($request->id)->update([
    				'title'		=>	$request->title,
    				'start'		=>	$request->start,
    				'end'		=>	$request->end
    			]);

    			return response()->json($event);
    		}
			if($request->type == 'editUpdate')
    		{
    			$event = PainSchedule::find($request->id)->update([
    				'title'		=>	$request->title,
    				'start'		=>	$request->start,
    				'end'		=>	$request->end,
					'service_type' => $request->serviceTypeAdd,
					'enccode'   =>  $enccode,
					'patient_lastname' => $patientLastNameAdd,
					'patient_firstname' => $patientFirstNameAdd,
					'patient_middlename' => $patientMiddleNameAdd,
					'patient_procedure' => $request->patientProcedureAdd,
					'induction_time' => $request->inductionTimeAdd,
					'referring_physician' => $request->referringPhysicianAdd,
					'anesthesiologist' => $request->anesthesiologistAdd,
					'duration_time' =>  $request->durationTimeAdd,
					'patient_room' => $patientRoomAdd,
					'svc_pvt' => $request->svcPvtAdd,
					'patient_age' => $patientAgeAdd,
					'patient_sex' => $patientSexAdd
    			]);

    			return response()->json($event);
    		}
			if($request->type == 'edit')
    		{	
    			//dd($request->id);
				$event = PainSchedule::where('id', $request->id)->get();
				
    			return response()->json($event);
    		}

    		if($request->type == 'delete')
    		{
				
    			
    			$event = PainSchedule::where('id', $request->id)->delete();
				// dd($event);?
    			return response()->json($event);
    		}
    	}
    }
}
?>
