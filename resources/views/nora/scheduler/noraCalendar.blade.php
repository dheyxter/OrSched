@extends('nora.layouts.master')
@section('content')
<head>

   <title>NON-OPERATIONAL ROOM ANESTHESIOLOGY</title>

</head>
<body>
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

   <div class="container">
      <!--  -->
      <!-- VIEW SCHEDULE MODAL -->
      <div id="ViewModal" class="modal fade">
         <div class="modal-dialog modal-xl">
            <div class="modal-content">
               <div class="modal-header">
                  <form>
                     <div class="form-group">
                        <h3 id="viewModal1">
                           <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                              <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                              <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                           </svg>
                           <b><i>ViEW SCHEDULE</i></b>
                        </h3>
                     </div>
                  </form >
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
               </div>
               <form id="viewFormSchedule" class="needs-validation"  novalidate>
                  <div class="modal-body">
                     <fieldset>
                        <legend>
                           <b>
                              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                                 <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
                              </svg>
                              Patient Details: 
                           </b>
                        </legend>
                        <div class="form-group row">
                           <label for="patientName" class="col-sm-3 col-form-label" >Patient Name:</label>
                           <div class="col-sm-9">
                              <input type="text" class="form-control" id="patientName"  disabled>
                              <input type="text" class="form-control" id="enccode"  value="{{$enccode}}" hidden >
                              <input type="text" class="form-control" id="patientNoraHpercode"  value="{{$patientNoraHpercode}}" hidden >
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="patientRoom" class="col-sm-3 col-form-label" >Room:</label>
                           <div class="col-sm-9">
                              <input type="text" class="form-control" id="patientRoom"   disabled>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="patientAge" class="col-sm-3 col-form-label" >Patient Age:</label>
                           <div class="col-sm-3">
                              <input type="text" class="form-control" id="patientAge" disabled>
                           </div>
                           <label for="patientSex" class="col-sm-3 col-form-label" >Patient Sex:</label>
                           <div class="col-sm-3">
                              <input type="text" class="form-control" id="patientSex" disabled>
                           </div>
                        </div>
                     </fieldset>
                     <div id="toEditDiv">
                        <fieldset>
                           <legend>
                              <b>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar-event" viewBox="0 0 16 16">
                                    <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                 </svg>
                                 Schedule Details: 
                              </b>
                           </legend>
                           <div class="form-group row" >
                              <label for="serviceType" class="col-sm-3 col-form-label">Service Type:</label>
                              
                              <div class="col-sm-9">
                                @if($userRole == 1)
                                    <input type="text" class="form-control" id="serviceType"  disabled>
                                @else   
                                <select class="form-control form-control-lg" id="serviceType"  required disabled>
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
                           
                        </fieldset>
                        <div class="form-group row">
                           <label for="inductionTime" class="col-sm-3 col-form-label">Induction Time: </label>
                           <div class="col-sm-4">
                              <input type="time" class="form-control" id="inductionTime" required disabled/>
                           </div>
                          
                           <label for="durationTime" class="col-sm-3 col-form-label">Duration Time (hr):</label>
                           <div class="col-sm-2">
                              <input type="number" class="form-control" id="durationTime" step="0.1" required disabled>
                           </div>
                           
                        </div>
                        <div class="form-group row">
                           <label for="patientProcedure" class="col-sm-3 col-form-label" >Procedure:</label>
                           <div class="col-sm-9">
                              <textarea class="form-control" id="patientProcedure" rows="2" required disabled style=></textarea>
                           </div>
                           
                        </div>
                        <div class="form-group row">
                           <label for="referringAddPhysicianInput1" class="col-sm-3 col-form-label" id="addPhysicianLabelId">Referring Physician:
                           </label>
                           <div class="col-sm-7">
                              <input type="text" class="form-control" id="referringAddPhysicianInput1" required disabled>
                           </div>
                           
                           <div class="col-sm-2">
                              <button type="button" class="btn btn-info" id="addPhysicianButton" required disabled>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                 </svg>
                              </button>
                           </div>
                        </div>
                        <div id="addPhysician">
                        </div>
                        <div class="form-group row" id="anesthesiologistDiv">
                           <label for="anesthesiologist" class="col-sm-3 col-form-label" >Anesthesiologist:</label>
                           <div class="col-sm-9">
                              <select class="form-control form-control-lg" id="anesthesiologist" required disabled>
                                 <option value="" selected disabled hidden id>Choose here</option>
                                 @foreach(\App\Http\Controllers\Nora\NoraHomeController::anestheologistList() as $a)                                                                
                                 <option value="{{$a->firstname}} {{$a->middlename}} {{$a->lastname}}">
                                    {{$a->lastname}}, {{$a->firstname}} {{$a->middlename}},
                                    {{$a->empdegree}} | {{$a->tsdesc}}
                                 </option>
                                 @endforeach
                              </select>
                           </div>
                          
                        </div>
                        <div class="form-group row">
                           <label for="referral_received" class="col-sm-3 col-form-label">Referral Received (FOR ANES ONLY)  </label>
                           <div class="col-sm-9">
                              <input type="input" class="form-control" id="referral_received" required disabled/>
                           </div>
                        </div>
                        <div class ="form-group row">
                           <label for="svc_pvt" class="col-sm-3 col-form-label" >SVC/PVT:</label>
                           <div class="col-sm-9">
                              <div class="custom-control custom-radio custom-control-inline">
                                 <input type="radio" id="SVC" name="svc_pvt" class="custom-control-input" value="SVC" disabled>
                                 <label class="custom-control-label" for="SVC">SVC</label>
                              </div>
                              <div class="custom-control custom-radio custom-control-inline">
                                 <input type="radio" id="PVT" name="svc_pvt" class="custom-control-input" value="PVT" disabled>
                                 <label class="custom-control-label" for="PVT">PVT</label>
                              </div>
                           </div>
                        </div>
                    <fieldset>
                     </div>
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
                     <div class="form-group row">
                     <label for="logged_by_department" class="col-sm-3 col-form-label">Department: </label>
                     <div class="col-sm-9">
                     <input type="input" class="form-control" id="logged_by_department" required disabled/>
                     </div>
                     </div> 
                     </fieldset>   
                  </div>
                  <div class="modal-footer">
                     <div class="btn-toolbar class=" visible role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="First group" id="viewSave">                    
                           <button class="btn btn-primary" type="button"  id="saveScheduleButton" disabled>
                           Save</button>  
                                 
                        </div>
                        <div class="btn-group mr-2" role="group" aria-label="Second group">
                           <button type="button" class="btn btn-primary" id="editScheduleButton">Edit</button>
                           <button type="submit" class="btn btn-danger" id="deleteScheduleButton" >Delete</button>
                        </div>
                     </div>
                  </div>
               </form>
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
        if(notificationType == "noraUpdateTime"){
            
            alertToast(notificationMessage,"info");
            $('#infotoast').click();
            toast.info("Schedule Date and Time have been updated");

            calendar.fullCalendar('refetchEvents');     
        }else if(notificationType =="noraUpdateDetails"){
            
            alertToast(notificationMessage,"warning");
            $('#warningtoast').click();
            toast.warning("Schedule Details have been updated");
            calendar.fullCalendar('refetchEvents');
        }else if(notificationType =="noraAddSchedule"){
            
            alertToast(notificationMessage,"success");
            $('#successtoast').click();
            toast.success("Schedule has been added");
            calendar.fullCalendar('refetchEvents');
        }
        
   
    });
    

    var alertPlaceholder = document.getElementById('liveAlertPlaceholder')

