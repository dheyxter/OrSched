@extends('layouts.master')

@section('content')
<div class="col-12"></div>
<div class="w-100"></div>
<div class="container-fluid">
  <canvas id="myChart"></canvas>
 </div>
@endsection

@section('script')
<script src="{{asset('js/charts.js')}}"></script>
<script src="{{asset('js/moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
 

</script>
@endsection

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css">


<style>


</style>
@endsection
