@extends('layout/default_no_search')

{{-- Page title --}}
@section('title')
    Project Manage
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
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/css/shopmanager/project.css').'?v='.(new DateTime())->getTimestamp() }}">
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.shopmanager-breadcum')
@stop

{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <div class="container project-container"
         data-getprojectsurl="{{route('shopmanager.project.getprojects')}}"
         data-getprojectiteminfourl="{{route('shopmanager.project.getprojectiteminfo')}}"
         data-getprojectitemexchangereturnurl="{{route('shopmanager.project.getprojectitemexchangereturn')}}"
         data-getorderinfourl="{{route('shopmanager.project.getorderinfo')}}"
         data-getorderrequestinfourl="{{route('shopmanager.project.getorderrequestinfo')}}"
         data-saveexchangerequesturl="{{route('shopmanager.project.saveexchangerequest')}}"
         data-savereturnrequesturl="{{route('shopmanager.project.savereturnrequest')}}"
    >
        <form action="{{ route('shopmanager.project.downloadnotdeliverylist') }}" method="POST"
              id="project-download-notdelivery-form">
            {{ csrf_field() }}
            <input type="hidden" name="projectID" id="project-download-notdelivery-projectid" value="">
        </form>
        <div class="row" style="min-height:800px;">
            <div class="text-center">
                <h3 class="border-success"><span class="heading_border bg-success">Project Manage</span></h3>
            </div>
            <div class="col-md-7">
                <div class="thumbnail wow slideInLeft" data-wow-duration="1s" style="padding: 10px;">
                    <div class="row" style="display: flex;align-items: center;">
                        <div class="col-md-2" style="text-align: right;">
                            <span style=""> Search:
                            </span>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="livicon" data-name="search" data-size="16" data-loop="true"
                                       data-c="#418bca"
                                       data-hc="#418bca"></i>
                                </span>
                                <input type="text" placeholder=" " name="project-search " class="form-control"
                                       id="project-search-input">
                            </div>
                        </div>
                        <label class="col-md-2 control-label" style="text-align:right">Order By:</label>
                        <div class="col-md-4">
                            <a class="btn btn-primary project-order-by btn-warning" data-orderby="time" type="button"
                               style="width:100px;">
                                TIME
                            </a>
                            <a class="btn btn-primary project-order-by" data-orderby="sale" type="button"
                               style="width:100px;">
                                SALE
                            </a>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="project-list-container">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-xs-12" style="text-align: right;">
                        </div>
                        <div class="col-md-5 col-xs-12" style="text-align: right;">
                            <button class="btn btn-primary btn-warning" type="button" id="project-copy-btn"
                                    data-copyurl="{{route('shopmanager.project.copyproject')}}"
                                    style="width: 70px;font-size: 20px;padding:2px;">
                                <i class="fa fa-fw fa-copy"></i>
                            </button>
                            <button class="btn btn-primary btn-warning" type="button" id="project-delete-btn"
                                    data-deleteurl="{{route('shopmanager.project.deleteproject')}}"
                                    style="width: 70px;font-size: 20px;padding:2px;">
                                <i class="fa fa-fw fa-trash"></i>
                            </button>
                            <button class="btn btn-primary btn-warning" type="button" id="project-update-btn"
                                    data-updateurl="{{route('halfdesign.setinfo')}}"
                                    style="width: 70px;font-size: 20px;padding:2px;">
                                <i class="fa fa-fw fa-pencil"></i>
                            </button>
                        </div>
                        <div class="col-md-5 col-xs-12" style="text-align: right;">
                            <button class="btn btn-primary btn-warning" type="button"
                                    style="width: 80px;margin-right:10px;" id="project-open-btn"
                                    data-updatestateurl="{{route('shopmanager.project.updateprojectstate')}}"
                            >
                                OPEN
                            </button>
                            <button class="btn btn-primary btn-danger" type="button" id="project-off-btn"
                                    style="width: 80px;margin-right:10px;"
                                    data-updatestateurl="{{route('shopmanager.project.updateprojectstate')}}"
                            >
                                OFF
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="thumbnail wow slideInLeft" data-wow-duration="1s" style="padding: 10px;">
                    <div class="project-status-container" style="display: block;">
                        <div class="row" style="padding: 10px;">
                            <div class="col-md-12 project-info-container">
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 10px;margin-top: 10px;">
                                        <div class="col-md-5 transaction-status-label" style="text-align: center;">
                                            <span>Transaction Status:</span>
                                        </div>
                                        <div class="col-md-4 transaction-status-label" style="text-align: center;">
                                            <span> <b id="project-status-transaction-count">0</b>&nbsp;&nbsp;Transactions</span>
                                        </div>
                                        <div class="col-md-3 transaction-status-label" style="text-align: center;">
                                            <span> <b id="project-status-transaction-money">0</b>&nbsp;&nbsp;Coins</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <span style="width:100%;display:block;height: 5px;border-bottom: 2px solid #b06a6a;"></span>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;margin-top: 10px;">
                                        <div class="col-md-5 transaction-status-label" style="text-align: center;">
                                            <span>End Date:</span>
                                        </div>
                                        <div class="col-md-3 transaction-status-label" style="text-align: center;">
                                            <span> <b id="project-status-end-date">2018-03-15</b></span>
                                        </div>
                                        <div class="col-md-4 transaction-status-label" style="text-align: center;">
                                            <button class="btn btn-primary btn-warning" type="button"
                                                    id="project-excel-download-btn">
                                                EXCEL
                                            </button>
                                            <input type="file" style="display:none;" id="project-excel-code-input">
                                            <button class="btn btn-primary" type="button" id="project-excel-code-btn"
                                                    data-uploadcodingfile="{{route('shopmanager.project.upload.codingfile')}}">
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
                                                        id="project-status-select-all">
                                                    All
                                                </button>
                                            </div>
                                            <div class="col-md-5">
                                                <button class="btn btn-primary btn-danger btn-block" type="button"
                                                        id="project-status-send-message"
                                                        {{--data-sendmail="{{ route('shopmanager.project.sendmail') }}"--}}
                                                >
                                                    Send Message
                                                </button>
                                            </div>
                                            <div class="col-md-5">
                                                <button class="btn btn-primary btn-danger btn-block" type="button"
                                                        id="project-exchange-return-btn">
                                                    Exchange && Return
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-exchange-return-container" style="display: none;">
                        <div class="row" style="padding: 10px;">
                            <div class="col-md-12 project-exchange-return-info-container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span style="width:100%;display:block;height: 5px;border-bottom: 2px solid #b06a6a;"></span>
                                    </div>
                                    <div class="col-md-12">
                                        <h4>Exchange</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="project-exchange-container">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h4>Return</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="project-return-container">
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
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade pullUp in" tabindex="-1" id="order-info-modal" role="dialog" aria-hidden="true">
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
                        <p class="col-md-3 text-center order-info-project">Project:</p>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <img class="order-info-image" src=""
                                 id="order-info-order-projectimg">
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <p class="order-info-project">Title:&nbsp;&nbsp; <b id="order-info-order-title"></b>
                                </p>
                            </div>
                            <div class="row">
                                <p class="order-info-project">Size:&nbsp;&nbsp; <b id="order-info-order-size"></b></p>
                            </div>
                            <div class="row">
                                <p class="order-info-project">Total Price:&nbsp;&nbsp; <b
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
    <div class="modal fade pullUp in" tabindex="-1" id="project-status-select-date" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Default:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="livicon" data-name="laptop" data-size="16" data-c="#555555"
                                   data-hc="#555555" data-loop="true"></i>
                            </div>
                            <input type="text" class="form-control" id="project-status-date-input"/>
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn  btn-primary" id="project-status-date-save-btn">Save</button>
                    <button class="btn  btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade pullUp in" id="project-return-check-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title"><i class="fa fa-fw fa-shopping-cart"></i>Return Request</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="project-return-check-modal-orderID">
                    <div class="row">
                        <div class="col-md-5 text-center;">
                            <div class="checkbox">
                                <label>
                                    <b>Check Complete:</b>&nbsp; <input type="checkbox"
                                                                        name="project-return-check-modal-check-complete"
                                                                        class="custom-checkbox">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 text-center;">
                            <div class="radio">
                                <label>
                                    <b>Check Agree:</b> <input type="radio"
                                                               name="project-return-check-modal-check-agree"
                                                               class="custom-radio" value="1">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3  text-center;">
                            <div class="radio">
                                <label>
                                    <b>Disagree:</b> <input type="radio" name="project-return-check-modal-check-agree"
                                                            class="custom-radio" value="0">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label><b>User Request Reason: </b></label>
                        </div>
                        <div class="col-md-offset-1 col-md-10">
                            <span style="font-size: 15px; font-weight:bold"
                                  id="project-return-user-request-text"></span>
                        </div>
                        <div class="col-md-12">
                            <label><b>Request Description: </b></label>
                        </div>
                        <div class="col-md-offset-1 col-md-10">
                            <textarea rows="3" class="form-control"
                                      id="project-return-check-modal-description"></textarea>
                        </div>
                    </div>
                    <div class="project-return-check-modal-agree" style="display:block">
                        <div class="row">
                            <div class="col-md-12">
                                <label><b>Return Money :</b></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4" style="text-align: right;">
                                <label><b id="project-return-check-modal-total-price"></b> -&nbsp;</label>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" type="number" placeholder="delivery cost"
                                       id="project-return-check-modal-delivery-cost">
                            </div>
                            <div class="col-md-4" style="text-align: left;">
                                <label>= &nbsp;<b id="project-return-check-modal-charge-cost"></b> coin</label>
                            </div>
                        </div>
                    </div>
                    <div class="project-return-check-modal-disagree" style="display: none;">
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-4" style="text-align: right;">
                                <label><b>Delivery Company </b>;</label>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" id="project-return-check-modal-delivery-company">
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-4" style="text-align: right;">
                                <label><b>Delivery No </b>;</label>
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" id="project-return-check-modal-delivery-no">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn  btn-primary" id="project-return-check-save-btn">Save Return</button>
                    <button class="btn  btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade pullUp in" id="project-exchange-check-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title"><i class="fa fa-fw fa-shopping-cart"></i>Exchange Request</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="project-exchange-check-modal-orderID">
                    <div class="row">
                        <div class="col-md-5 text-center;">
                            <div class="checkbox">
                                <label>
                                    <b>Check Complete:</b>&nbsp; <input type="checkbox"
                                                                        name="project-exchange-check-modal-check-complete"
                                                                        class="custom-checkbox">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 text-center;">
                            <div class="radio">
                                <label>
                                    <b>Check Agree:</b> <input type="radio"
                                                               name="project-exchange-check-modal-check-agree"
                                                               class="custom-radio" value="1">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3  text-center;">
                            <div class="radio">
                                <label>
                                    <b>Disagree:</b> <input type="radio" name="project-exchange-check-modal-check-agree"
                                                            class="custom-radio" value="0">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label><b>User Request Reason: </b></label>
                        </div>
                        <div class="col-md-offset-1 col-md-10">
                            <span style="font-size: 15px; font-weight:bold"
                                  id="project-exchange-user-request-text"></span>
                        </div>
                        <div class="col-md-12">
                            <label><b>Request Description: </b></label>
                        </div>
                        <div class="col-md-offset-1 col-md-10">
                            <textarea rows="3" class="form-control"
                                      id="project-exchange-check-modal-description"></textarea>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-4" style="text-align: right;">
                            <label><b>Delivery Company </b>;</label>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" id="project-exchange-check-modal-delivery-company">
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-4" style="text-align: right;">
                            <label><b>Delivery No </b>;</label>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" id="project-exchange-check-modal-delivery-no">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn  btn-primary" id="project-exchange-check-save-btn">Complete Exchange</button>
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
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/js/shopmanager/project.js').'?v='.(new DateTime())->getTimestamp() }}"></script>
    <script>
        jQuery(document).ready(function () {
            new WOW().init();
        });
    </script>
    <!-- end of page level js -->

@stop
