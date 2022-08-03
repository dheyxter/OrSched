@extends('layouts.master')
@section('content')
<div class="row">

    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show col-12" role="alert">
        <strong>{{ session('status') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>
    @endif

    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header bg-primary">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="font-weight-bold">Comments / Suggestions</h3>
                    </div>
                    <div class="col-md-6">
                        <button class="float-right btn btn-success" data-toggle="modal" data-target="#feedbackModal">Add
                            Comment / Suggestions</button></div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-condensed table-hover table-striped table-bordered" id="myTable1"
                    width="100%">
                    <thead>
                        <th width="10%">User</th>
                        <th width="45%">Message</th>
                        <th width="15%">Date</th>
                        <th width="10%">Status</th>
                        @if(App\Http\Controllers\LoggedUser::user_role()==1)
                        <th width="10%">Action</th>
                        @endif
                    </thead>
                    <tbody>
                        @foreach ($feedback as $f)
                        <tr>
                            <td>{{$f->username}}</td>
                            <td>{{$f->message}}</td>
                            <td>{{date('F Y h:i:s A', strtotime($f->created_at))}}</td>
                            <td class="text-center">
                                @if ($f->status == 1)
                                <span class="badge badge-pill badge-danger">To be reviewed by Programmer</span>
                                @elseif($f->status == 2)
                                <span class="badge badge-pill badge-primary mb-2">Reviewed by Programmer</span>
                                <button class="btn btn-sm btn-info" data-toggle="modal"
                                    data-target="#progRemarks{{$f->id}}"><i class="fa-solid fa-eye"></i> View
                                    Remarks</button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="progRemarks{{$f->id}}" tabindex="-1" aria-labelledby="feedbackModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="feedbackModalLabel">Programmer Remarks:</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <textarea class="form-control font-weight-bold" name="message" rows="5"
                                    readonly>{{$f->remarks}}</textarea>
                            </div>
                            <small class="float-left"><b>Updated at:</b> {{date('F Y h:i:s A', strtotime($f->updated_at))}}</small>
                        </div>
                        <div class="modal-footer">
                        <input type="text" value="{{$f->id}}" id="f_id" hidden>
                            <button type="button" class="btn btn-primary" id="thisResolve">Resolve</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @elseif($f->status == 3)
                    <span class="badge badge-pill badge-success">RESOLVED</span>
            @endif
            
            </td>
            @if(App\Http\Controllers\LoggedUser::user_role()==1)
            <td class="text-center">
                @if ($f->status == 1)
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#progRemarks{{$f->id}}">Add
                    Remarks</button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="progRemarks{{$f->id}}" tabindex="-1" aria-labelledby="Programmer_Remarks"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form action="/prog_remarks" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="Programmer Remarks">Remarks for Comment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group text-left">
                                <span><b>Message:</b> {{$f->message}}</span>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="prog_message" placeholder="" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="text" value="{{$f->id}}" name="feedback_id" hidden>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Remarks</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @else

        @endif
        </td>
        @endif
        </tr>
        @endforeach
        </tbody>
        </table>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="/message" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel">Feedback / Comments / Suggestions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea class="form-control" name="message"
                            placeholder="Send us feedbacks / comments or suggestions for improvement. Thank you"
                            rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>

@endsection
@section('script')
<script src="{{asset('js/scripts.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $(document).ready(function () {
        $('#myTable1').DataTable();
    });

    $('#thisResolve').on('click', function() {
        var id = $(this).siblings('#f_id').val();

            Swal.fire({
            title: 'Resolved Concern?',
            // text: "Do you want to save the status?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Back'
        }).then((result) => {
            if (result.value) {
                // IF CONFIRMED DO SOMETHING
               $.ajax({
                   type: 'POST',
                   url: '/resolved',
                   data: {
                       'id' : id,
                   },
                   beforeSend: function(){
                        Swal.fire({
                            title: '<div style="width: 7rem; height: 7rem;" class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>',
                            showConfirmButton : false,
                        });
                   },
                   success: function(data){
                        Swal.fire({
                            title: 'Resolved Successfully!',
                            showConfirmButton : false,
                            timer: 1000,
                            icon: 'success'
                        });
                        location.reload();
                   }
               });
            };
        });
    });

</script>
@endsection

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<style>

</style>
