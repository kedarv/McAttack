<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>McAttack</title>
    {{HTML::style('http://bootswatch.com/journal/bootstrap.min.css')}}
    @yield('append_css')
    {{HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js')}}
    {{HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js')}}
    @yield('append_headjs')
	<style>
	.aztec {
		width: 250px;
	}
	body {
		margin-top: 70px;
    background: url('http://subtlepatterns2015.subtlepatterns.netdna-cdn.com/patterns/food.png');
	}
  .well {
    background: #fff;
    border: none;
  }
  .alert-red {
    background: #FFC8C8;
    margin-bottom: 0px;
    color: #A24C4C;
  }
	</style>
</head>
<body>
  @include('nav')
	<div class="container">
		@yield('content')
	</div>
</body>
@yield('append_js')
</html>