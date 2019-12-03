@extends('layout/default_no_search')

{{-- Page title --}}
@section('title')
    Home
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/tabbular.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/animate/animate.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/jquery.circliful.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/owl_carousel/css/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/owl_carousel/css/owl.theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/index.css') }}">
    <!--end of page level css-->
@stop

{{-- slider --}}
@section('top')
    <!--Carousel Start -->
    <div id="owl-demo" class="owl-carousel owl-theme">
        <div class="item"><img src="{{ asset('assets/img/general/slide_0.png') }}" alt="slider-image">
        </div>
        <div class="item"><img src="{{ asset('assets/img/general/slide_0.png') }}" alt="slider-image">
        </div>
        <div class="item"><img src="{{ asset('assets/img/general/slide_0.png') }}" alt="slider-image">
        </div>
    </div>
    <!-- //Carousel End -->
@stop

@section('logo_title')
    Design U
@stop

{{-- content --}}
@section('content')
    <div class="container">
        <!-- Service Section Start-->
        <div class="row">
            <!-- Responsive Section Start -->
            <div class="text-center">
                <h3 class="border-primary"><span class="heading_border bg-primary">Our Services</span></h3>
            </div>
            <div class="col-md-4 wow bounceInLeft" data-wow-duration="3s">
                <div class="box">
                    <div class="box-icon shopping-icon">
                        <a href="{{route('shopping.index')}}">
                            <img class="img-responsive" src="{{asset('assets/img/general/shopping_img.png')}}">
                        </a>
                    </div>
                    <div class="info">
                        <h3 class="success text-center">Shopping</h3>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('shopmanager.index') }}">
                            <i class="livicon icon1" style="position: absolute;right: 25px;top: 65px;" data-name="gears"
                               data-size="50" data-loop="true" data-c="#418bca" data-hc="#418bca"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 wow flipInX" data-wow-duration="3s" data-wow-delay="0.5s">
                <div class="box">
                    <div class="box-icon selfdesign-icon">
                        <a href="{{route('halfdesign.index')}}">
                            <img class="img-responsive" src="{{asset('assets/img/general/self_design_img.png')}}">
                        </a>
                    </div>
                    <div class="info">
                        <h3 class="success text-center">Self Design</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 wow bounceInRight" data-wow-duration="3s" data-wow-delay="1s">
                <div class="box">
                    <div class="box-icon community-icon">
                        <a href="{{route('halfdesign.index')}}">
                            <img class="img-responsive" src="{{asset('assets/img/general/community_img.png')}}">
                        </a>
                    </div>
                    <div class="info">
                        <h3 class="success text-center">Community</h3>
                    </div>
                </div>
            </div>
            <!-- //Responsive Section End -->
        </div>
        <!-- //Services Section End -->
    </div>
    <!-- //Container End -->
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
    <script type="text/javascript" src="{{ asset('assets/js/frontend/jquery.circliful.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/wow/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/owl_carousel/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/carousel.js') }}"></script>
    <!--page level js ends-->
@stop
