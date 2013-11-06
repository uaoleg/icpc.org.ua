function appUserAdditionalCoach(options) {

    /**
     * Save button handler
     */
    $('.btn-save').on('click', function(){
        var $this = $(this),
            $form = $this.closest('.form-horizontal');
        $this.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/user/additional_coach',
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

                position:      $('#position').val(),
                officeAddress: $('#officeAddress').val(),
                phoneWork:     $('#phoneWork').val(),
                fax:           $('#fax').val()
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