function appAuthLogin() {

    /**
     * Resend email button click action
     */
    $('.js-auth-login-resend-confirmation-email').on('click', function(){
        var $thisElement = $(this);
        $thisElement.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/auth/resendEmailConfirmation',
            data: {
                confirmationId: $thisElement.data('id')
            },
            success: function() {
                $('.js-auth-login-resend-success').removeClass('hide');
                $thisElement.prop('disabled', false);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
				$('.js-auth-login-resend-failed').removeClass('hide');
                $thisElement.prop('disabled', false);
			},
            complete: function() {
                $('.js-auth-login-error').hide();
            }
        });
    });
}
