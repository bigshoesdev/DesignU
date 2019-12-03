@extends('layout/default')

{{-- Page title --}}
@section('title')
    Shopping
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/shopping/categorylist.css') }}">
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.shopping-breadcum')
@stop

{{-- Page content --}}
@section('content')
    <div class="container categorylist-container">
        <div class="row" style="min-height:700px;">
            <div class="col-md-12">
                <div class="row" style="margin-top: 30px;margin-bottom:30px;">
                    <div class="col-md-12 text-center">
                        <a type="button" href="{{ route('shopping.index') }}"
                           class="btn btn-primary btn-warning shopping-header-btn">ALL
                        </a>
                        <a type="button" href="{{ route('shopping.brandlist') }}"
                           class="btn btn-primary btn-warning  shopping-header-btn">BRAND
                        </a>
                        <a type="button" href="{{ route('shopping.categorylist') }}"
                           class="btn btn-primary shopping-header-btn">CATEGORY
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 wow flipInX" data-wow-duration="2s" data-wow-delay=0s">
                        <div class="row">
                            @foreach($categoryList as $category)
                                <a href="{{ route('shopping.category', ['id'=> $category->id])}}"
                                   class="category-logo-img">
                                    <img src="{{ asset($category->logo_url)  }}" style="border: 1px solid #d3b3b3;margin-right: 20px;border-radius: 5px;">
                                </a>
                            @endforeach
                        </div>
                    </div>
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
