@extends('layout/default')

{{-- Page title --}}
@section('title')
    Shopping
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/sweetalert/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/toastr/css/toastr.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/css/shopping/brand.css') .'?v='.(new DateTime())->getTimestamp() }}">
@stop


{{-- breadcrumb --}}
@section('top')
    @include('partial.shopping-breadcum')
@stop

{{-- Page content --}}
@section('content')
    <div class="container brand-container" data-downloaddesignsourceurl="{{route('shopping.downloaddesignsource')}}">
        <div class="row" style="margin-top: 30px;margin-bottom:30px;">
            <div class="col-md-12 text-center">
                <a type="button" href="{{ route('shopping.index') }}"
                   class="btn btn-primary btn-warning shopping-header-btn">ALL
                </a>
                <a type="button" href="{{ route('shopping.brandlist') }}"
                   class="btn btn-primary  shopping-header-btn">BRAND
                </a>
                <a type="button" href="{{ route('shopping.categorylist') }}"
                   class="btn btn-primary btn-warning shopping-header-btn">CATEGORY
                </a>
            </div>
        </div>
        <div class="row" style="min-height:700px;">
            <div class="col-md-3 wow slideInLeft" style="margin-top: 70px; border:2px solid #989a87;">
                <div class="row" style="text-align:center;margin-top: 20px;">
                    <img style="display: block;max-width: 90%;height:250px; margin: 0 auto;"
                         src="{{ asset('/').$brand->web_img_url }}">
                    </img>
                </div>
                <div class="row" style="text-align:center;margin-top: 10px;">
                    <h2 style="text-transform: uppercase;font-weight: bold;">{{$brand->brand_id}}</h2>
                </div>
                <div class="row" style="text-align:center;margin-top: 10px;margin-bottom:10px;">
                    <a href="javascript::" id="brand-design-source-btn">
                        <img src="{{asset('assets/img/shopping/design-source-img.png')}}"
                             style="width: 50px;height:50px;margin-right:10px;">
                    </a>
                    <a href="javascript::" id="brand-tip-modal-btn">
                        <img src="{{asset('assets/img/shopping/brand-tip-img.png')}}" style="width: 50px;height:50px;">
                    </a>
                </div>
                <img style="height: 100px;position: absolute;top: 150px;width: 100px; left: 85%;background: white;border-radius: 50%;border: 2px solid #9c5959;"
                     src="{{ asset('/').$brand->pic }}">
            </div>
            <div class="col-md-offset-1 col-md-8 wow slideInRight" style="margin-top: 50px;">
                <div class="row">
                    @foreach($productList as $product)
                        <div class="col-sm-3 col-md-4 wow flipInX" data-wow-duration="2s" data-wow-delay=0s"
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
                                <a href="{{ route('shopping.product', ['id'=> $product->id]) }}"
                                   class="btn btn-primary btn-block text-white">View</a>
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

    <div class="modal fade pullUp in" tabindex="-1" id="brand-tip-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">Brand Tip</h4>
                </div>
                <div class="modal-body">
                    {!! json_decode($brand->tip)  !!}
                </div>
                <div class="modal-footer">
                    <button class="btn  btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade pullUp in" tabindex="-1" id="brand-design-source-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">Brand Design Source</h4>
                </div>
                <div class="modal-body">
                    <form id="download-form" action="{{route('download.image') }}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" id="download-url" name="url">
                    </form>
                    <div class="row">
                        @foreach($designSources as $designSource)
                            <div class="col-md-3 col-xs-4"
                                 style="align-items: center;justify-content: space-around;display: flex;margin-bottom:10px;">
                                <div class="brand-design-source-img">
                                    <a href="javascript::" id="brand-design-source-{{$designSource->id}}"
                                       data-price="{{$designSource->price}}"
                                       class="brand-design-source-download"><i class="fa fa-download"></i></a>
                                    <div class="thumb_zoom">
                                        <img class="img-responsive"
                                             src="{{ asset('/'). $designSource->url }}">
                                    </div>
                                    <div style="text-align: center;color: #5d529a;font-size: 13px;font-weight: bold;">
                                        <a href="javascript::"
                                           class="btn btn-primary brand-design-source-price">{{ $designSource->price }}
                                            Coin</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn  btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/sweetalert/js/sweetalert.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript"
            src="{{ asset('assets/js/shopping/brand.js').'?v='.(new DateTime())->getTimestamp() }}"></script>
    <script>
        jQuery(document).ready(function () {
            new WOW().init();
        });
    </script>
@stop
