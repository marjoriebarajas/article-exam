@extends('Admin::layouts')

@section('page-body')
	<!-- Content Header (Page header) -->
	<section class="content-header">
      <h1>
        Roles
        <small>List of Roles</small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-users"></i> User Management</li>
        <li class="active"><a href="{{ route('roles.index') }}">Roles</a></li>
      </ol>
    </section>

    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
                    <div class="box-header">
              			@can('create', $permission)
						<div class="pull-right">
							<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#roles-modal" data-method="POST" data-action="{{ route('roles.store') }}" data-backdrop="static">
								<i class="fa fa-plus"></i>   Add Role
							</button>
						</div>
						@endcan
                    </div>
                    <div class="box-body">
                    	<div class="table-responsive">
	                    	<table id="roles-table" class="table table-sm table-bordered table-hover" width="100%">
				                <thead>
							         <tr>
							             <th>#</th>
							             <th>Display Name</th>
							             <th>Description</th>
							             <th>Created At</th>
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
@include('Admin::role.includes.roles-modal')
@endsection
@section('page-js')
<script type="text/javascript">
$(function(){
	roleTable = $('#roles-table').DataTable({
		processing: true,
	    serverSide: true,
	    responsive: true,
	    ajax: {
	        url:'{!! route('roles.datatables-index') !!}',
	        method: 'POST',
	    },
	    columns: [
	    	{data: 'DT_Row_Index', orderable: false, searchable: false,width:'10px', className : 'text-center'},
	    	{ data: 'name', name: 'name', orderable: true, searchable: true},
	    	{ data: 'description', name: 'description', orderable: false, searchable: false},
	    	{ data: 'created_at', name: 'created_at', orderable: true, searchable: false},
	    	{ data: 'action', name: 'action', orderable: false, searchable: false,width:'80px', class:'text-center'},
	    ],
	    fnDrawCallback: function ( oSettings ) {
	    	$('a#btn-role-delete').click(function(){
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
	    "order": [[1,'asc']],
	});
});
</script>
@include('Admin::role.includes.roles-modal-js')
@endsection