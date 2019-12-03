@extends('layout/default')

{{-- Page title --}}
@section('title')
    Half Design Product All
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link href="{{ asset('assets/vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fancybox/jquery.fancybox.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-buttons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/halfdesign/subimgview.css') }}"/>
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.halfdesign-list-breadcum')
@stop

{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <div class="container">
        <div class="row" style="min-height:700px;">
            <div class="col-md-12">
                <div class="row" style="margin-top: 30px;margin-bottom:30px;">
                    <div class="col-md-12 text-center">
                        <a type="button" href="{{ route('halfdesign.productlist') }}"
                           class="btn btn-primary btn-warning shopping-header-btn">ALL
                        </a>
                        <a type="button" href="{{ route('halfdesign.brandlist') }}"
                           class="btn btn-primary btn-warning shopping-header-btn">BRAND
                        </a>
                        <a type="button" href="{{ route('halfdesign.categorylist') }}"
                           class="btn btn-primary btn-warning shopping-header-btn">CATEGORY
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="thumbnail wow slideInLeft" data-wow-duration="3s">
                            <div class="text-center">
                                <h4 class="border-success"><span
                                            class="heading_border bg-success">Product Image View</span></h4>
                            </div>
                            <div class="row">
                                <div class="col-md-4" style="padding: 0">
                                    <div class="thumb_zoom main-img-wrapper">
                                        <img src="{{ asset('/').$product->getMainImage()->url }}"
                                             class="img-responsive"/>
                                    </div>
                                </div>
                                <div class="col-md-8" style="padding: 0">
                                    <div id="gallery">
                                        <div>
                                            @foreach($subImages as $index => $subImage)
                                                <div class="mix" data-my-order="{{$index + 1}}">
                                                    <div class="thumb_zoom sub-img-wrapper">
                                                        <a class="fancybox" href="{{ asset('/').$subImage->url }}"><i
                                                                    class="fa fa-search-plus"></i></a>
                                                        <img src="{{ asset('/').$subImage->url }}"
                                                             class="img-responsive">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
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
    <script type="text/javascript" src="{{ asset('assets/vendors/mixitup/jquery.mixitup.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/fancybox/jquery.fancybox.pack.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-buttons.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-media.js') }}"></script>
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function () {
            new WOW().init();
        });

        $(function () {
            gallery();
        });

        function gallery() {
            function mixitup() {
                $("#gallery").mixItUp({
                    animation: {
                        duration: 300,
                        effects: "fade translateZ(-360px) stagger(34ms)",
                        easing: "ease"
                    }
                });
            }

            mixitup();
        }

        $(document).ready(function () {
            $(".fancybox").fancybox();
        });

    </script>

@stop
