@extends('layout/default')

{{-- Page title --}}
@section('title')
    Half Design
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/tabbular.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/animate/animate.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/jquery.circliful.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/halfdesign/index.css') }}">

    <!--end of page level css-->
@stop

{{-- content --}}
@section('content')
    <div class="container">
        <!-- Service Section Start-->
        <div class="row" style="min-height:800px;">
            <!-- Responsive Section Start -->
            <div class="text-center" style="margin-top:80px;">
                <h3 class="border-primary"><span class="heading_border bg-primary">Half Design Service</span></h3>
            </div>
            <div class="col-md-5 wow bounceInLeft" data-wow-duration="3s" style="margin-left: 20px; margin-top: 60px;">
                <div class="box">
                    <div class="box-icon half-design-icon">
                        <a href="{{route('halfdesign.productlist')}}">
                            <img class="img-responsive" src="{{asset('assets/img/halfdesign/half_design_img.png')}}">
                        </a>
                    </div>
                    <div class="info">
                        <h3 class="success text-center">Half Design</h3>
                        <p>Complete Your Fashion By putting your personality in your designer's draft</p>
                    </div>
                    <div class="text-right">
                        <a href="{{route('halfdesign.setinfo')}}">
                            <i class="livicon icon1" style="position: absolute;right: 25px;top: 65px;" data-name="gears"
                               data-size="50" data-loop="true" data-c="#418bca" data-hc="#418bca"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
            </div>
            <div class="col-md-offset-1 col-md-5 wow bounceInRight" data-wow-duration="3s"  data-wow-delay="0.5s"
                 style="margin-right:20px;margin-top: 60px;">
                <div class="box">
                    <div class="box-icon design-sampling-icon">
                        <img class="img-responsive" src="{{asset('assets/img/halfdesign/design_sampling_img.png')}}">
                    </div>
                    <div class="info">
                        <h3 class="success text-center">Design Sampling</h3>
                        <p>Sampling / Pattern / 3D</p>
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
    <script type="text/javascript" src="{{ asset('assets/vendors/moment/js/moment.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            new WOW().init();
        });
    </script>
    <!--page level js ends-->
@stop
