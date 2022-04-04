@extends('nora.layouts.master')
@section('content')

<head>
    <title>NON-OPERATIONAL ROOM ANESTHESIOLOGY</title>

</head>
    

<body>

<div class="container">
<!--  -->
<div id="createEventModal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <form>
                <div class="form-group">
                    <h3 id="myModalLabel1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-event" viewBox="0 0 16 16">
                    <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                    <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z"/>
                    </svg> <i><b> CREATE SCHEDULE </b></i></h3>
                    <p style="color:red" id="svc_pvt_validation">* Please fill out the required fields</p>

                </div>
            </form>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <div class="modal-body"> 
            <div id="liveAlertPlaceholder"></div>
            
                <form>
                    <div class="form-group row">
                        <label for="patientName" class="col-sm-3 col-form-label" >Patient Name:</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="patientName"  value="{{$patientName}}"disabled>
                        <input type="text" class="form-control" id="enccode"  value="{{$enccode}}" hidden >
                        <input type="text" class="form-control" id="patientNoraHpercode"  value="{{$patientNoraHpercode}}" hidden >
                        
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="patientRoom" class="col-sm-3 col-form-label" >Room:</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="patientRoom"  value="{{$patientRoom}}"disabled>
                        
                        </div>
                    </div>
                    
                    <fieldset>
                    <legend>Schedule Details </legend>
                    <div class="form-group row">
                        <label for="serviceType" class="col-sm-3 col-form-label">Service Type:</label>
                        <div class="col-sm-9">
                            @if($userRole == 1)
                                <input type="text" class="form-control" id="serviceType"  value="BRACHY" disabled>
                            @else   
                            <select class="form-control form-control-lg" id="serviceType"  required>
                                <option value="" selected disabled hidden>Choose here</option>                               
                                <option value="GI" >GI</option>
                                <option value="RADIO/ONCO">RADIO/ONCO</option>
                                <option value="BRACHY">BRACHY</option>  
                            </select>                           
                            @endif
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label for="apptStartTime" class="col-sm-3 col-form-label">Start Schedule:
                        </label>
                            <div class="col-sm-9">
                            <input type="datetime-local" class="form-control" id="apptStartTime" required/>
                            </div>                       
                    </div>
                    <div class="form-group row">
                        <label for="apptEndTime" class="col-sm-3 col-form-label">End Schedule:
                        </label>
                            <div class="col-sm-9">
                            <input type="datetime-local" class="form-control" id="apptEndTime" required/>
                            </div>                       
                    </div>
                    </fieldset>
                    
                    <div class="form-group row">
                            <label for="inductionTime" class="col-sm-3 col-form-label">Induction Time: </label>
                                <div class="col-sm-4">
                                    <input type="time" class="form-control" id="inductionTime" required/>
                                </div>
                            <label for="durationTime" class="col-sm-3 col-form-label">Duration Time (hr):</label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" step="0.1" id="durationTime">
                                </div> 
                                                      
                    </div>    
                    <div class="form-group row">
                        <label for="patientProcedure" class="col-sm-3 col-form-label" >Procedure:</label>
                            <div class="col-sm-9">
                            <textarea class="form-control" id="patientProcedure" rows="2"></textarea>
                            </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="referringAddPhysicianInput1" class="col-sm-3 col-form-label" id="addPhysicianLabelId">Referring Physician:
                        </label>
                            
                            <div class="col-sm-7">
                            <input type="text" class="form-control" id="referringAddPhysicianInput1" >
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-info" id="addPhysicianButton"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                                </button> 
                            </div>
                            
                    </div>   
                    <div id="addPhysician">
                    </div>    
                    <div class="form-group row">
                        <label for="anesthesiologist" class="col-sm-3 col-form-label" >Anesthesiologist:</label>
                            <div class="col-sm-9">
                            <select class="form-control form-control-lg" id="anesthesiologist">
                            <option value="" selected disabled hidden>Choose here</option>
                            @foreach(\App\Http\Controllers\Nora\NoraSchedulerController::anestheologistList() as $a)                                                                
		                        <option value=" {{$a->firstname}} {{$a->middlename}} {{$a->lastname}}">
                                    {{$a->lastname}}, {{$a->firstname}} {{$a->middlename}},
                                    {{$a->empdegree}} | {{$a->tsdesc}}
                                 </option>
                             @endforeach
                            </select>
                            </div>
                    </div>   
                    <div class ="form-group row">
                           <label for="svc_pvt" class="col-sm-3 col-form-label" >SVC/PVT:</label>
                           <div class="col-sm-9" id="svc_pvt_div" >
                                <div class="custom-control custom-radio custom-control-inline" >
                                     <input type="radio" id="SVC" name="svc_pvt" class="custom-control-input" checked value="SVC" >
                                     <label class="custom-control-label" for="SVC">SVC</label>
                                 </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                     <input type="radio" id="PVT" name="svc_pvt" class="custom-control-input"  value="PVT" >
                                    <label class="custom-control-label" for="PVT">PVT</label>
                                </div>
                                <!-- <p style="color:red" id="svc_pvt_validation">Please choose if SVC or PVT</p> -->
                            </div>
					</div>
					
                
                    
                </form>
               

            </div>
            <div class="modal-footer">                
                <button type="submit" class="btn btn-primary" id="submitButton">Save</button>
            </div>
        </div>
    </div>
