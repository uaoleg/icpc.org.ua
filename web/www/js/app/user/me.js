function appUserMe() {

    /**
     * Init Select2
     */
    $('.form-group .form-control[name=schoolId]').select2({
        'width': 'resolve'
    });

    $('.btn-save').on('click', function() {
        var $this = $(this),
            $form = $this.closest('.form');
        $this.prop('disabled', true);
        $.ajax({
            cache: false,
            url: app.baseUrl + '/user/me',
            type: 'POST',
            data: {
                firstName:             $('#firstName').val(),
                lastName:              $('#lastName').val(),
                schoolId:              $('#schoolId').val(),
                currentPassword:       $('#currentPassword').val(),
                newPassword:           $('#newPassword').val(),
                repeatNewPassword:     $('#repeatNewPassword').val()
            },
            success: function(response) {
                appShowErrors(response.errors, $form);
                if (response.errors) {
                    $this.prop('disabled', false);
                } else {
                    location.href = app.baseUrl + '/user/me';
                }
            }
        });
    });
}