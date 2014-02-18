function appAuthSignedup() {

    /**
     * Resend email button click action
     */
    $('.btn-resend-email').on('click', function(){
        var $thisElement = $(this);
        $thisElement.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/auth/resendEmailConfirmation',
            data: {
                confirmationId: $thisElement.data('id')
            },
            success: function() {
                $('.alert').removeClass('hide');
                $thisElement.prop('disabled', false);
            }
        });
    });
}