@extends('layout')

@section('append_js')
<script>
$(document).ready(function(){
	$(".list-group-item").click(function(e){
		e.preventDefault();
		$.ajax({
			url: "{{action('PageController@generateCoupon')}}",
			data: {email: "{{$data['email']}}", id: $(this).data('id')},
			type: "POST",
			beforeSend: function(request) {
				return request.setRequestHeader('X-CSRF-Token', $("meta[name='token']").attr('content'));
			},
			success: function (response) {
				$("#code").html("Coupon Code: " + response['code']);
				$(".aztec").attr('src', response['aztec']);
				$("#coupon").fadeIn();
				console.log(response);
			}
		});

		//alert($(this).data('id'));
	});
})
</script>
@stop

@section('content')
@if(Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
  <div class="well">
  	<div id="coupon" style="display:none;">
    <img src="" class="aztec">
    <hr/>
    <h3 id="code"></h3>
    <hr/>
    </div>
    <h3>Offers Available:</h3>
    <div class="list-group">
    @foreach($arr['Data'] as $item)
		<a href="#" class="list-group-item" data-id="{{$item['Id']}}">
		<h4 class="list-group-item-heading">{{$item['Name']}}</h4>
		<p class="list-group-item-text">Valid from {{date('n/d/Y', strtotime($item['LocalValidFrom']))}} to {{date('n/d/Y', strtotime($item['LocalValidThru']))}}</p></a>
    @endforeach
  </div>
  <div class="alert alert-red">Code not working? You can download the McDonalds App and login using the email <code>{{$data['email']}}</code> and password <code>helloworlD1</code></div>
@stop