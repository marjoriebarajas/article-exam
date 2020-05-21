<script>
    jQuery(document).ready(function(){

        $("<?= $validator['selector']; ?>").each(function() {
            $(this).validate({
                errorElement: 'span',
                errorClass: 'help-block error-help-block error_message',

                // errorPlacement: function (error, element) {
                //     if (element.parent('.input-group').length ||
                //         element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                //         error.insertAfter(element.parent());
                //         // else just place the validation message immediately after the input
                //     } else {
                //         error.insertAfter(element);
                //     }
                // },
                errorPlacement: function(error, element) {
                    
                    if (element.parent('.input-group').length ||
                        element.prop('type') === 'checkbox' || element.prop('type') === 'radio' || element.hasClass('intlphone')) {

                        if(element.hasClass('radio-inline')) {
                            $(element).closest('.form-group').find('div.inline-message').html(error);
                        } else if(element.hasClass('entry_for')) {
                            $(element).closest('.form-group').find('div.inline-message').html(error);
                        } else {

                            error.insertAfter(element.parent());
                        }
                        // else just place the validation message immediatly after the input
                    } else if (element.hasClass('select2')) {
                        error.insertAfter(element.next('span'));
                    } else if (element.hasClass('select2-hide-search')) {
                        $(element).closest('.form-group').find('div.long-message').html(error);
                    } else if (element.hasClass('group')) {
                        $(element).closest('.form-group').find('div.group-message').html(error);
                    } else if (element.hasClass('textbox-short')) {
                        $(element).closest('.form-group').find('div.long-message').html(error);
                    } else if (element.prop('type') === 'hidden') {
                        $(element).closest('.form-group').find('div.combobox-message').html(error);
                    } else if (element.hasClass('min_age')) {
                        $(element).closest('.group').find('div.inline-message').html(error);
                    } else if( element.hasClass('text-label')){
                       $(element).closest('.form-group').find('div.inline-message').html(error);
                    } else {
                        
                        error.insertAfter(element);
                    }

                },
                highlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // add the Bootstrap error class to the control group
                },

                <?php if (isset($validator['ignore']) && is_string($validator['ignore'])): ?>

                ignore: "<?= $validator['ignore']; ?>",
                <?php endif; ?>

                /*
                 // Uncomment this to mark as validated non required fields
                 unhighlight: function(element) {
                 $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                 },
                 */
                success: function (element) {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // remove the Boostrap error class from the control group
                },

                focusInvalid: false, // do not focus the last invalid input
                <?php if (Config::get('jsvalidation.focus_on_error')): ?>
                invalidHandler: function (form, validator) {

                    if (!validator.numberOfInvalids())
                        return;

                    $('html, body').animate({
                        scrollTop: $(validator.errorList[0].element).offset().top
                    }, <?= Config::get('jsvalidation.duration_animate') ?>);
                    $(validator.errorList[0].element).focus();

                },
                <?php endif; ?>

                rules: <?= json_encode($validator['rules']); ?>
            });
        });
    });
</script>
