function appTeamCreate()
{

    /**
     * Click handler to save school info
     */
    $('.save-school-info').on('click', function() {

        var $this = $(this),
            $form = $this.closest('.form');
        $this.prop('disabled', true);

        $.ajax({
            url: app.baseUrl + '/team/saveschoolinfo',
            data: {
                shortNameUk: $('#shortNameUk').val(),
                fullNameEn:  $('#fullNameEn').val(),
                shortNameEn: $('#shortNameEn').val()
            },
            success: function(response) {
                appShowErrors(response.errors, $form);
                if (response.errors) {
                    $this.prop('disabled', false);
                    $this.closest('.panel')
                        .find('input').prop('disabled', false);
                } else {
                    $this.closest('.form')
                         .find('input').prop('disabled', true);
//                    location.href = app.baseUrl + '/user/me';
                    // need to disable School info panel and enable Team info panel
                }
            }
        });

    });

    /**
     * onChange team name handler to show what will the name with prefix be
     */
    var $shortNameEn = $('#shortNameEn').val();
    $('#teamName').on('keyup', function() {

        $('#teamNamePrefix').val($shortNameEn + $(this).val());

    });



}