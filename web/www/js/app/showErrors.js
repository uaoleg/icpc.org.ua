function appShowErrors(errors, $context) {
    if ($context === undefined) {
        $context = $('body');
    }
    $('.form-group', $context).removeClass('has-error');
    $('.form-group .help-block', $context).remove();
    if (errors) {
        $.each(errors, function(key, value) {
            var $input = $('.form-control.' + key, $context),
                $group = $input.closest('.form-group')
                $help  = $('<div>');
            $group.addClass('has-error');
            $help.addClass('help-block').html(value).appendTo($group);
        });
    }
}