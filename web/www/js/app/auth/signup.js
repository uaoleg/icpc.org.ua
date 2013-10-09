function appAuthSignup() {

    // Type and Coordinator checkboxes
    $(':checkbox[name=type], :checkbox[name=coordinator]').on('change', function() {
        var $group = $(this).closest('.btn-group');
        if ($(this).is(':checked')) {
            if ($(this).val() === 'student') {
                $('.btn:nth-child(2), .btn:nth-child(3)', $group).removeClass('active');
                $('.btn:nth-child(2) :checkbox, .btn:nth-child(3) :checkbox', $group).prop('checked', false).change();
            } else if (($(this).val() === 'coach') || ($(this).prop('name') === 'coordinator')) {
                $('.btn:nth-child(1)', $group).removeClass('active');
            }
        }
    });

    // Coordinator dropdown
    $(':checkbox[name=coordinator]').on('change', function() {
        var $this = $(this),
            $group = $this.closest('.btn-group'),
            $dropdown = $group.next('.btn-group').find('.dropdown-menu:first');

        // Toggle dropdown menu
        if ($this.is(':checked')) {
            $dropdown.show();
        } else {
            $dropdown.hide();
        }

        // Select value
        $('li a', $dropdown).on('click', function() {
            $this.val($(this).data('val'));
            $dropdown.hide();
            return false;
        });
    });


    // Signup request
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
                type:           $('.form-group .btn.active [name=type]').val(),
                coordinator:    $('.form-group .btn.active [name=coordinator]').val(),
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