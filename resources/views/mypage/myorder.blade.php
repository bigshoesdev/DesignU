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
    <link href="{{ asset('assets/vendors/animationcharts/jquery.circliful.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mypage/myorder.css') }}">
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.mypage-breadcum')
@stop

{{-- content --}}
@section('content')
    <div class="container" id="myorder-container">
        <!-- Service Section Start-->
        <div class="row" style="min-height:850px;">
            <!-- Responsive Section Start -->
            <div class="text-center myorder-header" style="margin-top:40px;">
                <h3 class="border-primary">
                    <span class="heading_border bg-primary">
                    <img src="{{ asset('assets/img/mypage/mypage_my_order_img.png') }}" class="myorder_img">
                        My Order
                    </span>
                </h3>
            </div>
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <div class="thumbnail wow slideInLeft" data-wow-duration="3s" style="padding: 10px;">
                        @foreach($customDrawOrders as $customDrawOrder)
                            <div class="row"
                                 style="min-height: 100px;display: flex;align-items: center;border:2px solid #a46767; margin-left: 20px; margin-right: 20px; margin-bottom: 5px;border-radius: 5px;">
                                <div class="col-md-2" style="text-align: right;">
                                    <img src="{{ asset('assets/img/mypage/myorder_halfdesign_img.png') }}"
                                         style="width:70px;height:70px;">
                                </div>
                                <div class="col-md-3 text-center">
                                    <img src="{{ asset(''). $customDrawOrder->getCustomDraw()->getProduct()->getMainImage()->url }}"
                                         style="width:70px;height:90px;">
                                </div>
                                <div class="col-md-4 text-center">
                                    <h3><b>{{$customDrawOrder->total_price}}</b> coins</h3>
                                </div>
                                <div class="col-md-3 text-center">
                                    @if($customDrawOrder->delivered == 0)
                                        @if($customDrawOrder->getCustomDraw()->getProduct()->is_pending == 1)
                                            <span class="myorder-making-status" data-dimension="90"
                                                  data-width="5"
                                                  data-text="FUNDING"
                                                  data-fontsize="12"
                                                  data-percent="100"
                                                  data-fgcolor="#F79646"
                                                  data-bgcolor="#eee"></span>
                                        @elseif($customDrawOrder->getCustomDraw()->getProduct()->is_pending == 0 && $customDrawOrder->getCustomDraw()->getProduct()->pending_success > 0)
                                            <span class="myorder-making-status" data-dimension="90"
                                                  data-width="5"
                                                  data-text="Making"
                                                  data-fontsize="12"
                                                  data-percent="100"
                                                  data-fgcolor="#F79646"
                                                  data-bgcolor="#eee"></span>
                                        @elseif($customDrawOrder->getCustomDraw()->getProduct()->is_pending == 0 && $customDrawOrder->getCustomDraw()->getProduct()->pending_success == 0)
                                            <button class="btn btn-primary btn-block" disabled="disabled">Funding Fail
                                            </button>
                                        @endif
                                    @else
                                        @if($customDrawOrder->is_request > 0)
                                            @if($customDrawOrder->getRequestExchangeReturn()->is_check >0)
                                                <button class="btn btn-primary btn-block"
                                                        style="font-size: 10px;text-transform: uppercase;">
                                                    Check Complete :
                                                    <br> {{ $customDrawOrder->getRequestExchangeReturn()->type }}
                                                    <br> {{ $customDrawOrder->getRequestExchangeReturn()->is_agree > 0 ? "Agree"  : "Disagree"}}
                                                </button>
                                            @else
                                                <span class="myorder-making-status" data-dimension="70"
                                                      data-width="5"
                                                      data-text="Checking"
                                                      data-fontsize="10"
                                                      data-percent="100"
                                                      data-fgcolor="#F79646"
                                                      data-bgcolor="#eee"></span>
                                                <br/>
                                                <span style="font-size: 12px; text-transform: uppercase; font-weight: bold;"> Request For {{$customDrawOrder->getRequestExchangeReturn()->type }}</span>
                                            @endif
                                        @else
                                            <span style="font-size: 15px; text-transform: uppercase; font-weight: bold;"> Delivery Complete </span>
                                            <button class="btn btn-primary btn-block myorder-exchange-return-btn"
                                                    style="font-size: 10px;text-transform: uppercase;"
                                                    data-orderid="{{ $customDrawOrder->id }}"
                                                    data-getcontactinfourl="{{route('mypage.myorder.contactinfo')}}"
                                                    data-type="halfdesign">
                                                Request <br/>Exchange And Return
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        @foreach($productOrders as $productOrder)
                            <div class="row"
                                 style="min-height: 100px;display: flex;align-items: center;border:2px solid #a46767; margin-left: 20px; margin-right: 20px; margin-bottom: 5px;border-radius: 5px;">
                                <div class="col-md-2" style="text-align: right;">
                                    <img src="{{ asset('assets/img/mypage/myorder_shopping_img.png') }}"
                                         style="width:70px;height:70px;">
                                </div>
                                <div class="col-md-3 text-center">
                                    <img src="{{ asset(''). $productOrder->getProduct()->getMainImage()->url }}"
                                         style="width:70px;height:90px;">
                                </div>
                                <div class="col-md-4 text-center">
                                    <h3><b>{{$productOrder->total_price}}</b> coins</h3>
                                </div>
                                <div class="col-md-3 text-center">
                                    @if($productOrder->delivered == 0)
                                        <span class="myorder-making-status" data-dimension="90"
                                              data-width="5"
                                              data-text="Making"
                                              data-fontsize="12"
                                              data-percent="100"
                                              data-fgcolor="#F79646"
                                              data-bgcolor="#eee"></span>
                                    @else
                                        @if($productOrder->is_request > 0)
                                            @if($productOrder->getRequestExchangeReturn()->is_check >0)
                                                <button class="btn btn-primary btn-block"
                                                        style="font-size: 10px;text-transform: uppercase;">
                                                    Check Complete :
                                                    <br> {{ $productOrder->getRequestExchangeReturn()->type }}
                                                    <br> {{ $productOrder->getRequestExchangeReturn()->is_agree > 0 ? "Agree"  : "Disagree"}}
                                                </button>
                                            @else
                                                <span class="myorder-making-status" data-dimension="70"
                                                      data-width="5"
                                                      data-text="Checking"
                                                      data-fontsize="10"
                                                      data-percent="100"
                                                      data-fgcolor="#F79646"
                                                      data-bgcolor="#eee"></span>
                                                <br/>
                                                <span style="font-size: 12px; text-transform: uppercase; font-weight: bold;"> Request For {{$productOrder->getRequestExchangeReturn()->type }}</span>
                                            @endif
                                        @else
                                            <span style="font-size: 15px; text-transform: uppercase; font-weight: bold;"> Delivery Complete </span>
                                            <button class="btn btn-primary btn-block myorder-exchange-return-btn"
                                                    style="font-size: 10px;text-transform: uppercase;"
                                                    data-orderid="{{ $productOrder->id }}"
                                                    data-getcontactinfourl="{{route('mypage.myorder.contactinfo')}}"
                                                    data-type="shopping">
                                                Request <br/>Exchange And Return
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- //Responsive Section End -->
        </div>
        <div class="modal fade" tabindex="-1" id="myorder-exchange-return-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title">Request For Exchange and Return</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Request Description</label>
                            </div>
                            <div class="col-md-offset-1 col-md-10">
                                <textarea id="myorder-exchange-return-modal-description" rows="3"
                                          class="form-control"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label>Contact US</label>
                            </div>
                            <div class="col-md-12">
                                <div class="row sns-container" style="margin-top: 10px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn  btn-primary btn-warning" id="myorder-exchange-btn"
                                data-exchangereturnurl="{{ route('mypage.myorder.exchangereturn') }}">Exchange
                        </button>
                        <button class="btn  btn-primary btn-warning" id="myorder-return-btn"
                                data-exchangereturnurl="{{ route('mypage.myorder.exchangereturn') }}">Return
                        </button>
                        <button class=" btn btn-primary btn-danger
                        " data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
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
    <script src="{{ asset('assets/vendors/animationcharts/jquery.circliful.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/js/mypage/myorder.js').'?v='.(new DateTime())->getTimestamp() }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            new WOW().init();
            $('.myorder-making-status').circliful();
        });
    </script>
    <!--page level js ends-->
@stop