</div>


<!-- Delete modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Confirmation Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete the schedule?
      </div>
      <div class="modal-footer">
        <button type="confirmDeleteNo" class="btn btn-secondary" data-dismiss="modal">NO</button>
        <button type="confirmDeleteYes" class="btn btn-primary" id="deleteConfirmed">YES</button>
      </div>
    </div>
  </div>
</div>
<br/>
    <div id="calendar"></div>
</div>


<!-- Booking not allowed -->
<div class="modal" tabindex="-1" role="dialog" id="bookingModal" >
  <div class="modal-dialog" role="document" >
    <div class="modal-content">
      <div class="modal-header alert-danger" >
        <h3 class="modal-title" ><b>Alert!</b></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><b>You can not create schedule in this day!</b></p>
      </div>
      <div class="modal-footer">       
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>





@endsection
@section('script')
<meta name="csrf-token" content="{{ csrf_token() }}" />

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>       
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>



$(document).ready(function () {
       
    function validateInputs(){
        //console.log("validate!!!");
        let validStartTime = !($('#apptStartTime').val().length === 0) ;
        let validEndTime = !($('#apptEndTime').val().length === 0) ;
        let validServiceType = !($('#serviceType').length === 0 || $('#serviceType').length === null);
        let validInductionTime = !($('#inductionTime').val().length === 0) ;
        let validDurationTime = !($('#durationTime').val().length === 0) ;
        let validPatientProcedure = !($('#patientProcedure').val().length === 0) ;
        let validReferPhysician = !($('#referringAddPhysicianInput1').val().length === 0) ;
        let validAnesthesiologist = !($('#anesthesiologist').val() === null) ;

        
        
        if(!(validStartTime)){
            $('#apptStartTime').css( "border", "1.5px solid red");
        }

        if(!(validEndTime)){
            $('#apptEndTime').css( "border", "1.5px solid red");
        }

        if(validServiceType){
            $('#serviceType').css( "border", "1.5px solid red");
        }

        if(!(validInductionTime)){
            $('#inductionTime').css( "border", "1.5px solid red");
        }

        if(!(validDurationTime)){
            $('#durationTime').css( "border", "1.5px solid red");
        }

        if(!(validPatientProcedure)){
            $('#patientProcedure').css( "border", "1.5px solid red");
        }
        if(!(validReferPhysician)){
            $('#referringAddPhysicianInput1').css( "border", "1.5px solid red");
        }

        if(!(validAnesthesiologist)){
            $('#anesthesiologist').css( "border", "1.5px solid red");
        }

        

        
        ///////////////////////////////////////////////////////////////

        $("#apptStartTime").on("input", function() {
            if($(this).val().length === 0){
                $('#apptStartTime').css( "border", "1.5px solid red ");
                validStartTime = false;
            }               
            else{
                $('#apptStartTime').css( "border", "1px solid rgba(0,0,0,.2)");
                validStartTime = true;
            }
            //console.log("apptStartTime: " + validStartTime);
        });
        
        $("#apptEndTime").on("input", function() {
            if($(this).val().length === 0){
                $('#apptEndTime').css( "border", "1.5px solid red ");
                validEndTime = false;
            }               
            else{
                $('#apptEndTime').css( "border", "1px solid rgba(0,0,0,.2)");
                validEndTime = true;
            }
            //console.log("apptEndTime: " + validEndTime);
        });

        $("#serviceType").on("input", function() {
            if($(this).val().length === 0){
                $('#serviceType').css( "border", "1.5px solid red ");
                validServiceType = false;
            }               
            else{
                $('#serviceType').css( "border", "1px solid rgba(0,0,0,.2)");
                validServiceType = true;
            }
            //console.log("serviceType: " + validServiceType);
        });

        $("#inductionTime").on("input", function() {
            if($(this).val().length === 0){
                $('#inductionTime').css( "border", "1.5px solid red ");
                validInductionTime = false;
            }               
            else{
                $('#inductionTime').css( "border", "1px solid rgba(0,0,0,.2)");
                validInductionTime = true;
            }
            //console.log("inductionTime: " + validInductionTime);
        });

        $("#durationTime").on("input", function() {
            if($(this).val().length === 0){
                $('#durationTime').css( "border", "1.5px solid red ");
                validDurationTime = false;
            }               
            else{
                $('#durationTime').css( "border", "1px solid rgba(0,0,0,.2)");
                validDurationTime = true;
            }
            //console.log("durationTime: " + validDurationTime);
        });

        $("#referringAddPhysicianInput1").on("input", function() {
            if($(this).val().length === 0){
                $('#referringAddPhysicianInput1').css( "border", "1.5px solid red ");
                validReferPhysician = false;
            }               
            else{
                $('#referringAddPhysicianInput1').css( "border", "1px solid rgba(0,0,0,.2)");
                validReferPhysician = true;
            }
            //console.log("referringAddPhysicianInput1: " + validReferPhysician);
        });

        $("#patientProcedure").on("input", function() {
            if($(this).val().length === 0){
                $('#patientProcedure').css( "border", "1.5px solid red ");
                validPatientProcedure = false;
            }               
            else{
                $('#patientProcedure').css( "border", "1px solid rgba(0,0,0,.2)");
                validPatientProcedure = true;
            }
            //console.log("patientProcedure: " + validPatientProcedure);
        });

        $("#anesthesiologist").on("input", function() {
            if($(this).val().length === 0){
                $('#anesthesiologist').css( "border", "1.5px solid red ");
                validAnesthesiologist = false;
            }               
            else{
                $('#anesthesiologist').css( "border", "1px solid rgba(0,0,0,.2)");
                validAnesthesiologist = true;
            }
            //console.log("anesthesiologist: " + validAnesthesiologist);
        });

        

        


        let proceedSave = false;

        $('#submitButton').on('click', function(e){ 
            var validSvcPvt = false;   
            if($('input[name="svc_pvt"]:checked').val()){
                validSvcPvt = true;
                //console.log("svc_pvt  checked")
                $('#svc_pvt_validation').removeAttr('hidden');
            }else{
                validSvcPvt = false;
                //console.log("svc_pvt not  checked")
                $("#svc_pvt_validation").prop("hidden",true);
            }
            //console.log($('input[name="svc_pvt"]:checked').val());
            // //console.log('validSvcPvt: ' + validSvcPvt);
            // //console.log('validStartTime: ' + validStartTime)
            // //console.log('validEndTime: ' + validEndTime)
            // //console.log('validServiceType: ' + validServiceType)
            // //console.log('validInductionTime: ' +validInductionTime)
            // //console.log('validDurationTime: ' + validDurationTime)
            // //console.log('validPatientProcedure: ' + validPatientProcedure)
            // //console.log('validReferPhysician: ' + validReferPhysician)
            // //console.log('validAnesthesiologist: ' +validAnesthesiologist)
            
             e.preventDefault();
             if(validStartTime &&
                    validEndTime &&
                    validServiceType &&
                    validInductionTime &&
                    validDurationTime &&
                    validPatientProcedure &&
                    validReferPhysician &&
                    validAnesthesiologist &&
                    validSvcPvt
                     ){
                        //alert("You will be safe here!!!");
                        doSubmitCreate();
                         
                        
                    }else{
                        alert("Please fill up the required fields !!" );
                    }   

        });
    }
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    var calendar = $('#calendar').fullCalendar({
        themeSysyem: "standard",
        eventTextColor:'#000000',
        allDaySlot: false,
        scrollTime: "08:00:00",
        minTime: '07:00:00',
        maxTime: '17:00:00',
        contentHeight: 'auto',
        editable:true,
        header:{
            left:'prev,next today',
            center:'title',
            right:'month,agendaWeek,agendaDay'
        },
        slotDuration: '01:00:00',
        agendaEventMinHeight: 0,
        defaultView:'agendaWeek',
        events:'/noraScheduler',
        selectable:true,
        selectHelper: true,    
        
        select:function(start, end, allDay,event)
        { var view = $('#calendar').fullCalendar('getView');
            
            const today = new Date()
            const tomorrow = new Date(today)
            tomorrow.setDate(tomorrow.getDate() + 1)
            var tomorrowDate = tomorrow.getFullYear()+'-'+(tomorrow.getMonth()+1)+'-'+tomorrow.getDate();

            const tomDate = new Date(tomorrowDate);
            const startEventDate = new Date(start-1);
            
            
           
            
            if (startEventDate < tomDate ){
                
                $('#bookingModal').modal('show');
            

            }
            else
            {                 
                if(view.type == 'month'){
                    //console.log('month');
                    endtime = $.fullCalendar.formatDate(start,'Y-MM-DD HH:mm:ss');
                }else{
                    //console.log(view.type);
                    endtime = $.fullCalendar.formatDate(end,'Y-MM-DD HH:mm:ss');
                }            
                starttime = $.fullCalendar.formatDate(start,'Y-MM-DD HH:mm:ss');
                var mywhen = starttime + ' - ' + endtime;
                //console.log(starttime);
                
                var startTimeParsed = starttime.split(' ').join('T');
                var endTimeParsed = endtime.split(' ').join('T');

                var duration = (Date.parse(endTimeParsed)-Date.parse(startTimeParsed))/3600000

                $('#createEventModal #apptStartTime').val(startTimeParsed);
                $('#createEventModal #apptEndTime').val(endTimeParsed);
                $('#createEventModal #apptAllDay').val(allDay);
                $('#createEventModal #durationTime').val(duration);
                //console.log(duration);
                // $('#createEventModal #when').text(mywhen);
                $('#createEventModal').modal('show');
             } 

        },
        editable:true,
        eventResize: function(event, delta)
        {
            
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            var title = event.title;
            var id = event.id;
            $.ajax({
                url:"/noraScheduler/action",
                type:"POST",
                data:{
                    title: title,
                    start: start,
                    end: end,
                    id: id,
                    type: 'update'
                },
                success:function(response)
                {
                    calendar.fullCalendar('refetchEvents');
                    displayMessage("Schedule Updated Successfully");
                }
            })
        },
        eventDrop: function(event, delta)
        {
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            var title = event.title;
            var id = event.id;
            $.ajax({
                url:"/noraScheduler/action",
                type:"POST",
                data:{
                    title: title,
                    start: start,
                    end: end,
                    id: id,
                    type: 'update'
                },
                success:function(response)
                {
                    calendar.fullCalendar('refetchEvents');
                    displayMessage("Schedule Updated Successfully");
                }
            })
        },

      
        
    });
    

    $(document).on('show.bs.modal', '#createEventModal', function (e) {
        //console.log("patientNoraHpercode: " + $('#patientNoraHpercode').val()); 
        //console.log('create modal open');
        
        validateInputs();    

            
    });


    //console.log("check svc_pvt: " +$('input[name="svc_pvt"]:checked').val());    
    

  function doSubmitCreate(){
    var eventId = event.id;
      //console.log("eventid: " + eventId);
    $("#createEventModal").modal('hide');
    //console.log($('#serviceType').val());
    //console.log($('#apptStartTime').val());
    //console.log($('#apptEndTime').val());
    // var duration = (Date.parse($('#apptEndTime').val())-Date.parse($('#apptStartTime').val()))/360000
    // //console.log(duration);
    //console.log($('#patientName').val());
    const physicianElements = document.querySelectorAll(`[id^="referringAddPhysicianInput"]`);
    
    let physicianList =[]
    for (var i = 0; i < physicianElements.length; i++) {
        physicianList.push(physicianElements[i].value);
    }
    //console.log("induction time: " + $('#inductionTime').val());
    //console.log("duration time: " +  $('#createEventModal #durationTime').val());
    physicianListFinal = physicianList.join(", ");
    //console.log(physicianListFinal);   
    //console.log("anesthesiologist: " + $('#anesthesiologist').val());
    //console.log("svc_pvt :" + $("input[type=radio][name=svc_pvt]:checked").val());

            $.ajax({
                    url:"/noraScheduler/action",
                    type:"POST",
                    data:{
                        title: $('#serviceType').val() + " - " + $('#patientName').val(),
                        start: $('#apptStartTime').val().split('T').join(' '),
                        end: $('#apptEndTime').val().split('T').join(' '),
                        enccode : $('#enccode').val(),
                        patientNoraHpercodeAdd :$('#patientNoraHpercode').val(),
                        serviceTypeAdd : $('#serviceType').val(),
                        patientProcedureAdd : $('#patientProcedure').val(),
                        inductionTimeAdd : $('#inductionTime').val(),
                        referringPhysicianAdd : physicianListFinal,
                        anesthesiologistAdd: $('#anesthesiologist').val(),
                        durationTimeAdd :  $('#createEventModal #durationTime').val(),
                        patientRoomAdd: $('#patientRoom').val(),
                        svcPvtAdd : $("input[type=radio][name=svc_pvt]:checked").val(),
                        type: 'add'
                    },
                    success:function(data)
                    {
                        calendar.fullCalendar('refetchEvents');
                        displayMessage("Schedule Created Successfully");
                        
                        window.location='noraHome';
                    }
                })
   }
});

