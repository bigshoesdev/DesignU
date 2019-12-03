@extends('layout/partial')

{{-- Page title --}}
@section('title')
    Size Selection
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/animate/animate.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/iCheck/css/all.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/iCheck/css/line/line.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendors/Buttons/css/buttons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/frontend/advbuttons.css') }}"/>
    <link href="{{ asset('assets/vendors/toastr/css/toastr.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mypage/sizesetting.css') }}">
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    <div class="breadcum">
        <div class="container">
            <div class="pull-right">
                <a href="{{route('halfdesign.customdraw.sizeselect')}}">
                    <img src="{{ asset('assets/img/mypage/mypage_size_setting_img.png') }}" class="breadcum_logo">
                    <span class="breadcum-page-title"> Size Setting</span>
                </a>&nbsp;
            </div>
        </div>
    </div>
@stop

{{-- content --}}
@section('content')
    <div class="container" id="sizesetting-container" data-sizesettinginfourl="{{route('mypage.sizesetting.info')}}"
         data-sizesettingdelurl="{{route('mypage.sizesetting.delete')}}"
         data-sizesettingapplyurl="{{route('mypage.sizesetting.apply')}}">
        <!-- Service Section Start-->
        <div class="row" style="min-height:850px;">
            <!-- Responsive Section Start -->
            <div class="text-center size-setting-header" style="margin-top:40px;">
                <h3 class="border-primary">
                    <span class="heading_border bg-primary">
                    <img src="{{ asset('assets/img/mypage/mypage_size_setting_img.png') }}" class="size_setting_img">
                        Size Setting
                    </span>
                </h3>
            </div>
            <div class="col-md-12">
                <div class="thumbnail wow slideInLeft" data-wow-duration="3s" style="padding: 10px;">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-10" style="padding-bottom:10px;">
                            <div class="text-center">
                                <h4 class="border-success"><span
                                            class="heading_border bg-success">Customizing Size</span>
                                </h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6" style="margin-top:10px;">
                                    <div class="row">
                                        <label class="col-md-4 control-label" style="text-align:right;font-size: 18px;">
                                            Name:
                                        </label>
                                        <div class="col-md-8">
                                            <input type="text" name="title" class="form-control" style="height: 40px;"
                                                   id="sizesetting-name-input">
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <label class="col-md-4 control-label" style="text-align:right;font-size: 18px;">
                                            Gender:
                                        </label>
                                        <label class="col-md-2 control-label"
                                               style="text-align:center;font-size: 15px; min-width:70px;">
                                            <input type="radio" name="gender" class="square" checked value="m"/>
                                            Man
                                        </label>
                                        <label class="col-md-2 control-label"
                                               style="text-align:center;font-size:15px;min-width:70px;">
                                            <input type="radio" name="gender" class="square" value="w"/>
                                            Woman
                                        </label>
                                        <label class="col-md-2 control-label"
                                               style="text-align:center;font-size:15px;min-width:70px;">
                                            <input type="radio" name="gender" class="square" value="c"/>
                                            Child
                                        </label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 control-label" style="text-align:right;">
                                            Height (cm): <span class='require'>*</span>
                                        </label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="livicon" data-name="dashboard" data-size="16" data-loop="true"
                                                   data-c="#418bca"
                                                   data-hc="#418bca"></i>
                                            </span>
                                                <input type="number" name="title" class="form-control"
                                                       id="size-height-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 control-label" style="text-align:right;">
                                            Weight (kg): <span class='require'>*</span>
                                        </label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="livicon" data-name="dashboard" data-size="16" data-loop="true"
                                                   data-c="#418bca"
                                                   data-hc="#418bca"></i>
                                            </span>
                                                <input type="number" name="title" class="form-control"
                                                       id="size-weight-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-3 control-label" style="text-align:right;font-size: 18px;">
                                            Size:
                                        </label>
                                    </div>
                                    <div class="row size-container" style="margin-left: 15px;">
                                    </div>
                                </div>
                                <div class="col-md-6" style="margin-top:10px;">
                                    <div class="row">
                                        <label class="col-md-4 control-label" style="text-align:right">
                                            Bust (cm): <span class='require'>*</span>
                                        </label>
                                        <div class="col-lg-7">
                                            <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="livicon" data-name="dashboard" data-size="16" data-loop="true"
                                                   data-c="#418bca"
                                                   data-hc="#418bca"></i>
                                            </span>
                                                <input type="number" name="title" class="form-control"
                                                       id="size-bust-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 control-label" style="text-align:right">
                                            Waist (cm): <span class='require'>*</span>
                                        </label>
                                        <div class="col-lg-7">
                                            <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="livicon" data-name="dashboard" data-size="16" data-loop="true"
                                                   data-c="#418bca"
                                                   data-hc="#418bca"></i>
                                            </span>
                                                <input type="number" name="title" class="form-control"
                                                       id="size-waist-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 control-label" style="text-align:right">
                                            Hip (cm): <span class='require'>*</span>
                                        </label>
                                        <div class="col-lg-7">
                                            <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="livicon" data-name="dashboard" data-size="16" data-loop="true"
                                                   data-c="#418bca"
                                                   data-hc="#418bca"></i>
                                            </span>
                                                <input type="number" name="title" class="form-control"
                                                       id="size-hip-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 control-label" style="text-align:right">
                                            Shoulder (cm):&nbsp;
                                        </label>
                                        <div class="col-lg-7">
                                            <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="livicon" data-name="dashboard" data-size="16" data-loop="true"
                                                   data-c="#418bca"
                                                   data-hc="#418bca"></i>
                                            </span>
                                                <input type="number" name="title" class="form-control"
                                                       id="size-shoulder-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 control-label" style="text-align:right">
                                            Sleeve (cm):&nbsp;&nbsp;
                                        </label>
                                        <div class="col-lg-7">
                                            <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="livicon" data-name="dashboard" data-size="16" data-loop="true"
                                                   data-c="#418bca"
                                                   data-hc="#418bca"></i>
                                            </span>
                                                <input type="number" name="title" class="form-control"
                                                       id="size-sleeve-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-4 control-label" style="text-align:right">
                                            Pant (cm):&nbsp;
                                        </label>
                                        <div class="col-lg-7">
                                            <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="livicon" data-name="dashboard" data-size="16" data-loop="true"
                                                   data-c="#418bca"
                                                   data-hc="#418bca"></i>
                                            </span>
                                                <input type="number" name="title" class="form-control"
                                                       id="size-pant-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 15px;">
                                        <div style="text-align:center;">
                                            <button class="btn btn-social-icon btn-lg btn-save" href="javascript::"
                                                    id="sizesetting-size-save"
                                                    data-savesizeurl="{{route('mypage.sizesetting.save')}}"><i
                                                        class="fa fa-save"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-offset-3 col-md-6" style="padding-bottom:10px;">
                            <div class="text-center">
                                <h4 class="border-success"><span
                                            class="heading_border bg-success">Size Box</span>
                                </h4>
                            </div>
                            <div class="row" id="size-box-container">
                            </div>
                            <div class="row" style="margin-top: 15px; text-align: center;">
                                <div class="col-md-offset-3 col-md-6">
                                    <button class="btn btn-primary btn-block" id="sizesetting-size-check">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //Responsive Section End -->
        </div>
        <!-- //Services Section End -->
    </div>
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script language="javascript" type="text/javascript"
            src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/underscore/js/underscore-min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/js/mypage/sizesetting.js').'?v='.(new DateTime())->getTimestamp() }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            new WOW().init();
        });
    </script>
    <!--page level js ends-->
@stop
