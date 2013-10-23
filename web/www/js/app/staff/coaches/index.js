function appStaffCoachesIndex() {

    // Set coach state
    $('.btn.coach-state').on('click', function() {
        var $this = $(this),
            $td = $this.closest('td');
        $('.btn.coach-state', $td).removeClass('hide');
        $this.addClass('hide');
        $.ajax({
            url: app.baseUrl + '/staff/coaches/setState',
            data: {
                userId: $(this).closest('tr').data('id'),
                state: $this.data('state')
            }
        });
    });

}