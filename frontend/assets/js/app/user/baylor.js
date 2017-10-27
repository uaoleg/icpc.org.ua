function appUserBaylor() {

    var $modal = $('#baylor-modal'),
        $inputs = $('input', $modal);

    $('.js-baylor-import').on('click', function() {

        var $this = $(this),
            $progress = $('.progress', $modal).removeClass('hide');
        $this.prop('disabled', true);
        $inputs.prop('disabled', true);
        $('.alert-danger', $modal).addClass('hide');

        $.ajax({
            url: app.baseUrl + '/user/baylor',
            data: {
                email: $('#baylor-modal__email').val(),
                password: $('#baylor-modal__password').val()
            },
            success: function(response) {
                if (response.errors) {
                    $('.js-baylor-error-creds', $modal).removeClass('hide');
                } else {
                    $modal.modal('hide');
                    $('.js-baylor-panel').removeClass('hide');

                    $.each(response.data, function(key, value) {
                        $('[data-baylor-' + key + ']').val(value);
                        $('[data-baylor-' + key + '-text]')
                            .removeClass('hide')
                            .find('p')
                            .text(value);
                    });

                    $('input[name=tShirtSize]')
                        .prop('checked', false)
                        .parent('label')
                        .removeClass('active');
                    $('input[name=tShirtSize][value=' + response.data.shirtSize + ']')
                        .prop('checked', true)
                        .parent('label')
                        .addClass('active');

                    $('.js-save').click();
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