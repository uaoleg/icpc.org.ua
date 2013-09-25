function appAuthSignup() {

    // Signup
    $('.btn.signup').on('click', function() {
        var $thisElement = $(this),
            $form = $thisElement.closest('.form-horizontal');
        $thisElement.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/auth/signup',
            data: {
                firstName:      $('.form-group .form-control[name=firstName]').val(),
                lastName:       $('.form-group .form-control[name=lastName]').val(),
                email:          $('.form-group .form-control[name=email]').val(),
                password:       $('.form-group .form-control[name=password]').val(),
                passwordRepeat: $('.form-group .form-control[name=passwordRepeat]').val(),
                role:           $('.form-group .btn.active [name=role]').val(),
                rulesAgree:     $('.form-group [name=rulesAgree]').is(':checked') ? 1 : 0,
                recaptcha_challenge_field: $('#recaptcha_challenge_field').val(),
                recaptcha_response_field:  $('#recaptcha_response_field').val()
            },
            success: function(resposne) {
                $('.form-group', $form).removeClass('has-error');
                $('.form-group .help-block', $form).remove();
                if (resposne.errors) {
                    $.each(resposne.errors, function(name, error) {
                        var $control = $('.form-group [name=' + name + ']', $form),
                            $group = $control.closest('.form-group'),
                            $helpBlock = $('<span>').addClass('help-block').html(error);
                        if (name !== 'recaptcha') {
                            $group.addClass('has-error').append($helpBlock);
                        } else {
                            Recaptcha.reload();
                        }
                    })
                    $('.form-group.has-error:first input', $form).focus();
                    $thisElement.prop('disabled', false);
                } else {
                    location.href = app.baseUrl + '/user/me';
                }
            }
        });
    });

}