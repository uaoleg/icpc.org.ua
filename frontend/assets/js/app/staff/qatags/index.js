function appStaffQatagsIndex() {

    /**
     * Delete tag button
     */
    $('.btn-delete-tag').on('confirmed', function(){
        var $btn = $(this);
        $.ajax({
            url: app.baseUrl + '/staff/qatags/delete',
            data: {
                id: $btn.data('id')
            },
            success: function(response) {
                if (response.errors) {
                    appShowErrors(response.errors, $('.form-horizontal'));
                } else {
                    $btn.closest('.tag-row').fadeOut();
                }
            }
        });
    });

}