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
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mypage/index.css') }}">

    <!--end of page level css-->
@stop

{{-- content --}}
@section('content')
    <div class="container">
        <!-- Service Section Start-->
        <div class="row" style="min-height:850px;">
            <!-- Responsive Section Start -->
            <div class="text-center" style="margin-top:40px;">
                <h3 class="border-primary"><span class="heading_border bg-primary">My Page Service</span></h3>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3.5s" data-wow-delay="0s">
                    <div class="thumbnail text-center">
                        <a href="{{ route('mypage.setting') }}">
                            <img src="{{ asset('assets/img/mypage/mypage_setting_img.png') }}" class="img-responsive"
                                 alt="htc image">
                            <h2 class="text-primary">Setting</h2>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3.5s" data-wow-delay="0s">
                    <div class="thumbnail text-center">
                        <a href="{{ route('mypage.address') }}">
                            <img src="{{ asset('assets/img/mypage/mypage_address_img.png') }}" class="img-responsive"
                                 alt="htc image">
                            <h2 class="text-primary">Address</h2>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3.5s" data-wow-delay="0s">
                    <div class="thumbnail text-center">
                        <a href="{{ route('mypage.sizesetting')  }}">
                            <img src="{{ asset('assets/img/mypage/mypage_size_setting_img.png') }}"
                                 class="img-responsive"
                                 alt="htc image">
                            <h2 class="text-primary">Size Setting</h2>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3.5s" data-wow-delay="0s">
                    <div class="thumbnail text-center">
                        <a href="{{ route('mypage.mymoney') }}">
                            <img src="{{ asset('assets/img/mypage/mypage_my_money_img.png') }}" class="img-responsive"
                                 alt="htc image">
                            <h2 class="text-primary">My Money</h2>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3.5s" data-wow-delay="0s">
                    <div class="thumbnail text-center">
                        <a href="{{ route('mypage.myfolder') }}">
                            <img src="{{ asset('assets/img/mypage/mypage_my_file_img.png') }}" class="img-responsive"
                                 alt="htc image">
                            <h2 class="text-primary">My Folder</h2>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3.5s" data-wow-delay="0s">
                    <div class="thumbnail text-center">
                        <a href="{{ route('mypage.mywork') }}">
                            <img src="{{ asset('assets/img/mypage/mypage_my_work_img.png') }}" class="img-responsive"
                                 alt="htc image">
                            <h2 class="text-primary">My Work</h2>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3.5s" data-wow-delay="0s">
                    <div class="thumbnail text-center">
                        <a href="{{ URL::to('single_product') }}">
                            <img src="{{ asset('assets/img/mypage/mypage_sampling_img.png') }}" class="img-responsive"
                                 alt="htc image">
                            <h2 class="text-primary">Sampling</h2>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="3.5s" data-wow-delay="0s">
                    <div class="thumbnail text-center">
                        <a href="{{ route('mypage.myorder')}}">
                            <img src="{{ asset('assets/img/mypage/mypage_my_order_img.png') }}" class="img-responsive"
                                 alt="htc image">
                            <h2 class="text-primary">My Order</h2>
                        </a>
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
    <script type="text/javascript" src="{{ asset('assets/vendors/wow/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/moment/js/moment.min.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            new WOW().init();
        });
    </script>
    <!--page level js ends-->
@stop
