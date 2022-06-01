@extends('layouts.app')
@section('content')
<div id="progReload" class="progress bg-light" style="height: 3px;">
    <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar"
        style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="percent"></span></div>
</div>
<div class="row">
    <div class="col-lg-12 mt-2">
        <h2><span class="float-right font-weight-bold mr-3">{{\Carbon\Carbon::now()->format('F d,Y h:i A')}}</span></h2>
    </div>
</div>

<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-4">
            
            <div class="card border-success">
                <div class="card-header bg-success">
                    <h3>OR SCHEDULER (To accept) </h3>
                </div>
                <div class="card-body" style="width: 100%; height: 900px; overflow: auto;">
                    <table class="table table-lg table-hover table-striped">
                        <thead>
                            <th></th>
                            <th>Patient Name</th>
                            <th>Location/Ward</th>
                        </thead>
                        <tbody>
                            @foreach ($patients as $key => $pat)
                            <tr>
                                <td>{{$key + 1 }}</td>
                                <td><b>{{$pat->patlast}}</b>, {{$pat->patfirst}} <small>{{$pat->patmiddle}}</small></td>
                                <td><small>{{$pat->patward}}</small></td>
                            </tr>
                                
                            @endforeach
                        </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card border-danger">
                <div class="card-header bg-danger">
                    <h3>Emergency Scheduled</h3>
                </div>
                <div class="card-body" style="width: 100%; height: 900px; overflow: auto;">
                    <table class="table table-lg table-hover table-striped">
                        <thead>
                            <th>Patient Name</th>
                            <th>Location / Ward</th>
                            <th>Procedure</th>
                            <th>Date Entered</th>
                            <th>Surgeon</th>
                            <th>Room</th>
                        </thead>
                        <tbody>
                            @foreach ($pat_scheduled as $pats)
                            
                                <tr>
                                    <td><b>{{$pats->patlast}}</b>, {{$pats->patfirst}} <small>{{$pats->patmiddle}}</small></td>
                                    <td><small>{{$pats->patward}}</small></td>
                                    <td class="text-uppercase"><b>{{$pats->procedures}}</b></td>
                                    <td><small><span class="text-primary font-weight-bold">{{date('F j, Y, g:i a', strtotime($pats->created_at))}}</span></small></td>
                                    <td class="text-uppercase font-weight-bold"><small>{{$pats->surgeons_name}}</small></td>
                                    <td>
                                        <span class="badge badge-danger"> 
                                            @if($pats->annex == 1)
                                                Room 1 - MIS
                                            @elseif($pats->annex == 2)
                                                Room 2 - ER
                                            @elseif($pats->annex == 3)
                                                Room 3 - Surgery
                                            @elseif($pats->annex == 4)
                                                Room 4 - OB Gyne
                                            @elseif($pats->annex == 5)
                                                Room 5 - ENT
                                            @elseif($pats->annex == 6)
                                                Room 6 - Ortho
                                            @elseif($pats->annex == 7)
                                                Room 7 - Ophtha
                                            @elseif($pats->annex == 8)
                                                Room 8 - Surgery</span>
                                            @else
                                            
                                            @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                   </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- trigger button if emergency --}}
<button type="button" class="btn btn-sm btn-primary" hidden id="trigg" data-toggle="modal"
    data-target="#UpdateModal">test</button>

@foreach ($patients as $p)
@if($p->type == '1' && $p->accept == NULL)
<div class="modal fade" id="UpdateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger border-bottom-0">
            </div>
            <div class="modal-body bg-danger text-center">
                <h1 class="blinking2">New Emergent Case! </h1> <br>
                <h2 class="blinking2">Check patient list to accept schedule</h2>
                <audio loop autoplay>
                    <source src="../alert.mp3" type="audio/mp3">
                  </audio>
            </div>
        </div>
        
    </div>
</div>
@endif
@endforeach


@section('script')
<script>
    var rw;
    var idleTime = 0;
    var refreshTime = 30; //change to 60
    $(function () {
        /***********************************/
        /* TIMER REFRESH */
        //Increment the idle time counter every minute.
        var idleInterval = setInterval(timerIncrement, 1000); // 1 minute
        //Zero the idle timer on mouse movement.
        $(this).mousemove(function (e) {
            idleTime = 0;
        });
        $(this).keypress(function (e) {
            idleTime = 0;
        });
        $(this).scroll(function (e) {
            idleTime = 0;
        });
        /** siaf ***/
    })

    function timerIncrement() {
        //console.log('tick');
        $("#progReload div.progress-bar").css("width", idleTime / refreshTime * 100 + '%');
        // $('#percent').text("Reloading page: "+idleTime / refreshTime * 100 + '%');
        //$("#counter").html(idleTime);
        idleTime = idleTime + 1;
        //console.log(isModalHidden);
        if (idleTime > refreshTime) { // 20 minutes
            //window.location.reload();
            idleTime = 0;
            location.reload();
        }
    }

    $('#trigg').trigger('click');
</script>
@endsection

@section('style')
<style>
    .num {
        color: black !important;
        font-size: 3.5rem !important;
    }

    .modal-dialog-centered {
        max-width: 45rem;
    }

    .blinking {
        animation: blinkingText1 1.2s infinite !important;
    }

    @keyframes blinkingText1 {
        0% {
            color: red;
        }

        49% {
            color: red;
        }

        60% {
            color: transparent;
        }

        99% {
            color: transparent;
        }

        100% {
            color: red;
        }

    }

    .blinking2 {
        animation: blinkingText 1.2s infinite !important;
    }

    @keyframes blinkingText {
        0% {
            color: rgb(255, 255, 255);
        }

        49% {
            color: rgb(255, 255, 255);
        }

        60% {
            color: transparent;
        }

        99% {
            color: transparent;
        }

        100% {
            color: rgb(255, 255, 255);
        }

    }

</style>
@endsection