function appStaffStudentsIndex() {

    // Set student state
    $(document).on('click', '.btn.student-state', function() {
        var $this = $(this);
        $this.siblings('.btn.student-state').removeClass('hide');
        $this.addClass('hide');
        $.ajax({
            url: app.baseUrl + '/staff/students/set-state',
            data: {
                userId: $this.data('uid'),
                state: $this.data('state')
            }
        });
    });

}