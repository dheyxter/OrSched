@extends('pain.layouts.master')
@section('content')

<head>
    <title>PAIN SCHEDULER</title>

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
            </svg> <i><b> CREATE LOG </b></i></h3>
            <p style="color:red" id="svc_pvt_validation">* Please fill out the required fields</p>
            
            <!-- <div class="control-group">
                    <label class="control-label" for="when">When:</label>
                    <div class="controls controls-row" id="when" style="margin-top:5px;">
                    </div>
            </div> -->
                 </div>
            </form>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <div class="modal-body"> 
                
                <form>
                    <div class="form-group row">
                        <label for="patientName" class="col-sm-3 col-form-label" >Patient Name:</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="patientName"  value="{{$patientName}}"disabled>
                        <input type="text" class="form-control" id="enccode"  value="{{$enccode}}" hidden>
                        <input type="text" class="form-control" id="patientPainHpercode"  value="{{$patientPainHpercode}}" hidden >

                        </div>
                    </div>
                    <div class="form-group row">
                           <label for="patientAge" class="col-sm-3 col-form-label" >Patient Age:</label>
                           <div class="col-sm-3">
                              <input type="text" class="form-control" id="patientAge" value = "{{$patientAge}}" disabled>
                           </div>
                           <label for="patientSex" class="col-sm-3 col-form-label" >Patient Sex:</label>
                           <div class="col-sm-3">
                                @if($patientSex == "M")
                                    <input type="text" class="form-control" id="patientSex" value="Male" disabled>
                                @else
                                    <input type="text" class="form-control" id="patientSex" value="Female" disabled>  
                                @endif
                           </div>
                    </div>
                      
                    <div class="form-group row">
                        <label for="painDiagnosis" class="col-sm-3 col-form-label" >Pain Diagnosis:</label>
                            <div class="col-sm-9">
                            <textarea class="form-control" id="painDiagnosis" rows="2"></textarea>
                            </div>
                    </div>
                    <div class="form-group row">
                        <label for="management" class="col-sm-3 col-form-label" >Management:</label>
                            <div class="col-sm-9">
                            <textarea class="form-control" id="management" rows="2"></textarea>
                            </div>
                    </div>
                    <div class="form-group row">
                        <label for="disposition" class="col-sm-3 col-form-label" >Disposition:
                        </label>
                            
                            <div class="col-sm-9">
                            <input type="text" class="form-control" id="disposition" >
                            </div>

                    </div> 
                    <div class="form-group row">
                        <label for="referringPhysician" class="col-sm-3 col-form-label" >Referring Physician:
                        </label>
                            
                            <div class="col-sm-9">
                            <input type="text" class="form-control" id="referringPhysician" >
                            </div>

                    </div>    

                    <div class="form-group row">
                        <label for="painCODROD" class="col-sm-3 col-form-label" >Pain COD/ROD:
                        </label>
                            
                            <div class="col-sm-9">
                            <input type="text" class="form-control" id="painCODROD" >
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




  
</body>

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
       
    function validateInputs(start,end){
        console.log("validate!!!");
        let validPatientName = $('#patientName').val().length > 0;
        let validPainDiagnosis = !($('#painDiagnosis').val().length === 0);
        let validManagement = !($('#management').val().length === 0);
        let validDisposition = !($('#disposition').val().length === 0);
        let validReferringPhysician = !($('#referringPhysician').val().length === 0);
        let validPainCODROD = !($('#painCODROD').val().length === 0);

        if(!validPainDiagnosis){
            $('#painDiagnosis').css( "border", "1.5px solid red");
            
        }

        if(!validManagement){
            $('#management').css( "border", "1.5px solid red");
        }

        if(!validDisposition){
            $('#disposition').css( "border", "1.5px solid red");
        }

        if(!validReferringPhysician){
            $('#referringPhysician').css( "border", "1.5px solid red");
        }

        if(!validPainCODROD){
            $('#painCODROD').css( "border", "1.5px solid red");
        }

      
        ////////////////////////////////////////////////////////
        $("#painDiagnosis").on("input", function() {
            if($(this).val().length === 0){
                $('#painDiagnosis').css( "border", "1.5px solid red ");
                validPainDiagnosis = false;               
            }               
            else{
                $('#painDiagnosis').css( "border", "1px solid rgba(0,0,0,.2)");
                validPainDiagnosis = true;               
            }
        });

        $("#management").on("input", function() {
            if($(this).val().length === 0){
                $('#management').css( "border", "1.5px solid red ");
                validManagement = false;               
            }               
            else{
                $('#management').css( "border", "1px solid rgba(0,0,0,.2)");
                validManagement = true;               
            }
        });

        $("#disposition").on("input", function() {
            if($(this).val().length === 0){
                $('#disposition').css( "border", "1.5px solid red ");
                validDisposition = false;               
            }               
            else{
                $('#disposition').css( "border", "1px solid rgba(0,0,0,.2)");
                validDisposition = true;               
            }
        });

        $("#referringPhysician").on("input", function() {
            if($(this).val().length === 0){
                $('#referringPhysician').css( "border", "1.5px solid red ");
                validReferringPhysician = false;               
            }               
            else{
                $('#referringPhysician').css( "border", "1px solid rgba(0,0,0,.2)");
                validReferringPhysician = true;               
            }
        });

        $("#painCODROD").on("input", function() {
            if($(this).val().length === 0){
                $('#painCODROD').css( "border", "1.5px solid red ");
                validPainCODROD = false;               
            }               
            else{
                $('#painCODROD').css( "border", "1px solid rgba(0,0,0,.2)");
                validPainCODROD = true;               
            }
        });

        console.log("patientName: " + validPatientName);
        console.log('validPainDiagnosis '+  validPainDiagnosis);
        console.log('validManagement ' + validManagement);
        console.log('validDisposition ' + validDisposition);
        console.log('validReferringPhysician ' + validReferringPhysician);
        console.log('validPainCODROD' + validPainCODROD);

        if(validPatientName && validPainDiagnosis && validManagement && validDisposition && validReferringPhysician && validPainCODROD ){
            doSubmitCreate(start,end);
            return true;
        }else{
            alert("Please fill up the required fields!");
            return false;
        }
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
            right:'month'
        },
        slotDuration: '01:00:00',
        agendaEventMinHeight: 0,
        defaultView:'month',
        events:'/painScheduler',
        selectable:true,
        selectHelper: true,      
        displayEventTime: false,          
        buttonText: {                
                
                month: 'Month Calendar View'
           },
        select:function(start, end, allDay)
        { 
            var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');

            var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');           
            

            $('#createEventModal').modal('show');
           
            $('#submitButton').on('click', function(e){ 
                e.preventDefault();
                validateInputs(start,end);
                
                    

             });
                      
            
        },
        editable:true,
        eventResize: function(event, delta)
        {
            
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            var title = event.title;
            var id = event.id;
            $.ajax({
                url:"/painScheduler/action",
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
                url:"/painScheduler/action",
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
        // eventClick: function(calEvent, jsEvent, view) {

        //     alert('Event: ' + calEvent.title);
        //     alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
        //     alert('View: ' + view.name);

        //     // change the border color just for fun
        //     $(this).css('border-color', 'red');

        //     }
        // eventClick:function(event)
        // {
        //     var eventId = event.id;
        //     console.log(JSON.stringify(eventId));
        //     $('#ViewModal').modal('show');
        //     console.log("event id: " + eventId.toString());
        //      $.ajax({
        //         url:"/painScheduler/action",
        //             type:"POST",
        //             data:{
        //             id:eventId,
        //             type:'edit'
        //             },
        //             cache: false,
        //             success:function(response)
        //             {
        //                 calendar.fullCalendar('refetchEvents');
        //                 displayMessage("Schedule Edited Successfully");
        //                 //location.reload();
        //             }
        //             })   
                                
        //          $( "#editScheduleButton" ).click(function() {
                   
        //                     $("#viewFormSchedule :input").prop("disabled", false);
        //                     $("#saveScheduleButton").css('visibility','visible'); 
                            
                               
        //             // $('#deleteScheduleButton').on('click', function(event){   
        //             //     console.log("event id to be edited: " + id);
        //             //     $('#deleteConfirmationModal').modal('show');        
                        
                        
        //             // $('#deleteConfirmed').on('click', function(event){ 
        //             //     console.log("deleted!");
        //             //     $.ajax({
        //             //                 url:"/painScheduler/action",
        //             //                 type:"POST",
        //             //                 data:{
        //             //                     id:id,
        //             //                     type:"delete"
        //             //                 },
        //             //                 cache: false,
        //             //                 success:function(response)
        //             //                 {
        //             //                     calendar.fullCalendar('refetchEvents');
        //             //                     displayMessage("Schedule Deleted Successfully");
        //             //                     location.reload();
        //             //                 }
        //             //             })                                
        //             //              $('#deleteConfirmationModal').modal('hide');  
        //             //          });              
                          
        //        //$('#ViewModal').modal('hide');  
        //     });

        // }
        
    });
    

    $(document).on('show.bs.modal', '#createEventModal', function (e) {
        console.log('create modal open');
    });


    console.log("check svc_pvt: " +$('input[name="svc_pvt"]:checked').val());    
    

  function doSubmitCreate(start,end){
   
    console.log(start);
    console.log($('#patientName').val() + " - " + $('#painDiagnosis').val());
    console.log(end);
    console.log($('#painDiagnosis').val());
    console.log($('#management').val());
    console.log($('#disposition').val());
    console.log($('#referringPhysician').val());
    console.log($('#painCODROD').val());
    
        
    
            $.ajax({
                    url:"/painScheduler/action",
                    type:"POST",
                    data:{
                        title: $('#patientName').val() + " - " + $('#painDiagnosis').val(),
                        start: start,
                        end: end,
                        enccode:$('#enccode').val(), 
                        patientPainHpercode:$('#patientPainHpercode').val(), 
                        painDiagnosis:$('#painDiagnosis').val(),
                        management : $('#management').val(), 
                        disposition :$('#disposition').val(),
                        referringPhysician: $('#referringPhysician').val(),
                        painCODROD:  $('#painCODROD').val(),          
                        type: 'add'
                    },
                    success:function(data)
                    {
                        calendar.fullCalendar('refetchEvents');
                        displayMessage("Schedule Created Successfully");
                        $("#createEventModal").modal('hide');
                        window.location='painHome';
                    }
                })
   }
});


function displayMessage(message) {
    toastr.success(message, 'Event');
} 



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

/* tr {
height: 50px;
} */

.modal-body {
max-height: calc(100vh - 210px);
overflow-y: auto;
}


input[type='radio'] { 
 transform: scale(2); 
}



</style>
@endsection
