@extends('Admin::layouts')

@section('page-body')
	<section class="content-header">
      <h1>
        Update Profile
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-users"></i> User Management</li>
        <li class="active"><a href="{{ route('users.profile', auth('admin')->user()->hashid) }}">Profile</a></li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                    </div>
                    <div class="box-body">
                        {!! Form::model($user, array('route' => ['users.update-profile', $user->hashid] , 'class' => 'form-horizontal', 'method' => 'PUT', 'id' => 'profile-form')) !!}
                        {!! Form::hidden('_method', 'PUT') !!}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name" class="col-md-4 col-form-label"><i class="asterisk" style="color:red;">*</i> Name</label>
                                        <div class="col-md-8">
                                            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'user_name', 'autocomplete' => 'off'] ) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-md-4 col-form-label"><i class="asterisk" style="color:red;">*</i> Email</label>
                                        <div class="col-md-8">
                                            {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email', 'autocomplete' => 'off'] ) !!}
                                        </div>
                                    </div>
                                    <div class="form-group" id="passsword_input">
                                        <label for="name" class="col-md-4 col-form-label"><i class="asterisk" style="color:red;">*</i> Password</label>
                                        <div class="col-md-8">
                                            {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group" id="passsword_input">
                                        <label for="name" class="col-md-4 col-form-label"><i class="asterisk" style="color:red;">*</i> Confirm Password</label>
                                        <div class="col-md-8">
                                            {!! Form::password('confirm_password', ['class' => 'form-control', 'id' => 'confirm_password']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                  <div class="col-md-4 col-md-offset-4 text-center">
                                       <button class="btn btn-primary btn-flat btn-lg btn-block" id="user-save-btn" data-loading-text="<i class='fa fa-refresh fa-spin'> </i> Updating..."><i class="fa fa-save"></i>&nbsp;&nbsp;Update&nbsp;&nbsp;</button>
                                  </div>
                             </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-js')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Modules\Admin\Requests\User\ProfileRequest', '#profile-form'); !!}
@endsection