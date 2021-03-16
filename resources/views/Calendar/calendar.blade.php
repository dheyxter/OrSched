@extends('layouts.master')
@section('content')
<h3>My Calendar</h3>
<hr>
<div class="container-fluid">
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h4>Add Schedule</h4>
                </div>
                <div class="card-body">
                   
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-body" id='calendar' class="modal fade">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('style')
<link rel='stylesheet' href='../fullcalendar/packages/core/main.css' />
<link rel="stylesheet" href="../fullcalendar/packages/daygrid/main.css">
<link rel="stylesheet" href="../fullcalendar/packages/timegrid/main.css">
<link rel="stylesheet" href="../fullcalendar/packages/list/main.css">
@endsection

@section('script')
<script src="{{asset('js/moment.js')}}"></script>
<script src="../fullcalendar/packages/core/main.js"></script>
<script src="../fullcalendar/packages/daygrid/main.js"></script>
<script src="../fullcalendar/packages/timegrid/main.js"></script>
<script src="../fullcalendar/packages/list/main.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        // console.log(calendarEl);

        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prevyear,prev,next,nextYear today',
                center: 'title',
                right: 'dayGridMonth dayGridWeek, dayGridDay'
            },

            // plugins: [ 'dayGrid', 'timeGrid', 'list' ]

            
        });

        calendar.render();
      });

</script>
@endsection

