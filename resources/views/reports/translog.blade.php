@extends('layouts.master')
@section('content')

<div class="col-12 d-print-none"></div>
<div class="w-100 d-print-none"></div>
<div class="mt-3 d-print-none">
    <h2 class="">  <svg xmlns="http://www.w3.org/2000/svg" idth="1.5em" height="1.5em" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
        <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
      </svg> Activity Logs</h2>   
</div>
<div class="container-fluid">
    <div class="col-12 mt-3">
        <table class="table table-bordered table-hover" id="myTable1">
            <thead>
                <th>Hospital Number</th>
                <th>Patient Name</th>
                <th>Details</th>
                <th>Entry by</th>
                <th>Time and Date</th>
            </thead>
            <tbody>
                @foreach($logs as $l)
                <tr>
                    <td><small>{{$l->patient_id}}</small></td>
                    <td>{{$l->patient_name}}</td>
                    <td>{{$l->act_details}}</td>
                    <td>{{$l->full_name}}</td>
                    <td>{{date('F j, Y, g:i a', strtotime($l->created_at))}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>




@endsection

@section('script')
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
</script>
@endsection

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<style>

</style>
