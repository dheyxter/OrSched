@extends('layouts.master')

@section('content')
<div id="progReload" class="progress bg-light" style="height: 5px;">
    <div class="progress-bar progress-bar-striped bg-primary progress-bar-animated" role="progressbar"
        style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="percent"></span></div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mt-2">
            <h3><span class="float-right">{{\Carbon\Carbon::now()->format('F d,Y h:i A')}}</span></h3>
        </div>
        <div class="w-100"></div>
        <div class="col-md-5 mt-3">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header bg-danger" align="center">
                            <h4>Total Emergent Cases</h4>
                        </div>
                        <div class="card-body" align="center">
                            <h1 class="num">
                                @foreach($emer as $e)
                                {{$e->total}}
                                @endforeach
                            </h1>
                        </div>
                        @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                        App\Http\Controllers\LoggedUser::user_role()==2)
                        <div class="card-footer">
                            <a href="{{route('emergent')}}" class="btn btn-primary btn-sm float-right" type="button">See
                                more <i class="fas fa-angle-double-right"></i></a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header bg-warning" align="center">
                            <h4>Total Elective Cases</h4>
                        </div>
                        <div class="card-body" align="center">
                            <h1 class="num">
                                @foreach($elec as $e)
                                {{$e->total}}
                                @endforeach
                            </h1>
                        </div>
                        @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                        App\Http\Controllers\LoggedUser::user_role()==2)
                        <div class="card-footer">
                            <a href="{{route('elective')}}" class="btn btn-primary btn-sm float-right" type="button">See
                                more <i class="fas fa-angle-double-right"></i></a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7 mt-3">
            <div class="card">
                <div class="card-header bg-success">
                    <h4> Patient/s Accepted Today</h4>
                </div>
                @if($patcount>0)
                <div class="card-body" style="width: 100%; height: 300px; overflow: auto;">
                    <table class="table table-sm table-hover table-striped" id="myTable1">
                        <thead>
                            <th>Patient Name</th>
                            <th>Date and Time Accepted</th>
                            <th>Type</th>
                            <th>Room / Annex</th>
                            <th>Accepted By</th>
                        </thead>
                        <tbody>
                            @foreach ($pat as $p)
                            @if($p->accept != NULL)
                            <tr>
                                <td>
                                    <input type="text" data-id="{{$p->id}}" hidden>
                                    <a class="btnpatientdetails" data-toggle="tooltip" data-placement="top"
                                        title="Click to View Details" style="color: black" data-id="{{$p->id}}"><img
                                            class="mr-1" src="../img/plastic-surgery.png" height="30" width="30"
                                            alt=""><b class="font-weight-bold">{{$p->patlast}},</b> {{$p->patfirst}}
                                        <small class="text-muted">{{$p->patmiddle}}</small></a>
                                </td>
                                <td>
                                    {{date('F j, Y, g:i a', strtotime($p->created_at))}}
                                <td>
                                    @if($p->type == 0)
                                    <span class="badge badge-warning">Elective</span>
                                    @else
                                    <span class="badge badge-danger">Emergent</span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->annex == 1)
                                    Annex 1
                                    @elseif($p->annex == 2)
                                    Annex 2
                                    @elseif($p->annex == 3)
                                    Annex 3
                                    @elseif($p->annex == 4)
                                    Room 1
                                    @elseif($p->annex == 5)
                                    Room 2
                                    @elseif($p->annex == 6)
                                    Room 3
                                    @elseif($p->annex == 7)
                                    Room 4
                                    @elseif($p->annex == 8)
                                    Room 5
                                    @elseif($p->annex == 9)
                                    Room 6
                                    @elseif($p->annex == 10)
                                    Room 7
                                    @else
                                    Room 8
                                    @endif
                                </td>
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==2)
                                <td>
                                    {{-- <a href="{{route('myschedules')}}" class="btn btn-sm btn-primary">See Details</a> --}}
                                    {{$p->accept_by}}
                                </td>
                                @endif
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="col-lg-12">
                    <h2 align="center">No Scheduled Patient/s</h2>
                </div>
                @endif
            </div>
        </div>
        <div class="w-100"></div>
        <div class="col-md-5 mt-3">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header bg-secondary" align="center">
                            <h4>Total Operations Done</h4>
                        </div>
                        <div class="card-body" align="center">
                            <form action="/" method="GET">
                                @csrf
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==2)
                                <div class="col-auto form-inline">
                                    <label for="month" class="font-weight-bold">SELECT MONTH</label>
                                    <select name="month" id="month" class="form-control ml-1" value="">
                                        <option value="">-- View All --</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                    <button type="submit" name="submit" class="btn btn-primary btn-sm ml-1"><i
                                            class="fas fa-arrow-right"></i></button>
                                </div>

                                <h1 class="num">
                                    @foreach($tot as $e)
                                    {{$e->tot}}
                                    @endforeach
                                    @else
                                    <h1 class="num">
                                        @foreach($tot as $e)
                                        {{$e->tot}}
                                        @endforeach
                                        @endif
                                    </h1>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header bg-dark" align="center">
                            <h5>Total Operations Done for Today</h5>
                        </div>
                        <div class="card-body" align="center">
                            <h1 class="num">
                                @foreach($tot1 as $e)
                                {{$e->tot}}
                                @endforeach
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7 mt-3">
            <div class="card">
                <div class="card-header bg-secondary">
                    <h4>Patient/s to be Scheduled</h4>
                </div>
                @if($patcount1>0)
                <div class="card-body" style="width: 100%; height: 390px; overflow: auto;">
                    <table class="table table-sm table-hover">
                        <thead>
                            <th>Patient Name</th>
                            <th>Ward</th>
                            <th>Encounter</th>
                            <th>Type</th>
                            <th>Status</th>
                        </thead>
                        {{-- @if(App\Http\Controllers\LoggedUser::getUser() && App\Http\Controllers\LoggedUser::user_role()==0 ) --}}
                        @if(App\Http\Controllers\LoggedUser::user_role()==0 ||
                        App\Http\Controllers\LoggedUser::user_role()==4 )
                        @foreach($patients1 as $pat)
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" data-id="{{$pat->id}}" hidden>
                                    <a class="btnpatientdetails" style="color: black" data-id="{{$pat->id}}"><img
                                            class="mr-1" src="../img/plastic-surgery.png" height="30" width="30"
                                            alt=""><b class="font-weight-bold">{{$pat->patlast}},</b> {{$pat->patfirst}}
                                        <small class="text-muted">{{$pat->patmiddle}}</small></a></td>
                                <td><small>{{$pat->patward}}</small></td>
                                <td>
                                    @if(substr($pat->enccode, 0,2) == 'ER' )
                                    <span class="badge badge-primary">ER</span>
                                    @elseif(substr($pat->enccode, 0,2) == 'AD')
                                    <span class="badge badge-success">ADM</span>
                                    @else
                                    <span class="badge badge-danger"> OPD</span>
                                    @endif
                                </td>
                                <td>
                                    @if($pat->type == 0)
                                    <span class="badge badge-warning">Elective</span>
                                    @else
                                    <span class="badge badge-danger">Emergent</span>
                                    @endif
                                </td>
                                <td>
                                    @if($pat->accept == NULL)
                                    <span class="blinking">
                                        <h5>Waiting to Accept</h5>
                                    </span>
                                    @else
                                    <span class="text-success font-weight-bold">Accepted</span>
                                    @endif

                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                        @elseif(App\Http\Controllers\LoggedUser::getUser() &&
                        App\Http\Controllers\LoggedUser::user_role()==1 ||
                        App\Http\Controllers\LoggedUser::user_role()==2 ||
                        App\Http\Controllers\LoggedUser::user_role()==3)
                        @foreach($patients as $pat)
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" data-id="{{$pat->id}}" hidden>
                                    <a class="btnpatientdetails" data-toggle="tooltip" data-placement="top"
                                        title="Click to View Details" style="color: black" data-id="{{$pat->id}}"><img
                                            class="mr-1" src="../img/plastic-surgery.png" height="30" width="30"
                                            alt=""><b class="font-weight-bold">{{$pat->patlast}},</b> {{$pat->patfirst}}
                                        <small class="text-muted">{{$pat->patmiddle}}</small></a>
                                </td>
                                <td><small>{{$pat->patward}}</small></td>
                                <td>
                                    @if(substr($pat->enccode, 0,2) == 'ER' )
                                    <span class="badge badge-danger">ER</span>
                                    @elseif(substr($pat->enccode, 0,2) == 'AD')
                                    <span class="badge badge-success">ADM</span>
                                    @else
                                    <span class="badge badge-primary"> OPD</span>
                                    @endif
                                </td>
                                <td>
                                    @if($pat->type == 0)
                                    <span class="badge badge-warning">Elective</span>
                                    @else
                                    <span class="badge badge-danger">Emergent</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="row">
                                        <span class="text-muted"></span>
                                        @if($pat->accept == 1)
                                        <span class="text-success font-weight-bold">Accepted
                                            <small>{{$pat->accept_by}}</small></span>
                                        {{-- @elseif($pat->scheduled == 1)
                                            <span>Scheduled</span>
                                        @else --}}
                                        {{-- @if(App\Http\Controllers\LoggedUser::user_role()==1 || App\Http\Controllers\LoggedUser::user_role()==2) --}}
                                        @else
                                        <input class="namePat" type="hidden"
                                            value="{{$pat->patlast}}, {{$pat->patfirst}} {{$pat->patmiddle}} ">
                                        <input class="patID" type="hidden" value="{{$pat->hpercode}}">
                                        <input type="hidden" value="{{App\Http\Controllers\LoggedUser::getUser()}}"
                                            class="nameEmp">
                                        <input type="hidden" value="{{App\Http\Controllers\LoggedUser::userid()}}"
                                            class="name">
                                        <input type="hidden" class="id" value="{{$pat->id}}">
                                        <button class=" ml-1 mx-auto btn btn-primary btn-sm btnAccept"
                                            type="submit">Accept</button>
                                        {{-- @endif --}}
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach

                        @endif
                    </table>
                    @else
                    <div class="col-lg-12">
                        <h2 align="center">No Patient/s to be Scheduled</h2>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @if(App\Http\Controllers\LoggedUser::user_role()==1 || App\Http\Controllers\LoggedUser::user_role()==3)
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-6"><h4>For Anesthesiologist</h4></div>
                        <div class="col-6">
                            <form action="{{route('selectAnes')}}" method="GET">
                                @csrf
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-secondary text-light mr-2" id="basic-addon1">Select
                                        Date - <i class="fa fa-calendar-day"></i></span>
                                    <input type="date" class="form-control mr-3" id="selectdate" name="selectdate"
                                        value="{{$datetoday}}">
                                    <button type="submit" class="btn btn-success" type="button" id="button-addon2">Generate
                                        List</button>
                                </div>
                            </form>
                        </div>
              
                    </div>
                </div>
                <div class="card-body" style="width: 100%; height: 500px; overflow: auto;">
                    <div class="row">
                        
                    </div>
                    <div class="row mt-4">
                        @if($schedcount>0)
                        <div class="w-100"></div>
                        <div class="col">
                            <div class="">
                                <div class="card-body">
                                    <table class="table-sm table-striped table-hover">
                                        <thead class="bg-dark text-white">
                                            <tr>
                                                <th width="15%">Patient</th>
                                                <th width="5%">Type</th>
                                                <th width="5%">Room</th>
                                                <th width="5%">Ward</th>
                                                <th width="15%">Surgeon</th>
                                                <th width="10%" >Anesthesiologist</th>
                                                <th width="15%">Procedure</th>
                                                <th width="11%" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($scheds as $sched)
                                                @if($sched->defer == 1)
                                                <tr class="text-danger font-weight-bold">
                                                    <td>
                                                        <input type="text" class="inpPatID" value="{{$sched->patient_id}}" hidden>
                                                        <a class="btnpatdetails" data-toggle="tooltip" data-placement="top"
                                                            title="Click to View Details" style="color: black" value="{{$sched->patient_id}}">
                                                            <b class="font-weight-bold">{{$sched->patlast}},</b> {{$sched->patfirst}}
                                                            <small class="text-muted">{{$sched->patmiddle}}</small></a>
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
                                                        {{$sched->patward}}
                                                    </td>
                                                    <td>
                                                        @if($sched->anes == NULL)
                                                        @if(App\Http\Controllers\LoggedUser::user_role()==1 || App\Http\Controllers\LoggedUser::user_role()==3)
                                                            <select class="selectpicker form-control" id="anes" name="anes[]" multiple data-live-search="true" required>
                                                                <option disabled>--Select Anes--</option>
                                                                @foreach(\App\Http\Controllers\HomeController::aneslist() as $a)
                                                                <option value=" {{$a->firstname}} {{$a->middlename}} {{$a->lastname}}">
                                                                    {{$a->lastname}}, {{$a->firstname}} {{$a->middlename}},
                                                                    {{$a->empdegree}} | {{$a->tsdesc}}
                                                                </option>
                                                                @endforeach
                                                                <input class="patInfo" type="text" name="patient_name" value="{{$sched->patlast}}, {{$sched->patfirst}} {{$sched->patmiddle}}" hidden>
                                                                <input name="hpercode" type="hidden" value="{{App\Http\Controllers\LoggedUser::getUser()}}">
                                                                <input class="idAnes" name="patient_id" type="text" value="{{$sched->patient_id}}" hidden>
                                                                <input type="hidden" class="hpercode" name="hpercode" value="{{$sched->hpercode}}" hidden>
                                                                <span id="anesInput" class="anesInput" hidden></span>
                                                                <button class="btn shadow btn-success btn-sm btn-block btnAnes1 mt-1"><i class="fas fa-save"></i> Add
                                                                </button>
                                                            </select>
                                                        @endif
                                                        @else
                                                        Dr. {{$sched->anes}}
                                                        @endif
                                                    </td>
                        
                                                    <td>
                                                        {{$sched->procedures}}
                                                    </td>
                                                    @if(App\Http\Controllers\LoggedUser::user_role()==1 || App\Http\Controllers\LoggedUser::user_role()==2)
                                                    <td>
                                                        @if($sched->defer == 1)
                                                            <input class="patId" type="hidden" value="{{ $sched->patient_id }}">
                                                            <input type="text" class="hpercode" value="{{$sched->hpercode}}" hidden>
                                                            <button type="button" class="btn shadow btn-outline-danger btnUndoDefer"> Undo Defer</button>
                                                            <button type="button" class="btn shadow btn-outline-secondary btnCancel" title="Cancel schedule"> Cancel</button>
                                                        @else
                                                            <input class="patId" type="text" value="{{ $sched->patient_id }}">
                                                            <input type="text" class="hpercode" value="{{$sched->hpercode}}" hidden>
                                                            <button type="button" class="btn shadow btn-outline-danger btnDefer1"> Defer</button>
                                                            <button type="button" class="btn shadow btn-outline-secondary btnCancel" title="Cancel schedule"> Cancel</button>
                                                        @endif
                                                       
                                                    </td>
                                                    @else
                                                    <td>
                                                        <input class="patId" type="hidden" value="{{ $sched->patient_id }}">
                                                        <input type="text" class="hpercode" value="{{$sched->hpercode}}" hidden>
                                                        <span>Deferred</span>
                                                        <button type="button" class="btn shadow btn-outline-secondary btnCancel"
                                                            title="Cancel schedule"> Cancel</button>
                                                    </td>
                                                    @endif
                                                </tr>
                                                @else
                                                <tr>
                                                    
                                                    <td>
                                                        
                                                        <input type="text" class="inpPatID" value="{{$sched->patient_id}}" hidden>
                                                        <a class="btnpatdetails" data-toggle="tooltip" data-placement="top"
                                                            title="Click to View Details" style="color: black" value="{{$sched->patient_id}}">
                                                            
                                                                <b class="font-weight-bold">{{$sched->patlast}},</b> {{$sched->patfirst}}
                                                            <small class="text-muted">{{$sched->patmiddle}}</small></a>
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
                                                        {{$sched->patward}}
                                                    </td>
                                                    <td>
                                                        Dr. {{$sched->surgeon}}
                                                    </td>
                                                    
                                                    <td>
                                                        @if($sched->anes == NULL)
                                                        @if(App\Http\Controllers\LoggedUser::user_role()==1 || App\Http\Controllers\LoggedUser::user_role()==3)
                                                            <select class="selectpicker form-control" id="anes" name="anes[]" multiple data-live-search="true" required>
                                                                <option disabled>--Select Anes--</option>
                                                                @foreach(\App\Http\Controllers\HomeController::aneslist() as $a)
                                                                <option value=" {{$a->firstname}} {{$a->middlename}} {{$a->lastname}}">
                                                                    {{$a->lastname}}, {{$a->firstname}} {{$a->middlename}},
                                                                    {{$a->empdegree}} | {{$a->tsdesc}}
                                                                </option>
                                                                @endforeach
                                                                <input class="patInfo" type="text" name="patient_name" value="{{$sched->patlast}}, {{$sched->patfirst}} {{$sched->patmiddle}}" hidden>
                                                                <input name="hpercode" type="hidden" value="{{App\Http\Controllers\LoggedUser::getUser()}}">
                                                                <input class="idAnes" name="patient_id" type="text" value="{{$sched->patient_id}}" hidden>
                                                                <input type="hidden" class="hpercode" name="hpercode" value="{{$sched->hpercode}}" hidden>
                                                                <span id="anesInput" class="anesInput" hidden></span>
                                                                <button class="btn shadow btn-success btn-sm btn-block btnAnes1 mt-1"><i class="fas fa-save"></i> Add
                                                                </button>
                                                            </select>
                                                        @endif
                                                        @else
                                                        Dr. {{$sched->anes}}
                                                        @endif
                                                    </td>
                        
                                                    <td>
                                                        {{$sched->procedures}}
                                                    </td>
                                                    @if(App\Http\Controllers\LoggedUser::user_role()==1 || App\Http\Controllers\LoggedUser::user_role()==2 )

                                                    <td>
                                                        <input class="patId" type="text" value="{{ $sched->patient_id }}" hidden>
                                                        <input type="text" class="hpercode" value="{{$sched->hpercode}}" hidden>
                                                        <button type="button" class="btn shadow btn-outline-danger btnDefer1"> Defer</button>
                                                        <button type="button" class="btn shadow btn-outline-secondary btnCancel" title="Cancel schedule"> Cancel</button>
                                                       
                                                    </td>
                                                    @else
                                                    <td>
                                                        <input class="patId" type="hidden" value="{{ $sched->patient_id }}" hidden>
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
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-4"><a href="{{route('anesSched')}}" class="btn btn-primary float-right">View All List</a></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="patModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header shadow bg-secondary">
                <h3 class="modal-title" id="exampleModalLabel"><i class="fas fa-hospital-user"></i> Patient Details</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="patModalBody">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- trigger button if emergency --}}