$("#serviceType").on("input", function() {
    let listEvents = $('#calendar').fullCalendar('clientEvents');
        for (const checkEvent of listEvents) {
                startEvent = $('#apptStartTime').val().split('T').join(' ')
               
                //console.log("startevent: " +startEvent);
                //console.log("data start: " +checkEvent.start._i);
                if(Date.parse(startEvent) == Date.parse(checkEvent.start._i)){
                    
                   if(checkEvent.title.includes($('#serviceType').val()) &&
                         $('#serviceType').val() != 'BRACHY'){       
                            console.log("rdisabled save");            
                        alert($('#serviceType').val());
                       $('#submitButton').prop('disabled',true);
                       break;
                   }else{
                    console.log("remove disable");
                    $('#submitButton').prop('disabled',false);
                }
                   
                }
               
        }
        
});

var alertPlaceholder = document.getElementById('liveAlertPlaceholder')
//trigger alert when same service type
function alert(message, type) {
  var wrapper = document.createElement('div')
  wrapper.innerHTML = '<div class="alert alert-warning alert-dismissible">' +
    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
    '<strong>Alert!</strong> <br>You can not another schedule for ' + message +  ' during this time !!!'+
  '</div>';

  
  alertPlaceholder.append(wrapper)
}




function displayMessage(message) {
    toastr.success(message, 'Event');
} 


