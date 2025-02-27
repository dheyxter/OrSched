@extends('layouts.master')

@section('content')
<div class="col-12">
    <input type="hidden" id="triggerInput" value="{{$getTrigger}}">
</div>
<div class="w-100"></div>
<div class="mt-3">
    <h2 class=""><svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-calendar2-plus" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M8 8a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H6a.5.5 0 0 1 0-1h1.5V8.5A.5.5 0 0 1 8 8z" />
            <path fill-rule="evenodd" d="M7.5 10.5A.5.5 0 0 1 8 10h2a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0v-2z" />
            <path fill-rule="evenodd"
                d="M14 2H2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM2 1a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z" />
            <path fill-rule="evenodd"
                d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z" />
            <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z" />
        </svg> Schedules</h2>
</div>
<hr>
<div class="row">
    <div class="col float-right">
        <div class="row">
            <div class="col">
                <form action="{{route('selectdateroom')}}" method="GET" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-5 shadow">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-secondary text-light" id="basic-addon1">Select Date - <i
                                    class="fa fa-calendar-day"></i></span>
                        </div>
                        <input type="date" class="form-control" id="selectdate" name="selectdate"
                            value="{{$datetoday}}">

                        <div class="input-group-prepend">
                            <span class="input-group-text bg-secondary text-light" id="basic-addon1">Select
                                Annex:</span>
                        </div>
                        <select class="form-control" type="text" class="selectroom" id="selectroom" name="selectroom">

                            @php
                                $rooms = [
                                    1 => 'Annex 1 - Private',
                                    2 => 'Annex 2 - Private',
                                    3 => 'Annex 3 - Private',
                                    4 => 'Room 1 - ER',
                                    5 => 'Room 2 - Optha',
                                    6 => 'Room 3',
                                    7 => 'Room 4',
                                    8 => 'Room 5',
                                    9 => 'Room 6',
                                    10 => 'Room 7 - Optha',
                                    11 => 'Room 8',
                                    12 => 'Covid Room'
                                ];
                            @endphp

                            <option value="0" disabled>Select Annex / Room</option>
                            @foreach($rooms as $key => $name)
                                <option value="{{ $key }}" {{ $roomtoday == $key ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach

                        </select>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary" type="button" id="button-addon2">Generate
                                List</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<div class="row">
    @if($schedcount>0)
    <div class="col-lg-12">
        <h2><span class="float-right"><i class="fas fa-users fa-1x mr-2"></i><b>@foreach ($count as $c) {{$c->total[0]}}
                    @endforeach</b></span></h2>
    </div>
    <div class="w-100"></div>
    <div class="col">
        <div class="">
            <div class="card-body">
                <table class="table-sm table-striped table-hover">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th width="5%">Case #</th>
                            <th width="10%">Patient Name</th>
                            {{-- <th>Date and Time of Operation</th> --}}
                            <th width="5%">Type</th>
                            <th width="5%">Room / Annex</th>
                            <th width="15%">Surgeon</th>
                            <th width="10%">Anesthesiologist</th>
                            <th width="15%">Procedure</th>
                            <th width="10%">Remarks</th>
                            {{-- @if(App\Http\Controllers\LoggedUser::user_role()==1)
                            <th></th>
                            <th>Action</th>
                            @else
                            <th>Action</th>
                            @endif --}}
                            <th width="11%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scheds as $sched)
                        @if($sched->defer == 1)
                        <tr class="text-danger font-weight-bold">
                            <td class="text-center font-weight-bold">C{{$sched->case_num}}</td>
                            <td>
                                <button type="button" class="btn mb-2 btnpatientdetails" style="color: black !important"
                                    data-patient_id="{{ $sched->id }}"><i class="fas fa-file-alt"></i>
                                    <b>{{$sched->patlast}}</b>, {{$sched->patfirst}}
                                    <small>{{$sched->patmiddle}}</small>
                                </button>
                            </td>
                            <td>
                                @if($sched->type == 0)
                                <span class="badge badge-primary">Elective</span>
                                @else
                                <span class="badge badge-danger">Emergent</span>
                                @endif
                            </td>
                            <td>
                                @if($sched->room_id == 1)
                                Annex 1
                                @elseif($sched->room_id == 2)
                                Annex 2
                                @elseif($sched->room_id == 3)
                                Annex 3
                                @elseif($sched->room_id == 4)
                                Room 1
                                @elseif($sched->room_id == 5)
                                Room 2
                                @elseif($sched->room_id == 6)
                                Room 3
                                @elseif($sched->room_id == 7)
                                Room 4
                                @elseif($sched->room_id == 8)
                                Room 5
                                @elseif($sched->room_id == 9)
                                Room 6
                                @elseif($sched->room_id == 10)
                                Room 7
                                @elseif($sched->room_id == 11)
                                Room 8
                                @elseif($sched->room_id == 12)
                                Covid Room
                                @else
                                No Room Indicate
                                @endif
                            </td>
                            <td>
                                Dr. {{$sched->surgeon}}
                            </td>

                            <td>
                                @if($sched->anes == NULL)
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==3)
                                {{-- <form action="{{route('addAnes')}}" method="POST"> --}}
                                @csrf
                                <select class="selectpicker" id="anes" name="anes[]" multiple data-live-search="true"
                                    required>
                                    <option disabled value="">--Select Anes--</option>
                                    @foreach(\App\Http\Controllers\ReservationController::aneslist() as $a)
                                    <option value=" {{$a->firstname}} {{$a->middlename}} {{$a->lastname}}">
                                        {{$a->lastname}}, {{$a->firstname}} {{$a->middlename}},
                                        {{$a->empdegree}} | {{$a->tsdesc}}
                                    </option>
                                    @endforeach
                                    {{-- <input type="text" class="form-control" id="anesInput" > --}}
                                    <input class="patInfo" type="text" name="patient_name"
                                        value="{{$sched->patlast}}, {{$sched->patfirst}} {{$sched->patmiddle}}" hidden>
                                    <input name="hpercode" type="hidden"
                                        value="{{App\Http\Controllers\LoggedUser::getUser()}}">
                                    <input class="idAnes" name="patient_id" type="text" value="{{$sched->patient_id}}"
                                        hidden>
                                    <input type="hidden" class="hpercode" name="hpercode" value="{{$sched->hpercode}}"
                                        hidden>
                                    <span id="anesInput" class="anesInput" hidden></span>
                                    <button class="btn shadow btn-success btn-sm btn-block btnAnes mt-1"><i
                                            class="fas fa-save"></i> Add
                                    </button>
                                </select>
                                {{-- </form> --}}
                                @endif
                                @else
                                Dr. {{$sched->anes}}
                                @endif
                            </td>

                            <td>
                                {{$sched->procedures}}
                            </td>
                            <td>
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==2 ||
                                App\Http\Controllers\LoggedUser::user_role()==3)
                                <input class="nameRemarks" type="hidden"
                                    value="{{$sched->patlast}}, {{$sched->patfirst}} {{$sched->patmiddle}} ">
                                <input class="idRemarks" type="hidden" value="{{$sched->id}}">
                                <textarea placeholder="" name="" id="" cols="10" rows="1"
                                    class="form-control textRemarks">{{$sched->remarks}}</textarea>
                                <input type="hidden" class="hpercode" value="{{$sched->hpercode}}" hidden>
                                <button class="btn shadow btn-success btn-sm btn-block btnRemarks mt-1"><i
                                        class="fas fa-save"></i> Update</button>
                                @else
                                <span>{{$sched->remarks}}</span>
                                @endif
                            </td>
                            @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                            App\Http\Controllers\LoggedUser::user_role()==2)
                            {{-- <td>
                                    <input class="patId" type="hidden" value="{{ $sched->id }}">
                            <button type="button" class="btn shadow btn-block btn-info text-light btnChangeTimeModal"
                                title="Change time"><i class="fas fa-edit"></i> <i class="fa fa-clock fa-lg"></i>
                                Change Time</button>
                            </td> --}}
                            <td>
                                @if($sched->defer == 1)
                                <input class="patId" type="hidden" value="{{ $sched->id }}">
                                <input type="text" class="hpercode" value="{{$sched->hpercode}}" hidden>
                                <button type="button" class="btn shadow btn-outline-danger btnUndoDefer"> Undo
                                    Defer</button>
                                <button type="button" class="btn shadow btn-outline-secondary btnCancel"
                                    title="Cancel schedule"> Cancel</button>
                                @else
                                <input class="patId" type="hidden" value="{{ $sched->id }}">
                                <input type="text" class="hpercode" value="{{$sched->hpercode}}" hidden>
                                <button type="button" class="btn shadow btn-outline-danger btnDefer"> Defer</button>
                                <button type="button" class="btn shadow btn-outline-secondary btnCancel"
                                    title="Cancel schedule"> Cancel</button>
                                @endif

                            </td>
                            @else
                            <td>
                                <input class="patId" type="hidden" value="{{ $sched->id }}">
                                <input type="text" class="hpercode" value="{{$sched->hpercode}}" hidden>
                                <span>Deferred</span>
                                <button type="button" class="btn shadow btn-outline-secondary btnCancel"
                                    title="Cancel schedule"> Cancel</button>
                            </td>
                            @endif
                        </tr>
                        @else
                        <tr>
                            <td class="text-center font-weight-bold">C{{$sched->case_num}}</td>
                            <td>
                                <button type="button" class="btn mb-2 btnpatientdetails" style="color: black !important"
                                    data-patient_id="{{ $sched->id }}"><i class="fas fa-file-alt"></i>
                                    <b>{{$sched->patlast}}</b>, {{$sched->patfirst}}
                                    <small>{{$sched->patmiddle}}</small>
                                </button>
                            </td>
                            <td>
                                @if($sched->type == 0)
                                <span class="badge badge-primary">Elective</span>
                                @else
                                <span class="badge badge-danger">Emergent</span>
                                @endif
                            </td>
                            <td>
                                @if($sched->room_id == 1)
                                Annex 1
                                @elseif($sched->room_id == 2)
                                Annex 2
                                @elseif($sched->room_id == 3)
                                Annex 3
                                @elseif($sched->room_id == 4)
                                Room 1
                                @elseif($sched->room_id == 5)
                                Room 2
                                @elseif($sched->room_id == 6)
                                Room 3
                                @elseif($sched->room_id == 7)
                                Room 4
                                @elseif($sched->room_id == 8)
                                Room 5
                                @elseif($sched->room_id == 9)
                                Room 6
                                @elseif($sched->room_id == 10)
                                Room 7
                                @elseif($sched->room_id == 11)
                                Room 8
                                @elseif($sched->room_id == 12)
                                Covid Room
                                @else
                                No Room Indicate
                                @endif
                            </td>
                            <td>
                                Dr. {{$sched->surgeon}}
                            </td>

                            <td>
                                @if($sched->anes == NULL)
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==3)
                                {{-- <form action="{{route('addAnes')}}" method="POST"> --}}
                                @csrf
                                <select class="selectpicker" id="anes" name="anes[]" multiple data-live-search="true"
                                    required>
                                    <option disabled value="">--Select Anes--</option>
                                    @foreach(\App\Http\Controllers\ReservationController::aneslist() as $a)
                                    <option value=" {{$a->firstname}} {{$a->middlename}} {{$a->lastname}}">
                                        {{$a->lastname}}, {{$a->firstname}} {{$a->middlename}},
                                        {{$a->empdegree}} | {{$a->tsdesc}}
                                    </option>
                                    @endforeach
                                    {{-- <input type="text" class="form-control" id="anesInput" > --}}
                                    <input class="patInfo" type="text" name="patient_name"
                                        value="{{$sched->patlast}}, {{$sched->patfirst}} {{$sched->patmiddle}}" hidden>
                                    <input name="hpercode" type="hidden"
                                        value="{{App\Http\Controllers\LoggedUser::getUser()}}">
                                    <input class="idAnes" name="patient_id" type="text" value="{{$sched->patient_id}}"
                                        hidden>
                                    <input type="hidden" class="hpercode" name="hpercode" value="{{$sched->hpercode}}"
                                        hidden>
                                    <span id="anesInput" class="anesInput" hidden></span>
                                    <button class="btn shadow btn-success btn-sm btn-block btnAnes mt-1"><i
                                            class="fas fa-save"></i> Add
                                    </button>
                                </select>
                                {{-- </form> --}}
                                @endif
                                @else
                                Dr. {{$sched->anes}}
                                @endif
                            </td>

                            <td>
                                {{$sched->procedures}}
                            </td>
                            <td>
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==2 ||
                                App\Http\Controllers\LoggedUser::user_role()==3)
                                <input class="nameRemarks" type="hidden"
                                    value="{{$sched->patlast}}, {{$sched->patfirst}} {{$sched->patmiddle}} ">
                                <input class="idRemarks" type="hidden" value="{{$sched->id}}">
                                <textarea placeholder="" name="" id="" cols="10" rows="1"
                                    class="form-control textRemarks">{{$sched->remarks}}</textarea>
                                <input type="hidden" class="hpercode" value="{{$sched->hpercode}}" hidden>
                                <button class="btn shadow btn-success btn-sm btn-block btnRemarks mt-1"><i
                                        class="fas fa-save"></i> Update</button>
                                @else
                                <span>{{$sched->remarks}}</span>
                                @endif
                            </td>
                            @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                            App\Http\Controllers\LoggedUser::user_role()==2)
                            {{-- <td>
                                    <input class="patId" type="hidden" value="{{ $sched->id }}">
                            <button type="button" class="btn shadow btn-block btn-info text-light btnChangeTimeModal"
                                title="Change time"><i class="fas fa-edit"></i> <i class="fa fa-clock fa-lg"></i>
                                Change Time</button>
                            </td> --}}
                            <td>
                                <input class="patId" type="hidden" value="{{ $sched->id }}">
                                <input type="text" class="hpercode" value="{{$sched->hpercode}}" hidden>
                                <button type="button" class="btn shadow btn-outline-danger btnDefer"> Defer</button>
                                <button type="button" class="btn shadow btn-outline-secondary btnCancel"
                                    title="Cancel schedule"> Cancel</button>

                            </td>
                            @else
                            <td>
                                <input class="patId" type="hidden" value="{{ $sched->id }}">
                                <input type="text" class="hpercode" value="{{$sched->hpercode}}" hidden>
                                <button type="button" class="btn shadow btn-block btn-outline-secondary btnCancel"
                                    title="Cancel schedule"> Cancel</button>
                            </td>
                            @endif
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col">
        <h2>No scheduled patient/s </h2>
    </div>
    @endif
