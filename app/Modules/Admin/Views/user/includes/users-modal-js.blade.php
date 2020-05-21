<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Modules\Admin\Requests\User\UserRequest', '#user-form'); !!}
<script type="text/javascript">
$(function(){
	$('#users-modal').on('show.bs.modal', function(e){
		var button = $(e.relatedTarget);
		var action = button.data('action');
		var method = button.data('method');
		var form = $('#user-form');

		var modal = $(this);
		form.attr('action', action);
		form.attr('method', method);
		form.find('[name="_method"]').val(method);

		if(method == 'PUT'){
			modal.find('#passsword_input').hide();
			var details = button.data('details');
			if(details){
				showLoader();
				$.ajax({
	                url: details,
	                type: 'GET',
	            }).done(function(response){
					$('#user_name').val(response.name);
					$('#email').val(response.email);

					var role = new Option(response.role.name, response.role.id, true, true);
                    modal.find('#role_id').append(role);
					hideLoader();
	            }).fail(function() {
	                swal('Error', 'Ops!, Something went wrong. Please reload this page and try again.', 'error');
	            });
			}
			modal.find('.modal-title').html('<i class="fas fa-pen"></i> Update User');
			modal.find('.form-group').removeClass('has-success has-error');
			modal.find('[id*="-error"]').remove();
		}
		if(method == 'POST'){
			hideLoader();
			modal.find('.modal-title').html('<i class="fa fa-plus-circle"></i> Add User');
			modal.find('.form-group').removeClass('has-success has-error');
			modal.find('[id*="-error"]').remove();
			modal.find('#passsword_input').show();
		}
	});

	$('#users-modal').on('hidden.bs.modal', function(e){
		var modal = $(this);

		modal.find('#user_name').val('');
		modal.find('#email').val('');
		modal.find('#password').val('');
		modal.find('#role_id').val(null).trigger('change');
		modal.find('.form-group').removeClass('has-success has-error');
		modal.find('[id*="-error"]').remove();
		$('#user-save-btn').button('reset');
		modal.find('#passsword_input').show();
	});

	$('#user-form').find("#role_id").select2({
        placeholder:' - Select - ',
        triggerChange: true,
        allowClear: true,
        dropdownParent: $('#users-modal'),
        ajax: {
            url: '{!! route('roles.select2') !!}',
            delay: 400,
            data: function (params) {
              return {
                name: params.term
              };
            },
            processResults: function (data, page) {
              return {
                results: data
              };
            }
        }
	}).on('change.select2', function (e){
		$(this).valid();
	});

	$('#user-save-btn').on('click', function(e) {
		e.preventDefault();
        var btn = $(this);
        btn.button('loading');
        var form = $('#user-form');
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
					    userTable.draw();
					}
					$('#users-modal').modal('hide');
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
    $('#user-save-btn').attr('disabled', true);
}

function hideLoader()
{
    $('.loader').hide();
    $('.form-content').show();
    $('#user-save-btn').removeAttr('disabled');
}
</script>