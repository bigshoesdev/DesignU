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
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fancybox/jquery.fancybox.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-buttons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mypage/address.css') }}">
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.mypage-breadcum')
@stop

{{-- content --}}
@section('content')
    <div class="container" id="address-container" data-addresslisturl="{{route('mypage.address.list')}}"
         data-addressdeleteurl="{{route('mypage.address.delete')}}">
        <!-- Service Section Start-->
        <div class="row" style="min-height:850px;">
            <!-- Responsive Section Start -->
            <div class="text-center address-header" style="margin-top:40px;">
                <h3 class="border-primary">
                    <span class="heading_border bg-primary">
                    <img src="{{ asset('assets/img/mypage/mypage_address_img.png') }}" class="address_img">
                        Address
                    </span>
                </h3>
            </div>
            <div class="row">
                <div class="thumbnail wow slideInLeft" data-wow-duration="1s" style="padding: 10px;">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-5">
                            <div class="row">
                                <div class="col-md-12 text-center" style="text-transform: uppercase;font-weight:bold;">
                                    <h3>Address FORM</h3>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 control-label" style="text-align:right">Name:
                                    <span class='require'>*</span></label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="livicon" data-name="pencil" data-size="16" data-loop="true"
                                           data-c="#418bca"
                                           data-hc="#418bca"></i>
                                    </span>
                                        <input type="text" placeholder=" " name="name" id="address-name-input"
                                               value=""
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 control-label" style="text-align:right">Country:
                                    <span class='require'>*</span></label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="livicon" data-name="pencil" data-size="16" data-loop="true"
                                           data-c="#418bca"
                                           data-hc="#418bca"></i>
                                    </span>
                                        <select class="form-control select2" id="address-country-input"
                                                name="country">
                                            <option value="Korea">Korea</option>
                                            <option value="China">China</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 control-label" style="text-align:right">Post Code:
                                    <span class='require'>*</span></label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="livicon" data-name="pencil" data-size="16" data-loop="true"
                                           data-c="#418bca"
                                           data-hc="#418bca"></i>
                                    </span>
                                        <input type="text" placeholder=" " name="postcode" id="address-postcode-input"
                                               value=""
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 control-label" style="text-align:right">Address: <span
                                            class='require'>*</span></label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="livicon" data-name="pencil" data-size="16" data-loop="true"
                                           data-c="#418bca"
                                           data-hc="#418bca"></i>
                                    </span>
                                        <input type="text" placeholder=" " name="address" id="address-address-input"
                                               value=""
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 control-label" style="text-align:right">HP: <span
                                            class='require'>*</span></label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="livicon" data-name="pencil" data-size="16" data-loop="true"
                                           data-c="#418bca"
                                           data-hc="#418bca"></i>
                                    </span>
                                        <input type="text" placeholder=" " name="hp" id="address-hp-input"
                                               value=""
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-4 col-md-6">
                                    <button class="btn btn-primary btn-block" id="address-add-btn"
                                            data-addressaddurl="{{ route('mypage.address.add') }}">
                                        <i class="fa fa-fw fa-plus-circle"></i>&nbsp;ADD
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12 text-center" style="text-transform: uppercase;font-weight:bold;">
                                    <h3>Address Box</h3>
                                </div>
                                <div class="col-md-12" id="address-box-container"
                                     style="min-height: 250px;border: 1px solid #bb4646;border-radius: 5px;margin-bottom: 10px;padding: 10px 20px 20px;">
                                </div>
                                <div class="col-md-offset-4 col-md-4">
                                    <button class="btn btn-primary btn-block" id="address-apply-btn"
                                            data-addressapplyurl="{{ route('mypage.address.apply') }}">
                                        <i class="fa fa-fw fa-check"></i>&nbsp;Apply
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
        <!-- //Container End -->
    @stop
    {{-- footer scripts --}}
    @section('footer_scripts')
        <!-- page level js starts-->
            <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
            <script src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('assets/vendors/select2/js/select2.js') }}"></script>
            <script src="{{ asset('assets/vendors/underscore/js/underscore-min.js') }}"></script>
            <script type="text/javascript"
                    src="{{ asset('assets/js/mypage/address.js').'?v='.(new DateTime())->getTimestamp() }}"></script>
            <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
            <script type="text/javascript">
                jQuery(document).ready(function () {
                    new WOW().init();
                });
            </script>
            <!--page level js ends-->
@stop
