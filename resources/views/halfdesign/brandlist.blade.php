@extends('layout/default')

{{-- Page title --}}
@section('title')
    Shopping
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/shopping/brandlist.css') }}">
@stop


{{-- breadcrumb --}}
@section('top')
    @include('partial.halfdesign-list-breadcum')
@stop

{{-- Page content --}}
@section('content')
    <div class="container brandlist-container">
        <div class="row" style="min-height:700px;">
            <div class="col-md-12">
                <div class="row" style="margin-top: 30px;margin-bottom:30px;">
                    <div class="col-md-12 text-center">
                        <a type="button" href="{{ route('halfdesign.productlist') }}"
                           class="btn btn-primary btn-warning shopping-header-btn">ALL
                        </a>
                        <a type="button" href="{{ route('halfdesign.brandlist') }}"
                           class="btn btn-primary  shopping-header-btn">BRAND
                        </a>
                        <a type="button" href="{{ route('halfdesign.categorylist') }}"
                           class="btn btn-primary btn-warning shopping-header-btn">CATEGORY
                        </a>
                    </div>
                </div>
                <div class="row">
                    @foreach($brandList as $brand)
                        <div class="col-sm-6 col-md-3 wow flipInX" data-wow-duration="2s" data-wow-delay=0s">
                            <div class=" thumbnail text-center">
                                <a href="{{ route('halfdesign.brand', ['id'=> $brand->id])}}">
                                    <img src="{{ asset('/').$brand->web_img_url  }}" class="img-responsive">
                                </a>
                                <br/>
                                <h4 class="text-primary"
                                    style="text-transform: uppercase; font-weight: bold;line-height: 0px;">{{ $brand->brand_id }} </h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function () {
            new WOW().init();
        });
    </script>
@stop
