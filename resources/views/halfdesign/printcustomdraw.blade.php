<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>CustomDraw Printing | Design U</title>

    <!--iOS -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{!! csrf_token() !!}"/>
    <meta name="root-path" content="{{ asset('/') }}"/>

    <link href="{{ asset('assets/vendors/toastr/css/toastr.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/halfdesign/printcustomdraw.css') }}">
    <script type="text/javascript" src="{{ asset('assets/vendors/modernizr/modernizr-2.6.2.min.js') }}"></script>
    <style type="text/css">
        @font-face {
            font-family: YanolJaBold;
            src: url('{{asset('assets/fonts/yanolja_bold.ttf')}}');
        }

        @font-face {
            font-family: YanolJaRegular;
            src: url('{{asset('assets/fonts/yanolja_regular.ttf')}}');
        }

        .back-link a {
            color: #4ca340;
            text-decoration: none;
            border-bottom: 1px #4ca340 solid;
        }

        .back-link a:hover,
        .back-link a:focus {
            color: #408536;
            text-decoration: none;
            border-bottom: 1px #408536 solid;
        }

        h1 {
            height: 100%;
            /* The html and body elements cannot have any padding or margin. */
            margin: 0;
            font-size: 14px;
            font-family: 'Open Sans', sans-serif;
            font-size: 32px;
            margin-bottom: 3px;
        }

        .entry-header {
            text-align: left;
            margin: 0 auto 50px auto;
            width: 80%;
            max-width: 978px;
            position: relative;
            z-index: 10001;
        }

        #demo-content {
            padding-top: 100px;
        }
    </style>
</head>
<body class="demo">

<!-- Demo content -->
<div id="demo-content">

    <header class="entry-header">

        <h1 class="entry-title">DesignU: Please Wait for automating your drawings, it will take few minutes.....</h1>
    </header>

    <div id="loader-wrapper">
        <div id="loader"></div>

        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>

    </div>

    <div id="printpapaer-container"
         data-productinfourl="{{route('halfdesign.product.info.printpaper')}}"  data-printurl="{{route('halfdesign.printpaper.printimage')}}"
         data-redirecturl="{{route('halfdesign.productlist')}}">
        <div class="printpapaer-preview-container" style="display: none;">
            <canvas id="setprintpaper-print-canvas" width="1000px" height="500px"></canvas>
        </div>
        <input type="hidden" id="customDrawID" value="{{ $customDraw->id }}"/>
    </div>

</div>
<!-- /Demo content -->
<script type="text/javascript" src="{{ asset('assets/js/lib.js') }}"></script>
<script src="{{ asset('assets/vendors/toastr/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/vendors/fabric/fabric.min.js') }}"></script>
<script src="{{ asset('assets/vendors/underscore/js/underscore-min.js') }}"></script>
<script type="text/javascript"
        src="{{ asset('assets/js/halfdesign/printcustomdraw.js') .'?v='.(new DateTime())->getTimestamp()}}"></script>
</body>
</html>
