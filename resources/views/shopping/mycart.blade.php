@extends('layout/default')

{{-- Page title --}}
@section('title')
    My Cart
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/animate/animate.min.css') }}"/>
    <link href="{{ asset('assets/vendors/toastr/css/toastr.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/shopping/mycart.css') }}">
    <link href="{{ asset('assets/vendors/sweetalert/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.shopping-breadcum')
@stop

{{-- content --}}
@section('content')
    <div class="container mycart-container" data-loginurl="{{ route('auth.login') }}"
         data-payinfourl="{{ route('shopping.mycart.payinfo') }}">
        <!-- Service Section Start-->
        <div class="row" style="min-height:850px;">
            <!-- Responsive Section Start -->
            <div class="text-center mycart-header" style="margin-top:40px;">
                <h3 class="border-primary">
                    <span class="heading_border bg-primary">
                         <i class="fa fa-fw fa-shopping-cart" style="font-size: 35px;"></i>
                        My Cart
                    </span>
                </h3>
            </div>
            <div class="col-md-12">
                <div class="thumbnail wow slideInLeft" data-wow-duration="1s" style="padding: 10px;">
                    @if(isset($cartList)&&!empty($cartList))
                        <table class="table table-bordered table-responsible">
                            <thead>
                            <tr>
                                <th style="width: 20%;">Product</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Style</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Time</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cartList as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('shopping.product', ['id' =>$item['product']->id ]) }}">
                                            <img src="{{ asset('/'.$item['product']->getMainImage()->url)}}"
                                                 style="display: block;max-width: 90%;height: 60px;margin: 0 auto;"/>
                                            <h4>{{ $item['product']->title }}</h4>
                                        </a>
                                    </td>
                                    <td>
                                        <h5>{{$item['size']->size}}</h5>
                                    </td>
                                    <td>
                                        <h5>{{$item['product']->price}}
                                            Coin</h5></td>
                                    <td>
                                        <h5>{{$item['style']->name}}</h5>
                                    </td>
                                    <td>
                                        <h5>{{$item['number']}}</h5>
                                    </td>
                                    <td>
                                        <h5>{{$item['total']}} coins</h5>
                                    </td>
                                    <td>
                                        <h5>{{$item['created_at']}}</h5>
                                    </td>
                                    <td>
                                        <a class="btn btn-block btn-primary cart-item-money-btn"
                                           data-cartid="{{$item['key']}}">
                                            <i class="fa fa-fw fa-money"></i>&nbsp;&nbsp;&nbsp;PAY&nbsp;&nbsp;&nbsp;
                                        </a>
                                        <a class="btn btn-block btn-warning"
                                           href="{{ route('shopping.mycart.remove', ['id'=> $item['key']]) }}">
                                            <i class="fa fa-fw fa-trash-o"></i>
                                            CANCEL
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            {{--<tfoot>--}}
                            {{--<tr>--}}
                            {{--<td colspan="5" class="text-right"><h5>Total</h5></td>--}}
                            {{--<td><h5>{{$totalPrice}} Coins</h5></td>--}}
                            {{--<td colspan="2">--}}
                            {{--<a class="btn btn-block btn-primary">--}}
                            {{--<i class="fa fa-fw fa-money"></i>&nbsp;PAY--}}
                            {{--</a>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--</tfoot>--}}
                        </table>
                    @else
                        <div class="alert alert-success" style="font-size:20px;">No items in your cart!</div>
                    @endif
                </div>
            </div>
            <!-- //Responsive Section End -->
        </div>
    </div>
    <!-- //Container End -->
    <div class="modal fade pullUp in" tabindex="-1" id="mycart-info-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title"><i class="fa fa-fw fa-shopping-cart"></i>ORDER</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img class="mycart-info-image" src="" id="mycart-info-order-userimg">
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <p class="mycart-info-order">Order No:&nbsp;&nbsp; <b id="mycart-info-order-no"></b></p>
                            </div>
                            <div class="row">
                                <p class="mycart-info-order">Order Date: <b id="mycart-info-order-date"></b></p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mycart-info-text">
                                        Name: <b id="mycart-info-order-username"></b>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mycart-info-text">
                                        Country: <b id="mycart-info-order-country"></b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mycart-info-text">
                                        Post Code: <b id="mycart-info-order-postcode"></b>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mycart-info-text">
                                        HP: <b id="mycart-info-order-hp"></b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="mycart-info-text">
                                        Address: <b id="mycart-info-order-address"></b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="mycart-info-text">
                                        Email: <b id="mycart-info-order-email"></b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="mycart-info-text">
                                        Memo:
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control resize_vertical" rows="3"
                                              id="mycart-info-order-note"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <p class="col-md-3 text-center mycart-info-product">Product:</p>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <img class="mycart-info-image" src=""
                                 id="mycart-info-order-productimg">
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <p class="mycart-info-product">Title:&nbsp;&nbsp; <b id="mycart-info-order-title"></b>
                                </p>
                            </div>
                            <div class="row">
                                <p class="mycart-info-product">Style:&nbsp;&nbsp; <b id="mycart-info-order-style"></b>
                                </p>
                            </div>
                            <div class="row">
                                <p class="mycart-info-product">Size:&nbsp;&nbsp; <b id="mycart-info-order-size"></b></p>
                            </div>
                            <div class="row">
                                <p class="mycart-info-product">Quantity:&nbsp;&nbsp; <b
                                            id="mycart-info-order-quantity"></b></p>
                            </div>
                            <div class="row">
                                <p class="mycart-info-product">Total Price:&nbsp;&nbsp; <b
                                            id="mycart-info-order-totalprice"></b> coins</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn  btn-primary" style="width: 150px;" id="mycart-coin-pay" data-orderurl="{{ route('shopping.mycart.order') }}"><i class="fa fa-fw fa-money"></i> Coin Pay </button>
                    <button class="btn  btn-primary" style="width: 150px;"><i class="fa fa-fw fa-money"></i> Charge </button>
                    <button class="btn  btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/underscore/js/underscore-min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert/js/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/shopping/mycart.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            new WOW().init();
        });
    </script>
    <!--page level js ends-->
@stop
