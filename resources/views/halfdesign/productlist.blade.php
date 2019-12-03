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
    <link rel="stylesheet" href="{{ asset('assets/css/halfdesign/productlist.css') }}"/>
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.halfdesign-list-breadcum')
@stop

{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <div class="container products-container">
        <div class="row" style="min-height:700px;">
            <div class="col-md-12">
                <div class="row" style="margin-top: 30px;margin-bottom:30px;">
                    <div class="col-md-12 text-center">
                        <a type="button" href="{{ route('halfdesign.productlist') }}"
                           class="btn btn-primary shopping-header-btn">ALL
                        </a>
                        <a type="button" href="{{ route('halfdesign.brandlist') }}"
                           class="btn btn-primary btn-warning shopping-header-btn">BRAND
                        </a>
                        <a type="button" href="{{ route('halfdesign.categorylist') }}"
                           class="btn btn-primary btn-warning shopping-header-btn">CATEGORY
                        </a>
                    </div>
                </div>
                <div class="row ">
                    @foreach($products as $index => $product)
                        <div class="col-md-4 wow flipInX" data-wow-duration="2s" data-wow-delay="{{0.3 * $index}}s">
                            <div class="panel panel-default text-center product-panel">
                                <div class="product-upper-panel">
                                    <div class="row">
                                        <div class="product-left-panel col-md-6">
                                            <a href="{{route('halfdesign.customdraw', ['productID' => $product->id])}}">
                                                <img src="{{ asset('/').$product->getMainImage()->url }}"
                                                     class="product-img"/>
                                            </a>
                                        </div>
                                        <div class="product-right-panel col-md-6">
                                            <div class="product-crowding-label">{{$product->crowding }}</div>
                                            <div class="product-funding-date-label">Funding: <span
                                                        class="product-funding-date-value">{{  date_parse( $product->date )['month'].'.'.date_parse( $product->date )['day'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-lower-panel" style="color:#383030;">
                                    <div class="row">
                                        <div class="col-md-7 text-left">
                                            <span class="product-title-text">{{ $product->title }}</span>
                                            <br/>
                                            <span class="product-description-text">{{$product->description}}</span>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="row">
                                                <a href="{{ route('halfdesign.subimgview', ['id' =>$product->id]) }}">
                                                    <img src="{{ asset('assets/img/halfdesign/sub_image_show_img.png') }}"
                                                         class="lower-img"/>
                                                </a>
                                                <a href="{{ route('halfdesign.crowdingview', ['id' =>$product->id]) }}"
                                                   style="position:absolute;">
                                                    <img src="{{ asset('assets/img/halfdesign/crowd_funding_img.png') }}"
                                                         class="lower-img"/>
                                                </a>
                                                <span class="product-crowding-no">12</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    {{ $products->links() }}
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
