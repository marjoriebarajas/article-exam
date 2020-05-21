@extends('Admin::login-layouts')

@section('page-body')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('admin.get-register') }}"><b>Article</b> Management</a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Register a new account</p>

        <form method="POST" action="{{ route('admin.post-register') }}" id="register-form">
            {{ csrf_field() }}
            <h4><i class="fa fa-lock"></i> Login Details</h4>
            <div class="form-group has-feedback">
                <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ old('name') }}">
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                <span class="fa fa-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password" value="{{ old('password') }}">
                <span class="fa fa-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="confirm_password" class="form-control" placeholder="Re-type Password" value="{{ old('confirm_password') }}">
                <span class="fa fa-lock form-control-feedback"></span>
            </div>
            <br>
            <h4><i class="fa fa-building"></i> Company Details</h4>
            <div class="form-group has-feedback">
                <input type="text" name="company_name" class="form-control" placeholder="Company Name" value="{{ old('company_name') }}">
                <span class="fa fa-building form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="contact_number" class="form-control" placeholder="Contact Number" value="{{ old('contact_number') }}">
                <span class="fa fa-phone form-control-feedback"></span>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-block" id="register-btn" data-loading-text="<i class='fa fa-refresh fa-spin'> </i> Please Wait...">Register</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <br>
        <p class="mb-1">
            <a href="{{ route('admin.get-login') }}">I already have an account.</a>
        </p>
    </div>
</div>
@endsection
@section('page-css')
<style type="text/css">
    .login-box{
        width: 500px;
    }
    @media (max-width: 768px){
        .login-box{
            width: 90%;
        }
    }

</style>
@endsection
@section('page-js')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Modules\Admin\Requests\Auth\RegisterRequest', '#register-form'); !!}
<script type="text/javascript">
    $('#register-btn').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        btn.button('loading');
        var form = $('#register-form');

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