@extends('layout')
@section('content')
  <div class="well">
    <img src="{{$data['aztec']}}" class="aztec">
    <hr/>
    <h3>{{$data['code']}}</h3>
  </div>
@stop