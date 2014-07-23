function appUserBaylor() {

    var $modal = $('#baylor-modal'),
        $inputs = $('input', $modal);

    $('.btn-baylor-import').on('click', function() {

        var $progress = $('.progress', $modal).removeClass('hide');
        $inputs.prop('disabled', true);
        $('.alert-danger', $modal).addClass('hide');

        $.ajax({
            url: app.baseUrl + '/user/baylor',
            data: {
                email: $('#baylor-modal__email').val(),
                password: $('#baylor-modal__password').val()
            },
            success: function(response) {
                $progress.addClass('hide');
                if (response.errors) {
                    $('.alert-danger', $modal).removeClass('hide');
                    $inputs.prop('disabled', false);
                } else {
                    $modal.modal('hide');

                    $.each(response.data, function(key, value) {
                        $('[data-baylor-' + key + ']').val(value);
                    });

                    $('input[name=tShirtSize]')
                        .prop('checked', false)
                        .parent('label')
                        .removeClass('active');
                    $('input[name=tShirtSize][value=' + response.data.shirtSize + ']')
                        .prop('checked', true)
                        .parent('label')
                        .addClass('active');
                }

            }
        });

    });

}