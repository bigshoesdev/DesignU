@extends('layout/default')

{{-- Page title --}}
@section('title')
    Half Design Product All
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link href="{{ asset('assets/vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link href="{{ asset('assets/vendors/animationcharts/jquery.circliful.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/halfdesign/crowdingview.css') }}"/>
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.halfdesign-list-breadcum')
@stop

{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <div class="container">
        <div class="row" style="margin-top: 30px;margin-bottom:10px;">
            <div class="col-md-12 text-center">
                <a type="button" href="{{ route('halfdesign.productlist') }}"
                   class="btn btn-primary btn-warning shopping-header-btn">ALL
                </a>
                <a type="button" href="{{ route('halfdesign.brandlist') }}"
                   class="btn btn-primary btn-warning  shopping-header-btn">BRAND
                </a>
                <a type="button" href="{{ route('halfdesign.categorylist') }}"
                   class="btn btn-primary btn-warning shopping-header-btn">CATEGORY
                </a>
            </div>
        </div>
        <div class="row" style="min-height:700px;">
            <div class="col-md-12" style="padding-top: 30px;">
                <div class="thumbnail wow slideInLeft" data-wow-duration="3s" style="padding: 20px;">
                    <div class="text-center">
                        <h4 class="border-success"><span class="heading_border bg-success">Product Crowding View</span>
                        </h4>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                          <span id="crowdingview-funding-percent" data-dimension="210"
                                data-text="{{ floor( $product->getPayedCustomDrawsCount()* 100 /$product->crowding  ) }}%"
                                data-fontsize="35"
                                data-percent="{{ floor( $product->getPayedCustomDrawsCount()* 100 /$product->crowding  ) }}"
                                data-fgcolor="#F79646"
                                data-bgcolor="#eee"></span>
                        </div>
                        <div class="col-md-3">
                            <img src="{{ asset('assets/img/halfdesign/crowd_funding_flow_img.png') }}"/>
                        </div>
                        <div class="col-md-5" style="min-height: 200px;">
                            <span class="crowdingview-day-value">{{$product->getDateDiffWithNow()['day']}}</span>
                            <span class="crowdingview-day-title" style="font-size: 30px;">Day</span>
                            <span class="crowdingview-time-value">{{ sprintf ("%02d",   $product->getDateDiffWithNow()['hour']).':'.sprintf ("%02d",   $product->getDateDiffWithNow()['min'])}}</span>
                        </div>
                    </div>
                    <div class="text-center">
                        <h4 class="border-success"><span class="heading_border bg-success">Product Drawing</span>
                        </h4>
                    </div>
                    <div class="row">
                        <div class="col-md-4"
                             style=" align-items: center; justify-content: space-around;display: flex;">
                            <div class="crowdingview-customdrawing-view">
                                <div class="crowdingview-customdrawing-view-wrapper">
                                    <a href="javascript::" id="crowdingview-customdrawing-view-free-title">
                                        Free Drawing
                                    </a>
                                    <a href="{{route('halfdesign.customdraw', ['id' => $product->id])}}"
                                       id="crowdingview-customdrawing-view-free-btn">
                                        <img src="{{ asset('assets/img/halfdesign/crowd_free_drawing_img.png') }}">
                                    </a>
                                    @foreach($product->getFirstDesignImages() as $designImage)
                                        <img class="crowdingview-customdrawing-view-img"
                                             src="{{asset('/'). $designImage->url }}">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row text-center">
                                <input type="checkbox" class="crowdingview-customdrawing-other-checkbox"> <span
                                        class="crowdingview-customdrawing-other-title">Other's Creating</span>
                            </div>
                            <div class="row text-center">
                                <div class="col-md-12">
                                    <a href="javascript::" id="crowdingview-customdrawing-other-left">
                                        <i class="fa  fa-caret-left"></i>
                                    </a>
                                    <a href="javascript::" id="crowdingview-customdrawing-other-right">
                                        <i class="fa fa-caret-right"></i>
                                    </a>
                                    <a href="javascript::" id="crowdingview-customdrawing-other-check">
                                        <i class="fa fa-check"></i>
                                    </a>
                                    <div class="crowdingview-other-img-scroll">
                                        <div class="crowdingview-other-img-container">
                                            @foreach([1,2,3] as $i)
                                                <div class="crowdingview-other-img-wrapper">
                                                    <div>
                                                        <a href="javascript::">
                                                            <img class="img-responsive crowdingview-other-img"
                                                                 src="{{asset('assets/img/general/sony.jpg') }}">
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript"
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/flotchart/js/jquery.flot.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/animatechart/jquery.flot.animator.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/animationcharts/jquery.circliful.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/flotchart/js/jquery.flot.resize.js') }}" language="javascript"
            type="text/javascript"></script>
    <script src="{{ asset('assets/js/pages/animation-chart.js') }}"></script>
    <script>
        jQuery(document).ready(function () {
            new WOW().init();
            $(document).ready(function () {
                $('#crowdingview-funding-percent').circliful();
            });
        });
    </script>

@stop
