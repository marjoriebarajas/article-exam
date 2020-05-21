@extends('Admin::layouts')

@section('page-body')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        WELCOME!
                    </div>
                    <div class="box-body">
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-js')
@endsection