function appStaffCoachesIndex() {

    // Set coach state
    $(document).on('click', '.btn.coach-state', function() {
        var $this = $(this);
        $this.siblings('.btn.coach-state').removeClass('hide');
        $this.addClass('hide');
        $.ajax({
            url: app.baseUrl + '/staff/coaches/set-state',
            data: {
                userId: $this.data('uid'),
                state: $this.data('state')
            }
        });
    });

}