<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Welcome to DesignU</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- global level js -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- end of global js-->
    <!-- page level styles-->
    <link href="{{ asset('assets/css/frontend/500.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .body-class {
            font-family: 'Open Sans', sans-serif;
            background: url({{asset('assets/img/general/login_background.png')}}) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            min-height: 100%;
            padding-top: 6%;
            padding-bottom: 5%;
        }
    </style>
    <!-- end of page level styles-->
</head>
<body>
<div id="container" >
    <div class="container-fluid" style="display: none;">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-offset-1 col-xs-10 middle">
            <div class="error-container">
                <div class="error-main">
                    <h2 style="width: 600px;color:white">
                        It is Fit to <b>Chrome Browser </b>. Do you want to download chrome and run again?
                        <a class="btn btn-primary" href="{{ route('home') }}">No i am here to do</a>
                        <a class="btn btn-success" href="https://chrome.en.softonic.com/download">Yes download</a>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- global js -->
<script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!--livicons-->
<script src="{{ asset('assets/vendors/livicons/minified/raphael-min.js') }}"></script>
<script src="{{ asset('assets/vendors/livicons/minified/livicons-1.4.min.js') }}"></script>
<!-- end of global js -->
<!-- begining of page level js-->
<script>
    var isChrome = !!window.chrome && !!window.chrome.webstore;
    if (isChrome) {
        location.replace("{{ route('home')}}");
    }else{
        $("body").addClass('body-class');
        $(".container-fluid").css('display','block');
    }

    $("document").ready(function () {
        setTimeout(function () {
            $(".livicon").trigger('click');
        }, 10);
    });
    // code for aligning center
    $(document).ready(function () {
        var x = $(window).height();
        var y = $(".middle").height();
        //alert(x);
        x = x - y;
        x = x / 2 - 100;
        $(".middle").css("padding-top", x);
    });
</script>
<!-- end of page level js-->
</body>
</html>