<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BurgerTime</title>
    {{HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css')}}
    {{HTML::style('https://fonts.googleapis.com/css?family=Open+Sans:400,700,600')}}
    @yield('append_css')
    <style>
      h1, h3 {
        font-weight: 700;
        text-transform: uppercase;
        margin-top: 0px;
      }
      body {
        margin-top: 20px;
      }
      .alert-red {
        background: #FFC8C8;
        margin-bottom: 0px;
        color: #A24C4C;
      }
    </style>
    @yield('append_headjs')
</head>
<body>
	<div class="container">
    <div class="alert alert-info">
      <h1>#BTFU</h1>
      Looks like you're not from West Lafayette. BurgerTime is region restricted, sorry :(
    </div>
	</div>
</body>
@yield('append_js')
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-17806840-30', 'auto');
  ga('send', 'pageview');

</script>
</html>