@extends('layouts.master')
@section('content')

<div class="mt-3">
    <h2 class=""> Patients</h2>
</div>
<hr>

<div class="row">
    <div class="col">
        <button type="button" class="btn btn-lg btn-outline-primary mb-2 shadow" data-toggle="modal" data-target="#patsearchmodal"> Add Patient </button>
    </div>
    
</div>
<div class="card">
    <div class="card-body" >
        <table class="table table-sm table-condensed table-hover table-striped" id="myTable1">
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
                    @if($user_role == 1)
                    <th>Entry by</th>
                    @endif
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
                            <small>No schedule yet</small>
                            {{-- <span class="text-muted mr-1">No schedule yet</span> --}}
                            @if(App\Http\Controllers\LoggedUser::getuser())
                            <form action="{{route('myschedules')}}" method="POST">
                                @csrf
                                <input name="myTrigger" type="hidden" value="test" hidden>
                                <input type="text" value="{{$pat->hpercode}}" name="hpercode" hidden>
                                <button class=" btn btn-outline-primary btn-sm">Create Schedule</button>
                            </form>
                            @endif
                        @elseif($pat->accept == NULL)
                        <span class="font-weight-bold text-primary">Waiting to Accept</span>
                        @else
                        <span class="font-weight-bold">Scheduled </span>
                        @if(App\Http\Controllers\LoggedUser::getuser())
                        <form action="{{route('myschedules')}}" method="POST">
                            @csrf
                            <input name="myTrigger" type="hidden" value="test" hidden>
                            <input type="text" value="{{$pat->hpercode}}" name="hpercode" hidden>
                            <button class=" btn btn-outline-danger btn-sm">Create Another Schedule</button>
                        </form>
                        @endif
                        @endif
                    </td>
                    @if(App\Http\Controllers\LoggedUser::user_role() == 1)
                    <td>
                        <small>{{$pat->lastname}}, {{$pat->firstname}} {{$pat->middlename}}</small>
                    </td>
                    @endif

                </tr>
                @endforeach
            </tbody>
        </table>
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
                    <div class="col-lg-6">
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
                        <span class="font-weight-bold text-danger h5">LIST OF ALL ACTIVE ENCOUNTERS</span>
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
                            '<input type="text" name="enccode" id="enccode" value="' + element.enccode + '" hidden>' +
                            '<input type="text" name="hpercode" id="hpercode" value="' + element.hpercode + '" hidden >' +
                            '<button type="submit" class="btn btn-primary btnSelect">SELECT</button>' +
                            '</form>' +
                            '</td>' +
                            '</tr>';
                    });
                    $('#modalenclist tbody').append(template);
                } else {
                    // alert("NO ACTIVE ENCOUNTER FOUND");
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'NO ACTIVE ENCOUNTER FOUND!'
                        // footer: '<a href>Why do I have this issue?</a>'
                        })
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
