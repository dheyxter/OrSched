@extends('pain.layouts.master')
@section('content')
<head>
   <title>PAIN CALENDAR</title>
</head>
<body id='painBody'>
<link href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/toasty.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/toasty.js"></script>
   <div class="container">
<link href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/toasty.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/toasty.js"></script>


<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center"> 
            <button type="button" id="successtoast" class="btn btn-success btn-icon-text" hidden> 
                <i class="fa fa-check btn-icon-prepend"></i>Toast Notification success</button> 
            <button type="button" id="infotoast" class="btn btn-info btn-icon-text" hidden> 
                <i class="fa fa-check btn-icon-prepend"></i>Toast Notification info</button> 
            <button type="button" id="warningtoast" class="btn btn-warning btn-icon-text" hidden> 
                <i class="fa fa-check btn-icon-prepend"></i>Toast Notification warning</button>
            <button type="button" id="errortoast" class="btn btn-primary btn-icon-text" hidden> 
                <i class="fa fa-check btn-icon-prepend"></i>Toast Notification error</button>
         </div>
    </div>
</div>

      <!--  -->
      <!-- VIEW SCHEDULE MODAL -->
      <div id="ViewModal" class="modal fade">
         <div class="modal-dialog modal-xl">
         <div class="modal-content">
            <div class="modal-header">
            <form>
                <div class="form-group">
            <h3 id="myModalLabel1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar2-event" viewBox="0 0 16 16">
            <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
            <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z"/>
            </svg> <i><b> EDIT LOG </b></i></h3>
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
                              <label for="apptStartTime" class="col-sm-3 col-form-label">Start Schedule:
                              </label>
                              <div class="col-sm-9">
                                 <input type="datetime-local" class="form-control" id="apptStartTime" required disabled/>
                              </div>
                              
                           </div>
                           <div class="form-group row">
                              <label for="apptEndTime" class="col-sm-3 col-form-label">End Schedule:
                              </label>
                              <div class="col-sm-9">
                                 <input type="datetime-local" class="form-control" id="apptEndTime" required disabled/>
                              </div>
                              
                        </div>
                    <div id="toEditDiv">
                        
                        <div class="form-group row">
                            <label for="painDiagnosis" class="col-sm-3 col-form-label" >Pain Diagnosis:</label>
                                <div class="col-sm-9">
                                <textarea class="form-control" id="painDiagnosis" rows="2" disabled></textarea>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="management" class="col-sm-3 col-form-label" >Management:</label>
                                <div class="col-sm-9">
                                <textarea class="form-control" id="management" rows="2" disabled></textarea>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="disposition" class="col-sm-3 col-form-label" >Disposition:
                            </label>
                                
                                <div class="col-sm-9">
                                <input type="text" class="form-control" id="disposition" disabled>
                                </div>

                        </div> 
                        <div class="form-group row">
                            <label for="referringPhysician" class="col-sm-3 col-form-label" >Referring Physician:
                            </label>
                                
                                <div class="col-sm-9">
                                <input type="text" class="form-control" id="referringPhysician" disabled>
                                </div>

                        </div>    

                        <div class="form-group row">
                            <label for="painCODROD" class="col-sm-3 col-form-label" >Pain COD/ROD:
                            </label>
                                
                                <div class="col-sm-9">
                                <input type="text" class="form-control" id="painCODROD" disabled>
                                </div>

                        </div>  
                        </div>   
                    <fieldset>
                     <div>
                     <legend><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg> <b> LOGGING DETAILS</b></legend>
                        <div class="form-group row">
                                <label for="loginDateTime" class="col-sm-3 col-form-label">Login Date & Time: </label>
                                <div class="col-sm-9">
                                <input type="datetime-local" class="form-control" id="loginDateTime" required disabled />
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="logged_by_name" class="col-sm-3 col-form-label">Logged by: </label>
                        <div class="col-sm-9">
                            <input type="input" class="form-control" id="logged_by_name" value="{{App\Http\Controllers\LoggedUser::getUser()}}" required disabled/>
                        </div>
                     </div>   
                     
                     </fieldset>
                        
                   
                    
                </form>
               

            </div>
            <div class="modal-footer">                
                    <div class="modal-footer">
                            <div class="btn-toolbar class=" visible role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group mr-2" role="group" aria-label="First group" id="viewSave">                    
                                    <button class="btn btn-primary" type="button"  id="saveScheduleButton" disabled>
                                    Save</button>  
                                            
                                    </div>
                                    <div class="btn-group mr-2" role="group" aria-label="Second group">
                                    <button type="button" class="btn btn-primary" id="editScheduleButton">Edit</button>
                                    <button type="button" class="btn btn-danger" id="deleteScheduleButton" >Delete</button>
                                    </div>
                            </div>
                    </div>
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
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <script>
var options = {

                autoClose: true,
                progressBar: true,
                enableSounds: true,
                sounds: {

                info: "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233294/info.mp3",
                // path to sound for successfull message:
                success: "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233524/success.mp3",
                // path to sound for warn message:
                warning: "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233563/warning.mp3",
                // path to sound for error message:
                error: "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233574/error.mp3",
                },
                };
