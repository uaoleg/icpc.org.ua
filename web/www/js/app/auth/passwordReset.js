function appAuthPasswordReset() {

    // Reset password request
    $('.btn.reset-password').on('click', function() {
        var $thisElement = $(this),
            $form = $thisElement.closest('.form-horizontal');
        $thisElement.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/auth/passwordResetSendEmail',
            data: {
                email: $('.form-group .form-control[name=email]').val(),
                recaptcha_response_field:  $('#g-recaptcha-response').val(),
                recaptchaIgnore:           $('.form-group [name=recaptchaIgnore]').is(':checked') ? 1 : 0
            },
            success: function(resposne) {
                appShowErrors(resposne.errors, $form);
                if (resposne.errors) {
                    $thisElement.prop('disabled', false);
                } else {
                    location.href = app.baseUrl + '/auth/passwordResetSent';
                }
            }
        });
    });

}