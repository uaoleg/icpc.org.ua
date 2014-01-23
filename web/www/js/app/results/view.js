function appResultsView() {

    /**
     * Mark team as completed phase
     */
    $(document).on('click', '.results-phase-completed', function() {
        var $this = $(this)
            $row = $this.closest('.jqgrow');
        $this.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/staff/team/phaseUpdate',
            data: {
                id:     $row.prop('id'),
                phase:  parseInt($('input[name=results-phase]').val()) + 1
            },
            success: function() {
                $this.prop('disabled', false);
            }
        });
    });

}