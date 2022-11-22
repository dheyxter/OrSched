@extends('layouts.master')

@section('content')
<div class="col-12">
    {{-- <input type="hidden" id="triggerInput" value="{{$getTrigger}}"> --}}
</div>
<div class="w-100"></div>
<div class="mt-3">
    <h2 class=""><svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-calendar2-plus" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8 8a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H6a.5.5 0 0 1 0-1h1.5V8.5A.5.5 0 0 1 8 8z" />
            <path fill-rule="evenodd" d="M7.5 10.5A.5.5 0 0 1 8 10h2a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0v-2z" />
            <path fill-rule="evenodd" d="M14 2H2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM2 1a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z" />
            <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z" />
            <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z" />
        </svg> View Final Schedule</h2>
</div>
<hr>
<div class="container-fluid">
    <div class="row">
     <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
               <div class="row">
                   <div class="col-lg-6">
                    <h3></h3>
                   </div>
                   <div class="col-lg-6">
                    <form action="{{route('anesSched2')}}" method="POST">
                        @csrf
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-secondary text-light mr-2" id="basic-addon1">Select
                                Scheduled Date - <i class="ml-2 fa fa-calendar-day"></i></span>
                            <input type="date" class="form-control mr-3" id="selectdate" name="selectdate"
                                value="{{$datetoday}}">
                            <button type="submit" class="btn btn-success" type="button" id="btnGenerate">Generate
                                List</button>
                        </div>
                    </form>
                   </div>
               </div>
            </div>
            <div class="card-body" style="width: 100%; height: 600px; overflow: auto;">
                {{-- <table class="table table-bordered table-hover">
                    <thead class="text-center h5">
                        <th>Room 1</th>
                        <th>Room 2</th>
                        <th>Room 3</th>
                        <th>Room 4</th>
                        <th>Room 5</th>
                        <th>Room 6</th>
                        <th>Room 7</th>
                        <th>Room 8</th>
                        <th>Annex 1</th>
                        <th>Annex 2</th>
                        <th>Annex 3</th>
                    </thead>
                    <tbody>
                        <tr>
                            
                        </tr>
                    </tbody>
                </table> --}}
                
                <table class="table table-sm table-striped table-hover table-bordered">
                    <thead>
                        <th>Room</th>
                        <th>Case #</th>
                        <th>Hosp. #</th>
                        <th>Patient</th>
                        <th>Ward</th>
                        <th>Type</th>
                        <th>Duration</th>
                        <th>SVC/PAY</th>
                        <th>Surgeon</th>
                        <th>Procedure</th>
                        <th class="text-center">Action</th>
                    </thead>
                    <tbody>
                        @foreach($scheds as $s)
                        <tr>
                            <td>
                                <small> 
                                    @if($s->annex == 1)
                                    Room 1 - MIS
                                    @elseif($s->annex == 2)
                                    Room 2 - ER
                                    @elseif($s->annex == 3)
                                    Room 3 - Surgery
                                    @elseif($s->annex == 4)
                                    Room 4 - OB Gyne
                                    @elseif($s->annex == 5)
                                    Room 5 - ENT
                                    @elseif($s->annex == 6)
                                    Room 6 - Ortho
                                    @elseif($s->annex == 7)
                                    Room 7 - Ophtha
                                    @elseif($s->annex == 8)
                                    Room 8 - Surgery
                                    @else
                                    
                                    @endif
                                </small>
                            </td>
                            <td><small>Case {{$s->case_num}}</small></td>
                            <td><small>{{$s->shortcode}}</small></td>
                            <td><b>{{$s->patlast}}</b>, {{$s->patfirst}} <small class="text-muted">{{$s->patmiddle}}</small></td>
                            <td><small>{{$s->patward}}</small></td>
                            <td>
                                @if($s->type == 0)
                               <span class="badge badge-warning"> Elective</span>
                                @else
                                <span class="badge badge-danger"> Emergent</span>
                                @endif
                            </td>
                            <td><small>{{$s->timeDuration}}</small></td>
                            <td><small> {{$s->adm_tacode == 'SERVI' ? "Service" : "Pay"}} </small></td>
                            <td><small>{{$s->surgeon}}</small></td>
                            <td><small>{{$s->procedures}}</small></td>

                            <td class="text-center">
                                @if(App\Http\Controllers\LoggedUser::user_role()==1 || App\Http\Controllers\LoggedUser::user_role()== 3)
                                    <button class="btn btn-outline-success" data-toggle="modal" data-target="#updPat{{$s->id}}">Update</button></td>
                                @elseif(App\Http\Controllers\LoggedUser::user_role()==1 || App\Http\Controllers\LoggedUser::user_role()== 2 || App\Http\Controllers\LoggedUser::user_role()== 5 )
                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#updPat{{$s->id}}">View</button></td>
                                @endif
                        </tr>

                        <div class="modal fade" id="updPat{{$s->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered">
                             <form action="{{route('getUpdate')}}" id="getAnesUpdate" method="POST">
                                 @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">
                                        <span class="text-warning ">VIEW OR SCHEDULE</span>
                                        <span><b>{{$s->patlast}}</b>, {{$s->patfirst}} <small class="text-muted">{{$s->patmiddle}}</small></span>
                                        <span class="text-muted ml-2">{{$s->hpercode}},</span>
                                        <span> <i>{{$s->patage}} y.o</i></span>
                                      </h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body py-2">
                                        <div class="row no-gutters">
                                            <div class="col-md-6">
                                                <div class="card shadow mr-1">
                                                    <div class="card-body py-2">
                                                        <div class="form-row py-1">
                                                            <div class="col bg-light py-1">
                                                                <span class="mb-0"> <mark><i class="fa fa-calendar-alt"></i> Scheduled Date </mark> </span>
                                                                <div class="input-group">
                                                                    <input type="date" class="form-control is-required" name="adm_date" value="{{date('Y-m-d', strtotime($s->date_of_sched))}}" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row py-1">
                                                            <div class="col-7 bg-light py-1">
                                                                <span class="mb-0"> <mark> Type of Service </mark> </span>
                                                                <div class="input-group"> 
                                                                    @if($s->tscode !=NULL)
                                                                    @if($s->tscode == 'ENTHN')
                                                                        <input type="text" class="form-control is-required" value="ENT-HNS" disabled>
                                                                    @elseif($s->tscode == 'GYNEC')
                                                                        <input type="text" class="form-control is-required" value="GYNECOLOGY" disabled>
                                                                    @elseif($s->tscode == 'MEDIC')
                                                                        <input type="text" class="form-control is-required" value="MEDICINE" disabled>
                                                                    @elseif($s->tscode == 'MEDNE')
                                                                        <input type="text" class="form-control is-required" value="NEUROSCIENCE" disabled>
                                                                    @elseif($s->tscode == 'OBSTE')
                                                                        <input type="text" class="form-control is-required" value="OBSTETRICS" disabled>
                                                                    @elseif($s->tscode == 'OPTHA')
                                                                        <input type="text" class="form-control is-required" value="OPHTHALMOLOGY" disabled>
                                                                    @elseif($s->tscode == 'ORTHO')
                                                                        <input type="text" class="form-control is-required" value="ORTHOPEDICS" disabled>
                                                                    @elseif($s->tscode == 'PEDIA')
                                                                        <input type="text" class="form-control is-required" value="PEDIATRICS" disabled>
                                                                    @elseif($s->tscode == 'PNCU')
                                                                        <input type="text" class="form-control is-required" value="PEDIA - PNCU" disabled>
                                                                    @elseif($s->tscode == 'PSYCH')
                                                                        <input type="text" class="form-control is-required" value="PSYCHIATRY" disabled>
                                                                    @elseif($s->tscode == 'SURGE')
                                                                        <input type="text" class="form-control is-required" value="SURGERY" disabled>
                                                                    @else
                                                                        <input type="text" class="form-control is-required" value="" disabled>
                                                                    @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-5 bg-light py-1">
                                                                <span class="mb-0"> <mark> Type of Accomodation </mark> </span>
                                                                <div class="input-group">
                                                                    @if($s->adm_tacode != NULL)
                                                                        @if($s->adm_tacode == 'SERVI')
                                                                            <input type="text" class="form-control is-required" value="Service" disabled>
                                                                        @elseif($s->adm_tacode == 'PAY')
                                                                            <input type="text" class="form-control is-required" value="Pay" disabled>
                                                                        @else
                                                                            <input type="text" class="form-control is-required" value="{{$s->adm_tacode}}" disabled>
                                                                        @endif
                                                                    @elseif($s->opd_tacode != NULL)
                                                                        @if($s->opd_tacode == 'SERVI')
                                                                            <input type="text" class="form-control is-required" value="Service" disabled>
                                                                        @elseif($s->opd_tacode == 'PAY')
                                                                            <input type="text" class="form-control is-required" value="Pay" disabled>
                                                                        @else
                                                                            <input type="text" class="form-control is-required" value="{{$s->opd_tacode}}" disabled>
                                                                        @endif
                                                                    @else
                                                                        @if($s->er_tacode == 'SERVI')
                                                                            <input type="text" class="form-control is-required" value="Service" disabled>
                                                                        @elseif($s->er_tacode == 'PAY')
                                                                            <input type="text" class="form-control is-required" value="Pay" disabled>
                                                                        @else
                                                                            <input type="text" class="form-control is-required" value="{{$s->er_tacode}}" disabled>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row py-1">
                                                            <div class="col-md-6 bg-light py-1 mb-5">
                                                                <span class="mb-0"> <mark> Time Start</mark> </span>
                                                                @if($s->timeStart !=NULL)
                                                                    <input type="time" name="time_start" class="form-control is-required time_start" id="time_start" value="{{date('H:i', strtotime($s->timeStart))}}" disabled>
                                                                @else
                                                                    <input type="time" name="time_start" class="form-control is-required time_start" id="time_start" value="" disabled >
                                                                @endif
                                                            </div>
                                                            <div class="col-md-6 bg-light py-1 mb-5">
                                                                <span class="mb-0"> <mark> Estimated Time Duration</mark> </span>
                                                                @if($s->timeDuration !=NULL)
                                                                    <input type="text" name="time_duration" class="form-control is-required time_duration" id="time_duration" value="{{$s->timeDuration}}" disabled>
                                                                @else
                                                                    <input type="text" name="time_duration" class="form-control is-required time_duration" id="time_duration" value="" placeholder="" disabled>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card shadow mr-1">
                                                    <div class="card-body py-2">
                                                        <div class="form-row py-1">
                                                            <div class="col-6 bg-light py-1">
                                                                <span class="mb-0"> <mark> Case Number </mark> </span>
                                                                <div class="input-group">
                                                                    <select name="case_num" class="form-control is-required " id="case_num" disabled>
                                                                        <option value="" disabled>Select Case Number</option>
                                                                        @if($s->case_num == 1)
                                                                            <option value="1" selected>Case 1</option>
                                                                        @else
                                                                            <option value="1">Case 1</option>
                                                                        @endif
                                                                        
                                                                        @if($s->case_num == 2)
                                                                            <option value="2" selected>Case 2</option>
                                                                        @else
                                                                            <option value="2">Case 2</option>
                                                                        @endif
                                                                        
                                                                        @if($s->case_num == 3)
                                                                            <option value="3" selected>Case 3</option>
                                                                        @else
                                                                            <option value="3">Case 3</option>
                                                                        @endif
                                                                        
                                                                        @if($s->case_num == 4)
                                                                            <option value="4" selected>Case 4</option>
                                                                        @else
                                                                            <option value="4">Case 4</option>
                                                                        @endif
                                                                        
                                                                        @if($s->case_num == 5)
                                                                            <option value="5" selected>Case 5</option>
                                                                        @else
                                                                            <option value="5">Case 5</option>
                                                                        @endif
                                                                        
                                                                        @if($s->case_num == 6)
                                                                            <option value="6" selected>Case 6</option>
                                                                        @else
                                                                            <option value="6">Case 6</option>
                                                                        @endif
                                                                        
                                                                        @if($s->case_num == 7)
                                                                            <option value="7" selected>Case 7</option>
                                                                        @else
                                                                            <option value="7">Case 7</option>
                                                                        @endif
                                                                        
                                                                        @if($s->case_num == 8)
                                                                            <option value="8" selected>Case 8</option>
                                                                        @else
                                                                        <option value="8">Case 8</option>
                                                                        @endif
                                                                        
                                                                        @if($s->case_num == 9)
                                                                            <option value="9" selected>Case 9</option>
                                                                        @else
                                                                        <option value="9">Case 9</option>
                                                                        @endif
                                                                        
                                                                        @if($s->case_num == 10)
                                                                            <option value="10" selected>Case 10</option>
                                                                        @else
                                                                        <option value="10">Case 10</option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 bg-light py-1">
                                                                <span class="mb-0"> <mark> Room / Annex </mark> </span>
                                                                <div class="input-group">
                                                                    <select name="romm" class="form-control is-required" id="room" disabled>
                                                                        <option value="" disabled>Select Room</option>

                                                                         @if ($s->annex == 1)
                                                                        <option value="1" selected>Annex 1 - Private</option>
                                                                        @else
                                                                        <option value="1">Annex 1 - Private</option>
                                                                        @endif

                                                                        @if ($s->annex == 2)
                                                                        <option value="2" selected>Annex 2 - Private</option>
                                                                        @else
                                                                        <option value="2">Annex 2 - Private</option>
                                                                        @endif

                                                                        @if ($s->annex == 3)
                                                                        <option value="3" selected>Annex 3 - Private</option>
                                                                        @else
                                                                        <option value="3">Annex 3 - Private</option>
                                                                        @endif
                                                                        @if ($s->annex == 4)
                                                                        <option value="4" selected>Room 1 - ER</option>
                                                                        @else
                                                                        <option value="4">Room 1 - ER</option>
                                                                        @endif

                                                                        @if ($s->annex == 5)
                                                                        <option value="5" selected>Room 2 - Optha</option>
                                                                        @else
                                                                        <option value="5">Room 2 - Optha</option>
                                                                        @endif

                                                                        @if ($s->annex == 6)
                                                                        <option value="6" selected>Room 3</option>
                                                                        @else
                                                                        <option value="6">Room 3</option>
                                                                        @endif

                                                                        @if ($s->annex == 7)
                                                                        <option value="7" selected>Room 4</option>
                                                                        @else
                                                                        <option value="7">Room 4</option>
                                                                        @endif

                                                                        @if ($s->annex == 8)
                                                                        <option value="8" selected>Room 5</option>
                                                                        @else
                                                                        <option value="8">Room 5</option>
                                                                        @endif

                                                                        @if ($s->annex == 9)
                                                                        <option value="9" selected>Room 6</option>
                                                                        @else
                                                                        <option value="9">Room 6</option>
                                                                        @endif

                                                                        @if ($s->annex == 10)
                                                                        <option value="10" selected>Room 7 - Optha</option>
                                                                        @else
                                                                        <option value="10">Room 7 - Optha</option>
                                                                        @endif
                                                                        @if ($s->annex == 11)
                                                                        <option value="11" selected>Room 8 </option>
                                                                        @else
                                                                        <option value="11">Room 8 </option>
                                                                        @endif
                                                                        @if ($s->annex == 12)
                                                                        <option value="12" selected>Covid Room </option>
                                                                        @else
                                                                        <option value="12">Covid Room </option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row py-1">
                                                            <div class="col bg-light py-1">
                                                                <span class="mb-0"> <mark> Surgeon </mark> </span>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control text-uppercase" name="surgeons" value="{{$s->surgeon}}" id="surgeon" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row py-1">
                                                            <div class="col bg-light py-1">
                                                                <span class="mb-0"> <mark> Type of Anesthesia </mark> </span>
                                                                <div class="input-group">
                                                                    <select class="form-control col-sm-12 is-required" name="typeAnes" id="typeAnes" disabled>
                                                                        <option disabled value="">-- Select Type of Anesthesia --</option>
                                                                        @foreach(\App\Http\Controllers\ReservationController::anestype() as $type)
                                                                        <option value="{{$type->shortcode}}">
                                                                            {{$type->anesname}}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row py-1">
                                                            <div class="col bg-light py-1">
                                                                <span class="mb-0"> <mark> Anesthesiologist </mark> </span>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" name="anes" id="anes" value="{{$s->anes}}" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-100"></div>
                                            <div class="col-md-6">
                                                <div class="card shadow mr-1">
                                                    <div class="card-body py-2">
                                                        <div class="form-row py-1">
                                                            <div class="col bg-light py-1">
                                                                <span class="mb-0"> <mark> Procedures </mark> </span>
                                                                <div class="input-group">
                                                                    <textarea name="procedure" class="form-control is-required" id="procedure" cols="100" rows="3" value="{{$s->procedures}}" disabled>{{$s->procedures}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card shadow mr-1">
                                                    <div class="card-body py-2">
                                                        <div class="form-row py-1">
                                                            <div class="col bg-light py-1">
                                                                <span class="mb-0"> <mark> Instrument's Needed </mark> </span>
                                                                <div class="input-group">
                                                                    <textarea name="instrument" class="form-control is-required" id="instrument" cols="80" rows="3" value="{{$s->instru}}" disabled>{{$s->instru}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        
                                        <input type="text" class="patID" name="patID" id="patID" value="{{$s->id}}" hidden>
                                      <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">CANCEL</button>
                                      @if(App\Http\Controllers\LoggedUser::user_role()==1 || App\Http\Controllers\LoggedUser::user_role()== 3)
                                      <button type="submit" class="btn btn-outline-primary btnUp" id="">UPDATE</button>
                                      @else
                                      @endif
                                    </div>
                                  </div>
                             </form>
                            </div>
                          </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6 text-right">
                        @if(App\Http\Controllers\LoggedUser::user_role()==1 || App\Http\Controllers\LoggedUser::user_role()== 3)
                        <a href="/index" class="btn btn-primary">Print Schedule</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
     </div>
    </div>
</div>


@endsection

@section('script')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script> --}}
    <script src="../js/bootstrap-select/select.js"></script>
    <script src="{{asset('js/anes.js')}}"></script>
    <script src="{{asset('js/scripts.js')}}"></script>
    <script src="{{asset('js/moment.js')}}"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    </script>
    @endsection
    @section('style')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" /> --}}
    {{-- <link rel="stylesheet" href="{{asset('css/bootstrap-select/select.css')}}"> --}}
    <link rel="stylesheet" href="../css/bootstrap-select/select.css">
    <style>
        .is-required {
            border-color: #28a745;
        }
        .is-required:focus {
            border-color: #28a745;
        }
    </style>
    @endsection