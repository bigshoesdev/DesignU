@extends('layout/default_no_search')

{{-- Page title --}}
@section('title')
    Product Manage
    @parent
@stop

@section('logo_title')
    Design U
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link href="{{ asset('assets/vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/toastr/css/toastr.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}">
    <link href="{{ asset('assets/vendors/iCheck/css/all.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/css/shopmanager/product.css').'?v='.(new DateTime())->getTimestamp() }}">
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.shopmanager-breadcum')
@stop

{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <div class="container product-container"
         data-getproductsurl="{{route('shopmanager.product.getproducts')}}"
         data-getproductiteminfourl="{{route('shopmanager.product.getproductiteminfo')}}"
         data-getproductallinfourl="{{route('shopmanager.product.getproductallinfo')}}"
         data-getproductitemexchangereturnurl="{{route('shopmanager.product.getproductitemexchangereturn')}}"
         data-getproductallexchangereturnurl="{{route('shopmanager.product.getproductallexchangereturn')}}"
         data-getproducturl="{{route('shopmanager.product.getproduct')}}"
         data-getorderinfourl="{{route('shopmanager.product.getorderinfo')}}"
         data-getorderrequestinfourl="{{route('shopmanager.product.getorderrequestinfo')}}"
         data-savereturnrequesturl="{{route('shopmanager.product.savereturnrequest')}}"
         data-saveexchangerequesturl="{{route('shopmanager.product.saveexchangerequest')}}"
    >
        <form action="{{ route('shopmanager.product.downloadnotdeliverylist') }}" method="POST"
              id="product-download-notdelivery-form">
            {{ csrf_field() }}
            <input type="hidden" name="productID" id="product-download-notdelivery-productid" value="">
            <input type="hidden" name="date" id="product-download-notdelivery-date" value="">
            <input type="hidden" name="mode" id="product-download-notdelivery-mode" value="">
        </form>
        <div class="row" style="min-height:800px;">
            <div class="text-center">
                <h3 class="border-success"><span class="heading_border bg-success">Product Manage</span></h3>
            </div>
            <div class="col-md-7">
                <div class="thumbnail wow slideInLeft" data-wow-duration="1s" style="padding: 10px;">
                    <div class="row" style="display: flex;align-items: center;">
                        <div class="col-md-2" style="text-align: right;">
                            <span> Search:
                            </span>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="livicon" data-name="search" data-size="16" data-loop="true"
                                       data-c="#418bca"
                                       data-hc="#418bca"></i>
                                </span>
                                <input type="text" placeholder=" " name="product-search " class="form-control"
                                       id="product-search-input">
                            </div>
                        </div>
                        <label class="col-md-2 control-label" style="text-align:right">Order By:</label>
                        <div class="col-md-4">
                            <a class="btn btn-primary product-order-by btn-warning" data-orderby="time" type="button"
                               style="width:100px;">
                                TIME
                            </a>
                            <a class="btn btn-primary product-order-by" data-orderby="sale" type="button"
                               style="width:100px;">
                                SALE
                            </a>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="product-list-container">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-xs-12" style="text-align: right;">
                        </div>
                        <div class="col-md-5 col-xs-12" style="text-align: right;">
                            <button class="btn btn-primary btn-warning" type="button" id="product-copy-btn"
                                    data-copyurl="{{route('shopmanager.product.copyproduct')}}"
                                    style="width: 70px;font-size: 20px;padding:2px;">
                                <i class="fa fa-fw fa-copy"></i>
                            </button>
                            <button class="btn btn-primary btn-warning" type="button" id="product-delete-btn"
                                    data-deleteurl="{{route('shopmanager.product.deleteproduct')}}"
                                    style="width: 70px;font-size: 20px;padding:2px;">
                                <i class="fa fa-fw fa-trash"></i>
                            </button>
                            <button class="btn btn-primary btn-warning" type="button" id="product-update-btn"
                                    style="width: 70px;font-size: 20px;padding:2px;">
                                <i class="fa fa-fw fa-pencil"></i>
                            </button>
                            <button class="btn btn-primary btn-warning" type="button" id="product-add-btn"
                                    style="width: 70px;font-size: 20px;padding:2px;">
                                <i class="fa fa-fw fa-plus"></i>
                            </button>
                        </div>
                        <div class="col-md-5 col-xs-12" style="text-align: right;">
                            <button class="btn btn-primary btn-warning" type="button"
                                    style="width: 80px;margin-right:10px;" id="product-open-btn"
                                    data-updatestateurl="{{route('shopmanager.product.updateproductstate')}}">
                                OPEN
                            </button>
                            <button class="btn btn-primary btn-danger" type="button" id="product-off-btn"
                                    style="width: 80px;margin-right:10px;"
                                    data-updatestateurl="{{route('shopmanager.product.updateproductstate')}}">
                                OFF
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="thumbnail wow slideInLeft" data-wow-duration="1s" style="padding: 10px;">
                    <div class="product-status-container" style="display: block;">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button class="btn  btn-warning product-status-container-selection btn-danger "
                                        data-select="item" type="button" style="width: 100px;">
                                    ITEM
                                </button>
                                <button class="btn btn-warning product-status-container-selection" type="button"
                                        data-select="all" style="width: 100px;">
                                    All
                                </button>
                                <button class="btn btn-warning product-status-container-selection" type="button"
                                        data-select="date" style="width: 120px;">
                                    <span id="product-status-calendar-label">{{ date('Y-m-d') }}</span>
                                    <a style="color:#4d5268;" id="product-status-container-calender-selection">
                                        <i class="fa fa-fw fa-calendar"></i>
                                    </a>
                                </button>
                            </div>
                        </div>
                        <div class="row" style="padding: 10px;">
                            <div class="col-md-12 product-status-container">
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 10px;margin-top: 10px;">
                                        <div class="col-md-5 transaction-status-label" style="text-align: center;">
                                            <span>Transaction Status:</span>
                                        </div>
                                        <div class="col-md-4 transaction-status-label" style="text-align: center;">
                                            <span> <b id="product-status-transaction-count">0</b>&nbsp;&nbsp;Transactions</span>
                                        </div>
                                        <div class="col-md-3 transaction-status-label" style="text-align: center;">
                                            <span> <b id="product-status-transaction-money">0</b>&nbsp;&nbsp;Coins</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <span style="width:100%;display:block;height: 5px;border-bottom: 2px solid #b06a6a;"></span>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;margin-top: 10px;">
                                        <div class="col-md-5 transaction-status-label" style="text-align: center;">
                                            <span>Not-Delivery Count:</span>
                                        </div>
                                        <div class="col-md-3 transaction-status-label" style="text-align: center;">
                                            <span> <b id="product-status-not-delivery-count">0</b>&nbsp;&nbsp;Delivery</span>
                                        </div>
                                        <div class="col-md-4 transaction-status-label" style="text-align: center;">
                                            <button class="btn btn-primary btn-warning" type="button"
                                                    id="product-excel-download-btn">
                                                EXCEL
                                            </button>
                                            <input type="file" style="display:none;" id="product-excel-code-input">
                                            <button class="btn btn-primary" type="button" id="product-excel-code-btn"
                                                    data-uploadcodingfile="{{route('shopmanager.product.upload.codingfile')}}">
                                                CODE
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <span style="width:100%;display:block;height: 5px;border-bottom: 2px solid #b06a6a;"></span>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="delivery-container">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row" style="margin-bottom: 10px;margin-top:10px;">
                                            <div class="col-md-2">
                                                <button class="btn btn-primary btn-danger btn-block" type="button"
                                                        id="product-status-select-all">
                                                    All
                                                </button>
                                            </div>
                                            <div class="col-md-5">
                                                <button class="btn btn-primary btn-danger btn-block" type="button"
                                                        id="product-status-send-message"
                                                        data-sendmail="{{ route('shopmanager.product.sendmail') }}">
                                                    Send Message
                                                </button>
                                            </div>
                                            <div class="col-md-5">
                                                <button class="btn btn-primary btn-danger btn-block" type="button"
                                                        id="product-exchange-return-btn">
                                                    Exchange && Return
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-exchange-return-container" style="display: none;">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button class="btn  btn-warning product-exchange-return-container-selection btn-danger "
                                        data-select="item" type="button" style="width: 100px;">
                                    ITEM
                                </button>
                                <button class="btn btn-warning product-exchange-return-container-selection"
                                        type="button"
                                        data-select="all" style="width: 100px;">
                                    All
                                </button>
                                <button class="btn btn-warning product-exchange-return-container-selection"
                                        type="button"
                                        data-select="date" style="width: 120px;">
                                    <span id="product-exchange-return-calendar-label">{{ date('Y-m-d') }}</span>
                                    <a style="color:#4d5268;" id="product-exchange-return-container-calender-selection">
                                        <i class="fa fa-fw fa-calendar"></i>
                                    </a>
                                </button>
                            </div>
                        </div>
                        <div class="row" style="padding: 10px;">
                            <div class="col-md-12 product-exchange-return-info-container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span style="width:100%;display:block;height: 5px;border-bottom: 2px solid #b06a6a;"></span>
                                    </div>
                                    <div class="col-md-12">
                                        <h4>Exchange</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="product-exchange-container">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h4>Return</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="product-return-container">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row" style="margin-bottom: 10px;margin-top:10px;">
                                            <div class="col-md-6">
                                                <button class="btn btn-primary btn-danger btn-block" type="button"
                                                        id="product-status-send-message"
                                                        data-sendmail="{{ route('shopmanager.product.sendmail') }}">
                                                    Send Message
                                                </button>
                                            </div>
                                            <div class="col-md-6">
                                                <button class="btn btn-primary btn-danger btn-block" type="button"
                                                        id="transaction-status-btn">
                                                    Transaction Status
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-add-container" style="display: none;">
                        <div class="text-center">
                            <h4 class="border-success">
                                <span class="heading_border bg-success">Product Information</span>
                            </h4>
                        </div>
                        <div class="row">
                            <label class="col-md-3 control-label" style="text-align:left">Main Image:</label>
                            <div class="col-md-3"
                                 style="align-items: center;justify-content: space-around;display: flex;">
                                <div class="product-add-main-img">
                                    <input style="display:none;" type="file" name="img"
                                           id="product-add-main-img-input">
                                    <div class="thumb_zoom">
                                        <div style="position:absolute;">
                                            <a id="product-add-main-img-btn" href="javascript::"
                                               data-uploadmainimgurl="{{ route('shopmanager.product.upload.mainimg') }}"
                                               style="width:100%;height:100%;">
                                                <img class="img-responsive" id="product-add-main-img-tag"
                                                     data-defaultsrc="{{ asset('assets/img/general/plus.png') }}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-md-4 control-label" style="text-align:left">Title:</label>
                                    <div class="col-md-8">
                                        <input id="product-add-title-input" name="title" type="text"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <label class="col-md-4 control-label" style="text-align:left">Price(Coin):</label>
                                    <div class="col-md-8">
                                        <input id="product-add-price-input" name="price" type="number"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <label class="col-md-2 control-label" style="text-align:left">Category:</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                            <span class="input-group-addon">
                                                   <i class="livicon" data-name="list" data-size="16" data-loop="true"
                                                      data-c="#418bca"
                                                      data-hc="#418bca"></i>
                                            </span>
                                    <select class="form-control select2" id="product-add-categoryid-input"
                                            name="categoryid">
                                        @foreach($categoryList as $category)
                                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <label class="col-md-2 control-label" style="text-align:left">Description:</label>
                            <div class="col-md-10">
                                <textarea id="product-add-description-input" name="description"
                                          class="form-control resize_vertical" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <label class="col-md-2 control-label" style="text-align:left">Style:</label>
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-warning btn-block" type="button"
                                        style="font-size: 20px;padding:2px;" id="product-add-style-btn">
                                    <i class="fa fa-fw fa-plus"></i>
                                </button>
                            </div>
                            <div class="col-md-8">
                                <div class="row product-add-style-container">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <label class="col-md-2 control-label" style="text-align:left">Free Style:</label>
                            <div class="col-md-10">
                                <input id="product-add-freestyle-input" name="freestyle" type="text"
                                       class="form-control ">
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <label class="col-md-3 control-label" style="text-align:left">Sub Image:</label>
                            <div class="col-md-9">
                                <div class="row" id="product-add-sub-img-container">
                                    <div class="col-xs-6 col-sm-4" style="margin-bottom: 5px;">
                                        <div class="product-add-sub-img">
                                            <input style="display:none;" type="file" name="img"
                                                   id="product-add-sub-img-input" multiple>
                                            <div class="thumb_zoom">
                                                <a id="product-add-sub-img-btn" href="javascript::"
                                                   data-uploadsubimgurl="{{ route('shopmanager.product.upload.subimg') }}"
                                                   style="width:100%;height:100%;">
                                                    <img class="img-responsive"
                                                         src="{{ asset('assets/img/general/plus.png') }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <label class="col-md-3 control-label" style="text-align:left">Video:</label>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-4" style="margin-bottom: 5px;">
                                        <div class="product-add-video">
                                            <input style="display:none;" type="file" name="video"
                                                   id="product-add-video-input">
                                            <div class="thumb_zoom">
                                                <a id="product-add-video-btn" href="javascript::"
                                                   data-uploadvideourl="{{ route('shopmanager.product.upload.video') }}"
                                                   style="width:100%;height:100%;">
                                                    <video autoplay src="" controls
                                                           poster="{{ asset('assets/img/general/plus.png') }}"
                                                           id="product-add-video-tag">
                                                    </video>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button class="btn btn-primary btn-warning btn-block" type="button"
                                        id="product-add-size-code">
                                    Size Code
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary btn-block" type="button" id="product-add-save-btn"
                                        data-saveproducturl="{{ route('shopmanager.product.saveproduct') }}"
                                        data-updateproducturl="{{ route('shopmanager.product.updateproduct') }}">
                                    Save
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary btn-danger btn-block" type="button"
                                        id="product-add-back-btn">
                                    Back
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="product-add-size-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Size Setting</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" accept-charset="UTF-8" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered" id="table">
                                    <thead class="no-border">
                                    <tr>
                                        <th>Size</th>
                                        <th>Shoulder</th>
                                        <th>Bust</th>
                                        <th>Waist</th>
                                        <th>Hip</th>
                                        <th>Sleeve</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody id="product-size-modal-size-container"
                                           class="no-border-x no-border-y ui-sortable">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="product-size-modal-add-size">Add Size
                    </button>
                    <button type="button" class="btn btn-primary" id="product-size-modal-save">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade in" id="product-add-style-modal" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Style Setting</h5>
                    </div>
                    <div class="modal-body">
                        <div class="product-add-style-modal-style-container">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" style="margin-bottom: 0px;"
                                id="product-style-modal-style-add-btn">Add
                        </button>
                        <button type="button" class="btn btn-primary" style="margin-bottom: 0px;"
                                id="product-style-modal-style-save-btn">Save
                        </button>
                        <button type="button" data-dismiss="modal" class="btn btn-danger" style="margin-bottom: 0px;">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade pullUp in" id="order-info-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title"><i class="fa fa-fw fa-shopping-cart"></i>ORDER</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img class="order-info-image" src="" id="order-info-order-userimg">
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <p class="order-info-order">Order No:&nbsp;&nbsp; <b id="order-info-order-no"></b></p>
                            </div>
                            <div class="row">
                                <p class="order-info-order">Order Date: <b id="order-info-order-date"></b></p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="order-info-text">
                                        Name: <b id="order-info-order-username"></b>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="order-info-text">
                                        Country: <b id="order-info-order-country"></b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="order-info-text">
                                        Post Code: <b id="order-info-order-postcode"></b>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="order-info-text">
                                        HP: <b id="order-info-order-hp"></b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="order-info-text">
                                        Address: <b id="order-info-order-address"></b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="order-info-text">
                                        Email: <b id="order-info-order-email"></b>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="order-info-text">
                                        Memo:
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control resize_vertical" rows="3"
                                              id="order-info-order-note"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <p class="col-md-3 text-center order-info-product">Product:</p>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <img class="order-info-image" src=""
                                 id="order-info-order-productimg">
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <p class="order-info-product">Title:&nbsp;&nbsp; <b id="order-info-order-title"></b>
                                </p>
                            </div>
                            <div class="row">
                                <p class="order-info-product">Style:&nbsp;&nbsp; <b id="order-info-order-style"></b>
                                </p>
                            </div>
                            <div class="row">
                                <p class="order-info-product">Size:&nbsp;&nbsp; <b id="order-info-order-size"></b></p>
                            </div>
                            <div class="row">
                                <p class="order-info-product">Quantity:&nbsp;&nbsp; <b
                                            id="order-info-order-quantity"></b></p>
                            </div>
                            <div class="row">
                                <p class="order-info-product">Total Price:&nbsp;&nbsp; <b
                                            id="order-info-order-totalprice"></b> coins</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn  btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade pullUp in" id="product-status-select-date" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Date:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="livicon" data-name="laptop" data-size="16" data-c="#555555"
                                   data-hc="#555555" data-loop="true"></i>
                            </div>
                            <input type="text" class="form-control" id="product-status-date-input"/>
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn  btn-primary" id="product-status-date-save-btn">Save</button>
                    <button class="btn  btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade pullUp in" id="product-return-check-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title"><i class="fa fa-fw fa-shopping-cart"></i>Return Request</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="product-return-check-modal-orderID">
                    <div class="row">
                        <div class="col-md-5 text-center;">
                            <div class="checkbox">
                                <label>
                                    <b>Check Complete:</b>&nbsp; <input type="checkbox"
                                                                        name="product-return-check-modal-check-complete"
                                                                        class="custom-checkbox">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 text-center;">
                            <div class="radio">
                                <label>
                                    <b>Check Agree:</b> <input type="radio"
                                                               name="product-return-check-modal-check-agree"
                                                               class="custom-radio" value="1">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3  text-center;">
                            <div class="radio">
                                <label>
                                    <b>Disagree:</b> <input type="radio" name="product-return-check-modal-check-agree"
                                                            class="custom-radio" value="0">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label><b>User Request Reason: </b></label>
                        </div>
                        <div class="col-md-offset-1 col-md-10">
                            <span style="font-size: 15px; font-weight:bold"
                                  id="product-return-user-request-text"></span>
                        </div>
                        <div class="col-md-12">
                            <label><b>Request Description: </b></label>
                        </div>
                        <div class="col-md-offset-1 col-md-10">
                            <textarea rows="3" class="form-control"
                                      id="product-return-check-modal-description"></textarea>
                        </div>
                    </div>
                    <div class="product-return-check-modal-agree" style="display:block">
                        <div class="row">
                            <div class="col-md-12">
                                <label><b>Return Money :</b></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="text-align: right;">
                                <label><b id="product-return-check-modal-total-price"></b> -&nbsp;</label>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" type="number" placeholder="delivery cost"
                                       id="product-return-check-modal-delivery-cost">
                            </div>
                            <div class="col-md-4" style="text-align: left;">
                                <label>= &nbsp;<b id="product-return-check-modal-charge-cost">7800</b> coin</label>
                            </div>
                        </div>
                    </div>
                    <div class="product-return-check-modal-disagree" style="display: none;">
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-4" style="text-align: right;">
                                <label><b>Delivery Company </b>;</label>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" id="product-return-check-modal-delivery-company">
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-4" style="text-align: right;">
                                <label><b>Delivery No </b>;</label>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" id="product-return-check-modal-delivery-no">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn  btn-primary" id="product-return-check-save-btn">Save Return</button>
                    <button class="btn  btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade pullUp in" id="product-exchange-check-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title"><i class="fa fa-fw fa-shopping-cart"></i>Exchange Request</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="product-exchange-check-modal-orderID">
                    <div class="row">
                        <div class="col-md-5 text-center;">
                            <div class="checkbox">
                                <label>
                                    <b>Check Complete:</b>&nbsp; <input type="checkbox"
                                                                        name="product-exchange-check-modal-check-complete"
                                                                        class="custom-checkbox">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 text-center;">
                            <div class="radio">
                                <label>
                                    <b>Check Agree:</b> <input type="radio"
                                                               name="product-exchange-check-modal-check-agree"
                                                               class="custom-radio" value="1">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3  text-center;">
                            <div class="radio">
                                <label>
                                    <b>Disagree:</b> <input type="radio" name="product-exchange-check-modal-check-agree"
                                                            class="custom-radio" value="0">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label><b>User Request Reason: </b></label>
                        </div>
                        <div class="col-md-offset-1 col-md-10">
                            <span style="font-size: 15px; font-weight:bold"
                                  id="product-exchange-user-request-text"></span>
                        </div>
                        <div class="col-md-12">
                            <label><b>Request Description: </b></label>
                        </div>
                        <div class="col-md-offset-1 col-md-10">
                            <textarea rows="3" class="form-control"
                                      id="product-exchange-check-modal-description"></textarea>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-4" style="text-align: right;">
                            <label><b>Delivery Company </b>;</label>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" id="product-exchange-check-modal-delivery-company">
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-4" style="text-align: right;">
                            <label><b>Delivery No </b>;</label>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" id="product-exchange-check-modal-delivery-no">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn  btn-primary" id="product-exchange-check-save-btn">Complete Exchange</button>
                    <button class="btn  btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page level js -->
    <!--tags-->
    <script type="text/javascript" src="{{ asset('assets/vendors/moment/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/select2/js/select2.js') }}"></script>
    <script src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/underscore/js/underscore-min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/js/shopmanager/product.js').'?v='.(new DateTime())->getTimestamp() }}"></script>
    <script>
        jQuery(document).ready(function () {
            new WOW().init();

            $("#product-status-date-input").datetimepicker().parent().css("position :relative");


        });
    </script>
    <!-- end of page level js -->

@stop
