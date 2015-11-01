<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>McAttack</title>
    {{HTML::style('http://bootswatch.com/simplex/bootstrap.min.css')}}
    @yield('append_css')
    {{HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js')}}
    {{HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js')}}
    @yield('append_headjs')
	<style>
	.aztec {
		width: 20%;
	}
	body {
		margin-top: 60px;
	}
	</style>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">McAttack</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
          </ul>
           <ul class="nav navbar-nav navbar-right">
           	<li><a href="#">Register</a></li>
           	<li><a href="#">Login</a></li>
           </ul>

        </div><!--/.nav-collapse -->
      </div>
    </nav>
    @include('nav')
	<div class="container">
		@yield('content')
	</div>
</body>
@yield('append_js')
</html>