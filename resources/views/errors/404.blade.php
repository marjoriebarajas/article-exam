@extends('Admin::layouts')

@section('page-body')
<div class="content">
    <div class="container-fluid">
        <div class="row">
		    <div class="col-md-12 text-center" style="margin-top: 130px;">
		        <h2>We’re very sorry!
            	<br>but the page you are trying to access doesn’t exist.</h2>
		        <a href="{{ route('dashboard.index') }}" title="" class="button btn-lg">Go Home!</a>
		    </div>
		</div>
	</div>
</div>
@endsection