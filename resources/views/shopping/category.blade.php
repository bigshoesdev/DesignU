@extends('layout/default')

{{-- Page title --}}
@section('title')
    Shopping
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/shopping/category.css') }}">
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.shopping-breadcum')
@stop

{{-- Page content --}}
@section('content')
    <div class="container category-container">
        <div class="row" style="margin-top: 30px;margin-bottom:30px;">
            <div class="col-md-12 text-center">
                <a type="button" href="{{ route('shopping.index') }}"
                   class="btn btn-primary btn-warning shopping-header-btn">ALL
                </a>
                <a type="button" href="{{ route('shopping.brandlist') }}"
                   class="btn btn-primary btn-warning shopping-header-btn">BRAND
                </a>
                <a type="button" href="{{ route('shopping.categorylist') }}"
                   class="btn btn-primary  shopping-header-btn">CATEGORY
                </a>
                <h2 style="text-transform: uppercase;font-weight: bold;">{{$category->name}}</h2>
            </div>
        </div>
        <div class="row" style="min-height:700px;">
            <div class="col-md-12 wow slideInRight">
                <div class="row">
                    @foreach($productList as $product)
                        <div class="col-sm-3 col-md-3 wow flipInX" data-wow-duration="2s" data-wow-delay=0s"
                             style="padding:20px;">
                            <div class=" thumbnail text-center">
                                <a href="{{ route('shopping.product', ['id'=> $product->id]) }}">
                                    <img src="{{ asset('/').$product->getMainImage()->url }}" class="img-responsive">
                                </a>
                                <br/>
                                <h3 class="text-primary"
                                    style="text-transform: uppercase; font-weight: bold;margin:0px;line-height: 10px;">{{$product->title}}
                                </h3>
                                <h4 class="text-danger"><b>{{ $product->price }}</b> coins</h4>
                                <a href="{{ route('shopping.product', ['id'=> $product->id]) }}" class="btn btn-primary btn-block text-white">View</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row text-center">
                    {{ $productList->links() }}
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
