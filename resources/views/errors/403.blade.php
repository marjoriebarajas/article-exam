@extends('Admin::layouts')

@section('page-body')
	<div class="content">
        <div class="container-fluid">
            <div class="row">
			    <div class="col-md-12 text-center" style="margin-top: 130px;">
			        <h1>We’re very sorry!</h1>
			        <h2>You are not authorize to access this page.</h2>
			        <a href="{{ route('dashboard.index') }}" title="" class="button btn-lg">Go Home!</a>
			    </div>
			</div>
		</div>
	</div>
@endsection