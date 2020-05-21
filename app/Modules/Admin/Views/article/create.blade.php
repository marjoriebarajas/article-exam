@extends('Admin::layouts')

@section('page-body')
	<section class="content-header">
      <h1>
        Add Article
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('articles.index') }}"><i class="fa fa-newspaper-o"></i> Article</a></li>
        <li class="active">Add</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <span class="text-danger">All fields with <i>(<i class="fa fa-asterisk form-required"></i>)</i> are required</span>.
                    </div>
                    <div class="box-body">
                        {!! Form::open(['route' => 'articles.store', 'method' => 'POST', 'class'=>'form-horizontal','role'=>'form','id'=>'article-form', 'autocomplete' => 'off','files' => true]) !!}
                            <div class="box-body">
                                <div class="col-md-12">
                                    @include('Admin::article.includes.form')
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="row">
                                      <div class="col-md-4 col-md-offset-4 text-center">
                                           <button class="btn btn-primary btn-flat btn-lg btn-block save-btn" data-loading-text="<i class='fa fa-refresh fa-spin'> </i> Saving..."><i class="fa fa-save"></i>&nbsp;&nbsp;Save&nbsp;&nbsp;</button>
                                      </div>
                                 </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
<!-- Modals -->
@endsection
@section('page-js')
	@include('Admin::article.includes.js')
@endsection