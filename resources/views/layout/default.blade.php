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
<!-- Header Start -->
<header>
    <!-- Icon Section Start -->
    <div class="icon-section">
        <div class="container">
            <ul class="list-inline">
                <li class="center">
                    <a href="{{route('home')}}">
                        <img class="designu-logo-icon" src="{{asset('assets/img/general/logo.png')}}"></img>
                        <span class="designu-logo-title"> Design U </span>
                    </a>
                </li>
                <li class="pull-right" style="display: flex;align-items: center;margin-top: 6px;">
                    @if(Sentinel::check())
                        <img src="@if(Sentinel::getUser()->pic != "")  {{ asset('/').Sentinel::getUser()->pic }} @else  {{asset('assets/img/general/no_avatar.jpg')}} @endif"
                             alt="img"
                             height="28px"
                             width="28px" class="img-circle"
                             style="margin-right:5px;">
                        </img>
                        <span style=" font-size: 10px; font-weight:700; color:white; width: 30px; line-height: 15px; text-transform: uppercase;margin-right:5px;">
                                {{Sentinel::getUser()->name}}
                        </span>
                        <span style="font-size: 20px; color:white; width: 20px;">
                        |
                        </span>
                        <a href="{{route('mypage.mymoney')}}"
                           style="margin-right: 10px; color:white; font-size:15px;font-weight:bold;">
                            {{Sentinel::getUser()->getBalance()->amount}}
                            <i class="fa fa-fw fa-money"></i>
                        </a>
                        <span style="font-size: 20px; color:white; width: 20px;">
                        |
                        </span>
                    @endif
                    <a href="javascript::" style="margin-right:5px;">
                        <i class="livicon" data-name="search" data-size="18" data-loop="true"
                           data-c="#fff" data-hc="#fff"></i>
                    </a>
                    <span style="margin-right:10px;">
                        <input type="text" class="menu-control-search">
                    </span>
                    <a href="{{ route('mypage.index') }}" style="margin-right:10px;">
                        <i class="livicon" data-name="user" data-size="25" data-loop="true"
                           data-c="#fff" data-hc="#757b87"></i>
                    </a>
                    <a href="#" style="margin-right:10px;">
                        <i class="livicon" data-name="bell" data-size="25" data-loop="true"
                           data-c="#fff"
                           data-hc="#757b87"></i>
                    </a>
                    <a href="{{ route('home') }}" style="margin-right:10px;">
                        <i class="livicon" data-name="home" data-size="25" data-loop="true"
                           data-c="#fff"
                           data-hc="#757b87"></i>
                    </a>
                    @if(Sentinel::check())
                        <a href="{{route('auth.logout')}}" style="margin-right:10px;">
                            <i class="livicon" data-name="sign-out" data-size="25" data-loop="true"
                               data-c="#fff"
                               data-hc="#757b87"></i>
                        </a>
                    @else
                        <a href="{{route('auth.login')}}" style="margin-right:10px;">
                            <i class="livicon" data-name="unlock" data-size="25" data-loop="true"
                               data-c="#fff"
                               data-hc="#757b87"></i>
                        </a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
    <!-- //Icon Section End -->
</header>
<!-- //Header End -->

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
<script type="text/javascript">


    @if(Sentinel::check())
    if (window.opener) {
        var result = {};
        result.success = true;
        if (window.opener.handleLogin)
            window.opener.handleLogin(result);
    }
    @endif
</script>
<!--global js end-->
<!-- begin page level js -->
@yield('footer_scripts')
<!-- end page level js -->
</body>

</html>
