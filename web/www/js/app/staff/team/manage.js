function appStaffTeamManage(options)
{

    /**
     * Select2 initialization
     */
    $('[name=member1], [name=member2], [name=member3], [name=member4]').select2();

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
                shortNameUk:    $('[name=shortNameUk]').val(),
                fullNameEn:     $('[name=fullNameEn]').val(),
                shortNameEn:    $('[name=shortNameEn]').val(),
                teamNamePrefix: $('[name=teamNamePrefix]').val(),
                member1:        $('[name=member1]').val(),
                member2:        $('[name=member2]').val(),
                member3:        $('[name=member3]').val(),
                member4:        $('[name=member4]').val()
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