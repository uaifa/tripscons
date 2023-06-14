
    <body class="bg-white">
        <!-- <div id="loader"></div> -->  
        <div id="wrapper">
            @yield('main')      
            @include('basic.layout.footer')
            @include('basic.layout.modals')
        </div>
        <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}" crossorigin="anonymous"></script>
        <script src="{{asset('assets/js/popper.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    </body>
</html>
<script src="{{asset('basic/js/jcf.js')}}"></script>
<script src="{{asset('basic/js/jcf.scrollable.js')}}"></script>
<script src="{{asset('basic/js/bootstrap.min.js')}}"></script>
<script src="{{asset('basic/js/bootstrap-material-design.js')}}"></script>
<script src="{{asset('assets/js/jquery.rateyo.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/daterangepicker.min.js')}}"></script>

<script src="{{asset('basic/js/mdtimepicker.js?ver='.rand(1,1000))}}"></script>

<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script
    src="{{asset('assets/js/loadingoverlay.min.js')}}"></script>
<script src="{{asset('basic/js/app.js')}}?version={{date('Y-m-d-H-i-s')}}"></script>

<!--
<script src="{{asset('basic/vendors/owlcarousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('basic/js/custom.js?ver='.rand(1,1000))}}"></script>
<script src="{{asset('basic/js/mycustom.js?ver='.rand(1,1000))}}"></script>-->

{{--AIzaSyCg3vStUnhT102nk3ZgE6DZRuTW281ocv8--}}

<!-- Replace the value of the key parameter with your own API key. -->





<script>
    $(function () {
        // tooltip settings
        $(document).tooltip({
            show: {
                effect: "slideDown",
                // effect: "explode",
                delay: 250
            },
            position: {
                my: "center bottom-20",
                at: "center right",
                // my: "center left-20",
                // at: "center right",
                using: function (position, feedback) {
                    $(this).css(position);
                    $("<div>")
                        .addClass("arrow")
                        .addClass(feedback.vertical)
                        .addClass(feedback.horizontal)
                        .appendTo(this);
                }
            }
        });


    });

    @if(getUrlSegment(1)!=='mobile')
    getLocation();

    @endif
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        sessionStorage.setItem("user_location", JSON.stringify({
            lat: position.coords.latitude,
            lng: position.coords.longitude
        }));
        axios.get('/save/user/location/' + position.coords.latitude + '/' + position.coords.longitude)
            .then(res => {
                // console.log(res);
            })
            .catch(err => {
                console.log(err);
            });
    }

    var myVar;

    function myFunction() {
      myVar = setTimeout(showPage, 1500);
    }

    function showPage() {
      document.getElementById("loader").style.display = "none";
      document.getElementById("wrapper").style.display = "block";
    }

</script>
@yield('script')
