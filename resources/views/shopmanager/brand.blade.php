@extends('layout/default_no_search')

{{-- Page title --}}
@section('title')
    Brand Manage
    @parent
@stop

@section('logo_title')
    Design U
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link href="{{ asset('assets/vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link href="{{ asset('assets/vendors/toastr/css/toastr.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fancybox/jquery.fancybox.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-buttons.css') }}">
    <link href="{{ asset('assets/vendors/summernote/summernote.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/css/shopmanager/brand.css').'?v='.(new DateTime())->getTimestamp() }}">
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.shopmanager-breadcum')
@stop

{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <div class="container brand-container" data-getbrandinfo="{{route('shopmanager.brand.getbrandinfo')}}"
         data-deletedesignsourceurl="{{route('shopmanager.brand.deletedesignsource')}}"
         data-deletesnsurl="{{route('shopmanager.brand.deletesns')}}">
        <div class="row" style="min-height:800px;">
            <div class="text-center">
                <h3 class="border-success"><span class="heading_border bg-success">Brand Manage</span></h3>
            </div>
            <div class="col-md-12">
                <div class="thumbnail wow slideInLeft" data-wow-duration="3s" style="padding: 10px;">
                    <div class="row">
                        <div class="col-md-7 brand-info-container" style="padding-bottom:10px;">
                            <div class="text-center">
                                <h4 class="border-success"><span
                                            class="heading_border bg-success">Brand Information</span>
                                </h4>
                            </div>
                            <div class="row">
                                <label class="col-md-4 control-label" style="text-align:left">Brand Image:</label>
                            </div>
                            <div class="row">
                                <div class="col-md-6"
                                     style="align-items: center;justify-content: space-around;display: flex;">
                                    <div class="brand-main-img brand-main-img-mobile">
                                        <input style="display:none;" type="file" name="img"
                                               id="brand-main-img-mobile-input">
                                        <div class="thumb_zoom">
                                            <a id="brand-main-img-moblie-input-click" href="javascript::"
                                               data-uploadmainimgurl="{{ route('shopmanager.brand.upload.mainimg') }}"
                                               style="width:100%;height:100%;">
                                                <img class="img-responsive"
                                                     src="">
                                            </a>
                                        </div>
                                        <div style="text-align: center;color: #526d4e;font-size: 13px;font-weight: bold;">
                                            Fit to Mobile ( 784 * 431 px)
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6"
                                     style="align-items: center;justify-content: space-around;display: flex;">
                                    <div class="brand-main-img brand-main-img-web"
                                         style="display: inline-flex;align-items: center;">
                                        <input style="display:none;" type="file" name="img"
                                               id="brand-main-img-web-input">
                                        <div class="thumb_zoom">
                                            <a id="brand-main-img-web-input-click"
                                               href="javascript::"
                                               data-uploadmainimgurl="{{ route('shopmanager.brand.upload.mainimg') }}"
                                               style="width:100%;height:100%;">
                                                <img class="img-responsive"
                                                     src="">
                                            </a>
                                        </div>
                                        <div style="text-align: center;color: #526d4e;font-size: 13px;font-weight: bold;">
                                            Fit to Web ( 443 * 658 px)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 control-label" style="text-align:left">Brand Design
                                    Source:</label>
                                <input style="display:none;" type="file" name="img" multiple
                                       id="brand-design-source-input">
                                <button class="btn btn-warning col-md-1" type="button" style="margin-top: 5px;"
                                        id="brand-design-source-input-click"
                                        data-uploaddesignsourceurl="{{ route('shopmanager.brand.upload.designsource') }}">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <label class="col-md-5 control-label" style="text-align:left; color:#727771;">Click
                                    Number To Set Price.</label>
                            </div>
                            <div class="row" id="brand-design-source-container">
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button class="btn btn-danger" type="button"
                                                style="margin-top: 5px;display: none;" id="brand-design-source-view-up">
                                            <i class="fa fa-angle-double-up"></i>
                                        </button>
                                        <button class="btn btn-danger" type="button"
                                                style="margin-top: 5px;display: none;"
                                                id="brand-design-source-view-down">
                                            <i class="fa fa-angle-double-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 control-label" style="text-align:left">Brand Tip:</label>
                                <button class="btn btn-warning col-md-1" type="button" style="margin-top: 5px;"
                                        id="brand-tip-click">
                                    <i class="fa fa-pencil"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-5" style="padding-bottom:10px;">
                            <div class="text-center">
                                <h4 class="border-success">
                                    <span class="heading_border bg-success">Shop Information</span>
                                </h4>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-1 col-md-10">
                                    <div class="row" style="display: flex;align-items: center;">
                                        <input style="display:none;" type="file" name="img" id="brand-logo-img-input">
                                        <label class="col-md-4 control-label">Brand Logo: </label>
                                        <div class="col-md-7 brand-logo-img">
                                            <div class="thumb_zoom">
                                                <a id="brand-logo-img-input-click" href="javascript::"
                                                   data-uploadlogoimgurl="{{ route('shopmanager.brand.upload.logoimg') }}"
                                                   style="width:100%;height:100%;">
                                                    <img class="img-responsive"
                                                         src="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="display: flex;align-items: center;">
                                        <label class="col-md-4 control-label">Deposit: </label>
                                        <div class="col-md-7">
                                            <label class="control-label col-md-6">
                                                <i class="fa  fa-dollar"></i> 0
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-warning" type="button">
                                                Pay
                                            </button>
                                        </div>
                                    </div>
                                    <div id="shop-info">
                                        <div class="row">
                                            <label class="col-md-4 control-label" for="id">Brand Name: <span
                                                        class='require'>*</span></label>
                                            <div class="col-md-7">
                                                <input id="shop-info-id" name="shop-info-id" type="text"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-4 control-label" for="company">Company:<span
                                                        class='require'>*</span> </label>
                                            <div class="col-md-7">
                                                <input id="company" name="shop-info-company" type="text"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-4 control-label" for="country">Country: <span
                                                        class='require'>*</span></label>
                                            <div class="col-md-7">
                                                <select class="form-control select2" name="shop-info-country">
                                                    <option value="Korea">Korea</option>
                                                    <option value="China">China</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-4 control-label" for="hp">HP: <span
                                                        class='require'>*</span></label>
                                            <div class="col-md-7">
                                                <input id="hp" name="shop-info-hp" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-4 control-label" for="address">Address: <span
                                                        class='require'>*</span></label>
                                            <div class="col-md-7">
                                                <input class="form-control" name="shop-info-address" type="text"
                                                       class="form-control" style="margin-bottom: 10px;">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-md-4 control-label" for="zipcode">ZipCode: <span
                                                        class='require'>*</span></label>
                                            <div class="col-md-7">
                                                <input id="zipcode" name="shop-info-zipcode" type="text"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-offset-4 col-md-4">
                                                <button class="btn btn-danger btn-block" type="button"
                                                        id="shop-info-save"
                                                        data-saveshopinfourl="{{route('shopmanager.brand.saveshopinfo')}}">
                                                    &nbsp;Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-1 col-md-10" style="margin-top: 10px;">
                                    <div class="row">
                                        <label class="col-md-4 control-label" for="zipcode">Contact: </label>
                                        <div class="col-md-5">
                                            <button class="btn btn-primary btn-block" type="button"
                                                    id="shop-info-select-sns-click">
                                                <i class="fa fa-plus"></i>
                                                &nbsp;&nbsp;Select SNS
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row sns-container" style="margin-top: 10px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="brand-tip-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title">Brand Tip</h4>
                    </div>
                    <div class="modal-body">
                        <textarea id="summernote"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn  btn-primary" id="brand-tip-save"
                                data-savetipurl="{{route('shopmanager.brand.savetip')}}">Save
                        </button>
                        <button class="btn  btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="shop-info-sns-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title">Select SNS</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 col-xs-6">
                                <div style="text-align: center;">
                                    <a href="javascript::" class="shop-info-sns-modal-contact-img"
                                       id="shop-info-sns-modal-contact-facebook">
                                        <img class="img-responsive"
                                             style="width: 50px; height: 50px;display: inline;"
                                             src="{{asset('/assets/img/shopmanager/contact-facebook.png')}}">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-6">
                                <div style="text-align: center;">
                                    <a href="javascript::" class="shop-info-sns-modal-contact-img"
                                       id="shop-info-sns-modal-contact-qq">
                                        <img class="img-responsive"
                                             style="width: 50px; height: 50px;display: inline;"
                                             src="{{asset('/assets/img/shopmanager/contact-qq.png')}}">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-6">
                                <div style="text-align: center;">
                                    <a href="javascript::" class="shop-info-sns-modal-contact-img"
                                       id="shop-info-sns-modal-contact-wechat">
                                        <img class="img-responsive"
                                             style="width: 50px; height: 50px;display: inline;"
                                             src="{{asset('/assets/img/shopmanager/contact-wechat.png')}}">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-6">
                                <div style="text-align: center;">
                                    <a href="javascript::" class="shop-info-sns-modal-contact-img"
                                       id="shop-info-sns-modal-contact-kakao">
                                        <img class="img-responsive"
                                             style="width: 50px; height: 50px;display: inline;"
                                             src="{{asset('/assets/img/shopmanager/contact-kakao.png')}}">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 20px;display: flex;align-items: center;">
                            <label class="col-md-offset-1 col-md-2 control-label" for="zipcode">SNS ID: <span
                                        class='require'>*</span></label>
                            <div class="col-md-7">
                                <input id="shop-info-sns-modal-snsid" name="" type="text"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn  btn-primary" id="shop-info-sns-savesns-click"
                                data-savesns="{{route('shopmanager.brand.savesns')}}">Save
                        </button>
                        <button class="btn  btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade in" id="brand-design-source-price-modal" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-group label-floating">
                            <label class="control-label">Please input price:</label>
                            <input id="brand-design-source-price-input" name="name" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" style="margin-bottom: 0px;"
                                id="brand-design-source-price-change-click"
                                data-savedesignsourceurl="{{route('shopmanager.brand.savedesignsourceprice')}}">Change
                            Price
                        </button>
                        <button type="button" data-dismiss="modal" class="btn btn-danger" style="margin-bottom: 0px;">
                            Close
                        </button>
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
    <script type="text/javascript" src="{{ asset('assets/vendors/moment/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/fancybox/jquery.fancybox.pack.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-buttons.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-media.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/select2/js/select2.js') }}"></script>
    <script src="{{ asset('assets/vendors/underscore/js/underscore-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script src="{{ asset('assets/vendors/summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript"
            src="{{ asset('assets/js/shopmanager/brand.js').'?v='.(new DateTime())->getTimestamp() }}"></script>
    <script>
        jQuery(document).ready(function () {
            new WOW().init();
            $("#summernote").summernote({
                height: 300,
                fontNames: ['Lato', 'Arial', 'Courier New']
            });
        });
    </script>
    <!-- end of page level js -->

@stop
