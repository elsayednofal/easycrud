<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{url('vendor/elsayednofal/easycrud/images/favicon-32x32.png')}}">

    <title>Easy Crud</title>

    <!-- Bootstrap core CSS -->
    <link href="{{url('vendor/elsayednofal/easycrud/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{url('vendor/elsayednofal/easycrud/css/starter-template.css')}}" rel="stylesheet">
    <script  src="{{url('vendor/elsayednofal/easycrud/js/jquery-1.11.3.min.js')}}" ></script>
    
  </head>

  <body>

      <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top" style="background-color: #f4645f !important">
          <a class="navbar-brand" href="{{url('easy-crud')}}" style="font-weight: bold;color: yellow;text-shadow: 0px 2px #004085;">
	      		<img src="{{url('vendor/elsayednofal/easycrud/images/logo.png')}}" alt="Easy Crud" style="width:50px" />
	            Easy Crud
	      </a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="navbar-toggler-icon"></span>
	      </button>

	      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
	        <ul class="navbar-nav mr-auto">
	          <li class="nav-item @if(Request::is('easy-crud/old')) active @endif">
	            <a class="nav-link" href="{{url('easy-crud/old')}}">Old Cruds</a>
	          </li>
	          <li class="nav-item @if(Request::is('easy-crud')) active @endif">
	            <a class="nav-link" href="{{url('easy-crud')}}">Build New</a>
	          </li>
	          <!--<li class="nav-item">
	            <a class="nav-link" href="#">Documentation</a>
	          </li>-->
	          
	        </ul>
                  <p style="color:#FFFFFF"><span>Developed By :</span><br/> Elsayed Nofal : elsayed_nofal@ymail.com</p>
	      </div>
	</nav>

    <div class="container">
	    @yield('content')
    </div><!-- /.container -->
    <script src="{{url('vendor/elsayednofal/easycrud/js/popper.min.js')}}"></script>
    <script src="{{url('vendor/elsayednofal/easycrud/js/bootstrap.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{url('vendor/elsayednofal/easycrud/sweet-alert/sweetalert.css')}}">
    <script src="{{url('vendor/elsayednofal/easycrud/sweet-alert/sweetalert.min.js')}}"></script>
    @yield('footer-js')
  </body>
</html>
