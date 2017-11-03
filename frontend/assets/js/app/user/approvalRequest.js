function appUserApprovalRequest()
{

    /**
     * Send coach approval request
     */
    $('.js-user-approval-request-button').off('click').on('click', function() {
        var $button = $(this),
            $label = $button.next('.js-user-approval-request-label');
        $button.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/user/approval-request',
            data: {
                role: $button.data('role')
            },
            success: function() {
                $button.addClass('hide');
                $label.removeClass('hide');
            }
        });
    });

}