function alertToast(message, type) {
  var wrapper = document.createElement('div')
  wrapper.innerHTML = '<div class="alert alert-' + type +' alert-dismissible ">' +
    '<a href="#" class="close" data-dismiss="alert" aria-label="close" "><button class="alert-danger" id="refetchCalendar">&times;</button></a>' +
    '<h4 class="blink_me"><strong>Alert!</strong></h4> <br><strong>' + message + '</strong</div>';
  alertPlaceholder.append(wrapper)

}


  </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>       
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.rawgit.com/PascaleBeier/bootstrap-validate/v2.2.5/dist/bootstrap-validate.js" ></script>
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/toasty.js"></script>
<script>
 $(document).ready(function () {






$.ajaxSetup({
           headers:{
               'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
           }
       });

    function validateInputs(eventId){
        let validStartTime = !($('#apptStartTime').val().length === 0) ;
        let validEndTime = !($('#apptEndTime').val().length === 0) ;
        let validServiceType = !($('#serviceType').length === 0);
        let validInductionTime = !($('#inductionTime').val().length === 0) ;
        let validDurationTime = !($('#durationTime').val().length === 0) ;
        let validPatientProcedure = !($('#patientProcedure').val().length === 0) ;
        let validReferPhysician = !($('#referringAddPhysicianInput1').val().length === 0) ;
        let validAnesthesiologist = !($('#anesthesiologist').val().length === 0) ;
        let validReferralReceived = !($('#referral_received').val().length === 0) ;
       
        if(!(validStartTime)){
            $('#apptStartTime').css( "border", "1.5px solid red");
        }

        if(!(validEndTime)){
            $('#apptEndTime').css( "border", "1.5px solid red");
        }

        if(!(validServiceType)){
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

        if(!(validReferralReceived)){
            $('#referral_received').css( "border", "1.5px solid red ");
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
            console.log("apptStartTime: " + validStartTime);
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
            console.log("apptEndTime: " + validEndTime);
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
            console.log("serviceType: " + validServiceType);
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
            console.log("inductionTime: " + validInductionTime);
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
            console.log("durationTime: " + validDurationTime);
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
            console.log("referringAddPhysicianInput1: " + validReferPhysician);
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
            console.log("patientProcedure: " + validPatientProcedure);
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
            console.log("anesthesiologist: " + validAnesthesiologist);
        });

        $("#referral_received").on("input", function() {
            if($(this).val().length === 0){
                $('#referral_received').css( "border", "1.5px solid red ");
                validReferralReceived = false;
            }               
            else{
                $('#referral_received').css( "border", "1px solid rgba(0,0,0,.2)");
                validReferralReceived = true;
            }
            console.log("referral_received: " + validReferralReceived);
        });

        let proceedSave = false;

        
        

        $('#saveScheduleButton').on('click', function(e){    
            console.log('validStartTime: ' + validStartTime)
            console.log('validEndTime: ' + validEndTime)
            console.log('validServiceType: ' + validServiceType)
            console.log('validInductionTime: ' +validInductionTime)
            console.log('validDurationTime: ' + validDurationTime)
            console.log('validPatientProcedure: ' + validPatientProcedure)
            console.log('validReferPhysician: ' + validReferPhysician)
            console.log('validAnesthesiologist: ' +validAnesthesiologist)
            console.log('validReferralReceived: ' +validReferralReceived)
             e.preventDefault();
             if(validStartTime &&
                    validEndTime &&
                    validServiceType &&
                    validInductionTime &&
                    validDurationTime &&
                    validPatientProcedure &&
                    validReferPhysician &&
                    validAnesthesiologist &&
                    validReferralReceived ){
                        //alert("You will be safe here!!!");
                        doSubmitUpdate(eventId);
                        
                        $("#toEditDiv :input").prop("disabled", false);
                         $('#ViewModal').modal('hide');
                        proceedSave = true;
                    }else{
                        alert("Please fill up the required fields !!" );
                    }   

        });
    }

//    $('#viewFormSchedule').submit(function(e){
//       // e.preventDefault();
//        console.log("submitted");
//    })
   
   
      
       
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
               right:'listWeek,listDay,month,agendaWeek,agendaDay'
           },
           buttonText: {   
                listWeek:'List Schedule Weekly',      
                listDay: 'List Schedule Daily'                
           },   
           eventOrder: 'title',
           slotDuration: '01:00:00',
           agendaEventMinHeight: 0,
           defaultView:'agendaWeek',
           events:'/noraHome',
           selectable:false,
           selectHelper: true,        
           select:function(start, end, allDay)
           { 
               var view = $('#calendar').fullCalendar('getView');
               if(view.type == 'month'){
                   console.log('month');
                   endtime = $.fullCalendar.formatDate(start,'Y-MM-DD HH:mm:ss');
               }else{
                   console.log(view.type);
                   endtime = $.fullCalendar.formatDate(end,'Y-MM-DD HH:mm:ss');
               }            
               starttime = $.fullCalendar.formatDate(start,'Y-MM-DD HH:mm:ss');
               var mywhen = starttime + ' - ' + endtime;
               console.log(starttime);
               
               var startTimeParsed = starttime.split(' ').join('T');
               var endTimeParsed = endtime.split(' ').join('T');
   
               var duration = (Date.parse(endTimeParsed)-Date.parse(startTimeParsed))/3600000
   
               $('#createEventModal #apptStartTime').val(startTimeParsed);
               $('#createEventModal #apptEndTime').val(endTimeParsed);
               $('#createEventModal #apptAllDay').val(allDay);
               $('#createEventModal #durationTime').val(duration);
               console.log(duration);
               // $('#createEventModal #when').text(mywhen);
               $('#createEventModal').modal('show');
              
               // var title = prompt('Event Title:');
               
               // if(title)
               // {
               //     var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');
   
               //     var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');
   
               //     $.ajax({
               //         url:"/fullcalendar/action",
               //         type:"POST",
               //         data:{
               //             title: title,
               //             start: start,
               //             end: end,
               //             type: 'add'
               //         },
               //         success:function(data)
               //         {
               //             calendar.fullCalendar('refetchEvents');
               //             displayMessage("Event Created Successfully");
               //         }
               //     })
               // }
           },
           editable:true,
           eventResize: function(event, delta)
           {
               
               var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
               var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
               var title = event.title;
               var id = event.id;
               $.ajax({
                   url:"/noraHome/action",
                   type:"POST",
                   data:{
                       title: title,
                       start: start,
                       end: end,
                       id: id,
                       patientNoraHpercode:$('#patientNoraHpercode').val(),
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
                   url:"/noraHome/action",
                   type:"POST",
                   data:{
                       title: title,
                       start: start,
                       end: end,
                       id: id,
                       patientNoraHpercode:$('#patientNoraHpercode').val(),
                       type: 'update'
                   },
                   success:function(response)
                   {
                       calendar.fullCalendar('refetchEvents');
                       //("Schedule Updated Successfully");
                   }
               })
           },
   
           eventClick:function(event)
           {
               var eventId = event.id;
               
               $('#ViewModal').modal('show');
               console.log("event id: " + eventId.toString());
                $.ajax({
                   url:"/noraHome/action",
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
                            $('#patientName').val(patientName);
                            $('#patientRoom').val(response[0].patient_room);
                            $('#patientAge').val(response[0].patient_age);
                            switch(response[0].patient_sex){
                                case 'M':  $('#patientSex').val('Male'); break;
                                case 'F':  $('#patientSex').val('Female'); break;   
                                }
                            $('#apptStartTime').val(response[0].start.split(' ').join('T'));
                            $('#apptEndTime').val(response[0].end.split(' ').join('T'));
                            console.log("end Time: " + response[0].end.split(' ').join('T'));
                            $('#durationTime').val(response[0].duration_time);
                            console.log("durationTime: " + response[0].duration_time);
                            $('#patientNoraHpercode').val(response[0].patientNoraHpercode);
                            console.log(response[0].patientNoraHpercode);
                            $('#inductionTime').val(response[0].induction_time.slice(0,5));
                            $('#patientProcedure').val(response[0].patient_procedure);                     
                            
                            $('#serviceType').val(response[0].service_type);
                            $('#anesthesiologist').val(response[0].anesthesiologist).change();
                            $('#referral_received').val(response[0].referral_received);
                            
                            var referringPhysicians = response[0].referring_physician;
                            var referringPhysiciansList = referringPhysicians.split(', ')
                            console.log(referringPhysiciansList)
                            for(let i = 0; i<referringPhysiciansList.length;i++){
                                if(i == 0){
                                    $('#referringAddPhysicianInput1').val(referringPhysiciansList[0]);
                                }else{
                                    console.log(referringPhysiciansList[i]);
                                    addPhysicianView(i,referringPhysiciansList[i]);
                                }
                            }
                            console.log(response[0].updated_at.split('.')[0]);
                            var logindateTime = moment(response[0].updated_at).utcOffset('+8:00').format('YYYY-MM-DDTHH:mm:ss');
                            $('#loginDateTime').val(logindateTime);
                            $("input[name=svc_pvt][id=" + response[0].svc_pvt + "]").prop('checked', true);
                            $('#ViewModal').on('hidden.bs.modal', function () {
    
                            //delete additional physician upo closng modal    
                            for(let i = 0; i<referringPhysiciansList.length;i++){
                                    if(i == 0){
                                        $('#referringAddPhysicianInput1').val();
                                    }else{
                                        $("#referringAddPhysicianView"+i).remove();
                                    }
                                }    
                            });
    
                           
                       }   
                    })   
                                   
                $( "#editScheduleButton" ).click(function() {
                                       
                    $("#toEditDiv :input").prop("disabled", false);
                    $("#saveScheduleButton").prop("disabled",false);
                    validateInputs(eventId);
                    $('#viewFormSchedule').find(':input[type=submit]').prop("disabled", false);
                      
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
    if(id){   
        
        $(document).unbind('click').on("click", "#deleteScheduleButton", function(event){   
                event.preventDefault();
                
                   $('#deleteConfirmationModal').modal('show');   
                       $('#deleteConfirmed').on('click', function(event){ 
                        event.preventDefault();
                           
                           $.ajax({
                               url:"/noraHome/action/delete",
                               type:"POST",
                               data:{
                                   id:id,
                                   type:"delete",
                                   enccode:$('#enccode').val()
                                   },
                               cache: false,
                               statusCode: {
                                    200: function (data) {
                                        
                                        $('#deleteConfirmationModal').modal('hide');  
                                        $('#ViewModal').modal('hide');   
                                    
                                        console.log("deleted!");
                                        displayMessage("Schedule Deleted Successfully");
                                        calendar.fullCalendar('refetchEvents');
                                        location.reload();        
                                    },
                                    208: function (data) {
                                        consle.log('208: Error');
                                        // Handle the 401 error here.
                                    }
                                }
                            //    success:function(response)
                                //    {
                                //     $('#deleteConfirmationModal').modal('hide');  
                                //     $('#ViewModal').modal('hide');   
                                   
                                //     console.log("deleted!");
                                //     displayMessage("Schedule Deleted Successfully");
                                //     calendar.fullCalendar('refetchEvents');
                                //    }
                           })                                
                       
                      
                               
                   });            
                  
               }); 
            }
   }
   
   function doSubmitUpdate(eventId){
       //$("#createEventModal").modal('hide');
       console.log($('#serviceType').val());
       console.log($('#apptStartTime').val());
       console.log($('#apptEndTime').val());
       // var duration = (Date.parse($('#apptEndTime').val())-Date.parse($('#apptStartTime').val()))/360000
       // console.log(duration);
       console.log($('#patientName').val());
       const physicianElements = document.querySelectorAll(`[id^="referringAddPhysicianInput"]`);
       
       let physicianList =[]
       for (var i = 0; i < physicianElements.length; i++) {
           physicianList.push(physicianElements[i].value);
       }
   
       
       physicianListFinal = physicianList.join(", ");

       
       console.log(physicianListFinal);   
       console.log("anesthesiologist: " + $('#anesthesiologist').val());
       //console.log("svc_pvt :" + document.querySelector('input[name="svc_pvt"]:checked').value);
   
               $.ajax({
                       url:"/noraHome/action",
                       type:"POST",
                       data:{
                           id:eventId,
                           title: $('#serviceType').val() + " - " + $('#patientName').val(),
                           start: $('#apptStartTime').val().split('T').join(' '),
                           end: $('#apptEndTime').val().split('T').join(' '),
                           enccode : $('#enccode').val(),
                           patientNoraHpercode : $('#patientNoraHpercode').val(),
                           serviceTypeAdd : $('#serviceType').val(),
                           patientProcedureAdd : $('#patientProcedure').val(),
                           inductionTimeAdd : $('#inductionTime').val(),
                           referringPhysicianAdd : physicianListFinal,
                           anesthesiologistAdd: $('#anesthesiologist').val(),
                           durationTimeAdd :  $('#durationTime').val(),
                           patientRoomAdd: $('#patientRoom').val(),
                           svcPvtAdd : document.querySelector('input[name="svc_pvt"]:checked').value,
                           referralReceivedAdd  : $('#referral_received').val(),
                           type: 'editUpdate'
                       },
                       success:function(data)
                       {
                           calendar.fullCalendar('refetchEvents');
                       }
                   })
      };
   
   
   
   
   function doSubmitCreate(){
       $("#createEventModal").modal('hide');
       console.log($('#serviceType').val());
       console.log($('#apptStartTime').val());
       console.log($('#apptEndTime').val());
       // var duration = (Date.parse($('#apptEndTime').val())-Date.parse($('#apptStartTime').val()))/360000
       // console.log(duration);
       console.log($('#patientName').val());
       const physicianElements = document.querySelectorAll(`[id^="referringAddPhysicianInput"]`);
       
       let physicianList =[]
       for (var i = 0; i < physicianElements.length; i++) {
           physicianList.push(physicianElements[i].value);
       }
   
       console.log("duration time: " +  $('#createEventModal #durationTime').val());
       physicianListFinal = physicianList.join(", ");
       console.log(physicianListFinal);   
       console.log("anesthesiologist: " + $('#anesthesiologist').val());
       console.log("svc_pvt :" + $("input[type=radio][name=svc_pvt]:checked").val());
   
               $.ajax({
                   
                       url:"/noraHome/action",
                       type:"POST",
                       data:{
                           title: $('#serviceType').val()+"-"+$('#patientName').val(),
                           start: $('#apptStartTime').val().split('T').join(' '),
                           end: $('#apptEndTime').val().split('T').join(' '),
                           enccode : $('#enccode').val(),
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
                           location.reload();
                           
                       }
                   })
      }
   });
   
   
   function displayMessage(message) {
       toastr.success(message, 'Event');
   } 
   
   
   $("#durationTime").bind('keyup mouseup', function () {
           var endTimeRaw = Date.parse($('#apptEndTime').val());
           var durationTime = $('#durationTime').val();
           var startTime = Date.parse($('#apptStartTime').val());
   
           console.log("startTime: " + formatDate(startTime));
           console.log("endTimeRaw:" + formatDate(endTimeRaw));        
           console.log("duration time: " + durationTime*3600000);
   
           var finalEndTime = startTime + (durationTime*3600000)  ;
           console.log("end: " + formatDate(finalEndTime));
   
           var formattedFinal = formatDate(finalEndTime).split(' ').join('T');
           console.log(formattedFinal);
           $('#apptEndTime').val(formattedFinal);
       });
   
   // $("#apptEndTime").bind('keyup mouseup', function () {
   //     var endTimeRaw = Date.parse($('#apptEndTime').val());
   //     console.log("endTimeRaw: "+ endTimeRaw);
   //     var startTimeRaw = Date.parse($('#apptStartTime').val());
   //     console.log("startTimeRaw: " + startTimeRaw);
   
   //     var durationTimeChange = (endTimeRaw-startTimeRaw)/3600000
            
   //     console.log("durationTimeChange: " + durationTimeChange);
   //     $('#createEventModal #durationTime').val(durationTimeChange);
   //     });    
   
   $( "#apptEndTime" ).change(function() {
     //alert( "Handler for .change() called." );
       var endTimeRaw = Date.parse($('#apptEndTime').val());
       //onsole.log("endTimeRaw: "+ endTimeRaw);
       var startTimeRaw = Date.parse($('#apptStartTime').val());
       //console.log("startTimeRaw: " + startTimeRaw);
   
       var durationTimeChange = (endTimeRaw-startTimeRaw)/3600000
            
       //console.log("durationTimeChange: " + durationTimeChange);
       $('#durationTime').val(durationTimeChange);
     
   });
   
   $( "#apptStartTime" ).change(function() {
     //alert( "Handler for .change() called." );
       var endTimeRaw = Date.parse($('#apptEndTime').val());
       //console.log("endTimeRaw: "+ endTimeRaw);
       var startTimeRaw = Date.parse($('#apptStartTime').val());
       //console.log("startTimeRaw: " + startTimeRaw);
   
       var durationTimeChange = (endTimeRaw-startTimeRaw)/3600000
            
      //console.log("durationTimeChange: " + durationTimeChange);
       $('#durationTime').val(durationTimeChange);
     
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
   
   
   function addPhysicianView(physicianIdView,physicianNameView) {
    console.log(physicianNameView); 
      const elements = ` 
      <div class="form-group row" id=referringAddPhysicianView${physicianIdView}>
      <label for="referPhysician" class="col-sm-3 col-form-label" >${physicianNumberLabel}</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="referringAddPhysicianInputView${physicianIdView}" value="${physicianNameView}" disabled>
         </div>
         <div class="col-sm-2">
            <button type="button" class="btn btn-danger" id="deletePhysicianButton${physicianIdView}" onclick="removeView(${physicianIdView})" disabled>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg>
            </button> 
         </div>
    </div>`
      toDoLists.insertAdjacentHTML('beforeend', elements);
      
    };
   
   function remove(physicianId) {
     
     $("#referringAddPhysician"+physicianId).remove();
   }
   
   function removeView(physicianId) {
     
     $("#referringAddPhysicianView"+physicianId).remove();
   }
   
   function playSound(url) {
    const audio = new Audio(url);
    audio.play();
    }

   
   
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
<link href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/toasty.css" rel="stylesheet" />

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