</div>


{{-- MODAL  --}}
@if(App\Http\Controllers\LoggedUser::getUser() && App\Http\Controllers\LoggedUser::user_role()==0 )
@foreach($pat as $pats)
<div class="modal fade changeTimeModal" id="changeTimeModal{{$pats->id}}" role="dialog">
    <div class="modal-dialog ">
        <form class="changetimeForm{{$pats->id}}" action="{{route('changetime')}}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header shadow-sm rounded bg-info">
                    <h4 class="modal-title">Change Time</h4>
                    <button type="button" class="close btn F-danger" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col font-weight-bold">
                            <h5><span>Current: </span></h5>
                            <h5><span class="oldTimeHere text-primary"></span></h5>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="newIn{{$pats->id}}" class="col-sm-2 col-form-label">From:</label>
                        <div class="col">
                            <div class="row">
                                <div class="col-7">
                                    <input id="newIn{{$pats->id}}" type="time" name="newtime" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="newOut{{$pats->id}}" class="col-sm-2 col-form-label">To:</label>
                        <div class="col">
                            <div class="row">
                                <div class="col-7">
                                    <input id="newOut{{$pats->id}}" type="time" name="newtimeout" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="pat_id" type="hidden" value="{{$pats->id}}">
                    <button type="button" class="btn shadow btn-success btnConfirmChangeTime">Change</button>
                    <button type="button" class="btn shadow btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach
