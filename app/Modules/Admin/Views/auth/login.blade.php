@extends('Admin::login-layouts')

@section('page-body')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('admin.get-login') }}"><b>Article</b> Management</a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        @include('Admin::message')
        <form method="POST" action="{{ route('admin.post-login') }}" id="login-form">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="help-block">
                        {{ $errors->first('password') }}
                    </span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" id="login-btn" data-loading-text="<i class='fa fa-refresh fa-spin'> </i> Please Wait...">Sign In</button>
                </div>
            </div>
        </form>
        <br>
        <p>
            <a href="{{ route('admin.get-register') }}" class="text-center">Sign Up</a>
        </p>
    </div>
</div>
@endsection
@section('page-css')

@endsection
@section('page-js')
@include('Admin::message-alert')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! $validator !!}
<script type="text/javascript">
    $('#login-btn').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        btn.button('loading');
        var form = $('#login-form');

        if(form.valid()){
            form.submit();
        }else{
            setTimeout(function(){
                btn.button('reset');
            }, 500);

           return false;
        }
    });
</script>
@endsection