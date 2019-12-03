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
    <div class="container" id="branddesignsource-container"
         data-getbrandinfo="{{route('shopmanager.brand.getbrandinfo')}}">
        <div class="row" style="min-height:850px;">
            <div class="text-center myfolder-header" style="margin-top:40px;">
                <h3 class="border-primary">
                    <span class="heading_border bg-primary">
                    <img src="{{ asset('assets/img/mypage/mypage_my_file_img.png') }}" class="my_folder_img">
                        Brand Design Source
                    </span>
                </h3>
            </div>
            <div class="col-md-12">
                <form id="download-form" action="{{route('download.image') }}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" id="download-url" name="url">
                </form>
                <div class="thumbnail wow slideInLeft" data-wow-duration="0s" style="padding: 10px;">
                    <div class="row" id="myfolder-item-container" style="padding:10px;">
                    </div>
                    <div class="row" style="margin-top: 15px;">
                        <div style="text-align:center;">
                            <button class="btn btn-social-icon btn-lg" href="javascript::" id="myfolder-apply">
                                <i class="fa  fa-check-circle-o"></i>
                            </button>
                        </div>
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
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var brandDesignSourceAry = [];

            var rootpath = $('meta[name="root-path"]').attr('content');

            getBrandInfo();

            $("#myfolder-apply").click(function (sender) {
                try {
                    var itemList = [];
                    $(".myfolder-item.selected").each(function () {
                        var id = $(this).data('id');
                        var file = _.find(brandDesignSourceAry, function (brandDesignSource) {
                            return brandDesignSource.id == id
                        });
                        file['type'] = 'designsource';
                        itemList.push(file);
                    });
                    window.opener.handleImageWindow(itemList);
                }
                catch (err) {
                }
                window.close();
                return false;
            });

            function getBrandInfo() {
                $.ajax({
                    url: $('#branddesignsource-container').data('getbrandinfo'),
                    type: 'post',
                    dataType: 'json',
                    success: function (result) {
                        brandDesignSourceAry = result.designSources;
                        refreshDesignSourceView();
                    }
                });
            }

            function refreshDesignSourceView() {
                var container = $("#myfolder-item-container");
                container.empty();

                for (var i in brandDesignSourceAry) {
                    var brandDesignSource = brandDesignSourceAry[i];
                    var html = '<div class="col-xs-6 col-sm-2 myfolder-item" data-id="' + brandDesignSource.id + '">' +
                        '<div class="myfolder-item-wrapper">' +
                        '<div class="thumb_zoom thumb_file">' +
                        '<a href="javascript::">' +
                        '<img src="' + rootpath + brandDesignSource.url + '">' +
                        '</a>' +
                        '<a href="javascript::" class="myfolder-item-download" data-id="' + brandDesignSource.id + '" data-url="' + brandDesignSource.url + '"><i class="fa fa-download"></i></a>' +
                        '<p class="myfolder-item-name">' + brandDesignSource.price + ' Coin</p></div>' +
                        '</div>' +
                        '</div>';

                    container.append(html);
                }

                $(".myfolder-item").off('click').on('click', function () {
                    var id = $(this).data('id');
                    $('.myfolder-item').removeClass('selected');
                    $(this).addClass('selected');
                })

                $(".myfolder-item-download").off('click').on('click', function () {
                    var id = $(this).data('id');
                    $("#download-url").val($(this).data('url'));
                    $("#download-form").submit();
                })
            }
        });
    </script>
    <!--page level js ends-->
@stop
