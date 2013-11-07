function appAuthSignup() {

    /**
     * On window unload
     */
    window.onbeforeunload = function() {
        if ($('.btn.signup', self.$form).is(':disabled')) {
            return;
        } else if ($('input[type=text]:visible, input[type=password]:visible').filter(function() {
            return ($(this).val().length !== 0);
        }).length > 0) {
            return _t('appjs', 'You have unsaved changes.');
        }
    };

    /**
     * Type and Coordinator checkboxes
     */
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

    /**
     * Coordinator dropdown
     */
    $(':checkbox[name=coordinator]').on('change', function() {

        var $this = $(this),
            $btn = $this.closest('.btn'),
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
            $('.caption', $btn).html($(this).html());
            $dropdown.hide();
            return false;
        });

        // Bind hide on document click
        if (!$this.data('hide-on-document-click')) {
            $this.data('hide-on-document-click', true);
            $(document).on('click', function(e) {
                var $target = $(e.target)
                if (!$target.hasClass('btn')) {
                    $target = $target.closest('.btn')
                }
                $target = $target.filter(function() {
                    return ($(':checkbox[name=coordinator]', this).length > 0);
                });
                if (!$target.length) {
                    $dropdown.hide();
                    if (!$this.val()) {
                        $btn.removeClass('active');
                        $(':checkbox', $btn).prop('checked', false).change();
                    }
                }
            });
        }

    });

    /**
     * Init Select2
     */
    $('.form-group .form-control[name=schoolId]').select2({
        'width': 'resolve'
    });

    /**
     * Signup request
     */
    $('.btn.signup').on('click', function() {
        var $thisElement = $(this),
            $form = $thisElement.closest('.form-horizontal');
        $thisElement.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/auth/signup',
            data: {
                firstNameUk:    $('.form-group .form-control[name=firstNameUk]').val(),
                middleNameUk:   $('.form-group .form-control[name=middleNameUk]').val(),
                lastNameUk:     $('.form-group .form-control[name=lastNameUk]').val(),
                email:          $('.form-group .form-control[name=email]').val(),
                password:       $('.form-group .form-control[name=password]').val(),
                passwordRepeat: $('.form-group .form-control[name=passwordRepeat]').val(),
                schoolId:       $('.form-group .form-control[name=schoolId]').val(),
                type:           $('.form-group .btn.active [name=type]').val(),
                coordinator:    $('.form-group .btn.active [name=coordinator]').val(),
                rulesAgree:     $('.form-group [name=rulesAgree]').is(':checked') ? 1 : 0,
                recaptcha_challenge_field: $('#recaptcha_challenge_field').val(),
                recaptcha_response_field:  $('#recaptcha_response_field').val()
            },
            success: function(resposne) {
                appShowErrors(resposne.errors, $form);
                if (resposne.errors) {
                    $thisElement.prop('disabled', false);
                } else {
                    location.href = app.baseUrl + '/user/me';
                }
            }
        });
    });

}