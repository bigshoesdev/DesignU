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
    <link href="{{ asset('assets/vendors/sweetalert/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mypage/mymoney.css') }}">
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.mypage-breadcum')
@stop

{{-- content --}}
@section('content')
    <div class="container mymoney-container" data-paypal="{{route('payment.paypal.checkout')}}">
        <form method="POST" id="mymoney-form">
            <input type="hidden" id="mymoney-form-method" name="method">
            <input type="hidden" id="mymoney-form-coin" name="coin">
        </form>
        <!-- Service Section Start-->
        <div class="row" style="min-height:850px;">
            <!-- Responsive Section Start -->
            <div class="text-center mymoney-header" style="margin-top:40px;">
                <h3 class="border-primary">
                    <span class="heading_border bg-primary">
                    <img src="{{ asset('assets/img/mypage/mypage_my_money_img.png') }}" class="mymoney_img">
                        My Money
                    </span>
                </h3>
            </div>
            <div class="row">
                <div class="thumbnail wow slideInLeft" data-wow-duration="1s" style="padding: 10px;">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-5">
                            <div class="row" style="display: flex;align-items: center;">
                                <div class="col-md-offset-1 col-md-3">
                                    <img src="{{ asset('assets/img/mypage/mypage_my_money_img.png') }}"
                                         style="width:80px;height:80px;">
                                </div>
                                <div class="col-md-8">
                                    <span style="font-size: 25px;"><b>{{$balance->amount}}</b> Coins</span>
                                </div>
                            </div>
                            <div class="row" style="height: 2px;border-bottom: 2px solid #d36f6f;">
                            </div>
                            <div class="row" style="padding: 5px;height:150px;display: flex;align-items: center;">
                                <div class="col-md-3">
                                    <a href="javascript::" class="mymoney-pay" id="mymoney-pay-paypal">
                                        <img src="{{ asset('assets/img/mypage/mypage_paypal_img.png') }}"
                                             class="mymoney-pay-img">
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="javascript::" class="mymoney-pay" id="mymoney-pay-wechat">
                                        <img src="{{ asset('assets/img/mypage/mypage_wechat_img.png') }}"
                                             class="mymoney-pay-img">
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="javascript::" class="mymoney-pay" id="mymoney-pay-aly">
                                        <img src="{{ asset('assets/img/mypage/mypage_aly_img.png') }}"
                                             class="mymoney-pay-img">
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="javascript::" class="mymoney-pay" id="mymoney-pay-kakao">
                                        <img src="{{ asset('assets/img/mypage/mypage_kakao_img.png') }}"
                                             class="mymoney-pay-img">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-offset-4 col-md-8 text-center"
                                     style="text-transform: uppercase;font-weight:bold;">
                                    <h3>Account Receivable</h3>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 control-label" style="text-align:right">Country:
                                    <span class='require'>*</span></label>
                                <div class="col-md-8">
                                    <input type="text" placeholder=" " name="name" id="address-name-input"
                                           value=""
                                           class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 control-label" style="text-align:right">Bank Name:
                                    <span class='require'>*</span></label>
                                <div class="col-md-8">
                                    <input type="text" placeholder=" " name="name" id="address-name-input"
                                           value=""
                                           class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 control-label" style="text-align:right">Card No:
                                    <span class='require'>*</span></label>
                                <div class="col-md-8">
                                    <input type="text" placeholder=" " name="name" id="address-name-input"
                                           value=""
                                           class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 control-label" style="text-align:right">Account Name:
                                    <span class='require'>*</span></label>
                                <div class="col-md-8">
                                    <input type="text" placeholder=" " name="name" id="address-name-input"
                                           value=""
                                           class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-4 col-md-8 text-center">
                                    <button class="btn btn-primary " style=" font-size: 20px;">
                                        <i class="fa fa-fw fa-save"></i>
                                    </button>
                                    <button class="btn btn-primary" style=" font-size: 20px;">
                                        <i class="fa fa-fw fa-plus"></i>
                                    </button>
                                    <button class="btn btn-primary " style="line-height: 30px; font-size: 15px;">
                                        Use Other Card
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- //Responsive Section End -->
            </div>
            <!-- //Services Section End -->
        </div>
    </div>
    <div class="modal fade pullUp in" id="mymoney-pay-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">
                        <i class="fa fa-fw fa-shopping-cart"></i>Charge
                        <img class="mymoney-pay-modal-pay-img"
                             src="{{ asset('assets/img/mypage/mypage_paypal_img.png') }}"
                             id="mymoney-pay-modal-paypal-img">
                        <img class="mymoney-pay-modal-pay-img" src="{{ asset('assets/img/mypage/mypage_aly_img.png') }}"
                             id="mymoney-pay-modal-aly-img">
                        <img class="mymoney-pay-modal-pay-img"
                             src="{{ asset('assets/img/mypage/mypage_wechat_img.png') }}"
                             id="mymoney-pay-modal-wechat-img">
                        <img class="mymoney-pay-modal-pay-img"
                             src="{{ asset('assets/img/mypage/mypage_kakao_img.png') }}"
                             id="mymoney-pay-modal-kakao-img">
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row mymoney-pay-modal-container" id="mymoney-pay-modal-usd-container">
                        @foreach([1,5,10,20,35,50] as $i)
                            <div class="col-md-4">
                                <div style="width: 100px;display: table;margin: auto;">
                                    <a href="javascript::" class="mymoney-pay-modal-item" data-coin="{{$i}}"
                                       data-unit="usd">
                                        <p class="mymoney-pay-coin-label"><b>{{$i}}</b> Coin</p>
                                        <p style="text-align: center;color: #564d4d;font-size:15px;"><b>{{ $i * 1.5 }} USD</b></p>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row mymoney-pay-modal-container" id="mymoney-pay-modal-chy-container">
                        @foreach([1,5,10,20,35,50] as $i)
                            <div class="col-md-4">
                                <div style="width: 100px;display: table;margin: auto;">
                                    <a href="javascript::" class="mymoney-pay-modal-item" data-coin="{{$i}}"
                                       data-unit="chy">
                                        <p class="mymoney-pay-coin-label"><b>{{$i}}</b> Coin</p>
                                        <p style="text-align: center;color: #564d4d;font-size:15px;"><b>{{ $i * 18 }} CHY</b></p>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row mymoney-pay-modal-container" id="mymoney-pay-modal-krw-container">
                        @foreach([1,5,10,20,35,50] as $i)
                            <div class="col-md-4">
                                <div style="width: 100px;display: table;margin: auto;">
                                    <a href="javascript::" class="mymoney-pay-modal-item" data-coin="{{$i}}"
                                       data-unit="krw">
                                        <p class="mymoney-pay-coin-label"><b>{{$i}}</b> Coin</p>
                                        <p style="text-align: center;color: #564d4d;font-size:15px;"><b>{{ $i * 2500 }} KRW</b></p>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn  btn-primary" id="mymoney-pay-modal-charge-btn">Charge</button>
                    <button class="btn  btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- //Container End -->
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/underscore/js/underscore-min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert/js/sweetalert.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript"
            src="{{ asset('assets/js/mypage/mymoney.js').'?v='.(new DateTime())->getTimestamp() }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            new WOW().init();
        });
    </script>
    <!--page level js ends-->
@stop
