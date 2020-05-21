@extends('Admin::layouts')

@section('page-body')
	<section class="content-header">
      <h1>
        Articles
        <small>List of Articles</small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="{{ route('articles.index') }}">Articles</a></li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        @can('create', $permission)
                        <div class="pull-right">
                            <a href="{{ route('articles.create') }}" data-toggle="tooltip" data-placement="top" data-original-title="Add Article" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Add Article</a>
                        </div>
                        @endcan
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="articles-table" class="table table-sm table-bordered table-hover" width="100%">
                                <thead>
                                     <tr>
                                         <th>#</th>
                                         <th>Title</th>
                                         <th>Published Date</th>
                                         <th>Expiring Date</th>
                                         <th>Status</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Modals -->
@endsection
@section('page-js')
@include('Admin::message-alert')
<script type="text/javascript">
$(function(){
	roleTable = $('#articles-table').DataTable({
		processing: true,
	    serverSide: true,
	    responsive: true,
	    ajax: {
	        url:'{!! route('articles.datatables-index') !!}',
	        method: 'POST',
	    },
	    columns: [
	    	{data: 'DT_Row_Index', orderable: false, searchable: false,width:'10px', className : 'text-center'},
	    	{ data: 'title', name: 'title', orderable: false, searchable: true},
	    	{ data: 'published_date', name: 'published_date', orderable: true, searchable: false,width:'100px'},
	    	{ data: 'expired_date', name: 'expired_date', orderable: true, searchable: false,width:'100px'},
            { data: 'status_display', name: 'status', orderable: false, searchable: false,width:'80px', class:'text-center'},
	    	{ data: 'action', name: 'action', orderable: false, searchable: false,width:'80px', class:'text-center'},
	    ],
	    fnDrawCallback: function ( oSettings ) {
	    	$('a#btn-article-delete').click(function(){
	    		var action = $(this).data('action');

				swal({
				    title: 'Are you sure?',
				    text: "You will not be able to recover this!",
				    type: 'warning',
				    showCancelButton: true,
				    confirmButtonColor: '#3085d6',
				    cancelButtonColor: '#d33',
				    confirmButtonText: 'Yes, delete it!',
				    showLoaderOnConfirm: true,
				    preConfirm : function(){
				    	return new Promise(function(){
					        $.ajax({
					            type: "DELETE",
					            url: action,
					            dataType: 'json',
					            success: function(data) {
					                if(data.type == "success") {
					                    swal({
				                    		title: 	'Deleted!',
				                    	  	text: 	data.message,
				                    	 	type: 	'success'
					                    });
					                    roleTable.draw();
					               }else{
	               		                swal({
		       		                		title: 	'Oops!',
		       		                	  	text: 	data.message,
		       		                	 	type: 	'error'
	               		                });
					               }
					            },
					            error :function( jqXhr ) {
					                swal(
				                      'Error!',
				                      'Something went wrong.',
				                      'error'
				                    );        
					            }
					        });
				    	});
				    },
				    allowOutsideClick: false
				});
	    	});
	    },
	    "order": [[2,'desc']],
	});
});
</script>
@endsection