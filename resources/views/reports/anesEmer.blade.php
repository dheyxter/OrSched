@extends('layouts.master')
@section('content')

<div class="col-12 d-print-none"></div>
<div class="w-100 d-print-none"></div>
<div class="row mt-3 d-print-none form-inline">
    <div class="col-6">
        <h2 class=""><i class="fas fa-file-alt"></i> Emergency Surgery Schedule</h2>
    </div>
    
</div>
<hr class="d-print-none">

<div class="row">
    <div class="col-3">
        <form action="{{route('anesEmerFilter')}}" method="POST">
            @csrf
            <div class="card mt-5">
                <div class="card-header bg-primary" align="center">
                    <span class="">SELECTION AREA</span>

                </div>
                <div class="card-body">
                    <label for="">From: </label>
                    <input type="date" class="form-control ml-1 mr-5" name="dateFrom" @if(!empty($dateFrom)) value="{{$dateFrom}}"@endif>

                    <label for="" class="mt-2">To: </label>
                    <input type="date" class="form-control ml-1 mr-3" name="dateTo" @if(!empty($dateTo)) value="{{$dateTo}}"@endif>

                    <button class="btn btn-outline-success mt-2 btn-block" type="submit"><i class="fas fa-search"></i>
                        Search</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-9">
        <div class="col-12" align="right">
            <input type="date" class="form-control ml-1 mr-5" id="dateFrom" name="dateFrom" @if(!empty($dateFrom)) value="{{$dateFrom}}"@endif hidden>
            <input type="date" class="form-control ml-1 mr-3" id="dateTo" name="dateTo" @if(!empty($dateTo)) value="{{$dateTo}}"@endif hidden>
            @if(empty($dateTo))
                <a href="#" id="btnPrint" hidden class="mb-2 printMe5 btn btn-outline-primary" type="button"><i class="fas fa-search"></i> Print Preview</a>
            @else 
                <a href="#" id="btnPrint" class="mb-2 printMe5 btn btn-outline-primary" type="button"><i class="fas fa-search"></i> Print Preview</a>
            @endif
        </div>
        <div class="w-100"></div>
        @if(count($total)>0)
        <table class="table table-responsive table-sm table-striped table-sm table-hover">
            <thead class="bg-dark text-white">
                 <th>Date and TIme</th>
                 <th>Room</th>
                <th>Name of Patient</th>
                <th>Age/Sex</th>
                <th>Room/Ward</th>
                <th>Procedure</th>
                <th>Induction Time</th>
                <th>Duration</th>
                <th>Surgeon</th>
                <th>Anesthesiologist</th>
                <th>SVC/PAY</th>
               
            </thead>
            <tbody>
                @foreach ($total as $t)
                <tr>
                    <td width="8%"><small>{{date('Y-m-d, h:i A', strtotime($t->created_at))}}</small></td>
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
                    <td width="8%">
                        <small>
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
                            @endif
                        </small>
                    </td>
                    <td width="15%"><small class="text-uppercase">DR. {{$t->surgeon}}</small></td>
                    <td width="15%"><small class="text-uppercase">DR. {{$t->anes}}</small></td>
                    <td>
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
        @else
        <div class="col-12" align="center">
           <div class="card shadow">
               <div class="card-header bg-warning">
                   <h1>No Data Found</h1>
               </div>
           </div>
        </div>
        @endif
    </div>
</div>




@endsection

@section('script')
<script src="{{asset('js/scripts.js')}}"></script>
<script src="jquery.print-preview.js"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // $(function () {
    //     $('.printMe').click(function () {
    //         // window.print();
    //         pop_searchPatient();
    //     });

    // });

    // function pop_searchPatient() {
    //     //window pop
    //     let w = 1250;
    //     let h = 635;
    //     let left = (screen.width / 2) - (w / 2);
    //     let top = (screen.height / 2) - (h / 2) - 50;
    //     childWin = window.open("/print/anesEmer", "searchPatient", "height=" + h + ", width=" + w +
    //         ", status=no, toolbar=no, menubar=no, location=no,addressbar=no,directories=no,top=" + top + ", left=" +
    //         left);
    // }

</script>

@endsection
@section('style')
<style>
    @media print {
        @page {
            size: landscape !important;
        }
    }

</style>