$("#durationTime").bind('keyup mouseup', function () {
        var endTimeRaw = Date.parse($('#apptEndTime').val());
        var durationTime = $('#durationTime').val();
        var startTime = Date.parse($('#apptStartTime').val());
        
       // //console.log("endTimeRaw:" + formatDate(endTimeRaw));        
        ////console.log("duration time: " + durationTime*3600000);

        var finalEndTime = startTime + (durationTime*3600000)  ;
        ////console.log("end: " + formatDate(finalEndTime));
        var formattedFinal = formatDate(finalEndTime).split(' ').join('T');
        //console.log(formattedFinal);
        $('#createEventModal #apptEndTime').val(formattedFinal);
    });

// $("#apptEndTime").bind('keyup mouseup', function () {
//     var endTimeRaw = Date.parse($('#apptEndTime').val());
//     //console.log("endTimeRaw: "+ endTimeRaw);
//     var startTimeRaw = Date.parse($('#apptStartTime').val());
//     //console.log("startTimeRaw: " + startTimeRaw);

//     var durationTimeChange = (endTimeRaw-startTimeRaw)/3600000
         
//     //console.log("durationTimeChange: " + durationTimeChange);
//     $('#createEventModal #durationTime').val(durationTimeChange);
//     });    

$( "#apptEndTime" ).change(function() {
  //alert( "Handler for .change() called." );
    var endTimeRaw = Date.parse($('#apptEndTime').val());
    //onsole.log("endTimeRaw: "+ endTimeRaw);
    var startTimeRaw = Date.parse($('#apptStartTime').val());
    ////console.log("startTimeRaw: " + startTimeRaw);

    var durationTimeChange = (endTimeRaw-startTimeRaw)/3600000
         
    ////console.log("durationTimeChange: " + durationTimeChange);
    $('#createEventModal #durationTime').val(durationTimeChange);
  
});

