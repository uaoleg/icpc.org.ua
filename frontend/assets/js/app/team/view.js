function appTeamView() {

    var $modal = $('#baylor-modal'),
        $inputs = $('input', $modal);

    /**
     * Delete team button action
     */
    $('.btn-delete-team').on('confirmed', function(){
        $.ajax({
            url: app.baseUrl + '/staff/team/delete?id=' + $(this).data('team-id'),
            success: function() {
                location.href = '/team/list';
            }
        });
    });

    /**
     * Sync team info
     */
    $('.js-baylor-import').on('click', function() {
        var $this = $(this),
            $progress = $('.progress', $modal).removeClass('hide');
        $this.prop('disabled', true);
        $inputs.prop('disabled', true);
        $('.alert-danger', $modal).addClass('hide');

        $.ajax({
            url: app.baseUrl + '/staff/team/baylorsync',
            data: {
                teamId: $('.btn-sync-team').data('team-id'),
                email: $('#baylor-modal__email').val(),
                password: $('#baylor-modal__password').val()
            },
            success: function(response) {
                if (response.errors) {
                    if (typeof response.errors === 'object') {
                        $('.js-baylor-user-not-found').removeClass('hide')
                            .html('<ul><li>' + response.errors.join('</li><li>') + '</li></ul>');
                    } else {
                        $('.js-baylor-error-creds', $modal).removeClass('hide');
                    }
                } else {
                    $modal.modal('hide');
                    location.reload();
                }
            },
            error: function() {
                $('.js-baylor-error-unknown', $modal).removeClass('hide');
            },
            complete: function() {
                $progress.addClass('hide');
                $this.prop('disabled', false);
                $inputs.prop('disabled', false);
            }
        });
    });

}