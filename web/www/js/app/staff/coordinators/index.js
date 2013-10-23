function appStaffCoordinatorsIndex() {

    // Set coordinator state
    $('.btn.coordinator-state').on('click', function() {
        var $this = $(this),
            $td = $this.closest('td');
        $('.btn.coordinator-state', $td).removeClass('hide');
        $this.addClass('hide');
        $.ajax({
            url: app.baseUrl + '/staff/coordinators/setState',
            data: {
                userId: $(this).closest('tr').data('id'),
                state: $this.data('state')
            }
        });
    });

}