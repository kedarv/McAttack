@extends('layout')

@section('append_css')
{{HTML::style('css/sweetalert.css')}}
@stop

@section('append_headjs')
{{HTML::script('js/sweetalert.min.js')}}
@stop

@section('append_js')
<script>
	$('#register').submit(function(e){
		e.preventDefault();
		var $form = $( this ),
		dataFrom = $form.serialize(),
		url = $form.attr( "action"),
		method = $form.attr( "method" );

		$.ajax({
			url: "{{action('PageController@doRegisterManual')}}",
			data: dataFrom,
			type: method,
			beforeSend: function(request) {
				return request.setRequestHeader('X-CSRF-Token', $("meta[name='token']").attr('content'));
			},
			success: function (response) {
				var errors = "";
				if (response['status'] == 'success') {
					swal({
						title: "Success",
						text: "Created Account",
						type: "success",
					});
				}
				else if(response['status'] == 'danger') {
					swal({
						title: "McD API Error",
						text: "Error creating account",
						type: "error",
					});
				}
				else {
					$.each( response['text'], function( index, value ){
						errors += (value  + "\n");
					})
					swal({
						title: "Error",
						text: errors,
						type: "error",
						confirmButtonColor: "#DD6B55",
					});
				}
			}
		});
	});
</script>
@stop

@section('content')
  <div class="well">
	{{Form::open(array('action' => 'PageController@doRegisterManual', 'id' => 'register'))}}
		<div class="form-group">
			{{Form::text("firstname", null, array("placeholder" => "First Name", "class" => "form-control input-lg"))}}
		</div>
		<div class="form-group">
			{{Form::text("lastname", null, array("placeholder" => "Last Name", "class" => "form-control input-lg"))}}
		</div>
		<div class="form-group">
			{{Form::text("zip", null, array("placeholder" => "Zip Code", "class" => "form-control input-lg"))}}
		</div>
		<div class="form-group">
			{{Form::email("email", null, array("placeholder" => "E-mail address", "class" => "form-control input-lg"))}}
		</div>
		<div class="form-group">
			{{Form::password("password", array("placeholder" => "Password", "class" => "form-control input-lg"))}}
		</div>
		<div class="form-group">
			{{Form::password("confirmpassword", array("placeholder" => "Confirm Password", "class" => "form-control input-lg"))}}
		</div>
		{{Form::submit('Sign Up', array("class" => "btn btn-primary"))}}
	{{Form::close()}}
  </div>
@stop