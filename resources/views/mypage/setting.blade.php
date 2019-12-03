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
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mypage/setting.css') }}">
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.mypage-breadcum')
@stop

{{-- content --}}
@section('content')
    <div class="container" id="setting-container">
        <!-- Service Section Start-->
        <div class="row" style="min-height:850px;">
            <!-- Responsive Section Start -->
            <div class="text-center setting-header" style="margin-top:40px;">
                <h3 class="border-primary">
                    <span class="heading_border bg-primary">
                    <img src="{{ asset('assets/img/mypage/mypage_setting_img.png') }}" class="setting_img">
                        Setting
                    </span>
                </h3>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissable margin5">
                    <strong>Success:</strong> {{ $message }}
                </div>
            @endif
            <div class="row">
                <div class="thumbnail wow slideInLeft" data-wow-duration="1s" style="padding: 10px;">
                    <form id="setting-form" method="POST"
                          action="{{route('mypage.setting.save')}}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-offset-2 col-md-2">
                                <div class="row text-center">
                                    <label class="control-label" style="text-align:right">Picture: <span
                                                class='require'>*</span></label>
                                </div>
                                <div class="row">
                                    <input type="file" id="mypage-user-pic-input" style="display: none;">
                                    <a href="javascript::" id="mypage-user-pic-btn"
                                       data-uploadpic="{{route('mypage.setting.uploadpic')}}">
                                        <img src="{{ asset('/'). $user->pic }}"
                                             style="height: 200px;max-width: 95%;border: 1px solid #9c4d4d;"
                                             id="mypage-user-pic-img">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row  {{ $errors->first('name', 'has-error') }}">
                                    <label class="col-md-3 control-label" style="text-align:right">Name: <span
                                                class='require'>*</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="livicon" data-name="pencil" data-size="16" data-loop="true"
                                           data-c="#418bca"
                                           data-hc="#418bca"></i>
                                    </span>
                                            <input type="text" placeholder=" " name="name"
                                                   value="@if(old('name')){{old('name')}}@else {{$user->name}} @endif"
                                                   class="form-control">
                                        </div>
                                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="row  {{ $errors->first('email', 'has-error') }}">
                                    <label class="col-md-3 control-label" style="text-align:right">Email: <span
                                                class='require'>*</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="livicon" data-name="pencil" data-size="16" data-loop="true"
                                           data-c="#418bca"
                                           data-hc="#418bca"></i>
                                    </span>
                                            <input type="text" placeholder=" " name="email"
                                                   value="@if(old('email')){{old('email')}}@else {{$user->email}} @endif"
                                                   class="form-control">
                                        </div>
                                        <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="row  {{ $errors->first('hp', 'has-error') }}">
                                    <label class="col-md-3 control-label" style="text-align:right">HP: <span
                                                class='require'>*</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="livicon" data-name="pencil" data-size="16" data-loop="true"
                                           data-c="#418bca"
                                           data-hc="#418bca"></i>
                                    </span>
                                            <input type="text" placeholder=" " name="hp" class="form-control"
                                                   value="@if(old('hp')){{old('hp')}}@else {{$user->hp}} @endif">
                                        </div>
                                        <span class="help-block">{{ $errors->first('hp', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="row  {{ $errors->first('msn', 'has-error') }}">
                                    <label class="col-md-3 control-label" style="text-align:right">MSN: <span
                                                class='require'>*</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="livicon" data-name="pencil" data-size="16" data-loop="true"
                                           data-c="#418bca"
                                           data-hc="#418bca"></i>
                                    </span>
                                            <input type="text" placeholder=" " name="msn" class="form-control"
                                                   value="@if(old('msn')){{old('msn')}}@else {{$user->msn}} @endif">
                                        </div>
                                        <span class="help-block">{{ $errors->first('msn', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-6">
                                        <button class="btn btn-primary btn-block">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
    <script src="{{ asset('assets/vendors/underscore/js/underscore-min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/js/mypage/setting.js').'?v='.(new DateTime())->getTimestamp() }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            new WOW().init();
        });
        @if ($message = Session::get('success'))
        if (window.opener) {
            var result = {};
            result.success = true;
            if (window.opener.handleFillUp)
                window.opener.handleFillUp(result);
        }
        @endif
    </script>
    <!--page level js ends-->
@stop
