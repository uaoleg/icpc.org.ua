function appTeamView() {

    /**
     * Delete team button action
     */
    $('.btn-delete-team').on('confirmed', function(){
        $.ajax({
            url: '/staff/team/delete',
            data: {
                teamId: $(this).data('team-id')
            },
            success: function(response) {
                location.href = '/team/list';
            }
        });
    });

}