@extends('layouts.master')
@section('content')

<div class="col-12"></div>
<div class="w-100"></div>
<div class="mt-3">
    <h2 class=""><svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-people-fill" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
        </svg> Patients</h2>
</div>
<hr>

<div class="row">
    <div class="col">
        <button type="button" class="btn btn-lg btn-outline-primary mb-2 shadow" data-toggle="modal"
            data-target="#patsearchmodal">
            Add Patient
            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-person-plus mb-1" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM6 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm4.5 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                <path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z" />
            </svg>
        </button>
    </div>

    {{-- @foreach($pat_hper as $p)
        <input type="text" class="hpercode" id="hpercode" value="{{$p->patient_id}}" hidden>
        <button class="btn btn-primary" id="btnTrig" hidden></button>
    @endforeach --}}
    
</div>
<div class="row">
    <div class="col row">
        <div class="col-lg-12">
        </div>
        <div class="col">
            <div class="">
                <div class="card-body" style="width: 100%; height: 750px; overflow: auto;">
                    <table class="table table-condensed table-hover table-striped" id="myTable1">
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th>Hospital #</th>
                                <th>Full Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Ward</th>
                                <th>Type</th>
                                <th>Admission Date and Time</th>
                                <th>Scheduled Date</th>
                                <th>Action</th>
                                @if(App\Http\Controllers\LoggedUser::user_role() == 1)
                                <th>Entry by</th>
                                @else
                                {{-- <th></th> --}}
                                @endif
                                {{-- <th>Logs</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patients as $pat)
                            <tr>
                                <td>
                                    <span class="text-muted"><small>{{$pat->hpercode}}</small></span>
                                </td>
                                <td>
                                    <b>{{$pat->patlast}},</b> {{$pat->patfirst}} <small
                                        class="text-muted">{{$pat->patmiddle}}</small>
                                </td>
                                <td>
                                    {{$pat->patage}}
                                </td>
                                <td>
                                    @if($pat->patsex == 'F')
                                    Female
                                    @else
                                    Male
                                    @endif
                                </td>
                                <td>
                                    {{$pat->patward}}
                                </td>
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
                                    <small>{{date('F j, Y, g:i a', strtotime($pat->adm_date))}}</small>
                                </td>
                                @if($pat->date_of_sched == NULL)
                                <td>
                                    <small><span class="badge badge-pill badge-dark">No Scheduled date </span></small>
                                </td>
                                @else
                                <td>
                                    <small>{{date('F j, Y', strtotime($pat->date_of_sched))}}</small>
                                </td>
                                @endif
                                <td>
                                    @if($pat->scheduled == NULL)
                                    <div class="row">
                                        <span class="text-muted mr-1">No schedule yet</span>
                                        @if(App\Http\Controllers\LoggedUser::getuser())
                                        <form action="{{route('myschedules')}}" method="POST">
                                            @csrf
                                            <input name="myTrigger" type="hidden" value="test" hidden>
                                            <button class=" ml-1 mx-auto btn btn-outline-primary btn-sm">Create Schedule</button>
                                        </form>
                                        @endif
                                    </div>
                                    @elseif($pat->accept == NULL)
                                    <span class="font-weight-bold text-primary">Waiting to Accept</span>
                                    @else
                                    <span class="font-weight-bold">Scheduled </span>
                                    @if(App\Http\Controllers\LoggedUser::getuser())
                                    <form action="{{route('myschedules')}}" method="POST">
                                        @csrf
                                        <input name="myTrigger" type="hidden" value="test" hidden>
                                        <button class=" ml-1 mx-auto btn btn-outline-danger btn-sm">Create Another Schedule</button>
                                    </form>
                                    @endif
                                    @endif
                                </td>
                                @if(App\Http\Controllers\LoggedUser::user_role() == 1)
                                <td>
                                    <small>{{$pat->lastname}}, {{$pat->firstname}} {{$pat->middlename}}</small>
                                </td>
                                @endif
                                {{-- <td>
                                    <input type="text" class="hpercode" id="hpercode" value="{{$pat->hpercode}}" hidden>
                                    <button type="button" class="btn btn-outline-primary btn-sm btnViewLogs" data-toggle="modal"
                                        data-target="#viewPat{{$pat->hpercode}}">
                                        View
                                    </button>
                                </td> --}}
{{-- 
                                <div class="modal fade" id="viewPat{{$pat->hpercode}}" tabindex="-1" aria-labelledby="viewPatLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable exmode">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewPatLabel">Historical Logs of Patient:
                                                    <b>{{$pat->patlast}}, </b> {{$pat->patfirst}} <small
                                                        class="text-muted">{{$pat->patmiddle}}</small></h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md-12 ">
                                                    <input type="text" class="hpercode" value="{{$pat->hpercode}}" hidden>
                                                    <ul class="timeline font-weight-normal">
                                                        @foreach($histo as $h)
                                                        <li>
                                                            <a onclick="return false;" href="">{{$h->act_details}}</a>
                                                            <a onclick="return false;" href="" class="float-right">{{date('F j, Y, g:i a', strtotime($h->created_at))}}</a>
                                                            <p> - Entry by {{$h->firstname}} {{$h->middlename}} {{$h->lastname}}</p>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top-0">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="patsearchmodal" tabindex="-1" role="dialog" aria-labelledby="patsearchmodalTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="patsearchmodalTitle">Search Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <label for="hospnumber">HOSPITAL NUMBER</label>
                        <input type="text" id="hospnumber" name="hospnumber" class="form-control">
                        <label for="patlast">LAST NAME:</label>
                        <input type="text" id="patlast" name="patlast" class="form-control">
                        <label for="patfirst">FIRST NAME:</label>
                        <input type="text" id="patfirst" name="patfirst" class="form-control">
                        <label for="patmiddle">MIDDLE NAME:</label>
                        <input type="text" id="patmiddle" name="patmiddle" class="form-control">
                        <button class="btn btn-primary btn-lg mt-3 btn-block" onclick="genpatlist()">Retrieve</button>
                    </div>
                    <div class="col-sm-6" style="height: 300px; overflow: auto;">
                        <table class="table table-bordered" style="width: 100%" id="modalenclist">
                            <thead class="bg-success text-white">
                                <th style="width: 20%">
                                    DATE/TIME
                                </th>
                                <th style="width: 20%">
                                    TYPE
                                </th>
                                <th style="width: 50%">
                                    FINAL DIAGNOSIS
                                </th>
                                <th style="width: 10%">
                                    ACTION
                                </th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12 mt-2">
                        <table class="table table-striped" style="width: 100%;" id="modalpatlist">
                            <thead class="bg-success text-white">
                                {{-- <th>
                                    ACTION
                                </th> --}}
                                <th>
                                    HOSP NUMBER
                                </th>
                                <th>
                                    LAST NAME
                                </th>
                                <th>
                                    FIRST NAME
                                </th>
                                <th>
                                    MIDDLE NAME
                                </th>
                                <th>
                                    BIRTH DATE
                                </th>
                                <th>
                                    BIRTHPLACE
                                </th>
                                <th>
                                    SEX
                                </th>
                                <th>
                                    ACTION
                                </th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('js/scripts.js')}}"></script>
<script src="{{asset('js/moment.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        $('#myTable1').DataTable();
    });

    function genpatlist() {
        var hospnumber = $("#hospnumber").val();
        var patlast = $("#patlast").val();
        var patfirst = $("#patfirst").val();
        var patmiddle = $("#patmiddle").val();
        var template = '';
        $.ajax({
            type: "POST",
            url: '/JS/genpatientlist',
            data: {
                hospnumber: hospnumber,
                patlast: patlast,
                patfirst: patfirst,
                patmiddle: patmiddle
            },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.length > 0) {
                    $('#modalpatlist tbody').empty();
                    $('#modalenclist tbody').empty();
                    data.forEach(element => {
                        template += '<tr>' +
                            // '<td><a href="#" id="btnSelect" class="btn btn-primary" data-hpercode="' +
                            // element.hpercode + '">Encounter History</a></td>' +
                            '<td>' + element.hpercode + '</td>' +
                            '<td>' + element.patlast + '</td>' +
                            '<td>' + element.patfirst + '</td>' +
                            '<td>' + element.patmiddle + '</td>' +
                            '<td>' + moment(element.patbdate).format('LL') + '</td>' +
                            '<td>' + element.patbplace + '</td>' +
                            '<td>' + element.patsex + '</td>' +
                            '<td>' +
                            '<form action="/patientdetails" method="POST" enctype="multipart/form-data">' +
                            '@csrf' +
                            '<input type="text" name="enccode" id="enccode" value="' + element
                            .enccode + '" hidden>' +
                            '<a href="#" id="btnSelect" class="btn btn-primary" data-hpercode="' +
                            element.hpercode + '">Encounter History</a>' +
                            // '<button type="submit" class="btn btn-primary">LATEST ENCOUNTER</button>' +
                            '</form>' +
                            '</td>' +
                            '</tr>';
                    });
                    $('#modalpatlist tbody').append(template);
                } else {
                    alert("NO PATIENT FOUND");
                }
            }
        });
    };

    $(document).on('click', '#btnSelect', function () {
        var hpercode = $(this).attr('data-hpercode');
        var template = '';
        $.ajax({
            type: "POST",
            url: '/JS/genenclist',
            data: {
                hpercode: hpercode
            },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.length > 0) {
                    $('#modalenclist tbody').empty();
                    data.forEach(element => {
                        template += '<tr>' +
                            '<td>' + '<small>' + moment(element.admdate).format('LL LT') +
                            '</small>' + '</td>' +
                            '<td>' + element.toecode + '</td>' +
                            '<td>' + element.findx + '</td>' +
                            '<td>' +
                            '<form action="/patientdetails" method="POST" enctype="multipart/form-data">' +
                            '@csrf' +
                            '<input type="text" name="enccode" id="enccode" value="' +
                            element.enccode + '" hidden>' +
                            '<input type="text" name="hpercode" id="hpercode" value="' +
                            element.hpercode + '" hidden >' +
                            '<button type="submit" class="btn btn-primary btnSelect">SELECT</button>' +
                            '</form>' +
                            '</td>' +
                            '</tr>';
                    });
                    $('#modalenclist tbody').append(template);
                } else {
                    alert("NO ENCOUTER FOUND");
                }

            },
        });
    })

    $(function () {
        var trigger = $('#hpercode').val();

        if (trigger != '') {
            $('#btnViewLogs').trigger('click');
        } else {

        }
    });

</script>

@endsection
@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<style>
    .modal-lg {
        max-width: 80% !important;
        margin-left: 15% !important;
    }

    .exmode {
        max-width: 50% !important;
    }

    ul.timeline {
        list-style-type: none;
        position: relative;
    }

    ul.timeline:before {
        content: ' ';
        background: #d4d9df;
        display: inline-block;
        position: absolute;
        left: 29px;
        width: 2px;
        height: 100%;
        z-index: 400;
    }

    ul.timeline>li {
        margin: 20px 0;
        padding-left: 70px;
    }

    ul.timeline>li:before {
        content: ' ';
        background: white;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 3px solid #22c0e8;
        left: 20px;
        width: 20px;
        height: 20px;
        z-index: 400;
    }

</style>
