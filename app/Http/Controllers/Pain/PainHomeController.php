<?php

namespace App\Http\Controllers\Pain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Pain\PainSchedule;
use App\Model\Pain\PainPatient;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use App\Events\MyEvent;

class PainHomeController extends Controller
{
    public function index(Request $request) {	
		$enccode = $request->enccode;
		$patientDetails = painPatient::where('enccode', $enccode)->get()->first();	
		if($patientDetails) {
			$patientPainHpercode = $patientDetails['hpercode'];
			$patientLastName = $patientDetails['patlast'];
			$patientFirstName = $patientDetails['patfirst'];
			$patientMiddleName = $patientDetails['patmiddle'];
			$patientName = $patientLastName.", ".$patientFirstName." ".$patientMiddleName;
			$patientRoom= $patientDetails['patward'];
			$patientAge = $patientDetails['patage'];
			$patientSex = $patientDetails['patsex'];
			} else {
				$patientName=  '';
				$patientRoom=  '';
				$patientAge=  '';
				$patientSex=  '';
				$patientPainHpercode=  '';
		}
		
		
		$events = array();
    	if($request->ajax()) { 
				
			
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
		
    	return view('pain.scheduler.painCalendar',compact('patientName','enccode','patientRoom','patientAge','patientSex','patientPainHpercode'));
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
		
		$employeeid = Auth::user()->employeeid;
		$enccode = $request->enccode;
		
		
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
    		
    		if($request->type == 'update')
    		{	
				
				
    			$event = PainSchedule::find($request->id);

				$event->update([
    				'title'		=>	$request->title,
    				'start'		=>	$request->start,
    				'end'		=>	$request->end
    			]);

				DB::table('nora.paul.pain_actlog')
				->insert([
					'act_details' => 'Update Schedule Date and Time',
					'events_id' =>  $request->id,
					'employeeid' => $employeeid,
					'patient_id' => $event->patientPainHpercode
					
				]);

				$messageUpdate = "Schedule for : ".$request->title." is moved on ".$request->start." TO ".$request->end; 
				$mesasgeToSend =[
					'type'=> 'painUpdateTime',
					'message' => $messageUpdate
				];

				event(new MyEvent($mesasgeToSend));

    			return response()->json($event);
    		}
			if($request->type == 'editUpdate')			
    		{   
				DB::table('nora.paul.pain_actlog')
				->insert([
					'act_details' => 'Update Schedule Details',
					'events_id' =>  $request->id,
					'employeeid' => $employeeid,
					'patient_id' => $request->patientPainHpercode
					
				]);

    			$event = PainSchedule::find($request->id)->update([
    				'title'		=>	$request->title,
    				'start'		=>	$request->start,
    				'end'		=>	$request->end,
					'pain_diagnosis'=>	$request->painDiagnosis,
					'management'=>	$request->management, 
					'disposition'=>	$request->disposition, 
					'referringPhysician'=>	$request->referringPhysician,
					'painCODROD'=>	$request->painCODROD
					
					
    			]);
				$messageUpdate = "Schedule details for ".$request->title." has been updated"; 
				$mesasgeToSend =[
					'type'=> 'painUpdateDetails',
					'message' => $messageUpdate
				];

				event(new MyEvent($mesasgeToSend));

    			return response()->json($event);
				
    		}

			if($request->type == 'edit')
    		{	
				
				$event = PainSchedule::where('id', $request->id)->get();
				//dd($event->all());
    			return response()->json($event);
    		}
			if($request->ajax())
    		{

			}	
    	}
    }

	public static function destroy(Request $request){
		//dd($request);
		$employeeid = Auth::user()->employeeid;
		$enccode = $request->enccode;
		
		
		$patientDetailsAdd = painPatient::where('enccode', $enccode)->get()->first();	
		
		$patientLastNameAdd = $patientDetailsAdd['patlast'];
		$patientFirstNameAdd = $patientDetailsAdd['patfirst'];
		$patientMiddleNameAdd = $patientDetailsAdd['patmiddle'];
		$patientRoomAdd = $patientDetailsAdd['patward'];
		
			
			DB::table('nora.paul.pain_patients')
			->where('enccode', $request->enccode)->decrement('scheduled', 1);
			
			$getHpercode = PainSchedule::where('id', $request->id)->get()->first();	
			
			DB::table('nora.paul.pain_actlog')
			->insert([
				'act_details' => 'Delete Schedule',
				'events_id' =>  $request->id,
				'employeeid' => $employeeid,
				'patient_id' => $request->patientPainHpercode
				
			]);
			
			$event = PainSchedule::where('id', $request->id)->delete();
			// dd($event);?
			return response()->json($event,200);
		
	}

	public static function getLogDetails(){
		//FULL NAME RETRIEVAL
				$username = Auth::user()->employeeid;
				
		
				$eventLogDateTime = PainSchedule::where('id', $request->id)->get();
				//dd($event->all());
    			//dd(eventLogDateTime);
						
				return $fullname;
		//END OF FULL NAME RETRIEVAL
			}
}
?>
