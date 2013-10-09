function appStaffIndexCoordinator() {

    // Set coordinator state
    $('.btn.coordinator-state').on('click', function() {
        var $this = $(this);
        $('.btn.coordinator-state').removeClass('hide');
        $this.addClass('hide');
        $.ajax({
            url: app.baseUrl + '/staff/index/coordinatorSetState',
            data: {
                userId: $(this).closest('tr').data('id'),
                state: $this.data('state')
            },
            success: function() {

            }
        });
    });

}