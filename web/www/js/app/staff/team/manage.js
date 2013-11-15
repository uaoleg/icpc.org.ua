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
                shortNameUk:    $('[name=schoolShortNameUk]').val(),
                fullNameEn:     $('[name=schoolFullNameEn]').val(),
                shortNameEn:    $('[name=schoolShortNameEn]').val(),
                teamNamePrefix: $('[name=teamNamePrefix]').val(),
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
    $('[name=schoolShortNameEn], [name=name]').on('keyup', function() {
        $('#teamNamePrefix').val($('[name=schoolShortNameEn]').val() + $('[name=name]').val());
    }).trigger('keyup');



}