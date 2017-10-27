function appAuthPasswordReset() {

    // Reset password request
    $('.btn.reset-password').on('click', function() {
        var $thisElement = $(this),
            $form = $thisElement.closest('.form-horizontal');
        $thisElement.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/auth/password-reset-send-email',
            data: {
                email: $('.form-group .form-control[name=email]').val(),
                recaptcha_challenge_field: $('#recaptcha_challenge_field').val(),
                recaptcha_response_field:  $('#recaptcha_response_field').val(),
                recaptchaIgnore:           $('.form-group [name=recaptchaIgnore]').is(':checked') ? 1 : 0
            },
            success: function(resposne) {
                appShowErrors(resposne.errors, $form);
                if (resposne.errors) {
                    $thisElement.prop('disabled', false);
                } else {
                    location.href = app.baseUrl + '/auth/password-reset-sent';
                }
            }
        });
    });

}