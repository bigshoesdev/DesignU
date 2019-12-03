@extends('layout/default')

{{-- Page title --}}
@section('title')
    Shopping
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/summernote/summernote.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fancybox/jquery.fancybox.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-buttons.css') }}">
    <link href="{{ asset('assets/vendors/toastr/css/toastr.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/shopping/product.css') }}">
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.shopping-breadcum')
@stop

{{-- Page content --}}
@section('content')
    <div class="container product-container">
        <input type="hidden" id="shopping-product-id" value="{{$product->id}}">
        <div class="row" style="min-height:700px;">
            <div class="col-md-2 wow slideInLeft" style="margin-top: 70px; border:2px solid rgb(197, 203, 147);">
                <div class="row" style="text-align:center;margin-top: 20px;">
                    <img style="display: block;max-width: 90%;height:250px; margin: 0 auto;"
                         src="{{ asset('/').$brand->web_img_url }}">
                    </img>
                </div>
                <div class="row" style="text-align:center;margin-top: 10px;">
                    <h4 style="text-transform: uppercase;font-weight: bold;">{{$brand->brand_id}}</h4>
                </div>
            </div>
            <div class="col-md-offset-1 col-md-9 wow slideInRight" style="margin-top: 50px;">
                <div class="row" style="margin-bottom:5px;">
                    <div class="col-md-6">
                        <div class="row" style="margin-bottom:5px;">
                            <a class="fancybox" href="{{ asset('/').$product->getMainImage()->url}}">
                                <img style="border: 2px solid rgb(197, 203, 147);display: block;max-width: 90%;height:250px; margin: 0 auto;"
                                     src="{{ asset('/').$product->getMainImage()->url}}">
                                </img>
                            </a>
                        </div>
                        <div class="row">
                            @foreach($product->get4MainImages() as $mainImg)
                                <div class="col-md-3">
                                    <a class="fancybox" href="{{ asset('/').$mainImg->url}}">
                                        <img style="max-width: 100%;height:100px; margin: 0 auto;border: 2px solid rgb(197, 203, 147);"
                                             src="{{ asset('/').$mainImg->url}}">
                                        </img>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-offset-1 col-md-5">
                        <div class="row">
                            <h1 style="font-weight: bold;color: #337ab7;">{{ $product->title }}</h1>
                        </div>
                        <div class="row">
                            <h3 style="color:#ef6f6c;"> Price: <b>{{ $product->price }}</b> coins</h3>
                        </div>
                        <div class="row">
                            <p style="margin-left: 5px;color:#2b1212;font-size:16px;">{{ $product->description }}</p>
                        </div>
                        <div class="row">
                            <label class="col-md-4 control-label" style="text-align:right">Size: </label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                           <i class="livicon" data-name="balance" data-size="16"
                                              data-loop="true"
                                              data-c="#418bca"
                                              data-hc="#418bca"></i>
                                    </span>
                                    <select class="form-control select2" id="shopping-product-size"
                                            name="shopping-product-size">
                                        @foreach($product->getSizes()->get() as $productSize)
                                            <option value="{{$productSize->id}}">{{$productSize->size}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 control-label" style="text-align:right">Style: </label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                           <i class="livicon" data-name="balance" data-size="16"
                                              data-loop="true"
                                              data-c="#418bca"
                                              data-hc="#418bca"></i>
                                    </span>
                                    <select class="form-control select2" id="shopping-product-style"
                                            name="shopping-product-style">
                                        @foreach($product->getStyles() as $productStyle)
                                            <option value="{{$productStyle->id}}">{{$productStyle->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 control-label" style="text-align:right">Number: </label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                           <i class="livicon" data-name="balance" data-size="16"
                                              data-loop="true"
                                              data-c="#418bca"
                                              data-hc="#418bca"></i>
                                    </span>
                                    <input class="form-control" tyle="number" id="shopping-product-number" value="0">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-offset-4 col-md-8">
                                <button class="btn btn-warning btn-block" type="button" id="shopping-addcart-btn"
                                        data-addcarturl="{{route('shopping.addcart')}}">
                                    <i class="fa fa-shopping-cart"></i>
                                    Add To Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="border-bottom: 2px solid #c54646;margin-bottom: 10px;">
                </div>
                <div class="row" style="margin-top: 5px;">
                    <div class="col-md-6">
                        <a class="fancybox" href="{{ asset('/').$product->video_url }}">
                            <video src="{{ asset('/').$product->video_url }}" controls
                                   style="border: 2px solid rgb(197, 203, 147);display: block;max-width: 90%;height:250px; margin: 0 auto;"></video>
                        </a>
                    </div>
                    @foreach($product->getOtherImages() as $mainImg)
                        <div class="col-md-3">
                            <a class="fancybox" href="{{ asset('/').$mainImg->url}}">
                                <img style="width: 100%;height: 150px; margin-bottom: 5px; border: 2px solid rgb(197, 203, 147);" src="{{ asset('/').$mainImg->url}}">
                                </img>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/moment/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/select2/js/select2.js') }}"></script>
    <script src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/underscore/js/underscore-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/fancybox/jquery.fancybox.pack.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-buttons.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-media.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/shopping/product.js').'?v='.(new DateTime())->getTimestamp() }}"></script>
    <script>
        jQuery(document).ready(function () {
            new WOW().init();
            $(".fancybox").fancybox();
        });
    </script>
@stop
