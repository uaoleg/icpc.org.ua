function appStaffStudentsIndex() {

    // Set coach state
    $('.btn.student-state').on('click', function() {
        var $this = $(this),
            $td = $this.closest('td');
        $('.btn.student-state', $td).removeClass('hide');
        $this.addClass('hide');
        $.ajax({
            url: app.baseUrl + '/staff/students/setState',
            data: {
                userId: $(this).closest('tr').data('id'),
                state: $this.data('state')
            }
        });
    });

}