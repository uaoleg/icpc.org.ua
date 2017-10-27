function appUserAdditionalCoach(options) {

    /**
     * Save button handler
     */
    $('.js-save').on('click', function(){
        var $this = $(this),
            $form = $this.closest('.form-horizontal');
        $this.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/user/additional-coach-save',
            data: {
                language: options.lang,

                dateOfBirth:              $('[name=dateOfBirth]').val(),
                phoneHome:                $('[name=phoneHome]').val(),
                phoneMobile:              $('[name=phoneMobile]').val(),
                skype:                    $('[name=skype]').val(),
                tShirtSize:               $('[name=tShirtSize]:checked').val(),
                acmNumber:                $('[name=acmNumber]').val(),
                schoolName:               $('[name=schoolName]').val(),
                schoolNameShort:          $('[name=schoolNameShort]').val(),
                schoolPostEmailAddresses: $('[name=schoolPostEmailAddresses]').val(),

                position:      $('[name=position]').val(),
                officeAddress: $('[name=officeAddress]').val(),
                phoneWork:     $('[name=phoneWork]').val(),
                fax:           $('[name=fax]').val()
            },
            success: function(response) {
                appShowErrors(response.errors, $form);
                if (response.errors) {
                    $this.prop('disabled', false);
                } else {
                    location.href = app.baseUrl + '/user/additional/lang/' + options.lang;
                }
            }
        });
    });

}