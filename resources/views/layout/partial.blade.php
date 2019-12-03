<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{!! csrf_token() !!}"/>
    <meta name="root-path" content="{{ asset('/') }}"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <title>
        @section('title')
            | Design U
        @show
    </title>
    <!--global css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/lib.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/layout/default.css') }}">
    <style type="text/css">
        @font-face {
            font-family: YanolJaBold;
            src: url('{{asset('assets/fonts/yanolja_bold.ttf')}}');
        }

        @font-face {
            font-family: YanolJaRegular;
            src: url('{{asset('assets/fonts/yanolja_regular.ttf')}}');
        }
    </style>
    <!--end of global css-->
    <!--page level css-->
@yield('header_styles')
<!--end of page level css-->
</head>

<body>

<!-- slider / breadcrumbs section -->
@yield('top')

<!-- Content -->
@yield('content')
<div class="copyright">
    <div class="container">
        <p>Copyright &copy; DesignU 2018</p>
    </div>
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top"
   data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="25" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<!--global js starts-->
<script type="text/javascript" src="{{ asset('assets/js/lib.js') }}"></script>
<!--global js end-->
<!-- begin page level js -->
@yield('footer_scripts')
<!-- end page level js -->
</body>

</html>
