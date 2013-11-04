function appShowErrors(errors, $context) {
    if ($context === undefined) {
        $context = $('body');
    }
    $('.form-group.has-error .help-block', $context).remove();
    $('.form-group', $context).removeClass('has-error');
    if (errors) {
        $.each(errors, function(key, value) {
            var $input,
                $group,
                $help;
            if (key === 'recaptcha') {
                Recaptcha.reload();
                $input = $('#recaptcha_widget_div');
            } else {
                $input = $('[name=' + key + ']', $context);
            }
            $group = $input.closest('.form-group');
            $group.addClass('has-error');
            $help = $('.help-block', $group);
            if ($help.length === 0) {
                $help = $('<div>').addClass('help-block').insertAfter($input);
            }
            $help.html(value);
        });
        $('.form-group.has-error:first input', $context).focus();
    }
}