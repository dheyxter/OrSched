@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div id='calendar'></div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        
    </script>
@endsection

@section('style')
    <style>
        html, body
        {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
            font-size: 14px;
        }

        #calendar 
        {
            max-width: 85%;
            margin: 40px auto;
        }
    </style>
@endsection