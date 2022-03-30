<!DOCTYPE html>
<html>
<head>
    <title>NON-OPERATIONAL ROOM ANESTHESIOLOGY</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>       
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">  
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">

    

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<style>

    label {
        display: inline-block;
        width: 100px;
    }

    tr {
    height: 50px;
    }
    



</style>
</head>

</head>
<body>
  
<div class="container">

<div id="createEventModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            
            <h4 id="myModalLabel1">CREATE SCHEDULE</h4>
            <!-- <div class="control-group">
                    <label class="control-label" for="when">When:</label>
                    <div class="controls controls-row" id="when" style="margin-top:5px;">
                    </div>
            </div> -->
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <div class="modal-body">
            <form id="createAppointmentForm" class="form-horizontal">
                <div class="control-group">                    
                    <div class="controls">                        
                        <label for="serviceType">Service type: </label>
						<select name="serviceType" id="serviceType" >
                            <option value="GI" >GI</option>
                            <option value="RADIO/ONCO">RADIO/ONCO</option>
                            <option value="BRACHY">BRACHY</option>                            
                        </select>
                            <br/>
                        <label for="startTime">Start time: </label>
                        <input type="datetime-local" id="apptStartTime" required/>
                            <br/>
                        <label for="startTime">End time: </label>
                        <input type="datetime-local" id="apptEndTime" required />
                        <!-- <input type="hidden" id="apptAllDay" disabled/> -->
                            <br/>                       
                        <label for="patientAge">Age: </label>
                        <input type="number" id="patientAge" required />
                            <br/> 
                        <label for="patientSex">Sex: </label>                        
						<div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="patientSexOptions" id="patientMale" value="Male" />
                        <label class="form-check-label" for="patientMale">Male</label>
                       
                        <input class="form-check-input" type="radio" name="patientSexOptions" id="patientFemale" value="Female" />
                            <label class="form-check-label" for="patientFemale">Female</label>
                        </div>
                        
                        
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
    
<br/>
    <div id="calendar"></div>
</div>



<script>



$(document).ready(function () {

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    var calendar = $('#calendar').fullCalendar({
        
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

            $('#createEventModal #apptStartTime').val(starttime.split(' ').join('T'));
            $('#createEventModal #apptEndTime').val(endtime.split(' ').join('T'));
            $('#createEventModal #apptAllDay').val(allDay);
            $('#createEventModal #when').text(mywhen);
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

        eventClick:function(event)
        {
            if(confirm("Are you sure you want to remove it?"))
            {
                var id = event.id;
                $.ajax({
                    url:"/noraScheduler/action",
                    type:"POST",
                    data:{
                        id:id,
                        type:"delete"
                    },
                    success:function(response)
                    {
                        calendar.fullCalendar('refetchEvents');
                        displayMessage("Schedule Deleted Successfully");
                    }
                })
            }
        }
        
    });
    $('#submitButton').on('click', function(e){
    // We don't want this to act as a link so cancel the link action
    e.preventDefault();

    doSubmit();
  });

  function doSubmit(){
    $("#createEventModal").modal('hide');
    console.log($('#serviceType').val());
    console.log($('#apptStartTime').val());
    console.log($('#apptEndTime').val());
    console.log($('#apptAllDay').val());
    
            $.ajax({
                    url:"/noraScheduler/action",
                    type:"POST",
                    data:{
                        title: $('#serviceType').val(),
                        start: $('#apptStartTime').val(),
                        end: $('#apptEndTime').val(),
                        type: 'add'
                    },
                    success:function(data)
                    {
                        calendar.fullCalendar('refetchEvents');
                        displayMessage("Schedule Created Successfully");
                    }
                })
   }
});

function displayMessage(message) {
    toastr.success(message, 'Event');
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
  
</body>
</html>