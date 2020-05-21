<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Modules\Admin\Requests\Role\RoleRequest', '#role-form'); !!}
<script type="text/javascript">
$(function(){
	$('#roles-modal').on('show.bs.modal', function(e){
		var button = $(e.relatedTarget);
		var action = button.data('action');
		var method = button.data('method');
		var form = $('#role-form');

		var modal = $(this);
		form.attr('action', action);
		form.attr('method', method);
		form.find('[name="_method"]').val(method);

		if(method == 'PUT'){
			var details = button.data('details');
			if(details){
				showLoader();
				$.ajax({
	                url: details,
	                type: 'GET',
	            }).done(function(response){
					$('#role_name').val(response.name);
					$('#description').val(response.description);
					hideLoader();
	            }).fail(function() {
	                swal('Error', 'Ops!, Something went wrong. Please reload this page and try again.', 'error');
	            });
			}
			modal.find('.modal-title').html('<i class="fas fa-pen"></i> Update Role');
			modal.find('.form-group').removeClass('has-success has-error');
			modal.find('[id*="-error"]').remove();
		}
		if(method == 'POST'){
			hideLoader();
			modal.find('.modal-title').html('<i class="fa fa-plus-circle"></i> Add Role');
			modal.find('.form-group').removeClass('has-success has-error');
			modal.find('[id*="-error"]').remove();
		}
	});

	$('#roles-modal').on('hidden.bs.modal', function(e){
		var modal = $(this);

		modal.find('#role_name').val('');
		modal.find('#description').val('');
		modal.find('.form-group').removeClass('has-error has-success');
		modal.find('[id*="-error"]').remove();
		$('#role-save-btn').button('reset');
	});

	$('#role-save-btn').on('click', function(e) {
		e.preventDefault();
        var btn = $(this);
        btn.button('loading');
        var form = $('#role-form');
        var action = form.attr('action');
		var method = form.attr('method');

        if(form.valid()){
            $.ajax({
				type: method,
				dataType: 'json',
				data: form.serialize(),
				url: action,
				success: function(data){
					if(data.type == 'success'){
						swal({ 
							title: "Success",
				            text: data.message,
				            type: "success",
					        confirmButtonColor: '#3085d6',
				            allowOutsideClick: false
						});
					    roleTable.draw();
					}
					$('#roles-modal').modal('hide');
					btn.button('reset');
				},
                error :function( jqXhr ) {
                    swal(
                      'Error!',
                      'Something went wrong.',
                      'error'
                    );      
                    btn.button('reset');
                }
			});
        }else{
            setTimeout(function(){
                btn.button('reset');
            }, 500);

           return false;
        }
    });
});
function showLoader()
{
    $('.loader').show();
    $('.form-content').hide();
    $('#role-save-btn').attr('disabled', true);
}

function hideLoader()
{
    $('.loader').hide();
    $('.form-content').show();
    $('#role-save-btn').removeAttr('disabled');
}
</script>