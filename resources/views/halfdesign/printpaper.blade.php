@extends('layout/default')

{{-- Page title --}}
@section('title')
    Half Design Print Paper
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link href="{{ asset('assets/vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css"
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}">
    <link href="{{ asset('assets/vendors/toastr/css/toastr.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/halfdesign/printpaper.css').'?v='.(new DateTime())->getTimestamp() }}">
    <!--end of page level css-->
@stop

{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <input type="hidden" id="customDrawID" value="{{ $customDraw->id }}"/>
    <div class="container" id="printpapaer-container"
         data-productinfourl="{{route('halfdesign.product.info.printpaper')}}">
        <div class="row">
            <div class="text-center">
                <h3 class="border-success"><span class="heading_border bg-success">Print Paper</span></h3>
            </div>
            <div class="col-md-12 ">
                <div class="thumbnail wow slideInLeft" data-wow-duration="3s">
                    <div class="row">
                        <div class="col-md-12" style="padding-bottom:10px;">
                            <div class="row"
                                 style="margin-top: 10px;">
                                <div class="col-md-4">
                                    <label class="col-lg-6 control-label" style="text-align:center">Size
                                        Setting:</label>
                                    <div class="col-lg-6">
                                        <select class="form-control select2" id="printpaper-size-setting">
                                            @foreach($sizes as $size)
                                                <option value="{{$size->id}}">{{$size->size}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <button class="btn btn-danger btn-block" type="button"
                                            id="printpaper-show-preview">
                                        Show Preview
                                    </button>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-danger btn-block" type="button"
                                            id="printpaper-cut-pattern">
                                        Cut Pattern Object
                                    </button>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-warning btn-block" type="button"
                                            id="printpaper-export-png"
                                            data-printurl="{{route('halfdesign.printimage')}}">
                                        Export To PNG
                                    </button>
                                </div>
                            </div>
                            <div class="text-center">
                                <h4 class="border-success"><span class="heading_border bg-success"
                                                                 id="printpaper-preview-header">Print Preview</span>
                                </h4>
                            </div>
                            <div class="row">
                                <div class="col-md-12"
                                     style="align-items: center;justify-content: space-around;display: flex;margin-top: 10px;">
                                    <div class="printpapaer-preview-container">
                                        <canvas id="setprintpaper-preview-canvas" width="1000px"
                                                height="500px"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-12"
                                     style="align-items: center;justify-content: space-around;display: flex;margin-top: 10px;">
                                    <div class="printpapaer-preview-container" style="display: none;">
                                        <canvas id="setprintpaper-print-canvas" width="1000px" height="500px"></canvas>
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
    <script type="text/javascript" src="{{ asset('assets/vendors/select2/js/select2.js') }}"></script>
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script src="{{ asset('assets/vendors/fabric/fabric.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/underscore/js/underscore-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/halfdesign/printpaper.js') .'?v='.(new DateTime())->getTimestamp()}}"></script>
    <script>
        jQuery(document).ready(function () {
            new WOW().init();
        });
    </script>
    <!-- end of page level js -->
@stop
