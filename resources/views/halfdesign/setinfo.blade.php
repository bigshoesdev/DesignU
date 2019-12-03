@extends('layout/default_no_search')

{{-- Page title --}}
@section('title')
    Half Design Setting Information
    @parent
@stop

@section('logo_title')
    Design Factory
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link href="{{ asset('assets/vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link href="{{ asset('assets/vendors/toastr/css/toastr.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fancybox/jquery.fancybox.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-buttons.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/css/halfdesign/setinfo.css').'?v='.(new DateTime())->getTimestamp() }}">
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    @include('partial.halfdesign-breadcum')
@stop

{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <div class="container">
        <div class="row">
            <div class="text-center">
                <h3 class="border-success"><span class="heading_border bg-success">Setting / Information</span></h3>
            </div>
            <div class="col-md-12">
                <div class="thumbnail wow slideInLeft" data-wow-duration="3s" style="padding: 10px;">
                    <div class="row">
                        <div class="col-md-6" style="padding-bottom:10px;">
                            <div class="text-center">
                                <h4 class="border-success"><span
                                            class="heading_border bg-success">Product Information</span>
                                </h4>
                            </div>
                            <div class="row">
                                <label class="col-md-3 control-label" style="text-align:right">Main Image:</label>
                                <form id="setinfo-main-img-form">
                                    <input style="display:none;" type="file" name="img" id="setinfo-main-img-input">
                                    <div class="col-md-8"
                                         style="align-items: center;justify-content: space-around;display: flex;">
                                        <div class="setinfo-main-img">
                                            <div class="thumb_zoom">
                                                @if(old('mainimg'))
                                                    <a class="fancybox" id="setinfo-main-img-fancy"
                                                       href="{{ asset('/').'/'.old('mainimg') }}">
                                                        <i class="fa  fa-search-plus"></i>
                                                    </a>
                                                    <a href="javascript::" id="setinfo-main-img-add"
                                                       data-uploadurl="{{ route('halfdesign.upload.mainimg') }}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <div style="position:absolute;">
                                                        <img class="img-responsive" id="setinfo-main-img"
                                                             src="{{ asset('/').'/'.old('mainimg') }}"
                                                             data-rootpath="{{ asset('/') }}">
                                                    </div>
                                                @elseif($product)
                                                    <a class="fancybox" id="setinfo-main-img-fancy"
                                                       href="{{ asset('/').$product->getMainImage()->url }}">
                                                        <i class="fa  fa-search-plus"></i>
                                                    </a>
                                                    <a href="javascript::" id="setinfo-main-img-add"
                                                       data-uploadurl="{{ route('halfdesign.upload.mainimg') }}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <div style="position:absolute;">
                                                        <img class="img-responsive" id="setinfo-main-img"
                                                             src="{{ asset('/').$product->getMainImage()->url }}"
                                                             data-rootpath="{{ asset('/') }}">
                                                    </div>
                                                @else
                                                    <a class="fancybox" id="setinfo-main-img-fancy"
                                                       href="{{ asset('assets/img/general/plus.png') }}">
                                                        <i class="fa  fa-search-plus"></i>
                                                    </a>
                                                    <a href="javascript::" id="setinfo-main-img-add"
                                                       data-uploadurl="{{ route('halfdesign.upload.mainimg') }}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <div style="position:absolute;">
                                                        <img class="img-responsive" id="setinfo-main-img"
                                                             src="{{ asset('assets/img/general/plus.png') }}"
                                                             data-rootpath="{{ asset('/') }}">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <form id="setinfo-main-form" method="POST"
                                  action="{{ route('halfdesign.setinfo.saveinfo') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="productID"
                                       value="@if(old('productID')){{old('productID')}}@elseif($product){{$product->id}} @else 0 @endif">
                                <input type="hidden" name="mainimg"
                                       value="@if(old('mainimg')){{old('mainimg')}}@elseif($product){{$product->getMainImage()->url}}@endif">
                                @if(old('subimg'))
                                    @foreach(old('subimg') as $img)
                                        <input type="hidden" name="subimg[]" value="{{ $img }}"
                                               id="{{ explode(".",$img)[0]}}">
                                    @endforeach
                                @elseif($product)
                                    @foreach($product->getSubImages() as $subImage)
                                        <input type="hidden" name="subimg[]" value="{{ $subImage->url }}"
                                               id="{{ explode(".",basename($subImage->url))[0]}}">
                                    @endforeach
                                @endif
                                @if(old('size'))
                                    @foreach(old('size') as $val)
                                        <input type="hidden" name="size[]" class="setinfo-size-input"
                                               value="{{ $val }}">
                                    @endforeach
                                @elseif($product)
                                    @foreach($product->getSizes()->get() as $size)
                                        <input type="hidden" name="size[]" class="setinfo-size-input"
                                                          value="{{ $size->size.",". $size->shoulder.",". $size->bust.",". $size->hip.",". $size->sleeve.",". $size->waist}}">
                                    @endforeach
                                @endif
                                <div class="row {{ $errors->first('mainimg', 'has-error') }}">
                                    <div class="col-md-offset-3 col-md-8">
                                        <span class="help-block">{{ $errors->first('mainimg', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="row {{ $errors->first('subimg', 'has-error') }}">
                                    <div class="col-md-offset-3 col-md-8">
                                        <span class="help-block">{{ $errors->first('subimg', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="row {{ $errors->first('size', 'has-error') }}">
                                    <div class="col-md-offset-3 col-md-8">
                                        <span class="help-block">{{ $errors->first('size', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="row  {{ $errors->first('crowding', 'has-error') }}">
                                    <label class="col-md-3 control-label" style="text-align:right">Crowding: <span
                                                class='require'>*</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="livicon" data-name="cloud" data-size="16" data-loop="true"
                                                   data-c="#418bca"
                                                   data-hc="#418bca"></i>
                                            </span>
                                            <input type="number" placeholder=" " name="crowding"
                                                   value="@if(old('crowding')){{old('crowding')}}@elseif($product){{$product->crowding}}@endif"
                                                   class="form-control">
                                        </div>
                                        <span class="help-block">{{ $errors->first('crowding', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="row {{ $errors->first('date', 'has-error') }}">
                                    <label class="col-md-3 control-label " style="text-align:right">
                                        Date: <span class='require'>*</span>
                                    </label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                           <span class="input-group-addon">
                                                <i class="livicon" data-name="calendar" data-size="16" data-loop="true"
                                                   data-c="#418bca"
                                                   data-hc="#418bca"></i>
                                            </span>
                                            <input class="form-control" data-date-format="YYYY-MM-DD" name="date"
                                                   id="setinfo-datepicker"
                                                   value="@if(old('date')){{old('date')}}@elseif($product){{$product->date}}@endif"
                                                   type="text">
                                        </div>
                                        <span class="help-block">{{ $errors->first('date', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="row {{ $errors->first('category_id', 'has-error') }}">
                                    <label class="col-md-3 control-label" style="text-align:right">
                                        Category: <span class='require'>*</span>
                                    </label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                   <i class="livicon" data-name="list" data-size="16" data-loop="true"
                                                      data-c="#418bca"
                                                      data-hc="#418bca"></i>
                                            </span>
                                            <select class="form-control select2" id="setinfo-category"
                                                    name="category_id">
                                                @foreach($categoryList as $category)
                                                    <option value="{{ $category['id'] }}"
                                                            @if(old('category_id') && old('category_id')== $category['id'])selected
                                                            @elseif($product && $product->category_id == $category["id"]) selected
                                                            @endif
                                                    >{{ $category['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                    <div class="row {{ $errors->first('price', 'has-error') }}">
                                    <label class="col-md-3 control-label" style="text-align:right">
                                        Price(Coin): <span class='require'>*</span>
                                    </label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="livicon" data-name="money" data-size="16" data-loop="true"
                                                   data-c="#418bca"
                                                   data-hc="#418bca"></i>
                                            </span>
                                            <input type="number" placeholder=" " name="price"
                                                   value="@if(old('price')){{old('price')}}@elseif($product){{$product->price}}@endif"
                                                   class="form-control">
                                        </div>
                                        <span class="help-block">{{ $errors->first('price', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="row {{ $errors->first('title', 'has-error') }}">
                                    <label class="col-md-3 control-label" style="text-align:right">
                                        Title: <span class='require'>*</span>
                                    </label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="livicon" data-name="plus-alt" data-size="16" data-loop="true"
                                                   data-c="#418bca"
                                                   data-hc="#418bca"></i>
                                            </span>
                                            <input type="text" placeholder=" " name="title" class="form-control"
                                                   value="@if(old('title')){{old('title')}}@elseif($product){{$product->title}}@endif">
                                        </div>
                                        <span class="help-block">{{ $errors->first('title', ':message') }}</span>
                                    </div>
                                </div>
                                <div class="row {{ $errors->first('description', 'has-error') }}">
                                    <label class="col-md-3 control-label" style="text-align:right"> Description:
                                        <span class='require'>*</span>
                                    </label>
                                    <div class="col-md-8">
                                            <textarea name="description" class="form-control resize_vertical"
                                                      rows="4">@if(old('description')){{old('description')}}@elseif($product){{$product->description}}@endif</textarea>
                                        <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                                    </div>
                                </div>
                            </form>
                            @if(!$product)
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-md-offset-3 col-md-8">
                                        <button class="btn btn-danger btn-block" type="button" id="setinfo-size-btn">
                                            Size Setting
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6" style="padding-bottom:10px;">
                            <div class="text-center">
                                <h4 class="border-success">
                                    <span class="heading_border bg-success">Sub Image View</span>
                                </h4>
                            </div>
                            <form id="setinfo-sub-img-form">
                                <input style="display:none;" type="file" name="img[]" id="setinfo-sub-img-input"
                                       multiple>
                            </form>
                            <div class="row" style="margin-top: 10px;" id="setinfo-sub-img-container">
                                @if(old('subimg'))
                                    @foreach(old('subimg') as $img)
                                        <div class="col-xs-6 col-sm-4"
                                             data-id="{{ explode(".",basename($img))[0]}}">
                                            <div class="setinfo-sub-img">
                                                <div class="thumb_zoom">
                                                    <a class="fancybox" id="setinfo-sub-img-fancy"
                                                       href="{{ asset('').'/'.$img}}"><i
                                                                class="fa  fa-search-plus"></i></a>
                                                    <a href="javascript::" id="setinfo-sub-img-delete"
                                                       onclick="removeSubImg(this)"><i class="fa fa-trash-o"></i>
                                                    </a>
                                                    <img class="img-responsive" id="setinfo-sub-img"
                                                         src="{{ asset('').'/'.$img}}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @elseif($product)
                                    @foreach($product->getSubImages() as $subImage)
                                        <div class="col-xs-6 col-sm-4"
                                             data-id="{{ explode(".",basename($subImage->url))[0]}}">
                                            <div class="setinfo-sub-img">
                                                <div class="thumb_zoom">
                                                    <a class="fancybox" id="setinfo-sub-img-fancy"
                                                       href="{{ asset('/').$subImage->url}}"><i
                                                                class="fa  fa-search-plus"></i></a>
                                                    <a href="javascript::" id="setinfo-sub-img-delete"
                                                       onclick="removeSubImg(this)"><i class="fa fa-trash-o"></i>
                                                    </a>
                                                    <img class="img-responsive" id="setinfo-sub-img"
                                                         src="{{asset('/').$subImage->url}}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="col-xs-6 col-sm-4">
                                    <div class="setinfo-sub-img">
                                        <div class="thumb_zoom">
                                            <a href="javascript::" id="setinfo-sub-img-add"
                                               data-uploadurl="{{ route('halfdesign.upload.subimg') }}">
                                                <img class="img-responsive" id="setinfo-sub-img"
                                                     src="{{ asset('assets/img/general/plus.png') }}"
                                                     data-rootpath="{{ asset('/') }}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-offset-2 col-md-8">
                                    <button class="btn btn-primary btn-block" type="button"
                                            id="setinfo-save-btn">
                                        Save Setting
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="setinfo-size-modal" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                    <tbody id="setinfo-size-container"
                                                           class="no-border-x no-border-y ui-sortable">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="setinfo-add-size">Add Size
                                    </button>
                                    <button type="button" class="btn btn-primary" id="setinfo-save-size">Save</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                    </button>
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
    <!-- begining of page level js -->
    <!--tags-->
    <script type="text/javascript" src="{{ asset('assets/vendors/moment/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/select2/js/select2.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/fancybox/jquery.fancybox.pack.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-buttons.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-media.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-loader/jquery-loader.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/js/halfdesign/setinfo.js').'?v='.(new DateTime())->getTimestamp() }}"></script>
    <script>
        jQuery(document).ready(function () {
            new WOW().init();
        });
    </script>
    <!-- end of page level js -->

@stop
