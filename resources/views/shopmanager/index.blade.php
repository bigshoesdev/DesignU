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
            <div class="col-md-4 wow bounceInLeft" data-wow-duration="3s">
                <div class="box">
                    <div class="box-icon ">
                        <a href="{{route('shopmanager.product')}}">
                            <i class="fa fa-fw fa-archive"
                               style=" position: relative; left: -10px; top: 30px; font-size: 120px; color: #5e6656;"></i>
                        </a>
                    </div>
                    <div class="info">
                        <h3 class="success text-center">Product Manage</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 wow bounceInDown" data-wow-duration="3s">
                <div class="box">
                    <div class="box-icon shopmanager-project-icon">
                        <a href="{{route('shopmanager.project')}}">
                            <i class="fa fa-fw fa-book"
                               style=" position: relative; left: -10px; top: 30px; font-size: 120px; color: #5e6656;"></i>
                        </a>
                    </div>
                    <div class="info">
                        <h3 class="success text-center">Project Manage</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 wow bounceInRight" data-wow-duration="3s">
                <div class="box">
                    <div class="box-icon shopmanager-brand-icon">
                        <a href="{{route("shopmanager.brand")}}">
                            <i class="fa fa-fw fa-gear"
                               style="position: relative; left: -10px; top: 30px; font-size: 120px; color: #5e6656;"></i>
                        </a>
                    </div>
                    <div class="info">
                        <h3 class="success text-center">Brand manage</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-12 wow bounceInUp" data-wow-duration="3s" style="margin-top: 30px;">
                <div id="line-chart" class="col-md-offset-1 col-md-10 flotChart1" style="height: 300px;"></div>
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
    <script type="text/javascript" src="{{ asset('assets/vendors/flotchart/js/jquery.flot.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/flotchart/js/jquery.flot.stack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/flotchart/js/jquery.flot.crosshair.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/flotchart/js/jquery.flot.time.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/flotchart/js/jquery.flot.selection.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/flotchart/js/jquery.flot.symbol.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/flotchart/js/jquery.flot.resize.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/flotchart/js/jquery.flot.categories.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/splinecharts/jquery.flot.spline.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/flot_tooltip/js/jquery.flot.tooltip.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            new WOW().init();

        });

        $(function () {

            var d1, d2, data, Options;

            d1 = [
                [1262304000000, 100], [1264982400000, 560], [1267401600000, 1605], [1270080000000, 1129],
                [1272672000000, 2163], [1275350400000, 1905], [1277942400000, 2002], [1280620800000, 2917],
                [1283299200000, 2700], [1285891200000, 2700], [1288569600000, 2100], [1291161600000, 2700]
            ];

            d2 = [
                [1262304000000, 434], [1264982400000, 232], [1267401600000, 875], [1270080000000, 553],
                [1272672000000, 975], [1275350400000, 1379], [1277942400000, 789], [1280620800000, 1026],
                [1283299200000, 1240], [1285891200000, 1892], [1288569600000, 1147], [1291161600000, 2256]
            ];

            data = [{
                label: "&nbsp;&nbsp;Payment",
                data: d1,
                color: "#EF6F6C"
            }, {
                label: "&nbsp;&nbsp;Refund",
                data: d2,
                color: "#01bc8c"
            }];

            Options = {
                xaxis: {
                    min: (new Date(2009, 12, 1)).getTime(),
                    max: (new Date(2010, 11, 2)).getTime(),
                    mode: "time",
                    tickSize: [1, "month"],
                    monthNames: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
                    tickLength: 0
                },
                yaxis: {},
                series: {
                    lines: {
                        show: true,
                        fill: false,
                        lineWidth: 2
                    },
                    points: {
                        show: true,
                        radius: 4.5,
                        fill: true,
                        fillColor: "#ffffff",
                        lineWidth: 2
                    }
                },
                grid: {
                    hoverable: true,
                    clickable: false,
                    borderColor: "#ddd",
                    borderWidth: 1
                },
//                legend: {
//                    container: '#basicFlotLegend',
//                    show: true
//                },

                tooltip: true,
                tooltipOpts: {
                    content: '%s: %y'
                }

            };


            var holder = $('#line-chart');

            if (holder.length) {
                $.plot(holder, data, Options);
            }


        });
        //line chart start
    </script>
    <!--page level js ends-->
@stop
