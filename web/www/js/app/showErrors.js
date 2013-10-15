function appShowErrors(errors, $context) {
    if ($context === undefined) {
        $context = $('body');
    }
    $('.form-group', $context).removeClass('has-error');
    $('.form-group .help-block', $context).remove();
    if (errors) {
        $.each(errors, function(key, value) {
            var $input = $('[name=' + key + ']', $context),
                $group = $input.closest('.form-group')
                $help  = $('<div>');
            if (key === 'recaptcha') {
                Recaptcha.reload();
            }
            $group.addClass('has-error');
            $help.addClass('help-block').html(value).appendTo($group);
        });
        $('.form-group.has-error:first input', $context).focus();
    }
}