function appResultsView() {

    /**
     * Remove team
     */
    $(document).on('click', '.js-remove-team', function() {
        return false;
    }).on('confirmed', '.js-remove-team', function() {
        var $row = $(this).closest('.jqgrow');
        $('td', $row).css('opacity', OPACITY_DISABLED);
        $.ajax({
            url: app.baseUrl + '/staff/results/teamDelete',
            data: {
                id: $row.prop('id')
            },
            success: function() {
                $('#results').jqGrid('delRowData', $row.prop('id'));
            }
        });
        return false;
    });

    /**
     * Mark team as completed phase
     */
    $(document).on('change', '.results-phase-completed', function() {
        var $this = $(this)
            $row = $this.closest('.jqgrow'),
            phase = parseInt($('input[name=results-phase]').val());

        $this.prop('disabled', true).tooltip('hide').trigger('changed');

        // Send request
        $.ajax({
            url: app.baseUrl + '/staff/team/phaseUpdate',
            data: {
                id:     $this.data('team-id'),
                phase:  $this.is(':checked') ? phase + 1 : phase
            },
            success: function() {
                $this.prop('disabled', false);
            }
        });
    }).on('changed', '.results-phase-completed', function() {
        var $this = $(this)
            $row = $this.closest('.jqgrow');
        $('.results-prize-place', $row).prop('disabled', !$this.is(':checked'));
    });

    /**
     * Set prize place
     */
    $(document).on('change', '.results-prize-place', function() {
        var $this = $(this)
            $row = $this.closest('.jqgrow');

        $this.prop('disabled', true).tooltip('hide');

        // Send request
        $.ajax({
            url: app.baseUrl + '/staff/results/prizePlaceUpdate',
            data: {
                id:         $row.prop('id'),
                prizePlace: $this.val()
            },
            success: function() {
                $this.prop('disabled', false);
            }
        });
    });

}