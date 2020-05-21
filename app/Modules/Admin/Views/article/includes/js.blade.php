<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>
{!! JsValidator::formRequest('App\Modules\Admin\Requests\Article\ArticleRequest', '#article-form'); !!}
<script type="text/javascript" src="{{ get_template('plugins/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
$(function(){
    CKEDITOR.replace('content', {
        height: '250px',
    });

    $(".input-datepicker").inputmask('mm/dd/yyyy', {"placeholder": 'mm/dd/yyyy'});
    $(".input-datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        minDate: new Date(),
        autoclose: true
    });

	$('#clear_expiring_at').on('click', function(event) {
        event.preventDefault();
        $('[name="expired_date"]').val('');
    });

    $('#remove_image').on('click', function(event) {
        event.preventDefault();
        $('[name="old_image"]').val('none');
        $('[name="thumbnail"]').val('');
        $('#image-preview').hide();
    });

     function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#image-preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#thumbnail").change(function(){
        readURL(this);
        var value = this.value;
        var extension = value.substr(value.lastIndexOf(".") + 1);

        if(extension == 'jpg' || extension == 'jpeg' || extension == 'png'){
            $('[name="old_image"]').val('');
        	$('#image-preview').show();
        }else{
            $('[name="old_image"]').val('none');
        	$('#image-preview').hide();
        }
    });

    $('button.save-btn').on('click', function() {
        var btn = $(this);
        btn.button('loading');
        var contentLength = CKEDITOR.instances['content'].getData().replace(/<[^>]*>/gi, '').length;

        if($('form#article-form').valid()){
            if(!contentLength) {
                swal('Please enter Content.', '', 'error').catch(swal.noop);
                setTimeout(function(){
                btn.button('reset');
                }, 200);
                return false;
            }
            return true;
        }else{
            setTimeout(function(){
                btn.button('reset');
            }, 500);

           return false;
        }
    });
});
</script>