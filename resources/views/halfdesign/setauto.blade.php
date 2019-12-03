@extends('layout/default_no_search')

{{-- Page title --}}
@section('title')
    Half Design Setting Automation
    @parent
@stop

@section('logo_title')
    Design Factory
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link href="{{ asset('assets/vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link href="{{ asset('assets/vendors/toastr/css/toastr.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/halfdesign/setauto.css') }}">
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
    <div class="container" id="setauto-container" data-productinfourl="{{route('halfdesign.product.info.auto')}}" >
        <div class="row">
            <div class="text-center">
                <h3 class="border-success"><span class="heading_border bg-success">Setting / Automation</span></h3>
            </div>
            <div class="col-md-12 ">
                <div class="thumbnail wow slideInLeft" data-wow-duration="3s">
                    <div class="row">
                        <div class="col-md-6" style="padding-bottom:10px;">
                            <div class="text-center">
                                <h4 class="border-success"><span class="heading_border bg-success">Design Image</span>
                                </h4>
                            </div>
                            <div class="row">
                                <form id="setauto-design-form">
                                    <input style="display:none;" type="file" name="img" id="setauto-design-input"
                                           multiple>
                                </form>
                                <div class="col-md-offset-1 col-md-10">
                                    <div class="setauto-design-import">
                                        <button class="btn btn-primary btn-block" type="button"
                                                id="setauto-design-add-btn"
                                                data-uploadurl="{{ route('halfdesign.upload.designimg') }}">Import
                                            Design
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <form id="setauto-design-form">
                                    <input style="display:none;" type="file" name="img" id="setauto-design-input">
                                </form>
                                <div class="col-md-offset-1 col-md-10"
                                     style="align-items: center;justify-content: space-around;display: flex;">
                                    <div class="setauto-design-container" data-rootpath="{{asset('/')}}">
                                        <a href="javascript::" id="setauto-design-left">
                                            <i class="fa  fa-caret-left"></i>
                                        </a>
                                        <a href="javascript::" id="setauto-design-right">
                                            <i class="fa fa-caret-right"></i>
                                        </a>
                                        <img class="setauto-design" id="setauto-design-no-img"
                                             src="{{ asset('assets/img/general/plus.png') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="setauto-design-img-scroll">
                                        <div class="setauto-design-img-container" id="setauto-sub-no-img">
                                            <div class="setauto-design-img-wrapper">
                                                <div>
                                                    <img class="img-responsive setauto-design-img"
                                                         src="{{ asset('assets/img/general/plus.png') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h4 class="border-success"><span class="heading_border bg-success"
                                                                 id="design-pattern-title">Design Pattern</span>
                                </h4>
                            </div>
                            <div class="row">
                                <form id="setauto-pattern-img-form">
                                    <input style="display:none;" type="file" name="img" id="setauto-pattern-img-input"
                                           multiple>
                                </form>
                                <div class="col-md-12">
                                    <div class="setauto-pattern-img-scroll">
                                        <div class="setauto-pattern-img-container">
                                            <div class="setauto-pattern-img-wrapper add-pattern">
                                                <div>
                                                    <a href="javascript::" id="setauto-pattern-img-add-btn"
                                                       data-uploadurl="{{ route('halfdesign.upload.patternimg') }}">
                                                        <img class="img-responsive setauto-design-img"
                                                             src="{{ asset('assets/img/general/plus.png') }}">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding-bottom:10px;">
                            <div class="text-center">
                                <h4 class="border-success"><span
                                            class="heading_border bg-success"
                                            id="pattern-mapping-title">Pattern Mapping</span>
                                </h4>
                            </div>
                            <div class="row">
                                <div class="col-md-12"
                                     style="align-items: center;justify-content: space-around;display: flex;">
                                    <div class="setauto-pattern-mapping-container">
                                        <a href="javascript::" id="setauto-pattern-mapping-left">
                                            <i class="fa  fa-caret-left"></i>
                                        </a>
                                        <a href="javascript::" id="setauto-pattern-mapping-right">
                                            <i class="fa fa-caret-right"></i>
                                        </a>
                                        <a href="javascript::" id="setauto-pattern-mapping-check">
                                            <i class="fa fa-check"></i>
                                        </a>
                                        <a href="javascript::" id="setauto-pattern-mapping-delete">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        <canvas id="setauto-pattern-mapping-canvas" width="450px"
                                                height="450px"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-1 col-md-10">
                                    <div class="setauto-design-import">
                                        <button class="btn btn-primary btn-block" type="button" id="setauto-save-mapping"
                                                data-saveurl="{{ route('halfdesign.setauto.savemapping') }}">Save Setting
                                        </button>
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
    <!-- begining of page level js -->
    <!--tags-->
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/fabric/fabric.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/underscore/js/underscore-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/halfdesign/setauto.js') }}"></script>
    <script>
        jQuery(document).ready(function () {
            new WOW().init();
        });
    </script>
    <!-- end of page level js -->
@stop
