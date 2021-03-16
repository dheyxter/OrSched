@extends('layouts.master')

@section('content')
<div class="col-12"></div>
<div class="w-100"></div>
<div class="mt-3"><h2 class=""><svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-door-open" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" d="M1 15.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5zM11.5 2H11V1h.5A1.5 1.5 0 0 1 13 2.5V15h-1V2.5a.5.5 0 0 0-.5-.5z"/>
    <path fill-rule="evenodd" d="M10.828.122A.5.5 0 0 1 11 .5V15h-1V1.077l-6 .857V15H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117z"/>
    <path d="M8 9c0 .552.224 1 .5 1s.5-.448.5-1-.224-1-.5-1-.5.448-.5 1z"/>
  </svg> Rooms</h2></div>
<hr>
<div class="row">
    <div class="col">
        <form action="/selectdateroom2" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-12 mb-5 row form-inline">
                    <div class="col-auto">
                        <label for="">
                            <h3>Select Date:</h3>
                        </label>
                    </div>
                    <div class="col-auto">
                        <input class="form-control form-control-lg" type="date" class="selectdate" id="selectdate"
                            name="selectdate" value="{{date('Y-m-d', strtotime($getdate))}}">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success" id="btnTrig" type="submit">Generate List</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    {{-- ANNEX 1 --}}
    @if(count($r1)>0)
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-success">
                <h4 class="text-center">Annex 1</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th width="5%">Date Reserve</th>
                            <th width="20%">Patient</th>
                            <th width="28%">Surgeon</th>
                            <th width="15%">Anesthesiologist</th>
                            <th width="15%">Procedure/s</th>
                            <th width="5%">Status</th>
                            <th width="8%">Date Finish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($r1 as $r)
                        <tr>
                            <td><small>{{date('F j, Y', strtotime($r->date_of_sched))}}</small></td>
                            <td>{{$r->patlast}}, {{$r->patfirst}} {{$r->patmiddle}}</td>
                            <td><small> Dr/s. {{$r->surgeon}}</small></td>
                            <td><small>{{$r->anes}}</small></td>
                            <td>{{$r->procedures}}</td>
                            <td align="center">
                                @if($r->op_status==1)
                                <span class="text-success" align="center"><i class="fa fa-check-circle"></i> done</span>
                                @else
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==2)
                                <input class="id" type="hidden" value="{{$r->patient_id}}">
                                <input class="hpercode" type="hidden" value="{{$r->hpercode}}">
                                <button class="btn btn-sm btn-primary btnComplete"><i class="fa fa-save"></i>
                                    complete</button>
                                @else
                                <span class="text-dark">...</span>
                                @endif
                                @endif
                            </td>
                            <td>
                               @if($r->date_finish == NULL)
                               @else
                               <small>{{date('F j, Y, g:i a', strtotime($r->date_finish))}}</small>
                               @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-secondary">
                <h4 class="text-center">Annex 1</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td colspan="8" align="center">
                                <h3>No scheduled patients</h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- ANNEX 2 --}}
    @if(count($r2)>0)
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-success">
                <h4 class="text-center">Annex 2</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th width="5%">Date Reserve</th>
                            <th width="20%">Patient</th>
                            <th width="28%">Surgeon</th>
                            <th width="15%">Anesthesiologist</th>
                            <th width="15%">Procedure/s</th>
                            <th width="5%">Status</th>
                            <th width="8%">Date Finish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($r2 as $r)
                        <tr>
                            <td><small>{{date('F j, Y', strtotime($r->date_of_sched))}}</small></td>
                            <td>{{$r->patlast}}, {{$r->patfirst}} {{$r->patmiddle}}</td>
                            <td><small> Dr/s. {{$r->surgeon}}</small></td>
                            <td><small>{{$r->anes}}</small></td>
                            <td>{{$r->procedures}}</td>
                            <td align="center">
                                @if($r->op_status==1)
                                <span class="text-success" align="center"><i class="fa fa-check-circle"></i> done</span>
                                @else
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==2)
                                <input class="id" type="hidden" value="{{$r->patient_id}}">
                                <input class="hpercode" type="hidden" value="{{$r->hpercode}}">
                                <button class="btn btn-sm btn-primary btnComplete"><i class="fa fa-save"></i>
                                    complete</button>
                                @else
                                <span class="text-dark">...</span>
                                @endif
                                @endif
                            </td>
                            <td>
                               @if($r->date_finish == NULL)
                               @else
                               <small>{{date('F j, Y, g:i a', strtotime($r->date_finish))}}</small>
                               @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-secondary">
                <h4 class="text-center">Annex 2</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td colspan="8" align="center">
                                <h3>No scheduled patients</h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
    {{-- ANNEX 3 --}}

    @if(count($r3)>0)
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-success">
                <h4 class="text-center">Annex 3</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th width="5%">Date Reserve</th>
                            <th width="20%">Patient</th>
                            <th width="28%">Surgeon</th>
                            <th width="15%">Anesthesiologist</th>
                            <th width="15%">Procedure/s</th>
                            <th width="5%">Status</th>
                            <th width="8%">Date Finish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($r3 as $r)
                        <tr>
                            <td><small>{{date('F j, Y', strtotime($r->date_of_sched))}}</small></td>
                            <td>{{$r->patlast}}, {{$r->patfirst}} {{$r->patmiddle}}</td>
                            <td><small> Dr/s. {{$r->surgeon}}</small></td>
                            <td><small>{{$r->anes}}</small></td>
                            <td>{{$r->procedures}}</td>
                            <td align="center">
                                @if($r->op_status==1)
                                <span class="text-success" align="center"><i class="fa fa-check-circle"></i> done</span>
                                @else
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==2)
                                <input class="id" type="hidden" value="{{$r->patient_id}}">
                                <input class="hpercode" type="hidden" value="{{$r->hpercode}}">
                                <button class="btn btn-sm btn-primary btnComplete"><i class="fa fa-save"></i>
                                    complete</button>
                                @else
                                <span class="text-dark">...</span>
                                @endif
                                @endif
                            </td>
                            <td>
                               @if($r->date_finish == NULL)
                               @else
                               <small>{{date('F j, Y, g:i a', strtotime($r->date_finish))}}</small>
                               @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-secondary">
                <h4 class="text-center">Annex 3</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td colspan="8" align="center">
                                <h3>No scheduled patients</h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- ROOM 1 --}}
    @if(count($or1)>0)
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="text-center">Room 1</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th width="5%">Date Reserve</th>
                            <th width="20%">Patient</th>
                            <th width="28%">Surgeon</th>
                            <th width="15%">Anesthesiologist</th>
                            <th width="15%">Procedure/s</th>
                            <th width="5%">Status</th>
                            <th width="8%">Date Finish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($or1 as $r)
                        <tr>
                            <td><small>{{date('F j, Y', strtotime($r->date_of_sched))}}</small></td>
                            <td>{{$r->patlast}}, {{$r->patfirst}} {{$r->patmiddle}}</td>
                            <td><small> Dr/s. {{$r->surgeon}}</small></td>
                            <td><small>{{$r->anes}}</small></td>
                            <td>{{$r->procedures}}</td>
                            <td align="center">
                                @if($r->op_status==1)
                                <span class="text-success" align="center"><i class="fa fa-check-circle"></i> done</span>
                                @else
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==2)
                                <input class="id" type="hidden" value="{{$r->patient_id}}">
                                <input class="hpercode" type="hidden" value="{{$r->hpercode}}">
                                <button class="btn btn-sm btn-primary btnComplete"><i class="fa fa-save"></i>
                                    complete</button>
                                @else
                                <span class="text-dark">...</span>
                                @endif
                                @endif
                            </td>
                            <td>
                               @if($r->date_finish == NULL)
                               @else
                               <small>{{date('F j, Y, g:i a', strtotime($r->date_finish))}}</small>
                               @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-secondary">
                <h4 class="text-center">Room 1</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td colspan="8" align="center">
                                <h3>No scheduled patients</h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- ROOM 2 --}}
    @if(count($or2)>0)
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="text-center">Room 2</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th width="5%">Date Reserve</th>
                            <th width="20%">Patient</th>
                            <th width="28%">Surgeon</th>
                            <th width="15%">Anesthesiologist</th>
                            <th width="15%">Procedure/s</th>
                            <th width="5%">Status</th>
                            <th width="8%">Date Finish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($or2 as $r)
                        <tr>
                            <td><small>{{date('F j, Y', strtotime($r->date_of_sched))}}</small></td>
                            <td>{{$r->patlast}}, {{$r->patfirst}} {{$r->patmiddle}}</td>
                            <td><small> Dr/s. {{$r->surgeon}}</small></td>
                            <td><small>{{$r->anes}}</small></td>
                            <td>{{$r->procedures}}</td>
                            <td align="center">
                                @if($r->op_status==1)
                                <span class="text-success" align="center"><i class="fa fa-check-circle"></i> done</span>
                                @else
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==2)
                                <input class="id" type="hidden" value="{{$r->patient_id}}">
                                <input class="hpercode" type="hidden" value="{{$r->hpercode}}">
                                <button class="btn btn-sm btn-primary btnComplete"><i class="fa fa-save"></i>
                                    complete</button>
                                @else
                                <span class="text-dark">...</span>
                                @endif
                                @endif
                            </td>
                            <td>
                               @if($r->date_finish == NULL)
                               @else
                               <small>{{date('F j, Y, g:i a', strtotime($r->date_finish))}}</small>
                               @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-secondary">
                <h4 class="text-center">Room 2</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td colspan="8" align="center">
                                <h3>No scheduled patients</h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- ROOM 3 --}}
    @if(count($or3)>0)
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="text-center">Room 3</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th width="5%">Date Reserve</th>
                            <th width="20%">Patient</th>
                            <th width="28%">Surgeon</th>
                            <th width="15%">Anesthesiologist</th>
                            <th width="15%">Procedure/s</th>
                            <th width="5%">Status</th>
                            <th width="8%">Date Finish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($or3 as $r)
                        <tr>
                            <td><small>{{date('F j, Y', strtotime($r->date_of_sched))}}</small></td>
                            <td>{{$r->patlast}}, {{$r->patfirst}} {{$r->patmiddle}}</td>
                            <td><small> Dr/s. {{$r->surgeon}}</small></td>
                            <td><small>{{$r->anes}}</small></td>
                            <td>{{$r->procedures}}</td>
                            <td align="center">
                                @if($r->op_status==1)
                                <span class="text-success" align="center"><i class="fa fa-check-circle"></i> done</span>
                                @else
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==2)
                                <input class="id" type="hidden" value="{{$r->patient_id}}">
                                <input class="hpercode" type="hidden" value="{{$r->hpercode}}">
                                <button class="btn btn-sm btn-primary btnComplete"><i class="fa fa-save"></i>
                                    complete</button>
                                @else
                                <span class="text-dark">...</span>
                                @endif
                                @endif
                            </td>
                            <td>
                               @if($r->date_finish == NULL)
                               @else
                               <small>{{date('F j, Y, g:i a', strtotime($r->date_finish))}}</small>
                               @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-secondary">
                <h4 class="text-center">Room 3</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td colspan="8" align="center">
                                <h3>No scheduled patients</h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- ROOM 4 --}}
    @if(count($or4)>0)
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="text-center">Room 4</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th width="5%">Date Reserve</th>
                            <th width="20%">Patient</th>
                            <th width="28%">Surgeon</th>
                            <th width="15%">Anesthesiologist</th>
                            <th width="15%">Procedure/s</th>
                            <th width="5%">Status</th>
                            <th width="8%">Date Finish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($or4 as $r)
                        <tr>
                            <td><small>{{date('F j, Y', strtotime($r->date_of_sched))}}</small></td>
                            <td>{{$r->patlast}}, {{$r->patfirst}} {{$r->patmiddle}}</td>
                            <td><small> Dr/s. {{$r->surgeon}}</small></td>
                            <td><small>{{$r->anes}}</small></td>
                            <td>{{$r->procedures}}</td>
                            <td align="center">
                                @if($r->op_status==1)
                                <span class="text-success" align="center"><i class="fa fa-check-circle"></i> done</span>
                                @else
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==2)
                                <input class="id" type="hidden" value="{{$r->patient_id}}">
                                <input class="hpercode" type="hidden" value="{{$r->hpercode}}">
                                <button class="btn btn-sm btn-primary btnComplete"><i class="fa fa-save"></i>
                                    complete</button>
                                @else
                                <span class="text-dark">...</span>
                                @endif
                                @endif
                            </td>
                            <td>
                               @if($r->date_finish == NULL)
                               @else
                               <small>{{date('F j, Y, g:i a', strtotime($r->date_finish))}}</small>
                               @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-secondary">
                <h4 class="text-center">Room 4</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td colspan="8" align="center">
                                <h3>No scheduled patients</h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- ROOM 5 --}}
    @if(count($or5)>0)
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="text-center">Room 5</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th width="5%">Date Reserve</th>
                            <th width="20%">Patient</th>
                            <th width="28%">Surgeon</th>
                            <th width="15%">Anesthesiologist</th>
                            <th width="15%">Procedure/s</th>
                            <th width="5%">Status</th>
                            <th width="8%">Date Finish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($or5 as $r)
                        <tr>
                            <td><small>{{date('F j, Y', strtotime($r->date_of_sched))}}</small></td>
                            <td>{{$r->patlast}}, {{$r->patfirst}} {{$r->patmiddle}}</td>
                            <td><small> Dr/s. {{$r->surgeon}}</small></td>
                            <td><small>{{$r->anes}}</small></td>
                            <td>{{$r->procedures}}</td>
                            <td align="center">
                                @if($r->op_status==1)
                                <span class="text-success" align="center"><i class="fa fa-check-circle"></i> done</span>
                                @else
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==2)
                                <input class="id" type="hidden" value="{{$r->patient_id}}">
                                <input class="hpercode" type="hidden" value="{{$r->hpercode}}">
                                <button class="btn btn-sm btn-primary btnComplete"><i class="fa fa-save"></i>
                                    complete</button>
                                @else
                                <span class="text-dark">...</span>
                                @endif
                                @endif
                            </td>
                            <td>
                               @if($r->date_finish == NULL)
                               @else
                               <small>{{date('F j, Y, g:i a', strtotime($r->date_finish))}}</small>
                               @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-secondary">
                <h4 class="text-center">Room 5</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td colspan="8" align="center">
                                <h3>No scheduled patients</h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- ROOM 5 --}}
    @if(count($or6)>0)
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="text-center">Room 6</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th width="5%">Date Reserve</th>
                            <th width="20%">Patient</th>
                            <th width="28%">Surgeon</th>
                            <th width="15%">Anesthesiologist</th>
                            <th width="15%">Procedure/s</th>
                            <th width="5%">Status</th>
                            <th width="8%">Date Finish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($or6 as $r)
                        <tr>
                            <td><small>{{date('F j, Y', strtotime($r->date_of_sched))}}</small></td>
                            <td>{{$r->patlast}}, {{$r->patfirst}} {{$r->patmiddle}}</td>
                            <td><small> Dr/s. {{$r->surgeon}}</small></td>
                            <td><small>{{$r->anes}}</small></td>
                            <td>{{$r->procedures}}</td>
                            <td align="center">
                                @if($r->op_status==1)
                                <span class="text-success" align="center"><i class="fa fa-check-circle"></i> done</span>
                                @else
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==2)
                                <input class="id" type="hidden" value="{{$r->patient_id}}">
                                <input class="hpercode" type="hidden" value="{{$r->hpercode}}">
                                <button class="btn btn-sm btn-primary btnComplete"><i class="fa fa-save"></i>
                                    complete</button>
                                @else
                                <span class="text-dark">...</span>
                                @endif
                                @endif
                            </td>
                            <td>
                               @if($r->date_finish == NULL)
                               @else
                               <small>{{date('F j, Y, g:i a', strtotime($r->date_finish))}}</small>
                               @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-secondary">
                <h4 class="text-center">Room 6</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td colspan="8" align="center">
                                <h3>No scheduled patients</h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- ROOM 6 --}}
    @if(count($or7)>0)
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="text-center">Room 7</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th width="5%">Date Reserve</th>
                            <th width="20%">Patient</th>
                            <th width="28%">Surgeon</th>
                            <th width="15%">Anesthesiologist</th>
                            <th width="15%">Procedure/s</th>
                            <th width="5%">Status</th>
                            <th width="8%">Date Finish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($or7 as $r)
                        <tr>
                            <td><small>{{date('F j, Y', strtotime($r->date_of_sched))}}</small></td>
                            <td>{{$r->patlast}}, {{$r->patfirst}} {{$r->patmiddle}}</td>
                            <td><small> Dr/s. {{$r->surgeon}}</small></td>
                            <td><small>{{$r->anes}}</small></td>
                            <td>{{$r->procedures}}</td>
                            <td align="center">
                                @if($r->op_status==1)
                                <span class="text-success" align="center"><i class="fa fa-check-circle"></i> done</span>
                                @else
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==2)
                                <input class="id" type="hidden" value="{{$r->patient_id}}">
                                <input class="hpercode" type="hidden" value="{{$r->hpercode}}">
                                <button class="btn btn-sm btn-primary btnComplete"><i class="fa fa-save"></i>
                                    complete</button>
                                @else
                                <span class="text-dark">...</span>
                                @endif
                                @endif
                            </td>
                            <td>
                               @if($r->date_finish == NULL)
                               @else
                               <small>{{date('F j, Y, g:i a', strtotime($r->date_finish))}}</small>
                               @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-secondary">
                <h4 class="text-center">Room 7</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td colspan="8" align="center">
                                <h3>No scheduled patients</h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- ROOM 7 --}}
    @if(count($or8)>0)
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="text-center">Room 8</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th width="5%">Date Reserve</th>
                            <th width="20%">Patient</th>
                            <th width="28%">Surgeon</th>
                            <th width="15%">Anesthesiologist</th>
                            <th width="15%">Procedure/s</th>
                            <th width="5%">Status</th>
                            <th width="8%">Date Finish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($or8 as $r)
                        <tr>
                            <td><small>{{date('F j, Y', strtotime($r->date_of_sched))}}</small></td>
                            <td>{{$r->patlast}}, {{$r->patfirst}} {{$r->patmiddle}}</td>
                            <td><small> Dr/s. {{$r->surgeon}}</small></td>
                            <td><small>{{$r->anes}}</small></td>
                            <td>{{$r->procedures}}</td>
                            <td align="center">
                                @if($r->op_status==1)
                                <span class="text-success" align="center"><i class="fa fa-check-circle"></i> done</span>
                                @else
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==2)
                                <input class="id" type="hidden" value="{{$r->patient_id}}">
                                <input class="hpercode" type="hidden" value="{{$r->hpercode}}">
                                <button class="btn btn-sm btn-primary btnComplete"><i class="fa fa-save"></i>
                                    complete</button>
                                @else
                                <span class="text-dark">...</span>
                                @endif
                                @endif
                            </td>
                            <td>
                               @if($r->date_finish == NULL)
                               @else
                               <small>{{date('F j, Y, g:i a', strtotime($r->date_finish))}}</small>
                               @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-secondary">
                <h4 class="text-center">Room 8</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td colspan="8" align="center">
                                <h3>No scheduled patients</h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- COVID ROOM --}}
    @if(count($or9)>0)
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="text-center">Covid Room</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th width="5%">Date Reserve</th>
                            <th width="20%">Patient</th>
                            <th width="28%">Surgeon</th>
                            <th width="15%">Anesthesiologist</th>
                            <th width="15%">Procedure/s</th>
                            <th width="5%">Status</th>
                            <th width="8%">Date Finish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($or9 as $r)
                        <tr>
                            <td><small>{{date('F j, Y', strtotime($r->date_of_sched))}}</small></td>
                            <td>{{$r->patlast}}, {{$r->patfirst}} {{$r->patmiddle}}</td>
                            <td><small> Dr/s. {{$r->surgeon}}</small></td>
                            <td><small>{{$r->anes}}</small></td>
                            <td>{{$r->procedures}}</td>
                            <td align="center">
                                @if($r->op_status==1)
                                <span class="text-success" align="center"><i class="fa fa-check-circle"></i> done</span>
                                @else
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 ||
                                App\Http\Controllers\LoggedUser::user_role()==2)
                                <input class="id" type="hidden" value="{{$r->patient_id}}">
                                <input class="hpercode" type="hidden" value="{{$r->hpercode}}">
                                <button class="btn btn-sm btn-primary btnComplete"><i class="fa fa-save"></i>
                                    complete</button>
                                @else
                                <span class="text-dark">...</span>
                                @endif
                                @endif
                            </td>
                            <td>
                               @if($r->date_finish == NULL)
                               @else
                               <small>{{date('F j, Y, g:i a', strtotime($r->date_finish))}}</small>
                               @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-6">
        <div class="card">
            <div class="card-header bg-secondary">
                <h4 class="text-center">Covid Room</h4>
            </div>
            <div class="card-body" style="width: 100%; height: 350px; overflow: auto;" style="width: 100%; height: 350px; overflow: auto;">
                <table class="table table-striped table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td colspan="8" align="center">
                                <h3>No scheduled patients</h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

@section('script')
<script src="{{asset('js/room.js')}}"></script>
<script>
    //   $('#btnTrig').trigger('click');
</script>
@endsection