var toast = new Toasty(options);
toast.configure(options);
// $('#successtoast').click(function() {toast.success("Schedule has been added");});
// $('#infotoast').click(function() {toast.info("Schedule Date and Timehave been updated");});
// $('#warningtoast').click(function() {toast.warning("Schedule Details have been updated");});
// $('#errortoast').click(function() {toast.error("This toast notification with sound");});

    // Enable pusher logging - don't include this in production
    
    Pusher.logToConsole = true;

    var pusher = new Pusher('10e718234a044bf1887b', {
      cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {


        let notificationMessage = JSON.parse(JSON.stringify(data.message.message));
        let notificationType = JSON.parse(JSON.stringify(data.message.type));
        var calendar = $('#calendar').fullCalendar({});
        if(notificationType == "painUpdateTime"){
            changeTitle();
            alertToast(notificationMessage,"info");
            $('#infotoast').click();
            toast.info("Schedule Date and Time have been updated");

            calendar.fullCalendar('refetchEvents');     
        }else if(notificationType =="painUpdateDetails"){
            changeTitle();
            alertToast(notificationMessage,"warning");
            $('#warningtoast').click();
            toast.warning("Schedule Details have been updated");
            calendar.fullCalendar('refetchEvents');

        }else if(notificationType =="painAddSchedule"){
            changeTitle();
            alertToast(notificationMessage,"success");
            $('#successtoast').click();
            toast.success("Schedule has been added");
            calendar.fullCalendar('refetchEvents');
        }else{
            changeTitle();
            calendar.fullCalendar('refetchEvents');
        }
        

    
    });
    
let countNotification = 0;
	
var title = document.title;
function changeTitle() {
    countNotification++;
        var newTitle = '(' + countNotification + ') ' + title;
        document.title = newTitle;
}
var alertPlaceholder = document.getElementById('liveAlertPlaceholder')

function alertToast(message, type) {
  var wrapper = document.createElement('div')
  wrapper.innerHTML = '<div class="alert alert-' + type +' alert-dismissible ">' +
    '<a href="#" class="close" data-dismiss="alert" aria-label="close" "><button class="alert-danger" onclick="removeNotification()">&times;</button></a>' +
    '<h4 class="blink_me"><strong>Alert!</strong></h4> <br><strong>' + message + '</strong</div>';
  alertPlaceholder.append(wrapper)

}
function removeNotification(){
    countNotification--;
        if(countNotification == 0){
            var newTitle = title;
        }else{
            var newTitle = '(' + countNotification + ') ' + title;
        }
        
        document.title = newTitle;
}

</script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>       
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.rawgit.com/PascaleBeier/bootstrap-validate/v2.2.5/dist/bootstrap-validate.js" ></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
   $(document).ready(function () {
    
//    $(document).on('show.bs.modal', '#ViewModal', function (e) {
//        console.log('view modal open');
      
   
//    });

function validateInputs(eventId){
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

        // console.log("patientName: " + validPatientName);
        // console.log('validPainDiagnosis '+  validPainDiagnosis);
        // console.log('validManagement ' + validManagement);
        // console.log('validDisposition ' + validDisposition);
        // console.log('validReferringPhysician ' + validReferringPhysician);
        // console.log('validPainCODROD' + validPainCODROD);

        if(validPatientName && validPainDiagnosis && validManagement && validDisposition && validReferringPhysician && validPainCODROD ){
            doSubmitUpdate(eventId);
            
            return true;
        }else{
            alert("Please fill up the required fields!");
            return false;
        }
    }

//    $('#viewFormSchedule').submit(function(e){
//       // e.preventDefault();
//        console.log("submitted");
//    })
   
   
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
            right:'listMonth, month'
            },
            slotDuration: '01:00:00',
            agendaEventMinHeight: 0,
            defaultView:'month',
            events:'/painScheduler',
            selectable:true,
            selectHelper: true,      
            displayEventTime: false,  
            weekends: true,
            buttonText: {                
                listMonth: 'Month List View',
                month: 'Month Calendar View'
           },       

           editable:true,
           eventResize: function(event, delta)
           {
               
               var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
               var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
               var title = event.title;
               var id = event.id;
               $.ajax({
                   url:"/painHome/action",
                   type:"POST",
                   data:{
                       title: title,
                       start: start,
                       end: end,
                       id: id,
                       patientpainHpercode:$('#patientPainHpercode').val(),
                       type: 'update'
                   },
                   success:function(response)
                   {
                       calendar.fullCalendar('refetchEvents');
                       //displayMessage("Schedule Updated Successfully");
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
                   url:"/painHome/action",
                   type:"POST",
                   data:{
                       title: title,
                       start: start,
                       end: end,
                       id: id,
                       patientPainHpercode:$('#patientPainHpercode').val(),
                       type: 'update'
                   },
                   success:function(response)
                   {
                       calendar.fullCalendar('refetchEvents');
                      // displayMessage("Schedule Updated Successfully");
                   }
               })
           },
   
           eventClick:function(calEvent, jsEvent, view)
           {
               var eventId = calEvent.id;
               
               $('#ViewModal').modal('show');
               console.log("event id: " + eventId.toString());
                $.ajax({
                   url:"/painHome/action",
                        type:"POST",
                        data:{
                        id:eventId,
                        type:'edit'
                        },
                        cache: false,
                        success:function(response)
                        {
                            console.log(response[0]);
                            calendar.fullCalendar('refetchEvents');
                            var patientName =   response[0].patient_lastname.concat(", ") 
                                                .concat(response[0].patient_firstname).concat(" ")
                                                .concat(response[0].patient_middlename);
                            $('#enccode').val(response[0].enccode);
                            $('#apptStartTime').val(response[0].start.split(' ').join('T'));
                            $('#apptEndTime').val(response[0].end.split(' ').join('T'));
                            $('#patientName').val(patientName);                            
                            $('#patientAge').val(response[0].patient_age);
                            switch(response[0].patient_sex){
                                case 'M':  $('#patientSex').val('Male'); break;
                                case 'F':  $('#patientSex').val('Female'); break;   
                                }                           
                            $('#patientPainHpercode').val(response[0].patientPainHpercode);                            
                            $('#patientPainHpercode').val(response[0].patientPainHpercode);                           
                           
                            $('#painDiagnosis').val(response[0].pain_diagnosis);
                            $('#management').val(response[0].management); 
                            $('#disposition').val(response[0].disposition);
                            $('#referringPhysician').val(response[0].referringPhysician);
                            $('#painCODROD').val(response[0].painCODROD)        
                            var logindateTime = moment(response[0].updated_at).utcOffset('+8:00').format('YYYY-MM-DDTHH:mm:ss');
                            $('#loginDateTime').val(logindateTime);
                            $('#ViewModal').on('hidden.bs.modal', function () {
                                
                            //     var dt = new Date(response[0].updated_at.split('.')[0]);
                            // alert(dt.toLocaleString());
                            
                        });
    
                           
                       }   
                    })   
                                   
                $( "#editScheduleButton" ).click(function() {                   
                    $("#toEditDiv :input").prop("disabled", false);
                    $("#saveScheduleButton").prop("disabled",false);
                    
                    $('#viewFormSchedule').find(':input[type=submit]').prop("disabled", false);
                      
                 });

                 $( "#saveScheduleButton" ).click(function() {     
                    validateInputs(eventId);
                 });
               
                 
                                   
                 deleteEvent(eventId);            
                  //$('#ViewModal').modal('hide');  
   
           }
           
       });
       // $('#submitButton').on('click', function(e){
       // // We don't want this to act as a link so cancel the link action
       // e.preventDefault();
   
       // doSubmitCreate();
       // });
   
       
   function deleteEvent(id){
    if(id)  {

    
    $(document).unbind('click').on("click", "#deleteScheduleButton", function(event){   
                event.preventDefault();
                
                   $('#deleteConfirmationModal').modal('show');   
                       $('#deleteConfirmed').on('click', function(event){ 
                        event.preventDefault();
                           
                           $.ajax({
                               url:"/painHome/action/delete",
                               type:"POST",
                               data:{
                                   id:id,
                                   type:"delete",
                                   enccode:$('#enccode').val(),
                                   patientPainHpercode:$('#patientPainHpercode').val()
                                   },
                               cache: false,
                               statusCode: {
                                    200: function (data) {
                                        
                                        $('#deleteConfirmationModal').modal('hide');  
                                        $('#ViewModal').modal('hide');   
                                    
                                        console.log("deleted!");
                                        //displayMessage("Schedule Deleted Successfully");
                                        calendar.fullCalendar('refetchEvents');
                                        //location.reload();        
                                    },
                                    208: function (data) {
                                        consle.log('208: Error');
                                       
                                    }
                                }

                           })                                
                       
                      
                               
                   });            
                  
               }); 

    } 
   }
   
   function doSubmitUpdate(eventId){
       
    //alert("Success!");
    
    console.log($('#patientName').val() + " - " + $('#painDiagnosis').val());
    
    console.log($('#painDiagnosis').val());
    console.log($('#management').val());
    console.log($('#disposition').val());
    console.log($('#referringPhysician').val());
    console.log($('#painCODROD').val());
    
        
    
            $.ajax({
                    url:"/painHome/action",
                    type:"POST",
                    data:{
                        id:eventId,
                        title: $('#patientName').val() + " - " + $('#painDiagnosis').val(),
                        start: $('#apptStartTime').val().split('T').join(' '),
                        end: $('#apptEndTime').val().split('T').join(' '),
                        enccode:$('#enccode').val(), 
                        patientPainHpercode:$('#patientPainHpercode').val(), 
                        painDiagnosis:$('#painDiagnosis').val(),
                        management : $('#management').val(), 
                        disposition :$('#disposition').val(),
                        referringPhysician: $('#referringPhysician').val(),
                        painCODROD:  $('#painCODROD').val(),          
                        type: 'editUpdate'
                    },
                    success:function(data)
                    {
                        calendar.fullCalendar('refetchEvents');
                        //displayMessage("Schedule Created Successfully");
                        $("#ViewModal").modal('hide');
                        //window.location='painHome';
                    }
                })
      };
   
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
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	

<style>
   /* label {
   display: inline-block;
   width: 100px;
   } */

   .modal-body {
   max-height: calc(100vh - 210px);
   overflow-y: auto;
   }
   input[type='radio'] { 
   transform: scale(2); 
   
   }

   .blink_me {
  animation: blinker 2s step-start infinite;
}

    @keyframes blinker {
    30% {
        opacity: 0;
    }
    }
    .btn {
    margin-right: 0.5rem !important
}



.toast {
    transition: all 0.1s ease-in-out;
    position: relative;
    padding: 16px;
    border: 5px solid;
    font-size: large;

}
.toast-container--fade {
    right: 0;
    top: 0
}

   
</style>
@endsection