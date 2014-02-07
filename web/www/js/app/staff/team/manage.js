function appStaffTeamManage(options)
{

    /**
     * Select2 initialization
     */
    $('[name=memberIds]').select2();

    /**
     * Click handler to save school info
     */
    $('.btn-save').on('click', function() {
        var $this = $(this),
            $form = $this.closest('.form');
        $this.prop('disabled', true);

        $.ajax({
            url: app.baseUrl + '/staff/team/manage',
            data: {
                teamId:         options.teamId,
                shortNameUk:    $('[name=shortNameUk]').val(),
                fullNameEn:     $('[name=fullNameEn]').val(),
                shortNameEn:    $('[name=shortNameEn]').val(),
                teamNamePrefix: $('[name=teamNamePrefix]').val(),
                league:         $('[name=league]:checked').val(),
                memberIds:      $('[name=memberIds]').val()
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
    $('[name=shortNameEn], [name=name]').on('keyup', function() {
        $('#teamNamePrefix').val($('[name=shortNameEn]').val() + $('[name=name]').val());
    }).trigger('keyup');



}