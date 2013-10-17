function appShowErrors(errors, $context) {
    if ($context === undefined) {
        $context = $('body');
    }
    $('.form-group', $context).removeClass('has-error');
    $('.form-group .help-block', $context).remove();
    if (errors) {
        $.each(errors, function(key, value) {
            var $input,
                $group,
                $help = $('<div>');
            if (key === 'recaptcha') {
                Recaptcha.reload();
                $input = $('#recaptcha_widget_div');
            } else {
                $input = $('[name=' + key + ']', $context);
            }
            $group = $input.closest('.form-group');
            $help.addClass('help-block').html(value).appendTo($group);
            $group.addClass('has-error');
        });
        $('.form-group.has-error:first input', $context).focus();
    }
}