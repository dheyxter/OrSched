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
                            <h5>Total Emergent Cases</h5>
                        </div>
                        <div class="card-body" align="center">
                            <h1 class="num">
                                @foreach($emer as $e)
                                    {{number_format($e->total)}}
                                @endforeach
                            </h1>
                        </div>
                        @if(App\Http\Controllers\LoggedUser::user_role()== 1 || App\Http\Controllers\LoggedUser::user_role()== 2)
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
                            <h5>Total Elective Cases</h5>
                        </div>
                        <div class="card-body" align="center">
                            <h1 class="num">
                                @foreach($elec as $e)
                                {{number_format($e->total)}}
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
                            <th>Date Scheduled</th>
                            <th>Type</th>
                            <th>Room</th>
                            <th>Accepted By</th>
                        </thead>
                        <tbody>
                            @foreach ($pat as $pat)
                            @if($pat->accept != NULL)
                            <tr>
                                <td>
                                    <input type="text" data-id="{{$pat->id}}" hidden>
                                   <small> 
                                    <button class="btn btn-sm" data-toggle="modal" data-target="#btnPatDetails{{$pat->id}}">
                                        <small data-toggle="tooltip" data-placement="top" title="Click to View Details">
                                            <img class="mr-1" src="../img/plastic-surgery.png" height="30" width="30" alt="">
                                            <b class="font-weight-bold">{{$pat->patlast}},</b> {{$pat->patfirst}}
                                                <small class="text-muted">{{$pat->patmiddle}}</small>
                                        </small>
                                      </button>
                                    {{-- <a class="btnpatientdetails" data-toggle="tooltip" data-placement="top" title="Click to View Details" style="color: black" data-id="{{$pat->id}}">
                                    <img class="mr-1" src="../img/plastic-surgery.png" height="30" width="30" alt=""><b class="font-weight-bold">{{$pat->patlast}},</b> {{$pat->patfirst}}
                                    <small class="text-muted">{{$pat->patmiddle}}</small></a> --}}
                                </small>
                                </td>
                               
                                <td>
                                    <small>{{date('F j, Y, g:i a', strtotime($pat->created_at))}}</small>
                                </td>
                                <td>
                                    @if($pat->type == 0)
                                    <span class="badge badge-warning">Elective</span>
                                    @else
                                    <span class="badge badge-danger">Emergent</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $roomNames[$pat->annex] ?? 'Unknown Room' }}</small>
                                </td>
                                <td>
                                    <small>{{$pat->accept_by}}</small>
                                </td>
                            </tr>
                            @endif
                            <div class="modal fade" id="btnPatDetails{{$pat->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="exampleModalLabel"><i class="fas fa-hospital-user"></i> Patient Details</h3>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body text-dark">
                                        <div class="container-fluid font-weight-bold">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <span class="font-weight-normal">Hospital Number</span> <br>
                                                    <span class="font-weight-normal">Patient Name</span> <br>
                                                    <span class="font-weight-normal">Age</span> <br>
                                                    <span class="font-weight-normal">Gender</span> <br>
                                                    <span class="font-weight-normal">Department</span> <br>
                                                    <span class="font-weight-normal">Ward</span> <br>
                                                    <span class="font-weight-normal">Admitted Date and Time</span> <br>
                                                    <span class="font-weight-normal">Date of Schedule</span> <br>
                                                    <span class="font-weight-normal">Time Start</span> <br>
                                                    <span class="font-weight-normal">Time Duration</span> <br>
                                                    <span class="font-weight-normal">Surgeon/s</span> <br>
                                                    <span class="font-weight-normal">Type of Anesthesia</span> <br>
                                                    <span class="font-weight-normal">Procedure</span> <br>
                                                    <span class="font-weight-normal">Instrument/s Needed</span> <br>
                                                    <span class="font-weight-normal">Entry By and Date</span> <br>
                                                </div>
                                                <div class="col-md-9">
                                                    <span>{{$pat->hpercode}}</span> <br>
                                                    <span>{{$pat->patlast}}, {{$pat->patfirst}} <small>{{$pat->patmiddle}}</small></span> <br>
                                                    <span>{{$pat->patage}} year/s old</span> <br>
                                                    <span>{{$pat->patsex == 'M' ? 'Male' : 'Female'}}</span> <br>
                                                    <span>{{$pat->tsdesc}} </span> <br>
                                                    <span>{{$pat->patward}} </span> <br>
                                                    <span>{{date('F d,Y h:i A', strtotime($pat->adm_date))}}</span> <br>
                                                    <span>{{date('F d,Y h:i A', strtotime($pat->date_of_sched))}}</span> <br>
                                                    <span>{{$pat->timeStart ? date('h:i A', strtotime($pat->timeStart)) : 'no time entered'}}</span> <br>
                                                    <span>{{$pat->timeDuration}}</span><br>
                                                    <span>
                                                        @php
                                                        $doctors = \App\Http\Controllers\ReservationController::doclist();
                                                        $surgeonIds = json_decode($pat->surgeon, true);
                                                        @endphp
                            
                                                        @if ($surgeonIds)
                                                        @foreach ($surgeonIds as $surgeonId)
                                                            @foreach ($doctors as $doctor)
                                                                @if ($doctor->employeeid == $surgeonId)
                                                                Dr/s. {{ $doctor->firstname }} {{ $doctor->lastname }} /
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                        @else
                                                            {{$pat->surgeon}}
                                                        @endif
                                                    </span> <br>
                                                    <span>{{$pat->anesname}}</span> <br>
                                                    <span>{{$pat->procedures}}</span> <br>
                                                    <span>{{$pat->instru}}</span> <br>
                                                    <span>{{$pat->entry}} - <small>{{date('F d,Y h:i A', strtotime($pat->created_at))}}</small></span>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                </div>
                            </div>
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
                            <th><center>Action</center></th>
                        </thead>
                        @if(App\Http\Controllers\LoggedUser::user_role()== 0 || App\Http\Controllers\LoggedUser::user_role()== 4 )
                        @foreach($patients1 as $pat)
                        <tbody>
                            <tr>
                                <td>
                                    <button class="btn btn-sm" data-toggle="modal" data-target="#btnPatDetails1{{$pat->id}}">
                                        <small data-toggle="tooltip" data-placement="top" title="Click to View Details">
                                            <img class="mr-1" src="../img/plastic-surgery.png" height="30" width="30" alt="">
                                            <b class="font-weight-bold">{{$pat->patlast}},</b> {{$pat->patfirst}}
                                                <small class="text-muted">{{$pat->patmiddle}}</small>
                                        </small>
                                        </button>
                                    </td>
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
                                    @if($pat->accept == NULL && $pat->cancel == NULL )
                                        <span class="blinking">
                                            <h5>Waiting to Accept</h5>
                                        </span>
                                    @elseif($pat->accept == NULL && $pat->cancel != NULL)
                                        <center><span><small class="font-weight-bold text-danger">Schedule Cancelled</small> <a href="#" class="badge badge-primary" data-toggle="modal" data-target="#viewCancel{{$pat->id}}">View</a></span>
                                       </center>

                                       <div class="modal fade" id="viewCancel{{$pat->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                          <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                              <h5 class="modal-title" id="exampleModalLabel">OR Nurse Remarks</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <h5>Patient: <b>{{$pat->patlast}},</b> {{$pat->patfirst}}, <small class="text-muted">{{$pat->patmiddle}}</small></h5>
                                                    <span class="text-danger"><b>Schedule Date:</b>  <b>{{date('F j, Y', strtotime($pat->date_of_sched))}}</b></span>
                                                    <h5 class="text-danger"><i class="fa-solid fa-hospital"></i>:  
                                                        <small>{{ $roomNames[$pat->annex] ?? 'Unknown Room' }}</small>
                                                    </h5>
                                                </div>
                                              <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Remarks:</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" readonly>{{$pat->cancel_remarks}}</textarea>
                                              </div>
                                                <small class="text-muted">Entry by: {{$pat->cancel_lname}}, {{$pat->cancel_fname}} - {{date('F j, Y h:m a', strtotime($pat->cancel_remarks_at))}}</small>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    @else
                                    <span class="text-success font-weight-bold">Accepted</span>
                                    @endif

                                </td>
                            </tr>
                        </tbody>
                            <div class="modal fade" id="btnPatDetails1{{$pat->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="exampleModalLabel"><i class="fas fa-hospital-user"></i> Patient Details</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body text-dark">
                                        <div class="container-fluid font-weight-bold">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <span class="font-weight-normal">Hospital Number</span> <br>
                                                    <span class="font-weight-normal">Patient Name</span> <br>
                                                    <span class="font-weight-normal">Age</span> <br>
                                                    <span class="font-weight-normal">Gender</span> <br>
                                                    <span class="font-weight-normal">Department</span> <br>
                                                    <span class="font-weight-normal">Ward</span> <br>
                                                    <span class="font-weight-normal">Admitted Date and Time</span> <br>
                                                    <span class="font-weight-normal">Date of Schedule</span> <br>
                                                    <span class="font-weight-normal">Time Start</span> <br>
                                                    <span class="font-weight-normal">Time Duration</span> <br>
                                                    <span class="font-weight-normal">Surgeon/s</span> <br>
                                                    <span class="font-weight-normal">Type of Anesthesia</span> <br>
                                                    <span class="font-weight-normal">Procedure</span> <br>
                                                    <span class="font-weight-normal">Instrument/s Needed</span> <br>
                                                    <span class="font-weight-normal">Entry By and Date</span> <br>
                                                </div>
                                                <div class="col-md-8">
                                                    <span>{{$pat->hpercode}}</span> <br>
                                                    <span>{{$pat->patlast}}, {{$pat->patfirst}} <small>{{$pat->patmiddle}}</small></span> <br>
                                                    <span>{{$pat->patage}} year/s old</span> <br>
                                                    <span>{{$pat->patsex == 'M' ? 'Male' : 'Female'}}</span> <br>
                                                    <span>{{$pat->tsdesc}} </span> <br>
                                                    <span>{{$pat->patward}} </span> <br>
                                                    <span>{{date('F d,Y h:i A', strtotime($pat->adm_date))}}</span> <br>
                                                    <span>{{date('F d,Y h:i A', strtotime($pat->date_of_sched))}}</span> <br>
                                                    <span>{{$pat->timeStart ? date('h:i A', strtotime($pat->timeStart)) : 'no time entered'}}</span> <br>
                                                    <span>{{$pat->timeDuration}}</span><br>
                                                    <span>
                                                        @php
                                                        $doctors = \App\Http\Controllers\ReservationController::doclist();
                                                        $surgeonIds = json_decode($pat->surgeon, true);
                                                        @endphp
                            
                                                        @if ($surgeonIds)
                                                        @foreach ($surgeonIds as $surgeonId)
                                                            @foreach ($doctors as $doctor)
                                                                @if ($doctor->employeeid == $surgeonId)
                                                                Dr/s. {{ $doctor->firstname }} {{ $doctor->lastname }} ;
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                        @else
                                                            {{$pat->surgeon}}
                                                        @endif
                                                    </span> <br>
                                                    <span>{{$pat->anesname}}</span> <br>
                                                    <span>{{$pat->procedures}}</span> <br>
                                                    <span>{{$pat->instru}}</span> <br>
                                                    <span>{{$pat->entry}} - <small>{{date('F d,Y h:i A', strtotime($pat->created_at))}}</small></span>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        @endforeach
                        @elseif(App\Http\Controllers\LoggedUser::getUser() && App\Http\Controllers\LoggedUser::user_role()==1 ||  App\Http\Controllers\LoggedUser::user_role()==2 || App\Http\Controllers\LoggedUser::user_role()==3)
                        @foreach($patients as $pat)
                        <tbody>
                            <tr>
                                <td>
                                    <button class="btn btn-sm" data-toggle="modal" data-target="#btnPatDetails1{{$pat->id}}">
                                        <small data-toggle="tooltip" data-placement="top" title="Click to View Details">
                                            <img class="mr-1" src="../img/plastic-surgery.png" height="30" width="30" alt="">
                                            <b class="font-weight-bold">{{$pat->patlast}},</b> {{$pat->patfirst}}
                                                <small class="text-muted">{{$pat->patmiddle}}</small>
                                        </small>
                                        </button>
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
                                        @elseif($pat->cancel == 1) 
                                            <span data-toggle="tooltip" data-placement="left" title="Remarks for Cancellation">
                                                <button class="btn btn-sm btn-danger ml-5"  data-toggle="modal" data-target="#cancelSched{{$pat->id}}"><i class="fa-solid fa-notes-medical"></i></button>
                                            </span>
                                           <form action="/cancelRemarks" method="POST">
                                            @csrf
                                            <div class="modal fade" id="cancelSched{{$pat->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered ">
                                                  <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                      <h5 class="modal-title" id="exampleModalLabel">Reason for Cancellation Schedule </h5>
                                                      <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <h5>Patient: <b>{{$pat->patlast}},</b> {{$pat->patfirst}}, <small class="text-muted">{{$pat->patmiddle}}</small></h5>
                                                            <span class="text-danger"><b>Schedule Date:</b>  <b>{{date('F j, Y', strtotime($pat->date_of_sched))}}</b></span>
                                                            <h5 class="text-danger"><i class="fa-solid fa-hospital"></i>:  
                                                                <small>{{ $roomNames[$pat->annex] ?? 'Unknown Room' }}</small>
                                                            </h5>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="cancelSched">Reason</label>
                                                            <textarea class="form-control" rows="3" name="cancelRemarks" autofocus >{{$pat->cancel_remarks}}</textarea>
                                                          </div>
                                                          <small class="text-muted">Entry by: {{$pat->cancel_lname}}, {{$pat->cancel_fname}} - {{date('F j, Y h:m a', strtotime($pat->cancel_remarks_at))}}</small>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="text" name="hospID" value="{{$pat->id}}" hidden>
                                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                      <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                           </form>
                                        @else 
                                        <input class="namePat" type="hidden"
                                            value="{{$pat->patlast}}, {{$pat->patfirst}} {{$pat->patmiddle}} ">
                                        <input class="patID" type="hidden" value="{{$pat->hpercode}}">
                                        <input type="hidden" value="{{App\Http\Controllers\LoggedUser::getUser()}}"
                                            class="nameEmp">
                                        <input type="hidden" value="{{App\Http\Controllers\LoggedUser::userid()}}"
                                            class="name">
                                        <input type="hidden" class="id" value="{{$pat->id}}">
                                        <button class=" ml-5 btn btn-primary btn-sm btnAccept"
                                            type="submit" data-toggle="tooltip" data-placement="left"
                                            title="Accept"><i class="fa-solid fa-check"></i></button>
                                        <button class="ml-3 btn btn-secondary btn-sm btnCancel"
                                            type="submit" data-toggle="tooltip" data-placement="top"
                                            title="Cancel"><i class="fa-solid fa-xmark"></i></button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                            <div class="modal fade" id="btnPatDetails1{{$pat->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="exampleModalLabel"><i class="fas fa-hospital-user"></i> Patient Details</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body text-dark">
                                        <div class="container-fluid font-weight-bold">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <span class="font-weight-normal">Hospital Number</span> <br>
                                                    <span class="font-weight-normal">Patient Name</span> <br>
                                                    <span class="font-weight-normal">Age</span> <br>
                                                    <span class="font-weight-normal">Gender</span> <br>
                                                    <span class="font-weight-normal">Department</span> <br>
                                                    <span class="font-weight-normal">Ward</span> <br>
                                                    <span class="font-weight-normal">Admitted Date and Time</span> <br>
                                                    <span class="font-weight-normal">Date of Schedule</span> <br>
                                                    <span class="font-weight-normal">Time Start</span> <br>
                                                    <span class="font-weight-normal">Time Duration</span> <br>
                                                    <span class="font-weight-normal">Surgeon/s</span> <br>
                                                    <span class="font-weight-normal">Type of Anesthesia</span> <br>
                                                    <span class="font-weight-normal">Procedure</span> <br>
                                                    <span class="font-weight-normal">Instrument/s Needed</span> <br>
                                                    <span class="font-weight-normal">Entry By and Date</span> <br>
                                                </div>
                                                <div class="col-md-8">
                                                    <span>{{$pat->hpercode}}</span> <br>
                                                    <span>{{$pat->patlast}}, {{$pat->patfirst}} <small>{{$pat->patmiddle}}</small></span> <br>
                                                    <span>{{$pat->patage}} year/s old</span> <br>
                                                    <span>{{$pat->patsex == 'M' ? 'Male' : 'Female'}}</span> <br>
                                                    <span>{{$pat->tsdesc}} </span> <br>
                                                    <span>{{$pat->patward}} </span> <br>
                                                    <span>{{date('F d,Y h:i A', strtotime($pat->adm_date))}}</span> <br>
                                                    <span>{{date('F d,Y h:i A', strtotime($pat->date_of_sched))}}</span> <br>
                                                    <span>{{$pat->timeStart ? date('h:i A', strtotime($pat->timeStart)) : 'no time entered'}}</span> <br>
                                                    <span>{{$pat->timeDuration}}</span><br>
                                                    <span>
                                                        @php
                                                        $doctors = \App\Http\Controllers\ReservationController::doclist();
                                                        $surgeonIds = json_decode($pat->surgeon, true);
                                                        @endphp
                            
                                                        @if ($surgeonIds)
                                                        @foreach ($surgeonIds as $surgeonId)
                                                            @foreach ($doctors as $doctor)
                                                                @if ($doctor->employeeid == $surgeonId)
                                                                Dr/s. {{ $doctor->firstname }} {{ $doctor->lastname }} /
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                        @else
                                                            {{$pat->surgeon}}
                                                        @endif
                                                    </span> <br>
                                                    <span>{{$pat->anesname}}</span> <br>
                                                    <span>{{$pat->procedures}}</span> <br>
                                                    <span>{{$pat->instru}}</span> <br>
                                                    <span>{{$pat->firstname}} {{$pat->lastname}} - <small>{{date('F d,Y h:i A', strtotime($pat->created_at))}}</small></span>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                </div>
                            </div>
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
    </div>
