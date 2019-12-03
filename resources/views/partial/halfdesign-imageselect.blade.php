@extends('layout/partial')

{{-- Page title --}}
@section('title')
    Image Selection
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
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mypage/myfolder.css') }}">
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    <div class="breadcum">
        <div class="container">
            <div class="pull-right">
                <a href="{{route('halfdesign.customdraw.imageselect')}}">
                    <img src="{{asset('assets/img/mypage/mypage_my_file_img.png') }}" class="breadcum_logo">
                    <span class="breadcum-page-title">My Folder</span>
                </a>&nbsp;
                |&nbsp;&nbsp;
                <a href="{{route('halfdesign.customdraw.branddesignsource')}}">
                    <img src="{{asset('assets/img/mypage/mypage_my_work_img.png') }}" class="breadcum_logo">
                    <span class="breadcum-page-title">Brand Design Source</span>
                </a>
            </div>
        </div>
    </div>
@stop

{{-- content --}}
@section('content')
    <div class="container" id="myfolder-container" data-getfilesinfourl="{{route('mypage.myfolder.info')}}"
         data-addfileurl="{{route('mypage.myfolder.addfile')}}" data-movefileurl="{{route('mypage.myfolder.movefile')}}"
         data-removefileurl="{{route('mypage.myfolder.removefile')}}"
         data-downloadfileurl="{{ route('mypage.myfolder.downloadfile') }}">
        <form action="{{ route('mypage.myfolder.downloadfile') }}" method="POST" id="myfolder-download-form">
            {{ csrf_field() }}
            <input type="hidden" name="type" id="myfolder-download-form-type" value="">
            <input type="hidden" name="id" id="myfolder-download-form-id" value="">
        </form>
        <!-- Service Section Start-->
        <div class="row" style="min-height:850px;">
            <!-- Responsive Section Start -->
            <div class="text-center myfolder-header" style="margin-top:40px;">
                <h3 class="border-primary">
                    <span class="heading_border bg-primary">
                    <img src="{{ asset('assets/img/mypage/mypage_my_file_img.png') }}" class="my_folder_img">
                        My Folder
                    </span>
                </h3>
            </div>
            <div class="col-md-12">
                <div class="thumbnail wow slideInLeft" data-wow-duration="0s" style="padding: 10px;">
                    <input type="file" style="display: none" id="myfolder-item-input" multiple>
                    <div class="row" id="myfolder-item-container">
                    </div>
                    <div class="row" style="margin-top: 15px;">
                        <div style="text-align:center;">
                            <button class="btn btn-social-icon btn-lg" href="#myfolder-folder-name-modal"
                                    data-toggle="modal" id="myfolder-folder-new">
                                <i class="fa fa-folder"></i>
                            </button>
                            <button class="btn btn-social-icon btn-lg" href="javascript::" id="myfolder-cut">
                                <i class="fa fa-cut"></i>
                            </button>
                            <button class="btn btn-social-icon btn-lg" href="javascript::" id="myfolder-paste">
                                <i class="fa fa-paste"></i>
                            </button>
                            <button class="btn btn-social-icon btn-lg" href="javascript::" id="myfolder-remove">
                                <i class="fa fa-trash"></i>
                            </button>
                            <button class="btn btn-social-icon btn-lg" href="javascript::" id="myfolder-apply">
                                <i class="fa  fa-check-circle-o"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //Responsive Section End -->
        </div>
        <!-- //Services Section End -->
        <div class="modal fade in" id="myfolder-folder-name-modal" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-group label-floating">
                            <label class="control-label">Please input folder name:</label>
                            <input id="myfolder-folder-name-input" name="name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" style="margin-bottom: 0px;"
                                id="myfolder-create-folder"
                                data-createfolderurl="{{route('mypage.myfolder.createfolder')}}">Create
                        </button>
                        <button type="button" data-dismiss="modal" class="btn btn-danger" style="margin-bottom: 0px;">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade in" id="myfolder-item-name-modal" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-group label-floating">
                            <label class="control-label">Please input name:</label>
                            <input id="myfolder-item-name-input" name="name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" style="margin-bottom: 0px;"
                                id="myfolder-item-name-change"
                                data-itemnamechangeurl="{{route('mypage.myfolder.changename')}}">Change Name
                        </button>
                        <button type="button" data-dismiss="modal" class="btn btn-danger" style="margin-bottom: 0px;">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
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
            src="{{ asset('assets/vendors/fancybox/jquery.fancybox.pack.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-buttons.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-media.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/mypage/myfolder.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            new WOW().init();
        });
    </script>
    <!--page level js ends-->
@stop
