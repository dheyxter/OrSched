@extends('nora.layouts.master')
@section('content')
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
            

            table, th, td,tr,tbody {
                border: 2px solid black !important;
                }

        /* .noPrint {
            display: none !important
        } */
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
        table, th, td ,tr,tbody{
            border: 2px solid black !important;
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

<body >


        <div class ="d-print-none">
        <form action="/noraReports" id="noPrint" >
        <label for="schedulePrint">Date of Schedule:</label>
            <input type="date" id="schedulePrint" name="schedulePrint">
            <button type="submit" class="btn btn-primary ">Generate Repot</button>
            <button class="printMe btn btn-primary d-print-none"><i class="fas fa-print"></i>
            Print</button>
        </form>

        <!-- <script>
        document.getElementById('schedulePrint').value = new Date().toISOString().substring(0, 10);
        </script>     -->
        </div>
        
    </div>
    <div id='DivIdToPrint'>
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
                                <br>
                                <h5 class="font-weight-bold">ELECTIVE SURGERY SCHEDULE</h5>
                            </div>
                        </div>
                        <div class="col-5 form-inline">
                            <div class="col-5 border border-bottom-0" align="right"><small>Form No.:</small></div>
                            <div class="col-7 border border-left-0 border-right-0 border-bottom-0" align="center"><small>MS - ANES - 005</small></div>
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
            <div class="text-center mt-1">
                                <br>
                                <h5 class="font-weight-bold"><u>NORA CASES</u></h5>
                            </div>
            <table class="table table-sm table-bordered table-striped table-light">
                <thead align="center" class="p-3 mb-2 bg-success text-dark">
                    <th><small><b>RM</b></small></th>
                    <th><small><b>name of Patient</b></small></th>
                    <th><small><b>Age/Sex</b></small></th>
                    <th><small><b>Ward</b></small></th>
                    <th><small><b>Procedure</b></small></th>
                    <th><small><b>Cutting Time</b></small></th>
                    <th><small><b>Duration</b></small></th>
                    <th><small><b>Surgeons</b></small></th>
                    <th><small><b>Anesthesiologists</b></small></th>
                    <th><small><b>SVC/PAY</b></small></th>
                </thead>
                <tbody>
                @foreach ($data as $datum)
                    <tr>                        
                    <td>
                        @if($datum->service_type_id == '1')
                            <small>GI</small>
                        @elseif($datum->service_type_id == '2')
                            <small>RADIO/ONCO</small>
                        @elseif($datum->service_type_id == '3')
                            <small>BRACHY</small>                        
                        @else
                            <small>OTHERS</small>
                        @endif
                    </td>
                    <td><small>{{$datum->patient_lastname}}, {{$datum->patient_firstname}} {{$datum->patient_middlename}}</small></td>
                    <td><small>{{$datum->patient_age}}/ {{$datum->patient_sex}}</small></td>
                    <td><small>{{$datum->patient_room}}</small></td>
                    <td><small>{{$datum->patient_procedure}}</small></td>
                    <td width="11%"><small>{{date('h:i A', strtotime($datum->start))}}</small></td>
                    <td width="11%"><small>{{$datum->duration_time}} HR</small></td>
                    <td width="11%"><small>{{$datum->referring_physician}}</small></td>
                    <td width="11%"><small>{{$datum->anesthesiologist}}</small></td>
                    <td width="11%"><small>{{$datum->svc_pvt}}</small></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
@endsection