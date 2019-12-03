@extends('layout/default')

{{-- Page title --}}
@section('title')
    Half Design Custom Draw
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link href="{{ asset('assets/vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css"
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}">
    <link href="{{ asset('assets/vendors/sweetalert/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/toastr/css/toastr.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/css/halfdesign/customdraw.css').'?v='.(new DateTime())->getTimestamp()}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-slider/css/bootstrap-slider.min.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-buttons.css') }}">
    <link rel='stylesheet' type="text/css" href='{{ asset('assets/vendors/spectrum/spectrum.css') }}'/>
    <!--end of page level css-->
@stop

{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <input type="hidden" id="productID" value="{{ $productID}}"/>
    <input type="hidden" id="customDrawID" value="{{ $customDrawID}}"/>
    <div class="container" id="customdraw-container"
         data-productinfourl="{{route('halfdesign.product.info.customdraw')}}">
        <div class="row">
            <div class="text-center">
                <h3 class="border-success"><span class="heading_border bg-success">Custom Draw</span></h3>
            </div>
            <div class="col-md-12 ">
                <div class="thumbnail wow slideInLeft" data-wow-duration="3s">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom:10px;">
                            <div class="text-center">
                                <h4 class="border-success"><span class="heading_border bg-success">Draw Map</span>
                                </h4>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="customdraw-design-img-scroll">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"
                                     style="align-items: center;justify-content: space-around;display: flex;margin-top: 10px;">
                                    <div class="customdraw-preview-container">
                                        <a href="javascript::" id="customdraw-preview-left">
                                            <i class="fa  fa-caret-left"></i>
                                        </a>
                                        <a href="javascript::" id="customdraw-preview-right">
                                            <i class="fa  fa-caret-right"></i>
                                        </a>
                                        <a href="javascript::" id="customdraw-preview-eye">
                                            <i class="fa  fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 customdraw-toolbar-container">
                                    <a class="toolbar-item @if(!Sentinel::check()) hidden @endif" href="javascript::"
                                       id="customdraw-toolbar-image"
                                       data-imageselecturl="{{route('halfdesign.customdraw.imageselect')}}">
                                        <i class="fa fa-image"></i>
                                    </a>
                                    <a class="toolbar-item @if(!Sentinel::check()) hidden @endif" href="javascript::"
                                       id="customdraw-toolbar-pattern">
                                        <i class="fa fa-th"></i>
                                    </a>
                                    <a class="toolbar-item" href="javascript::" id="customdraw-toolbar-text">
                                        <i class="fa fa-font"></i>
                                    </a>
                                    <a class="toolbar-item" href="javascript::" id="customdraw-toolbar-circle">
                                        <i class="fa fa-circle"></i>
                                    </a>
                                    <a class="toolbar-item" href="javascript::" id="customdraw-toolbar-square">
                                        <i class="fa fa-square"></i>
                                    </a>
                                    <a class="toolbar-item" href="javascript::" id="customdraw-toolbar-triangle">
                                        <i class="fa fa-exclamation-triangle "></i>
                                    </a>
                                    <a class="toolbar-item" href="javascript::" id="customdraw-toolbar-copy">
                                        <i class="fa fa-copy"></i>
                                    </a>
                                    <a class="toolbar-item" href="javascript::" id="customdraw-toolbar-paste">
                                        <i class="fa fa-paste"></i>
                                    </a>
                                    <a class="toolbar-item" href="javascript::" id="customdraw-toolbar-flip">
                                        <i class="fa fa-arrows-h"></i>
                                    </a>
                                    <a class="toolbar-item" href="javascript::" id="customdraw-toolbar-delete">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </div>
                                <div class="col-md-4 customdraw-colorbar-container"
                                     style="margin-top: 10px;margin-left:10px;">
                                    <a class="colorbar-pen disable" href="javascript::" id="customdraw-colorbar-spot">
                                        <i class="fa  fa-pencil"></i>
                                    </a>
                                    @for ($i = 0; $i < 10; $i++)
                                        <a class="colorbar-item" href="javascript::"
                                           id="customdraw-colorbar-item-{{$i}}">
                                            <i class="fa"></i>
                                        </a>
                                    @endfor
                                    <a class="colorbar-change" href="javascript::" id="customdraw-colorbar-change">
                                        <i class="fa  fa-plus"></i>
                                    </a>
                                </div>
                                <div class="col-md-2 customdraw-toolbar-right-container" style="margin-left: 30px;">
                                    @if(isset($customDraw)  && $customDraw->is_pay > 0)
                                    @else
                                        <a class="toolbar-item @if(!Sentinel::check()) hidden @endif"
                                           href="javascript::"
                                           id="customdraw-toolbar-check"
                                           data-sizeselecturl="{{route('halfdesign.customdraw.sizeselect')}}"
                                           data-payinfourl="{{route('halfdesign.customdraw.payinfo')}}"
                                        >
                                            <i class="fa fa-credit-card"></i>
                                        </a>
                                    @endif
                                    <a class="toolbar-item @if(!Sentinel::check()) hidden @endif" href="javascript::"
                                       id="customdraw-toolbar-link">
                                        <i class="fa fa-link"></i>
                                    </a>
                                    <a class="toolbar-item" href="javascript::" id="customdraw-toolbar-save"
                                       data-printcustomdrawurl="{{route('halfdesign.customdraw.printdraw')}}"
                                       data-savecustomdrawurl="{{route('halfdesign.customdraw.savedraw')}}"
                                       data-loginurl="{{route('auth.login')}}">
                                        <i class="fa fa-check"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-4" style="margin-top: 10px;" id="customdraw-fontfamily-wrapper">
                                    <label class="col-lg-4 control-label" style="text-align:center">Font
                                        Setting:</label>
                                    <div class="col-lg-8">
                                        <select class="form-control select2" id="customdraw-fontfamily">
                                            <option value="YanolJaBold" style="font-family: YanolJaBold">야놀자 야체 B
                                            </option>
                                            <option value="YanolJaBold" style="font-family: YanolJaRegular">야놀자 야체 R
                                            </option>
                                            <option value="series" style="font-family: YanolJaRegular">Series
                                            </option>
                                            <option value="monospace" style="font-family: YanolJaRegular">Monospace
                                            </option>
                                            <option value="cursive" style="font-family: YanolJaRegular">Cursive
                                            </option>
                                            <option value="fantasy" style="font-family: YanolJaRegular">Fantasy
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" style="margin-top: 10px;"
                                     id="customdraw-repeat-image-scale-wrapper">
                                    <p>
                                        <b style="margin-right: 15px;">Image Scale:</b>
                                        <input type="text" class="slider form-control" value="" data-slider-min="1"
                                               data-slider-max="100" data-slider-step="1" data-slider-value="50"
                                               id="customdraw-repeat-image-scale" data-slider-tooltip="hide"
                                               data-slider-handle="round"/>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="customdraw-color-change-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">Change Color</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" style="text-align:center;">
                            <input type='text' id="customdraw-color-input"/>
                        </div>
                    </div>
                    <div class="row" styl="margin-top: 10px;">
                        <div class="col-md-12">
                            <label class="col-lg-3 control-label" style="text-align:center">HEX: </label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="customdraw-color-hex"
                                       style="text-align:center;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="col-lg-3 control-label" style="text-align:center">RGB: </label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" readonly="readonly" id="customdraw-color-rgb"
                                       style="text-align:center;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="col-lg-3 control-label" style="text-align:center">HSV: </label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" readonly="readonly" id="customdraw-color-hsv"
                                       style="text-align:center;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="col-lg-3 control-label" style="text-align:center">HSL: </label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" readonly="readonly" id="customdraw-color-hsl"
                                       style="text-align:center;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="col-lg-3 control-label" style="text-align:center">CMYK: </label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" readonly="readonly" id="customdraw-color-cmyk"
                                       style="text-align:center;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn  btn-primary" id="customdraw-color-change">Change Color</button>
                    <button class="btn  btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade pullUp in" tabindex="-1" id="customdraw-payinfo-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title"><i class="fa fa-fw fa-shopping-cart"></i>ORDER</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img class="customdraw-payinfo-image" src="" id="customdraw-payinfo-order-userimg">
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <p class="customdraw-payinfo-order">Order No:&nbsp;&nbsp; <b id="customdraw-payinfo-order-no"></b></p>
                            </div>
                            <div class="row">
                                <p class="customdraw-payinfo-order">Order Date: <b id="customdraw-payinfo-order-date"></b></p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="customdraw-payinfo-text">
                                        Name: <b id="customdraw-payinfo-order-username"></b>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="customdraw-payinfo-text">
                                        Country: <b id="customdraw-payinfo-order-country"></b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="customdraw-payinfo-text">
                                        Post Code: <b id="customdraw-payinfo-order-postcode"></b>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="customdraw-payinfo-text">
                                        HP: <b id="customdraw-payinfo-order-hp"></b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="customdraw-payinfo-text">
                                        Address: <b id="customdraw-payinfo-order-address"></b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="customdraw-payinfo-text">
                                        Email: <b id="customdraw-payinfo-order-email"></b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="customdraw-payinfo-text">
                                        Memo:
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control resize_vertical" rows="3"
                                              id="customdraw-payinfo-order-note"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <p class="col-md-3 text-center customdraw-payinfo-product">Product:</p>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <img class="customdraw-payinfo-image" src=""
                                 id="customdraw-payinfo-order-productimg">
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <p class="customdraw-payinfo-product">Title:&nbsp;&nbsp; <b id="customdraw-payinfo-order-title"></b>
                                </p>
                            </div>
                            <div class="row">
                                <p class="customdraw-payinfo-product">Total Price:&nbsp;&nbsp; <b
                                            id="customdraw-payinfo-order-totalprice"></b> coins</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn  btn-primary" style="width: 150px;" id="customdraw-coin-pay" data-payurl="{{ route('halfdesign.customdraw.pay') }}"><i class="fa fa-fw fa-money"></i> Coin Pay </button>
                    <button class="btn  btn-primary" style="width: 150px;"><i class="fa fa-fw fa-money"></i> Charge </button>
                    <button class="btn  btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page level js -->
    <!--tags-->
    <script type="text/javascript" src="{{ asset('assets/vendors/select2/js/select2.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-slider/js/bootstrap-slider.js') }}"></script>
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert/js/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/fabric/fabric.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/underscore/js/underscore-min.js') }}"></script>
    <script src="{{ asset('assets/vendors/spectrum/spectrum.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/js/halfdesign/customdraw.js').'?v='.(new DateTime())->getTimestamp() }}"></script>
    <script>
        jQuery(document).ready(function () {
            new WOW().init();
        });
    </script>
    <!-- end of page level js -->
@stop