@elseif(App\Http\Controllers\LoggedUser::getUser() && App\Http\Controllers\LoggedUser::user_role()==1 ||
App\Http\Controllers\LoggedUser::user_role()==2)
@foreach($scheds as $pats)
<div class="modal fade changeTimeModal" id="changeTimeModal{{$pats->id}}" role="dialog">
    <div class="modal-dialog ">
        <form class="changetimeForm{{$pats->id}}" action="{{route('changetime')}}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header shadow-sm rounded bg-info">
                    <h4 class="modal-title">Change Time</h4>
                    <button type="button" class="close btn F-danger" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col font-weight-bold">
                            <h5><span>Current: </span></h5>
                            <h5><span class="oldTimeHere text-primary"></span></h5>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="newIn{{$pats->id}}" class="col-sm-2 col-form-label">From:</label>
                        <div class="col">
                            <div class="row">
                                <div class="col-7">
                                    <input id="newIn{{$pats->id}}" type="time" name="newtime" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="newOut{{$pats->id}}" class="col-sm-2 col-form-label">To:</label>
                        <div class="col">
                            <div class="row">
                                <div class="col-7">
                                    <input id="newOut{{$pats->id}}" type="time" name="newtimeout" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="pat_id" type="hidden" value="{{$pats->id}}">
                    <button type="button" class="btn shadow btn-success btnConfirmChangeTime">Change</button>
                    <button type="button" class="btn shadow btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach
