@extends('layouts.master')
@section('content')

<div class="w-100 d-print-none"></div>
<div class="mt-3 d-print-none">
    <h2 class="">   <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-people" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zm7.973.056v-.002.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
    </svg> Users</h2>   
</div>
<hr>

<div class="row">
    <div class="container-fluid">
        <table class="table table-condensed table-hover table-striped" id="myTable1">
            <thead class="text-center bg-secondary">
                <th>Employee Id</th>
                <th>Full Name</th>
                <th>Position</th>
                <th>Role</th>
                <th>System</th>
                <th>Confirm?</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($user as $users)
                <tr>
                    <td>{{$users->employeeid}}</td>
                    <td><span data-toggle="tooltip" data-placement="top" title="Date Logged: {{date('F j, Y, g:i a', strtotime($users->created_at))}}">{{$users->lastname}}, {{$users->firstname}} {{$users->middlename}}</span></td>
                    <td>{{$users->postitle}}</td>
                    <td>
                        @if ($users->user_role == 0)
                            <span class="badge badge-primary">Ward Nurses</span>
                        @elseif($users->user_role == 1)
                            <span class="badge badge-danger">Administrator</span>
                        @elseif($users->user_role == 3)
                           <span class="badge badge-success">Anesthesiologist</span>
                        @elseif($users->user_role == 4)
                           <span class="badge badge-secondary">Doctor / Surgeon</span>
                        @else
                            <span class="badge badge-warning">OR Nurse</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($users->system == 'cdoe')
                            <button class="btn btn-outline-success btn-sm">CDOE USER <span><i class="fas fa-user-md fa-1x"></i></span></button>
                        @elseif($users->system == 'homis')
                            <button class="btn btn-outline-primary btn-sm">HOMIS USER <span><i class="fas fa-user fa-1x"></i></span></button>
                        @else
                        @endif
                    </td>
                    <td class="text-center">
                        @if($users->is_confirm == NULL)
                            
                        @else
                        <span class="text-success"><i class="fas fa-check"></i></span>
                        @endif
                    </td>
                    <td class="text-center">
                        <input type="text" id="empID" class="empID" value="{{$users->employeeid}}" hidden>
                        <button type="button" class="btn btn-sm btn-outline-primary btnEditUser" data-toggle="modal" data-target="#editUser{{$users->employeeid}}"> EDIT</button>
                    </td>
                </tr>

                <div class="modal fade" id="editUser{{$users->employeeid}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header bg-primary border-bottom-0">
                          <h5 class="modal-title" id="exampleModalLabel">Edit User Role </h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="{{route('changeRole')}}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="empid" value="{{$users->employeeid}}">
                                    <div class="col-3"><span class="float-right"><h3>User:</h3></span></div>
                                    <div class="col-9"><span><h3>{{$users->lastname}}, {{$users->firstname}} {{$users->middlename}}</h3></span></div>
                                    <div class="w-100"></div>
                                    <div class="col-3"><h3><span class="float-right">Role</span></h3></div>
                                    <div class="col-9">
                                        <select class="form-control" name="role" id="role" readonly>
                                            <option value="#" disabled>Select Role</option>
                                            <option value="0"><h2>[0] - Ward Nurses</h2></option>
                                            <option value="1"><h2>[1] - Administrator</h2></option>
                                            <option value="2"><h2>[2] - OR Nurse / Ward Assistant</h2></option>
                                            <option value="3"><h2>[3] - Anesthesiologist</h2></option>
                                            <option value="4"><h2>[4] - Doctor / Surgeon</h2></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-top-0">
                              <button type="submit" class="btn btn-outline-primary">Save changes</button>
                              <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- USER ROLE 
    0 - ward nurses
    1 - administrator
    2 - or nurses
    3 - anes
    --}}

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
</script>
@endsection

@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<style>

</style>
