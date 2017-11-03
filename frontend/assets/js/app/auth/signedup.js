function appAuthSignedup() {

    /**
     * Resend email button click action
     */
    $('.btn-resend-email').on('click', function(){
        var $thisElement = $(this);
        $thisElement.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/auth/resend-email-confirmation',
            data: {
                confirmationId: $thisElement.data('id')
            },
            success: function() {
                $('.alert.alert-success').removeClass('hide');
                $thisElement.prop('disabled', false);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
				$('.alert.alert-warning').removeClass('hide');
                $thisElement.prop('disabled', false);
			}
        });
    });
}