@endif

<!-- Modal -->
<div class="modal fade" id="patientdetails" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-secondary shadow">
                <h4 class="modal-title"><i class="fas fa-hospital-user"></i> Patient Details</h4>
                <button type="button" class="close btn btn-danger" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="patdetailsbody">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addschedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header shadow bg-dark">
                <h5 class="modal-title" id="exampleModalLabel">Select Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" align="center">
                    <div class="col-12">
                        @if(Carbon\Carbon::now()->format('H:i') > '16:00' || Carbon\Carbon::now()->format('H:i')
                        < '07:00' ) @else <a href="" data-dismiss="modal" data-toggle="modal" data-id="elec"
                            value="{{$elec}}" data-target="#addsched1"
                            class="btn btn-lg shadow btn-warning btn-block elec">Elective</a>
                            @endif
                            <a href="" data-dismiss="modal" data-toggle="modal" data-id="emer" value="{{$emer}}"
                                data-target="#addsched2"
                                class="btn btn-lg shadow btn-danger btn-block emer">Emergent</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ELECTIVE SCHEDULE --}}
<div class="modal fade" id="addsched1" name="" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-lg ">
        <form id="addscheduleform" action="{{route('addschedule')}}" method="POST" enctype="multipart/form-data"
            class="">
            @csrf
            <input class="form-control" type="date" class="selectdate" name="selectdate"
                value="{{date('Y-m-d', strtotime($datetoday))}}" hidden>
            <div class="modal-content">
                <div class="modal-header shadow-sm bg-warning">
                    <h4 class="modal-title">Add Schedule</h4>
                    <button type="button" class="close btn F-danger" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="date" class="col-sm-3 col-form-label"
                            value="{{date('d-m-Y', strtotime($datetoday))}}">Date of Operation:</label>
                        <div class="col-sm-9">
                            <input type="date" id="date" name="date" class="form-control is-invalid font-weight-bold"
                                required>
                            <div class="invalid-feedback">
                                required
                            </div>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="type" class="col-sm-3 col-form-label">Type:</label>
                        <div class="col-sm-9">
                            <div class="row">

                                <div class="col-lg-12"><input type="radio" id="type" value="0" name="type"
                                        onclick="rad(this.value)" checked> <span class="font-weight-bold">Elective
                                    </span>
                                    <div class="w-100"></div>

                                </div>
                                <input type="text" id="result" hidden>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="room" class="col-sm-3 col-form-label">Room:</label>
                        <div class="col-sm-9">
                            @php
                            $rooms = [
                            1 => 'Room 1 - MIS',
                            2 => 'Room 2 - ER',
                            3 => 'Room 3 - Surgery',
                            4 => 'Room 4 - OB Gyne',
                            5 => 'Room 5 - ENT',
                            6 => 'Room 6 - Ortho',
                            7 => 'Room 7 - Ophtha',
                            8 => 'Room 8 - Surgery',
                            ];
                            @endphp

                            <select name="room" id="room" class="form-control is-invalid">
                                <option value="0" disabled>Select Annex / Room</option>
                                @foreach ($rooms as $key => $room)
                                <option value="{{ $key }}" {{ $roomtoday == $key ? 'selected' : '' }}>{{ $room }}
                                </option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">
                                required
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="room" class="col-sm-3 col-form-label">Case:</label>
                        <div class="col-sm-9">
                            <select name="caseNum" id="caseNum" class="form-control is-invalid">
                                <option value="0" disabled>Select Case Number</option>
                                <option value="1">Case 1</option>
                                <option value="2">Case 2</option>
                                <option value="3">Case 3</option>
                                <option value="4">Case 4</option>
                                <option value="5">Case 5</option>
                                <option value="6">Case 6</option>
                                <option value="7">Case 7</option>
                                <option value="8">Case 8</option>
                                <option value="9">Case 9</option>
                                <option value="10">Case 10</option>
                            </select>
                            <div class="invalid-feedback">
                                required
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="procedure" class="col-sm-3 col-form-label">Total Schedule:</label>
                        <div class="col-sm-9">
                            <span id="full_time"><span id="show_time"></span>
                                <input type="text" id="show_time" hidden>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="procedure" class="col-sm-3 col-form-label">Time Start:</label>
                        <div class="col-sm-9">
                            <input type="time" name="timeStart" id="timeStart" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="procedure" class="col-sm-3 col-form-label">Time Duration:</label>
                        <div class="col-sm-9">
                            <input type="text" name="timeDuration" id="timeDuration" class="form-control is-invalid"
                                placeholder="indicate number of hours only">
                            <div class="invalid-feedback">
                                required
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="procedure" class="col-sm-3 col-form-label">Type of Anesthesia:</label>
                        <div class="col-sm-9">
                            <select class="form-control col-sm-12 is-invalid" name="typeAnes" required>
                                <option disabled value="">-- Select Type of Anesthesia --</option>
                                @foreach(\App\Http\Controllers\ReservationController::anestype() as $type)
                                <option value="{{$type->shortcode}}">
                                    {{$type->anesname}}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                required
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="surgeon" class="col-sm-3 col-form-label">Surgeon:</label>
                        <div class="col-sm-9">
                            <select class="selectpicker form-control col-sm-12 is-invalid" name="surgeon[]" multiple
                                data-live-search="true" required>
                                <option disabled value="">-- Select Surgeon --</option>
                                @foreach(\App\Http\Controllers\ReservationController::doclist() as $doclist)
                                <option value="{{$doclist->employeeid}}">
                                    {{$doclist->lastname}}, {{$doclist->firstname}} {{$doclist->middlename}}
                                    {{$doclist->empdegree}} | {{$doclist->tsdesc}}
                                </option>
                                @endforeach
                                <input name="entry_by" type="hidden"
                                    value="{{App\Http\Controllers\LoggedUser::getUser()}}">
                            </select>
                            <div class="invalid-feedback">
                                required
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="patient" class="col-sm-3 col-form-label">Patient:</label>
                        <div class="col-sm-9">
                            <select name="patid" id="patient" class="form-control is-invalid" required>
                                @foreach($pat as $pats)
                                {{-- @if(empty($pats->scheduled)) --}}
                                <option value="{{$pats->id}}"> {{$pats->patlast}}, {{$pats->patfirst}}
                                    {{$pats->patmiddle}} </option>
                                {{-- @endif --}}
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                required
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="procedure" class="col-sm-3 col-form-label">Planned Procedure:</label>
                        <div class="col-sm-9">
                            <textarea id="procedures" name="procedures" class="form-control is-invalid" rows="3"
                                required> </textarea>
                            <div class="invalid-feedback">
                                required
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="procedure" class="col-sm-3 col-form-label">Instruments Needed:</label>
                        <div class="col-sm-9">
                            <textarea id="instru" name="instru" class="form-control is-invalid" rows="2"
                                required></textarea>
                            <div class="invalid-feedback">
                                required
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="procedure" class="col-sm-3 col-form-label">Other Instruments Needed:</label>
                        <div class="col-sm-9">
                            <textarea id="other_instru" name="other_instru" class="form-control is-invalid" rows="2"
                                required></textarea>
                            <div class="invalid-feedback">
                                required
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn shadow btn-primary btnAddSchedule" id="btnAddSchedule">Add</button>
                    <button type="button" class="btn shadow btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- EMERGENT SCHEDULE --}}
