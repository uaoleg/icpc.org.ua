function appUserAdditionalStudent(options) {

    /**
     * Save button handler
     */
    $('.btn-save').on('click', function(){
        var $this = $(this),
            $form = $this.closest('.form-horizontal');
        $this.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/user/additional_student',
            data: {
                language: options.lang,

                phoneHome:              $('#phoneHome').val(),
                phoneMobile:            $('#phoneMobile').val(),
                skype:                  $('#skype').val(),
                ACMNumber:              $('#ACMNumber').val(),
                instName:               $('#instName').val(),
                instNameShort:          $('#instNameShort').val(),
                instDivision:           $('[name=instDivision]:checked').val(),
                instPostEmailAddresses: $('#instPostEmailAddresses').val(),

                studyField:        $('#studyField').val(),
                speciality:        $('#speciality').val(),
                faculty:           $('#faculty').val(),
                group:             $('#group').val(),
                instAdmissionYear: $('#instAdmissionYear').val(),
                dateOfBirth:       $('#dateOfBirth').val(),
                document:          $('#document').val(),
            },
            success: function(response) {
                appShowErrors(response.errors, $form);
                if (response.errors) {
                    $this.prop('disabled', false);
                } else {
                    location.href = app.baseUrl + '/user/additional_' + options.lang;
                }
            }
        });
    });

}