$( "#apptStartTime" ).change(function() {
  //alert( "Handler for .change() called." );
    var endTimeRaw = Date.parse($('#apptEndTime').val());
    ////console.log("endTimeRaw: "+ endTimeRaw);
    var startTimeRaw = Date.parse($('#apptStartTime').val());
    ////console.log("startTimeRaw: " + startTimeRaw);

    var durationTimeChange = (endTimeRaw-startTimeRaw)/3600000
         
   ////console.log("durationTimeChange: " + durationTimeChange);
    $('#createEventModal #durationTime').val(durationTimeChange);
  
});

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
        hour = d.getHours();
        minutes = d.getMinutes();
        
    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;
        minutes = d.getMinutes();

    var time = "";
    if(minutes < 10){
        minutes = "0" + minutes;
    }

    if(hour < 10){
        hour = "0" + hour;
    }

    time = hour + ":" + minutes + ":00";

    var dateParsed = [year, month, day].join('-')
    return dateParsed + " " + time;
}




var button = document.getElementById('addPhysicianButton');
var toDoLists = document.getElementById('addPhysician');

var physicianId = 1;
var physicianNumberLabel = "Additional Physician: ";
// $("#addPhysicianButton").click(function(){
//     alert("add! add!");
// });

button.addEventListener('click', function() {
  const elements = ` 
  <div class="form-group row" id=referringAddPhysician${physicianId}>
  <label for="referPhysician" class="col-sm-3 col-form-label" >${physicianNumberLabel}</label>
    <div class="col-sm-7">
        <input type="text" class="form-control" id="referringAddPhysicianInput${physicianId}" >
     </div>
     <div class="col-sm-2">
        <button type="button" class="btn btn-danger" id="deletePhysicianButton${physicianId}" onclick="remove(${physicianId})">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
            </svg>
        </button> 
     </div>
</div>`
  toDoLists.insertAdjacentHTML('beforeend', elements);
  physicianId++;
});

function remove(physicianId) {
  
  $("#referringAddPhysician"+physicianId).remove();
}






/////////////////////////


// function setStartDateTime() {
//   document.getElementById("startDateTime").value = "2014-01-02T11:42:13.510";
// }

// $(function() {
//     $('#start_date').datetimepicker({ 
//             format: 'YYYY-MM-DD HH:mm', 
//             stepping: 60, 
//             collapse: false, 
//             sideBySide: true
//             });
//     });

// $(function() {
//     $('#end_date').datetimepicker({ 
//             format: 'YYYY-MM-DD HH:mm', 
//             stepping: 60, 
//             collapse: false, 
//             sideBySide: true});
// });

</script>  
@endsection
@section('style')

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    
<style>

/* label {
    display: inline-block;
    width: 100px;
} */

tr {
height: 50px;
}

.modal-body {
max-height: calc(100vh - 210px);
overflow-y: auto;
}


input[type='radio'] { 
 transform: scale(2); 
}



</style>
@endsection
