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
                teamId:    options.teamId,
                name:      $('[name=name]').val(),
                memberIds: $('[name=memberIds]').val()
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
     * onKeyUp action to append prefix to team name
     */
    $('[name=name]').on('keyup', function(){
        var $this = $(this),
            prefix = $this.data('prefix'),
            val = $this.val();

        if (val.length <= prefix.length) {
            $this.val(prefix);
        } else {
            $this.val(prefix + val.substr(prefix.length));
        }
    });

}