<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Welcome to DesignU</title>
    <!--global css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <!--end of global css-->
    <!--page level css starts-->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendors/iCheck/css/all.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/register.css') }}">
    <!--end of page level css-->
</head>
<body>
<div class="container">
    <!--Content Section Start -->
    <div class="row">
        <div class="box animation flipInX">
            <img src="{{ asset('assets/img/general/designu.png') }}" alt="logo" class="img-responsive mar">
            <!-- Notifications -->
            <div id="notific">
                @include('notifications')
            </div>
            <form action="{{ route('auth.register') }}" method="POST" id="reg_form">
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                <div class="form-group {{ $errors->first('name', 'has-error') }}">
                    <label class="sr-only">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                           value="{!! old('name') !!}">
                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->first('email', 'has-error') }}">
                    <label class="sr-only"> Email</label>
                    <input type="email" class="form-control" id="Email" name="email" placeholder="Email"
                           value="{!! old('Email') !!}">
                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->first('password', 'has-error') }}">
                    <label class="sr-only"> Password</label>
                    <input type="password" class="form-control" id="Password1" name="password" placeholder="Password">
                    {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->first('password_confirm', 'has-error') }}">
                    <label class="sr-only"> Confirm Password</label>
                    <input type="password" class="form-control" id="Password2" name="password_confirm"
                           placeholder="Confirm Password">
                    {!! $errors->first('password_confirm', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="clearfix"></div>
                <div class="form-group checkbox" style="text-align: left"  id="term_condition">
                    <label>
                        <input type="checkbox" name="term_condition"
                               value="true" {{ old('term_condition') == 'true' ? 'checked' : ''}}><span
                                style="margin-left: 10px;">  I accept <a href="#"> Terms and Condition</a></span>
                    </label>
                    <span class="help-block hide">You have to accept the Terms and Condition.</span>
                </div>
                <div class="form-group checkbox" style="text-align: left"  id="private_policy">
                    <label>
                        <input type="checkbox" name="private_policy"
                               value="true" {{ old('private_policy') == 'true' ? 'checked' : ''}}><span
                                style="margin-left: 10px;">  I accept <a href="#"> Private and Policy</a></span>
                    </label>
                    <span class="help-block hide">You have to accept the Private and Policy.</span>
                </div>
                <button type="submit" id="register" class="btn btn-block btn-primary" style="margin-top:15px;">Sign Up
                </button>
                <div class="form-group social-login-container" style="margin-top:15px;">
                    <a href="{{route('auth.social.redirect', ['provider' => 'qq'])}}" class="social-login-btn">
                        <img src="{{asset('/assets/img/auth/qq-login-img.png')}}">
                    </a>
                    <a href="{{route('auth.social.redirect', ['provider' => 'weixin'])}}" class="social-login-btn">
                        <img src="{{asset('/assets/img/auth/wechat-login-img.png')}}">
                    </a>
                    <a href="{{route('auth.social.redirect', ['provider' => 'facebook'])}}"
                       class="social-login-btn">
                        <img src="{{asset('/assets/img/auth/facebook-login-img.png')}}">
                    </a>
                </div>
                Already have an account? Please <a href="{{ route('auth.login') }}"> Log In</a>
            </form>
        </div>
    </div>
    <!-- //Content Section End -->
</div>
<!--global js starts-->
<script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/frontend/register_custom.js') }}"></script>
<!--global js end-->
</body>
</html>