<div class="modal fade" id="addsched2" name="" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <form id="addscheduleform1" action="/addschedule2" method="POST" enctype="multipart/form-data">
            @csrf
            <input class="form-control" type="date" id="selectdate1" name="selectdate"
                value="{{date('Y-m-d', strtotime($datetoday))}}" hidden>
            <div class="modal-content">
                <div class="modal-header shadow-sm bg-danger">
                    <h4 class="modal-title">Add Schedule</h4>
                    <button type="button" class="close btn F-danger" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="date" class="col-sm-3 col-form-label">Date of Operation:</label>
                        <div class="col-sm-9">
                            <input type="date" id="date_emer" name="date" class="form-control is-invalid font-weight-bold"
                                required>
                            <div class="invalid-feedback">
                                required
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="type" class="col-sm-3 col-form-label">Type:</label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-lg-12"><input type="radio" id="type" value="1" name="type"
                                        onclick="rad(this.value)" checked> <span class="font-weight-bold">Emergent
                                    </span>
                                    <div class="w-100"></div>

                                </div>
                                <input type="text" id="result" hidden>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="room" class="col-sm-3 col-form-label">Annex / Room:</label>
                        <div class="col-sm-9">
                            @php
                            $rooms = [
                            1 => 'Room 1 - MIS',
                            2 => 'Room 2 - ER',
                            3 => 'Room 3 - Surgery',
                            4 => 'Room 4 - OB Gyne',
                            5 => 'Room 5 - ENT',
                            6 => 'Room 6 - Ortho',
                            7 => 'Room 7 - Ophtha',
                            8 => 'Room 8 - Surgery',
                            ];
                            @endphp

                            <select name="room" id="room" class="form-control is-invalid">
                                <option value="0" disabled>Select Annex / Room</option>
                                @foreach ($rooms as $key => $room)
                                <option value="{{ $key }}" {{ $roomtoday == $key ? 'selected' : '' }}>{{ $room }}
                                </option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">
                                required
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="room" class="col-sm-3 col-form-label">Case:</label>
                        <div class="col-sm-9">
                            <select name="caseNum" id="caseNum" class="form-control is-invalid">
                                <option value="0" disabled>Select Case Number</option>
                                <option value="1">Case 1</option>
                                <option value="2">Case 2</option>
                                <option value="3">Case 3</option>
                                <option value="4">Case 4</option>
                                <option value="5">Case 5</option>
                                <option value="6">Case 6</option>
                                <option value="7">Case 7</option>
                                <option value="8">Case 8</option>
                                <option value="9">Case 9</option>
                                <option value="10">Case 10</option>
                            </select>
                            <div class="invalid-feedback">
                                required
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="procedure" class="col-sm-3 col-form-label">Total Schedule:</label>
                        <div class="col-sm-9">
                            <span id="full_time"><span id="show_time"></span></span>
                            <input type="text" id="show_time" hidden>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="procedure" class="col-sm-3 col-form-label">Time Start:</label>
                        <div class="col-sm-9">
                            <input type="time" name="timeStart" id="timeStart" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="procedure" class="col-sm-3 col-form-label">Time Duration:</label>
                        <div class="col-sm-9">
                            <input type="text" name="timeDuration" id="timeDuration" class="form-control"
                                placeholder="indicate number of hours only">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="procedure" class="col-sm-3 col-form-label">Type of Anesthesia:</label>
                        <div class="col-sm-9">
                            <select class="form-control col-sm-12 is-invalid" name="typeAnes" required>
                                <option disabled value="">-- Select Type of Anesthesia --</option>
                                @foreach(\App\Http\Controllers\ReservationController::anestype() as $type)
                                <option value="{{$type->shortcode}}">
                                    {{$type->anesname}}
                                </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                required
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="surgeon" class="col-sm-3 col-form-label">Surgeon:</label>
                        <div class="col-sm-9">
                            <select class="selectpicker form-control col-sm-12 is-invalid" id="surgeon_emer" name="surgeon[]" multiple
                                data-live-search="true" required>
                                <option disabled value="">-- Select Surgeon --</option>
                                @foreach(\App\Http\Controllers\ReservationController::doclist() as $doclist)
                                <option value="{{$doclist->employeeid}}">
                                    {{$doclist->lastname}}, {{$doclist->firstname}} {{$doclist->middlename}}
                                    {{$doclist->empdegree}} | {{$doclist->tsdesc}}
                                </option>
                                @endforeach
                                <input name="entry_by" type="hidden"
                                    value="{{App\Http\Controllers\LoggedUser::getUser()}}">
                            </select>
                            <div class="invalid-feedback">
                                required
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="patient" class="col-sm-3 col-form-label">Patient:</label>
                        <div class="col-sm-9">
                            <select name="patid" id="patient" class="form-control is-invalid" required>
                                @foreach($pat as $pats)
                                {{-- @if(empty($pats->scheduled)) --}}
                                <option value="{{$pats->id}}"> {{$pats->patlast}}, {{$pats->patfirst}}
                                    {{$pats->patmiddle}} </option>
                                {{-- @endif --}}
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                required
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="procedure" class="col-sm-3 col-form-label">Planned Procedure:</label>
                        <div class="col-sm-9">
                            <textarea id="procedures" name="procedures" class="form-control is-invalid" rows="3"
                                required></textarea>
                            <div class="invalid-feedback">
                                required
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="procedure" class="col-sm-3 col-form-label">Instruments Needed:</label>
                        <div class="col-sm-9">
                            <textarea id="instru" name="instru" class="form-control" rows="2" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn shadow btn-success btnAddSchedule1">Add</button>
                    <button type="button" class="btn shadow btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script> --}}
