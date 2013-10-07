function appStaffNewsManage() {}

/**
 * Init manage page
 */
appStaffNewsManage.prototype.init = function() {

    var self = this;
    self.$form = $('.form-horizontal');

    // On language changed
    $('select', self.$form).on('change', function() {
        self.onchange();
    });

    // On title changed
    $('input', self.$form).on('keydown', function() {
        self.onchange();
    });

    // Init ckeditor
    self.editor = CKEDITOR.replace($('textarea.content', self.$form)[0], {
        extraPlugins: 'onchange',
        height: '400px'
    });
    self.editor.on('change', function(e) {
        self.onchange();
    });

};

/**
 * On change event
 */
appStaffNewsManage.prototype.onchange = function() {
    $('.news-status-switcher .btn').prop('disabled', true);
    $('.btn.save-news').prop('disabled', false);
};