function appStaffNewsCreate() {

    var self = this;
    self.init();

    // Save news
    $('.btn.save-news', self.$form).on('click', function() {
        var $selfElement = $(this);
        $selfElement.prop('disabled', true);
        $.ajax({
            url: app.baseUrl + '/staff/news/create',
            data: {
                lang:    $('.lang', self.$form).val(),
                title:   $('.title', self.$form).val(),
                content: self.editor.getData()
            },
            success: function(response) {
                appShowErrors(response.errors, self.$form);
                if (response.errors) {
                    return;
                } else {
                    location.href = app.baseUrl + '/staff/news/edit' +
                        '/id/' + response.id +
                        '/lang/' + $('.lang', self.$form).val();
                }
            }
        });
    });

}

appStaffNewsCreate.prototype = appStaffNewsManage.prototype;