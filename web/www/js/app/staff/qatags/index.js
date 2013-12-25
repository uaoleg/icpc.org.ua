function appStaffQatagsIndex() {

    /**
     * Delete tag button
     */
    $('.btn-delete-tag').on('click', function(){
        var $btn = $(this);
        if (confirm($btn.data('question'))) {
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
        }
    });

}