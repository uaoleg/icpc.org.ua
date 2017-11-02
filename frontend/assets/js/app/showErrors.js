function appShowErrors(errors, $context) {
    if ($context === undefined) {
        $context = $('body');
    }
    $('.form-group', $context).removeClass('has-error');
    $('.form-group .help-block', $context).remove();
    if (errors) {
        $.each(errors, function(key, value) {
            var $input;
            var $group;
            var $help = $('<div>').addClass('help-block').html(value);
            if (key === 'recaptcha') {
                grecaptcha.reset();
                $input = $('#recaptcha_widget_div');
            } else {
                $input = $('[name=' + key + ']', $context);
            }
            $group = $input.closest('.form-group');
            $group.addClass('has-error');
            $col = $('div[class^="col-"], div[class*=" col-"]', $group)
            if ($col.length > 0) {
                $help.appendTo($col);
            } else {
                $help.appendTo($group);
            }
        });
        $('.form-group.has-error:first input', $context).focus();
    }
}