<script src="{{asset('js/bootstrap-select/select.js')}}"></script>
<script src="{{asset('js/scripts.js')}}"></script>
<script src="{{asset('js/moment.js')}}"></script>
<script>
    $(function () {
        var trigger = $('#triggerInput').val();
        console.log(trigger);

        if (trigger != '') {
            $('#addschedule').modal('show');
        }

    });

</script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '.btnpatientdetails', function () {
        var patient_id = $(this).attr('data-patient_id');
        var template = '';
        $.ajax({
            type: "POST",
            url: '/JSON/patdetails',
            data: {
                patient_id: patient_id
            },
            dataType: 'json',
            success: function (data) {
                if (data != null) {
                    $('#patdetailsbody').empty();
                    template += '<table class="table table-hover table-borderless table-sm">' +
                        '<tr><td>Hospital #: </td><td>' + data.hpercode + '</td></tr>' +
                        '<tr><td>Patient Name: </td><td>' + '<h5>' + data.patlast + ', ' + data
                        .patfirst +
                        ' ' + data.patmiddle + '</h5>' + '</td></tr>' +
                        '<tr><td>Age: </td><td>' + data.patage + ' ' + 'year/s old' + '</td></tr>' +
                        '<tr><td>Gender: </td><td>' + data.patsex + '</td></tr>' +
                        '<tr><td>Department: </td><td>' + data.tsdesc + '</td></tr>' +
                        '<tr><td>Ward: </td><td>' + data.patward + '</td></tr>' +
                        '<tr><td>Admitted Date and Time: </td><td>' + moment(data.adm_date).format(
                            'LLL') + '</td></tr>' +
                        '<tr><td colspan="2" style="margin-top: -5rem;"><h3 style="color: #38c172"><center>--- SCHEDULE DETAILS ---</center></h3></td></tr>' +
                        '<tr><td>Date of Schedule: </td><td>' + moment(data.date_of_sched).format(
                            'LL') + '</td></tr>' +
                        '<tr><td>Time Start: </td><td>' + moment(data.timeStart).format('LT') +
                        '</td></tr>' +
                        '<tr><td>Time Duration: </td><td>' + data.timeDuration + ' hour/s' +
                        '</td></tr>' +
                        '<tr><td>Surgeon/s: </td><td>' + 'Dr.' + ' ' + data.surgeon + '</td></tr>' +
                        '<tr><td>Type of Anesthesia: </td><td>' + data.anesname + '</td></tr>' +
                        '<tr><td>Procedure: </td><td>' + data.procedures + '</td></tr>' +
                        '<tr><td>Instrument/s Needed: </td><td>' + data.instru + '</td></tr>' +
                        '<tr><td>Entry By and Date: </td><td>' + data.firstname + ' ' + data
                        .middlename + ' ' + data.lastname + ', ' + ' ' + moment(data.created_at)
                        .format('LLL') + '</td></tr>';
                    template += '</table>';

                    $('#patdetailsbody').append(template);
                    $('#patientdetails').modal('show');
                }
            },
        });
    });

    function rad(type) {
        document.getElementById("result").value = type;
        console.log(type);
    }

    // $(document).on('click','.elec', function() {
    //     var get_id = $(this).attr('data-id');
    //     var endTime = '16:00:00';
    //     var begTime = '07:00:00'
    //     var today = new Date();
    //     var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    //     console.log(time);

    //     if(get_id == 'elec' && time >= endTime && time <= begTime) 
    //     {
    //         $('#btnAddSchedule').prop('disabled', false);
    //     }
    //     else
    //     {
    //         $('#btnAddSchedule').prop('disabled', false);
    //     }


    //     console.log(get_id);
    // });

    // $(document).on('click','.emer', function() {
    //     var get_id = $(this).attr('data-id');
    //     var endTime = '16:00:00';
    //     var begTime = '07:00:00'
    //     var today = new Date();
    //     var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    //     console.log(time);

    //     $('#btnAddSchedule1').prop('disabled', false);

    //     console.log(get_id);
    // });

</script>
@endsection
@section('style')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" /> --}}
<link rel="stylesheet" href="{{asset('css/bootstrap-select/select.css')}}">
@endsection
