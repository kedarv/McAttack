@extends('layout')
@section('content')
  <div class="well">
	{{Form::open(array('action' => 'PageController@login'))}}
		<div class="form-group">
			{{Form::email("email", null, array("placeholder" => "E-mail address", "class" => "form-control input-lg"))}}
		</div>
		<div class="form-group">
			{{Form::password("password", array("placeholder" => "Password", "class" => "form-control input-lg"))}}
		</div>
		{{Form::submit('Login', array("class" => "btn btn-primary"))}}
	{{Form::close()}}
  </div>
@stop