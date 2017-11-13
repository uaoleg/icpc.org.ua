function appStaffQatagsManage() {

    /**
     * Save tag
     */
    $('.save-tag').on('click', function(){
        $.ajax({
            url: app.baseUrl + '/staff/qatags/manage?id=' + $('input[name=id]').val(),
            data: {
                name: $('input[name=name]').val(),
                desc: $('textarea[name=desc]').val()
            },
            success: function(response) {
                if (response.errors) {
                    appShowErrors(response.errors, $('.form-horizontal'));
                } else {
                    location = app.baseUrl + '/staff/qatags';
                }
            }
        });
    });

}