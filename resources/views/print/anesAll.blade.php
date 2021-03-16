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
            margin: 0;
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
                        <div class="text-center mt-3">
                            <h4 class="font-weight-bold">SURGERY SCHEDULE</h4>
                        </div>
                    </div>
                    <div class="col-5 form-inline">
                        <div class="col-5 border border-bottom-0" align="right"><small>Form No.:</small></div>
                        <div class="col-7 border border-left-0 border-right-0 border-bottom-0" align="center"><small>MS-ANES-005</small></div>
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
                <th><small><b>RM</b></small></th>
                <th><small><b>NAME OF PATIENT</b></small></th>
                <th><small><b>AGE/SEX</b></small></th>
                <th><small><b>RM/WARD</b></small></th>
                <th><small><b>PROCEDURE</b></small></th>
                <th><small><b>INDUCTION TIME</b></small></th>
                <th><small><b>DURATION</b></small></th>
                <th><small><b>SURGEON</b></small></th>
                <th><small><b>ANESTHESIOLOGIST</b></small></th>
                <th><small><b>SVC/PAY</b></small></th>
            </thead>
            <tbody>
                @foreach ($tot as $t)
                <tr>
                    {{-- <td width="8%"><small>{{date('Y-m-d, h:i A', strtotime($t->created_at))}}</small></td> --}}
                    <td width="8%"><small>
                        @if($t->annex == 1)
                        A1
                        @elseif($t->annex == 2)
                        A2
                        @elseif($t->annex == 3)
                        A3
                        @elseif($t->annex == 4)
                        RM 1
                        @elseif($t->annex == 5)
                        RM 2
                        @elseif($t->annex == 6)
                        RM 3
                        @elseif($t->annex == 7)
                        RM 4
                        @elseif($t->annex == 8)
                        RM 5
                        @elseif($t->annex == 9)
                        RM 6
                        @elseif($t->annex == 10)
                        RM 7
                        @elseif($t->annex == 11)
                        RM 8
                        @else
                        COVID
                        @endif
                    </small></td>
                    <td width="20%"><small>{{$t->patlast}}, {{$t->patfirst}} {{$t->patmiddle}}</small></td>
                    <td width="5%"><small>{{$t->patage}} / {{$t->patsex}}</small></td>
                    <td><small>{{$t->patward}}</small></td>
                    <td width="20%"><small>{{$t->procedures}}</small></td>
                    <td width="8%"><small>{{date('h:i A', strtotime($t->created_at))}}</small></td>
                    <td width="8%"><small>
                        @if($t->op_duration == 60)
                        1 HR
                        @elseif($t->op_duration > 61 && $t->op_duration <= 120)
                        1-2 HRS
                        @elseif($t->op_duration > 121 && $t->op_duration <= 180)
                        3 HRS
                        @elseif($t->op_duration > 181 && $t->op_duration <= 240)
                        3-4 HRS
                        @elseif($t->op_duration <= 60)
                        BELOW 1 HR
                        @else
                        5HRS and up
                        @endif</small>
                    </td>
                    <td width="15%"><small class="text-uppercase">DR. {{$t->surgeon}}</small></td>
                    <td width="15%"><small class="text-uppercase">DR. {{$t->anes}}</small></td>
                    <td class="text-center">
                        @if($t->adm_tacode != NULL)
                            @if($t->adm_tacode = 'SERVI')
                                S
                            @elseif($t->adm_tacode = 'PAY')
                                P
                            @else 
                                {{$t->adm_tacode}}
                            @endif
                        @elseif($t->opd_tacode != NULL)
                                @if($t->opd_tacode = 'SERVI')
                                    S
                                @elseif($t->opd_tacode = 'PAY')
                                    P
                                @else 
                                    {{$t->opd_tacode}}
                                @endif
                        @else 
                                @if($t->er_tacode = 'SERVI')
                                    S
                                @elseif($t->er_tacode = 'PAY')
                                    P
                                @else 
                                    {{$t->er_tacode}}
                                @endif
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</body>

</html>
