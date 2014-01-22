function appTeamList() {

    /**
     * Change phase
     */
    $(document).on('change', '.team-phase', function() {
        var $this = $(this),
            $row = $this.closest('.jqgrow');
        $this.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/staff/team/phaseUpdate',
            data: {
                id:    $row.prop('id'),
                phase: $this.val()
            },
            success: function() {
                $this.prop('disabled', false);
            }
        });
    });

}