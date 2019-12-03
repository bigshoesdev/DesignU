@extends('layout/default_no_search')

{{-- Page title --}}
@section('title')
    Half Design Setting Print
    @parent
@stop

@section('logo_title')
    Design Factory
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link href="{{ asset('assets/vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/toastr/css/toastr.css') }}" rel="stylesheet" type="text/css"/>
    <link rel='stylesheet' type="text/css" href='{{ asset('assets/vendors/spectrum/spectrum.css') }}'/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}">
    <link href="{{ asset('assets/vendors/sweetalert/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/css/halfdesign/setprint.css') .'?v='.(new DateTime())->getTimestamp() }}">
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.halfdesign-breadcum')
@stop

{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <input type="hidden" id="productID" value="{{ $product->id }}"/>
    <div class="container" id="setprint-container" data-productinfourl="{{route('halfdesign.product.info.print')}}">
        <div class="row">
            <div class="text-center">
                <h3 class="border-success"><span class="heading_border bg-success">Setting / Printing</span></h3>
            </div>
            <div class="col-md-12 ">
                <div class="thumbnail wow slideInLeft" data-wow-duration="3s">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom:10px;">
                            <div class="text-center">
                                <h4 class="border-success"><span class="heading_border bg-success">Print Setting</span>
                                </h4>
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-3" style="margin: 10px 20px 15px 20px;">
                                    <button class="btn btn-primary btn-block" type="button"
                                            id="setprint-show-printing">Load Patterns
                                    </button>
                                </div>
                                <div class="col-md-3" style="margin: 10px 20px 15px 20px;">
                                    <button class="btn btn-warning btn-block" type="button" id="setprint-cut-height"
                                            data-printimage="{{route('halfdesign.printimage')}}">Cut Height
                                    </button>
                                </div>
                                <div class="col-md-3" style="margin: 10px 20px 15px 20px;">
                                    <button class="btn btn-danger btn-block" type="button"
                                            id="setprint-save-printing"
                                            data-saveprinturl="{{route('halfdesign.setprint.saveprint')}}">Save
                                        Printing
                                    </button>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row" style="margin-top:10px;margin-bottom: 10px;">
                                <div class="col-md-4">
                                    <label class="col-lg-4 control-label" style="text-align:center">Textile
                                        Width: </label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="livicon" data-name="plus" data-size="16" data-loop="true"
                                                   data-c="#418bca"
                                                   data-hc="#418bca"></i>
                                            </span>
                                            <input type="number" placeholder=""
                                                   id="setprint-textile-width-input"
                                                   value="148"
                                                   class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-lg-4 control-label" style="text-align:center">
                                        Textile Unit:
                                    </label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                   <i class="livicon" data-name="balance" data-size="16"
                                                      data-loop="true"
                                                      data-c="#418bca"
                                                      data-hc="#418bca"></i>
                                            </span>
                                            <select class="form-control select2" id="textile_unit"
                                                    name="textile_unit">
                                                <option value="cm">Cm</option>
                                                <option value="inch">Inch</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-lg-4 control-label" style="text-align:center">
                                        Pixel Unit :
                                    </label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                   <i class="livicon" data-name="balance" data-size="16"
                                                      data-loop="true"
                                                      data-c="#418bca"
                                                      data-hc="#418bca"></i>
                                            </span>
                                            <select class="form-control select2" id="unit_base"
                                                    name="unit_base">
                                                <option value="adobe">Adobe Illustrator</option>
                                                <option value="international">International</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-bottom:10px;">
                            <div class="text-center">
                                <h4 class="border-success"><span class="heading_border bg-success"
                                                                 id="setprint-print-paper-header">Print Paper</span>
                                </h4>
                            </div>
                            <div class="row">
                                <div class="col-md-12"
                                     style="align-items: center;justify-content: space-around;display: flex;">
                                    <div class="setprint-paper-container">
                                        <a href="javascript::" id="setprint-paper-copy" class="disable">
                                            <i class="fa fa-copy"></i>
                                        </a>
                                        <a href="javascript::" id="setprint-paper-group" class="disable">
                                            <i class="fa fa-link"></i>
                                        </a>
                                        <a href="javascript::" id="setprint-paper-ungroup" class="disable">
                                            <i class="fa fa-unlink"></i>
                                        </a>
                                        <a href="javascript::" id="setprint-paper-square">
                                            <i class="fa fa-square"></i>
                                        </a>
                                        <a href="javascript::" id="setprint-paper-color" style="display: none;">
                                            <i class="fa fa-circle"></i>
                                        </a>
                                        <a href="javascript::" id="setprint-paper-flip" class="disable">
                                            <i class="fa fa-arrows-h"></i>
                                        </a>
                                        <a href="javascript::" id="setprint-paper-rotate" class="disable">
                                            <i class="fa  fa-repeat"></i>
                                        </a>
                                        <a href="javascript::" id="setprint-paper-delete" class="disable">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        <a href="javascript::" id="setprint-paper-eye">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript::" id="setprint-paper-arrange">
                                            <i class="fa fa-list"></i>
                                        </a>
                                        <canvas id="setprint-paper-canvas"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="setprint-color-picker-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">Add Color</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" style="text-align:center;">
                            <input type='text' id="setprint-color-input"/>
                        </div>
                    </div>
                    <div class="row" styl="margin-top: 10px;">
                        <div class="col-md-12">
                            <label class="col-lg-3 control-label" style="text-align:center">HEX: </label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" readonly="readonly" id="setprint-color-hex"
                                       style="text-align:center;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="col-lg-3 control-label" style="text-align:center">RGB: </label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" readonly="readonly" id="setprint-color-rgb"
                                       style="text-align:center;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="col-lg-3 control-label" style="text-align:center">HSV: </label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" readonly="readonly" id="setprint-color-hsv"
                                       style="text-align:center;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="col-lg-3 control-label" style="text-align:center">HSL: </label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" readonly="readonly" id="setprint-color-hsl"
                                       style="text-align:center;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn  btn-primary" id="customdraw-color-add">Add Color</button>
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
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/select2/js/select2.js') }}"></script>
    <script src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/fabric/fabric.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/underscore/js/underscore-min.js') }}"></script>
    <script src="{{ asset('assets/vendors/spectrum/spectrum.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert/js/sweetalert.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/bin-packing/packer.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/bin-packing/packer.growing.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/js/halfdesign/setprint.js') .'?v='.(new DateTime())->getTimestamp()}}"></script>
    <script>
        jQuery(document).ready(function () {
            new WOW().init();
        });
    </script>
    <!-- end of page level js -->

@stop
