function appStaffNewsEdit() {

    var self = this,
        $form = $('.form-horizontal');

    // On title changed
    $('input', $form).on('keydown', function() {
        self.onchange();
    });

    // Init ckeditor
    var editor = CKEDITOR.replace($('textarea.content', $form)[0], {
        extraPlugins: 'onchange',
        height: '400px'
    });
    editor.on('change', function(e) {
        self.onchange();
    });

    // Save news
    $('.btn.save-news', $form).on('click', function() {
        var $selfElement = $(this);
        $selfElement.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/staff/news/edit',
            data: {
                id: $('.id', $form).val(),
                title: $('.title', $form).val(),
                content: editor.getData()
            },
            success: function(response) {
                appShowErrors(response.errors, $form);
                if (response.errors) {
                    return;
                } else if (response.isNew) {
                    location.href = app.baseUrl + '/staff/news/edit/id/' + response.id;
                }
            }
        });
    });

}

/**
 * On change event
 */
appStaffNewsEdit.prototype.onchange = function() {
    $('.btn.save-news').prop('disabled', false);
}