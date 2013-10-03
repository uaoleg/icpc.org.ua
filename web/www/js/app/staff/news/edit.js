function appStaffNewsEdit() {

    var self = this;
    self.init();

    // Save news
    $('.btn.save-news', self.$form).on('click', function() {
        var $selfElement = $(this);
        $selfElement.prop('disabled', true);
        $('.news-status-switcher .btn-success').prop('disabled', false);
        $.ajax({
            url: app.baseUrl + '/staff/news/edit',
            data: {
                id:      $('.id', self.$form).val(),
                lang:    $('.lang', self.$form).val(),
                title:   $('.title', self.$form).val(),
                content: self.editor.getData()
            },
            success: function(response) {
                appShowErrors(response.errors, self.$form);
                if (response.errors) {
                    return;
                }
            }
        });
    });

}

appStaffNewsEdit.prototype = appStaffNewsManage.prototype;