@if(App\Http\Controllers\LoggedUser::user_role()==2 || App\Http\Controllers\LoggedUser::user_role()==3)
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
                <h2 class="blinking2">Check patient list to accept patient schedule</h2> <br>

                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
@endif
@endforeach
@endif

<!-- Button trigger modal -->
@foreach($mydata as $a)
@if($a->is_confirm == NULL)
<button type="button" class="btn btn-sm btn-primary invisible" id="trigg1" data-toggle="modal"
    data-target="#Updates"></button>
@endif
@endforeach
<!-- Modal -->
<div class="modal fade" id="Updates" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent border-bottom-0">
                <h3 class="text-dark">New Updates!</h3>
            </div>
            <div class="modal-body">
                <form action="{{url('/isConfirm')}}" method="POST">
                    @csrf
                    <p class="text-muted">
                        We're constantly working to improve your experience, here's a summary of what has changed...
                    </p>
                    <span class="badge badge-pill badge-success h1">IMPROVEMENTS</span>
                    @foreach($mydata as $a)
                    <input type="text" hidden name="employeeid" id="" value="{{$a->employeeid}}">
                    <input type="text" hidden name="" id="is_id" value="{{$a->is_confirm}}">
                    @endforeach
                    <div class="col-12"><b>- General UX improvements</b></div>
                    <div class="row">
                        <div class="col-4">
                            <span class="ml-3 mb-2"><b>- Updates on Schedule Tab</b></span>
                            <img src="./img/updt.png" alt="" class="img-thumbnail">
                        </div>
                        <div class="col-8">
                            <ul class="mt-4">
                                <li>You may now <span class="text-success text-bold">view</span> your patients scheduled on a specific date.</li>
                                <li>On date area, please select date, then all your patient list will be loaded.</li>
                                <li>If there are some discrepancies on your entry regarding the schedule, you have the access now to <span class="text-bold">CANCEL SCHEDULE</span> of your patient and re-schedule it.</li>
                                <li>For RE-SCHEDULE, please proceed to PATIENT tab on your side panel and select your patient to re-schedule.</li>
                            </ul>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-12">
                            <span class="h5 text-danger">Reminder: <br>Starting next week our new Address for OR Scheduler is: <b>192.168.7.17:84</b></span>
                        </div>
                    </div>
                    <center><button type="submit" class="btn btn-outline-primary mt-4">Acknowledge</button></center>
                </form>
            </div>
            <div class="modal-footer">
                <p><small class="text-info">Should you have any concern, please call IHOMS at local 202</small> </p>
            </div>
        </div>
    </div>
</div> 
@endsection

@section('script')
<script src="{{asset('js/scripts.js')}}"></script>
<script src="{{asset('js/moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        $('#myTable1').DataTable();
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $(function () {
        var trigger = $('#is_id').val();

        if (trigger == '') {
            $('#trigg1').trigger('click');
        } else {

        }
    });

    $(document).on('click', '.btnpatientdetails', function () {

        var patient_id = $(this).attr('data-id');
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
                    $('#patModalBody').empty();
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

                    $('#patModalBody').append(template);
                    $('#patModal').modal('show');
                }
            },
        });
    });

</script>
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
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