</div>
<!-- Modal -->
{{-- <div class="modal fade" id="patModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div> --}}

  {{-- trigger button if emergency --}}
@if(App\Http\Controllers\LoggedUser::user_role()==2 || App\Http\Controllers\LoggedUser::user_role()==3  )
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
                <audio loop autoplay>
                    <source src="../alert.mp3" type="audio/mp3">
                  </audio>

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
<button type="button" class="btn btn-sm btn-primary invisible" id="trigg1" data-backdrop="static" data-keyboard="false" data-toggle="modal"
    data-target="#Updates"></button>
@endif
@endforeach
<!-- Modal -->
<div class="modal fade" id="Updates"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered">
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
                    <span class="badge badge-pill badge-success">IMPROVEMENTS</span>
                    @foreach($mydata as $a)
                    <input type="text" hidden name="employeeid" id="" value="{{$a->employeeid}}">
                    <input type="text" hidden name="" id="is_id" value="{{$a->is_confirm}}">
                    @endforeach
                    <div class="row">
                        <div class="col-12">
                            <span class="ml-3 mb-2 font-weight-bold">- Creation of Feedback / Comments Suggestions</span>
                            <img src="./img/feedback_orsched.png" alt="" class="img-thumbnail">
                        </div>
                        <div class="col-12">
                            <ul class="mt-3">
                                <li>You may now <span class="text-success text-bold">send feedback / comments / suggestions </span> to the programmer for any improvements you want to be shown on next updates.</li>
                                <li>You can <span class="text-primary text-bold">monitor</span> all send comments in this tab and also will be able to know if programmer respond to your request</li>
                                <li>You can also tag programmer feedback if requests has been resolved</li>
                                
                            </ul>
                        </div>
                        {{-- <div class="w-100"></div>
                        <div class="col-12">
                            <span class="h5 text-danger">Reminder: <br>Starting next week our new Address for OR Scheduler is: <b>192.168.7.17:84</b></span>
                        </div> --}}
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
