<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>McAttack</title>
    {{HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css')}}
    {{HTML::style('https://fonts.googleapis.com/css?family=Open+Sans:400,700,600')}}
    @yield('append_css')
    <style>
      h3 {
        font-weight: 700;
        text-transform: uppercase;
        margin-top: 0px;
      }
      .aztec {
        width: 250px;
      }
      body {
        font-family: 'Roboto', sans-serif;
        margin-top: 20px;
        background: #000;
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
      .list-group-item-heading {
        font-weight: 300;
      }
    </style>

    {{HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js')}}
    {{HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js')}}
    @yield('append_headjs')
</head>
<body>
	<div class="container">
		@yield('content')
	</div>
</body>
@yield('append_js')
</html>