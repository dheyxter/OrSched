<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BGHMC | OR SCHEDULER</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script src="{{ asset('js/app.js') }}"> </script>
    <script src="jquery3.5.1.js"></script>
    <link rel="icon" href="../img/bghmc.png" type="image/png">
    <link rel="stylesheet" href="/css/app.css">
    <style>
        @media print {
            @page {
                size: landscape !important
            }

            table, th, td {
                border: 1px solid black !important;
                }
        }
        
        body {
            background-color: #fff;
            /* color: #636b6f; */
            font-family: 'Roboto', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: -1;
        }

        .border {
            border: 1px solid black !important;
        }

        .border-right-0 {
            border-right: none !important;
        }

        .border-top-0 {
            border-top: none !important;
        }

        .border-left-0 {
            border-left: none !important;
        }

        .border-bottom-0 {
            border-bottom: none !important;
        }
        table, th, td {
            border: 1px solid black !important;
            }
    </style>
    <script type="text/javascript">
        $(function () {
            $('.printMe').click(function () {
                window.print();
                // pop_searchPatient();
            });
        });

    </script>
</head>

<body>
    <div class="col-12 bg-dark">
        <button class="printMe btn btn-lg btn-primary mt-2 mb-2 d-print-none"><i class="fas fa-print"></i>
            Print</button>
    </div>
    <div class="container-fluid">
        <div class="row mt-3 no-gutters ml-2">
            <div class="col-2 border border-right-0" align="center">
                <img src="../img/bghmc.png" class="mt-4 mb-0" width="100" height="100" alt="">
            </div>
            <div class="col-10 border no-gutters">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center"><small>Republic of the Philippines</small></div>
                        <div class="text-center"><small>Department of Health</small></div>
                        <div class="text-center text-uppercase font-weight-bold"><small>baguio general hospital and medical
                            center</small> </div>
                        <div class="text-center"><small>Baguio City</small> </div>
                    </div>
                </div>
                <div class="no-gutters row">
                    <div class="col-7 border border-left-0 border-right-0 border-bottom-0">
                        <div class="text-center mt-1">
                            <span class="font-weight-bold">OPERATING ROOM</span>
                            <h5 class="font-weight-bold">EMERGENCY LOGBOOK</h5>
                        </div>
                    </div>
                    <div class="col-5 form-inline">
                        <div class="col-5 border border-bottom-0" align="right"><small>Form No.:</small></div>
                        <div class="col-7 border border-left-0 border-right-0 border-bottom-0" align="center"><small>NS-OR-006</small></div>
                        <div class="w-100"></div>
                        <div class="col-5 border border-bottom-0" align="right"><small>Rev.No:</small></div>
                        <div class="col-7 border border-left-0 border-right-0 border-bottom-0" align="center"><small>Ø</small></div>
                        <div class="w-100"></div>
                        <div class="col-5 border border-bottom-0" align="right"><small>Effectivity Date:</small></div>
                        <div class="col-7 border border-left-0 border-right-0 border-bottom-0" align="center"><small>August 1, 2014</small></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100 mb-4"></div>
        <table class="table table-sm table-bordered">
            <thead align="center">
                <th><small><b>Date and Time</b></small></th>
                <th><small><b>Ward</b></small></th>
                <th><small><b>Ward</b></small></th>
                <th><small><b>Name of Patient</b></small></th>
                <th><small><b>Age/Sex</b></small></th>
                <th><small><b>Procedure/s</b></small></th>
                <th><small><b>Surgeon</b></small></th>
                <th><small><b>Ward Nurse on Duty</b></small></th>
            </thead>
            <tbody>
                @foreach ($tot as $t)
                    <tr>
                        <td width="11%"><small>{{date('Y-m-d, h:i A', strtotime($t->created_at))}}</small></td>
                        <td>
                            @if($t->tscode == 'SURGE')
                            <small>SURGERY</small>
                        @elseif($t->tscode == 'MEDIC')
                            <small>MEDICINE</small>
                        @elseif($t->tscode == 'PEDIA')
                            <small>PEDIATRICS</small>
                        @elseif($t->tscode == 'ENTHN')
                            <small>ENTHN</small>
                        @elseif($t->tscode == 'OPTHA')
                            <small>OPTHALMOLOGY</small>
                        @elseif($t->tscode == 'ORTHO')
                            <small>ORTHPEDICS</small>
                        @elseif($t->tscode == 'OB' || $t->tscode == 'OBSTE')
                            <small>OBSTETRICS</small>
                        @elseif($t->tscode == 'GYNEC')
                            <small>GYNECOLOGY</small>
                        @else
                            <small>OTHERS</small>
                        @endif
                        </td>
                        <td width="10%"><small>{{$t->patward}}</small></td>
                        <td width="20%"><small>{{$t->patlast}}, {{$t->patfirst}} {{$t->patmiddle}}</small></td>
                        <td width="5%"><small>{{$t->patage}} / {{$t->patsex}}</small></td>
                        <td width="20%"><small>{{$t->procedures}}</small></td>
                        <td width="15%"><small class="text-uppercase">DR. {{$t->surgeon}}</small></td>
                        <td width="13%"><small>{{$t->entry_by}}</small></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</body>

</html>
