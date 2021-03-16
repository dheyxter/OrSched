@extends('layouts.master')
@section('content')

<div class="col-12 d-print-none"></div>
<div class="w-100 d-print-none"></div>
<div class="mt-3 d-print-none">
 
</div>
<hr>
<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <div class="card shadow">
                <div class="card-header bg-primary shadow">
                    <h2> <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-file-earmark-medical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 1h5v1H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V6h1v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2z"/>
                        <path d="M9 4.5V1l5 5h-3.5A1.5 1.5 0 0 1 9 4.5z"/>
                        <path fill-rule="evenodd" d="M7 4a.5.5 0 0 1 .5.5v.634l.549-.317a.5.5 0 1 1 .5.866L8 6l.549.317a.5.5 0 1 1-.5.866L7.5 6.866V7.5a.5.5 0 0 1-1 0v-.634l-.549.317a.5.5 0 1 1-.5-.866L6 6l-.549-.317a.5.5 0 0 1 .5-.866l.549.317V4.5A.5.5 0 0 1 7 4zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                      </svg>Logbook</h2>
                </div>
                <div class="card-body">
                    <a href="{{route('all')}}" class="btn btn-lg btn-outline-primary btn-block">All</a>
                    <a href="{{route('emergent')}}" class="btn btn-lg btn-outline-primary btn-block">Emergency</a>
                    <a href="{{route('elective')}}" class="btn btn-lg btn-outline-primary btn-block">Elective</a>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card shadow">
                <div class="card-header bg-success shadow">
                    <h2><svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-calendar3" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z"/>
                        <path fill-rule="evenodd" d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                      </svg> Surgery Schedule</h2>
                </div>
                <div class="card-body">
                    <a href="{{('anesReport')}}" class="btn btn-lg btn-outline-success btn-block">All</a>
                    <a href="{{('anesEmer')}}" class="btn btn-lg btn-outline-success btn-block">Emergency</a>
                    <a href="{{('anesElec')}}" class="btn btn-lg btn-outline-success btn-block">Elective</a>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection

@section('script')
<script src="{{asset('js/scripts.js')}}"></script>
{{-- <script src="jquery.print-preview.js"></script> --}}

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function(){
        $('.printMe').click(function(){
            // window.print();
            pop_searchPatient();
        });
            
        
    });

//     function pop_searchPatient() {
//     let w = 1250;
//     let h = 635;
//     let left = (screen.width/2)-(w/2);
//     let top = (screen.height/2)-(h/2)-50;
//     childWin = window.open("/print/all", "searchPatient", "height="+h+", width="+w+", status=no, toolbar=no, menubar=no, location=no,addressbar=no,directories=no,top="+top+", left="+left);
// }

</script>

@endsection
@section('style')
<style>
    /* @media print{
        @page {
            size: landscape !important;
            }
        } */
</style>
