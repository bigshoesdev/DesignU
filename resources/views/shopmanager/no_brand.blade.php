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
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/shopmanager/index.css') }}">
    <!--end of page level css-->
@stop

{{-- content --}}
@section('content')
    <div class="container">
        <!-- Service Section Start-->
        <div class="row" style="min-height:800px;">
            <!-- Responsive Section Start -->
            <div class="text-center" style="margin-top:80px;">
                <h3 class="border-primary"><span class="heading_border bg-primary">Shop Manager Service</span></h3>
            </div>
            <div class="container bg-border wow pulse" data-wow-duration="2.5s" style="margin-top: 50px;">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-sm-10 col-xs-12">
                        <h1 class="purchae-hed">You do not register BRAND information. Please register BRAND
                            information and upload product image.</h1></div>
                    <div class="col-md-12 col-sm-12 col-xs-12"><a href="{{route("shopmanager.brand")}}"
                                                                  class="btn btn-primary purchase-styl pull-right">Register
                            Brand</a></div>
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
        $(document).ready(function () {
            new WOW().init();
        });
    </script>
    <!--page level js ends-->
@stop
