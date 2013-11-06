function appTeamManage(options)
{

    /**
     * Select2 initialization
     */
    $('#member1').select2();
    $('#member2').select2();
    $('#member3').select2();
    $('#member4').select2();

    /**
     * Click handler to save school info
     */
    $('.btn-save').on('click', function() {
        var $this = $(this),
            $form = $this.closest('.form');
        $this.prop('disabled', true);

        $.ajax({
            url: app.baseUrl + '/team/manage',
            data: {
                teamId:         options.teamId,
                shortNameUk:    $('#shortNameUk').val(),
                fullNameEn:     $('#fullNameEn').val(),
                shortNameEn:    $('#shortNameEn').val(),
                teamNamePrefix: $('#teamNamePrefix').val(),
                member1:        $('#member1').val(),
                member2:        $('#member2').val(),
                member3:        $('#member3').val(),
                member4:        $('#member4').val()
            },
            success: function(response) {
                appShowErrors(response.errors, $form);
                if (response.errors) {
                    $this.prop('disabled', false);
                } else {
                    if (options.teamId !== '') {
                        location.href = app.baseUrl + '/team/view/id/' + options.teamId;
                    } else {
                        location.href = app.baseUrl + '/team/list';
                    }
                }
            }
        });

    });

    /**
     * onChange team name handler to show what will the name with prefix be
     */
    var $shortNameEn = $('#shortNameEn').val();
    $('#name').on('keyup', function() {

        $('#teamNamePrefix').val($shortNameEn + $(this).val());

    });



}