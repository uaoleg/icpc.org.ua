function appStaffCoordinatorsIndex() {

    // Set coordinator state
    $(document).on('click', '.btn.coordinator-state', function() {
        var $this = $(this);
        $this.siblings('.btn.coordinator-state').removeClass('hide');
        $this.addClass('hide');
        $.ajax({
            url: app.baseUrl + '/staff/coordinators/setState',
            data: {
                userId: $this.data('uid'),
                state: $this.data('state')
            }
        });
    });

}