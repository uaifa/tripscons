<!doctype html>
<html lang="en" >
  <head>
  	<title>TripsCon | Find best places and packages</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token"  ref="csrfToken" content="{{ csrf_token() }}">
    {{--    Hidden inputs--}}
    <input type="hidden" id="csrf_token" value="{{csrf_token()}}">
    <input type="hidden" id="current_user" value="{{\Illuminate\Support\Facades\Auth::check()? json_encode(\Illuminate\Support\Facades\Auth::user()):''}}">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/css/ripple.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- <link href="css/animate.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{asset('assets/owlcarousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/owlcarousel/owl.theme.default.min.css')}}">
	  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    
    <link href="{{asset('/')}}assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/daterangepicker.min.css')}}"/>

  {{--    tripscon--}}
  {{--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBURKqVNB1eT1EPIj4KqCh2N4zwlo_aLW4&libraries=places"></script>--}}

  {{--    ihealer--}}
{{--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBURKqVNB1eT1EPIj4KqCh2N4zwlo_aLW4&libraries=places"></script>--}}

{{--    ihealer 2--}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBURKqVNB1eT1EPIj4KqCh2N4zwlo_aLW4&libraries=places"></script>

{{--Vue Multi-Select--}}
    <link rel="stylesheet" href="{{asset('assets/css/vue-multiselect.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/mdtimepicker.css')}}">

    <style>
    
/* Center the loader */
#loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 120px;
  height: 120px;
  margin: -76px 0 0 -76px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
  text-align: center;
}
</style>
    @yield('style')

  </head>
