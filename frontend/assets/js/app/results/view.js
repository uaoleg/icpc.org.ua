function appResultsView() {

    // Popover with tasks
    $('.js-result').each(function() {
        var $result = $(this);
        $('[data-toggle="popover"]', $result).each(function() {
            var $popover = $(this);
            $popover.popover({
                content: $('.js-content', $popover).html(),
                html: true
            });
        });
    });

    /**
     * Remove team
     */
    $(document).on('confirmed', '.js-remove-team', function() {
        var $btn = $(this);
        var $row = $btn.closest('.js-result');
        $row.css('opacity', OPACITY_DISABLED);
        $.ajax({
            url: app.baseUrl + '/staff/results/team-delete?id=' + $row.data('key'),
            success: function() {
                $row.fadeOut();
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
        var $this = $(this);
        var $row = $this.closest('.js-result');

        $this.prop('disabled', true).tooltip('hide');

        // Send request
        $.ajax({
            url: app.baseUrl + '/staff/results/prize-place-update?id=' + $row.data('key'),
            data: {
                prizePlace: $this.val()
            },
            success: function() {
                $this.prop('disabled', false);
            }
        });
    });

}