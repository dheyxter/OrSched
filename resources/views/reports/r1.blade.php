@extends('layouts.master')
@section('content')

<div class="col-12 d-print-none"></div>
<div class="w-100 d-print-none"></div>
<div class="row mt-3 d-print-none form-inline">
    <div class="col-6">
        <h2 class=""><i class="fas fa-file-alt"></i> Emergency Logbook</h2>
    </div>

</div>
<hr class="d-print-none">

<div class="row">
    <div class="col-3">
        <form action="{{route('emergent_filter')}}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header bg-primary" align="center">
                    <span class="">SELECTION AREA</span>

                </div>
                <div class="card-body">
                    <label for="">From: </label>
                    <input type="date" class="form-control ml-1 mr-5" name="dateFrom" @if(!empty($dateFrom)) value="{{$dateFrom}}"@endif required>

                    <label for="" class="mt-2">To: </label>
                    <input type="date" class="form-control ml-1 mr-3" name="dateTo" @if(!empty($dateTo)) value="{{$dateTo}}"@endif required>

                    <label for="" class="mt-2">Department: </label>
                    <select class="custom-select" type="text" name="tscode" id="tscode">
                        <option selected disabled value="">--Select Department--</option>
                        @foreach(\App\Http\Controllers\ReportsController::wardlist() as $w)
                            <option @if(!empty($tscode)) @if($tscode == $w->tscode) selected @endif @endif value="{{$w->tscode}}">{{$w->tscode}}</option>
                        @endforeach
                    </select>

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
            <a href="#" id="btnPrint" hidden class="mb-2 printMe1 btn btn-outline-primary" type="button"><i class="fas fa-search"></i> Print Preview</a>
        @else 
            <a href="#" id="btnPrint" class="mb-2 printMe1 btn btn-outline-primary" type="button"><i class="fas fa-search"></i> Print Preview</a>
        @endif
        </div>
        <div class="w-100"></div>
        @if(count($total)>0)
        <table class="table table-responsive table-sm table-striped table-sm table-hover" id="myTable1">
            <thead class="bg-dark text-white">
                <th>Date and Time</th>
                <th>Department</th>
                <th>Ward</th>
                <th>Name of Patient</th>
                <th>Age/Sex</th>
                <th>Procedure/s</th>
                <th>Surgeon</th>
                <th>Type Of Anesthesia</th>
                <th>Ward Nurse on Duty</th>
            </thead>
            <tbody>
                @foreach ($total as $t)
                <tr>
                    <td width="13%"><small>{{date('Y-m-d, h:i A', strtotime($t->created_at))}}</small></td>
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
                    <td width="15%"><small class="text-uppercase">{{$t->surgeon}}</small></td>
                    <td width="15%"><small class="text-uppercase">{{$t->typeAnes}}</small></td>
                    <td width="13%"><small>{{$t->entry_by}}</small></td>
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
</script>

@endsection
@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<style>
    @media print {
        @page {
            size: landscape !important;
        }
    }

</style>
