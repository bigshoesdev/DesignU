@extends('layout/default')

{{-- Page title --}}
@section('title')
    My Page
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/animate/animate.min.css') }}"/>
    <link href="{{ asset('assets/vendors/toastr/css/toastr.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fancybox/jquery.fancybox.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-buttons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mypage/mywork.css') }}">
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.mypage-breadcum')
@stop

{{-- content --}}
@section('content')
    <div class="container" id="mywork-container">
        <!-- Service Section Start-->
        <div class="row" style="min-height:850px;">
            <!-- Responsive Section Start -->
            <div class="text-center mywork-header" style="margin-top:40px;">
                <h3 class="border-primary">
                    <span class="heading_border bg-primary">
                    <img src="{{ asset('assets/img/mypage/mypage_my_work_img.png') }}" class="mywork_img">
                        My Work
                    </span>
                </h3>
            </div>
            <div class="row">
                @foreach($hdCustomDraws as $index => $hdCustomDraw)
                    <div class="col-md-4 wow flipInX" data-wow-duration="1s">
                        <div class="panel panel-default text-center mywork-panel">
                            <div class="mywork-upper-panel">
                                <div class="row">
                                    <div class="mywork-image-panel col-md-12">
                                        <div class="thumb_zoom">
                                            <a class="fancybox"
                                               href="{{ route('halfdesign.customdraw', ['productID'=> $hdCustomDraw->product_id, 'customDrawID' => $hdCustomDraw->id]) }}">
                                                <img src="{{ asset('/').$hdCustomDraw->getFirstPrintImageURL()}}"
                                                     class="img-responsive mywork-img"/>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mywork-lower-panel" style="color:#383030;">
                                <div class="row" style="height:50px;">
                                    <div class="col-md-7 mywork-state-text">
                                        @if($hdCustomDraw->getProduct()->is_pending == 0 && $hdCustomDraw->getProduct()->pending_success > 0)
                                            Funding Success
                                        @elseif($hdCustomDraw->getProduct()->is_pending == 0 && $hdCustomDraw->getProduct()->pending_success == 0)
                                            Funding Fail
                                        @elseif($hdCustomDraw->getProduct()->is_pending == 1 && $hdCustomDraw->is_pay > 0)
                                            Pay Complete
                                        @else
                                            Pay Incomplete
                                        @endif
                                    </div>
                                    <div class="col-md-5">
                                        @if($hdCustomDraw->getProduct()->is_pending == 0 && $hdCustomDraw->getProduct()->pending_success > 0)
                                            <a type="button" class="btn btn-primary disabled">Event Off</a>
                                        @elseif($hdCustomDraw->getProduct()->is_pending == 0 && $hdCustomDraw->getProduct()->pending_success == 0)
                                            <a type="button" class="btn btn-primary disabled">Event Off</a>
                                        @elseif($hdCustomDraw->getProduct()->is_pending == 1 && $hdCustomDraw->is_pay > 0)
                                            <a type="button" class="btn btn-primary disabled">In Funding</a>
                                        @else
                                            <a type="button" style="color:white" class="btn btn-primary"
                                               href="{{ route('halfdesign.customdraw', ['productID'=> $hdCustomDraw->product_id, 'customDrawID' => $hdCustomDraw->id]) }}">Paymenet</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">
                {{ $hdCustomDraws->links() }}
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
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/underscore/js/underscore-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/fancybox/jquery.fancybox.pack.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-buttons.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-media.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/js/mypage/mywork.js').'?v='.(new DateTime())->getTimestamp() }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            new WOW().init();

            $(".fancybox").fancybox();
        });
    </script>
    <!--page level js ends-->
@stop
