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
            <li class="active"><a href="{{action('PageController@home')}}">Home</a></li>
          </ul>
           <ul class="nav navbar-nav navbar-right">
           	<li><a href="{{action('PageController@register')}}">Manual Register</a></li>
           	<li><a href="{{action('PageController@login')}}">Manual Login</a></li>
           </ul>

        </div><!--/.nav-collapse -->
      </div>
    </nav>