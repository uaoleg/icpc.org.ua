function appAuthPasswordResetToken() {

    // Reset password request
    $('.btn.reset-password').on('click', function() {
        var $thisElement = $(this),
            $form = $thisElement.closest('.form-horizontal');
        $thisElement.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/auth/passwordResetSetNew',
            data: {
                token:          $('[name=token]', $form).val(),
                email:          $('[name=email]', $form).val(),
                password:       $('[name=password]', $form).val(),
                passwordRepeat: $('[name=passwordRepeat]', $form).val()
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